<?php

/**
 * @filename ToolsController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2015 阿年飞少 
 * @datetime 2015-7-9  17:53:57 
 */
class ToolsController extends Admin {

    public function init() {
        parent::init();
        $this->checkPower('tools');
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionCheckLog() {
        $type = zmf::filterInput($_GET['type'], 1);
        switch ($type) {
            case 'app':
                $content = file_get_contents(Yii::app()->basePath . '/runtime/application.log');
                break;
            case 'log':
                $content = file_get_contents(Yii::app()->basePath . '/runtime/log.txt');
                break;
            case 'slowlog':
                $content = file_get_contents(Yii::app()->basePath . '/runtime/slowquery.log');
                break;
            case 'delApp':
                unlink(Yii::app()->basePath . '/runtime/application.log');
                $this->message(1, '已删除', Yii::app()->createUrl('admin/tools/index'), 1);
                break;
            case 'appLogs':
                $topDir = Yii::app()->basePath . '/runtime/appLogs';
                $dirNames = zmf::readDir($topDir, false);
                $sizeTotal = 0;
                foreach ($dirNames as $_dir) {
                    $dir = $topDir . '/' . $_dir;
                    $ctime = filemtime($dir);
                    $size = filesize($dir);
                    $dirs[] = array(
                        'filename' => $_dir,
                        'cTime' => $ctime,
                        'size' => $size,
                    );
                    $sizeTotal += $size;
                }
                $dirs = zmf::multi_array_sort($dirs, 'cTime', SORT_DESC);
                break;
            case 'appLog':
                $content = file_get_contents(Yii::app()->basePath . '/runtime/appLogs/' . $_GET['file']);
                break;
            case 'delAppLog':
                unlink(Yii::app()->basePath . '/runtime/appLogs/' . $_GET['file']);
                $this->message(1, '已删除', Yii::app()->createUrl('admin/tools/index'), 1);
                break;
            case 'delLog':
                unlink(Yii::app()->basePath . '/runtime/log.txt');
                $this->message(1, '已删除', Yii::app()->createUrl('admin/tools/index'), 1);
                break;
            case 'crash':
                $dirs = zmf::readDir(Yii::app()->basePath . '/runtime/crashLog', false);
                break;
            case 'crashLog':
                $content = file_get_contents(Yii::app()->basePath . '/runtime/crashLog/' . $_GET['file']);
                break;
            case 'delCrashLog':
                unlink(Yii::app()->basePath . '/runtime/crashLog/' . $_GET['file']);
                $this->message(1, '已删除', Yii::app()->createUrl('admin/tools/index'), 1);
                break;
        }
        if (in_array($type, array('appLogs', 'crash'))) {
            $data = array(
                'dirs' => $dirs,
                'type' => $type,
                'totalSize' => $sizeTotal,
            );
            $this->render('crash', $data);
        } else {
            $data = array(
                'content' => $content
            );
            $this->render('log', $data);
        }
    }

    public function actionSubmitUrls() {
        if (isset($_POST['urls'])) {
            $urls = $_POST['urls'];
            $type = $_POST['type'];
            $baiduPushCode = zmf::config('baiduPushCode');
            if ($baiduPushCode) {
                $json = tools::submitBaiduUrls($urls, $type, $baiduPushCode);
                $url = Yii::app()->createUrl('admin/tools/submitUrls');
                if ($json['success'] >= 1 || $json['success_mip'] > 0) {
                    zmf::fp($json, 1);
                    $this->message(1, '还可提交' . ($json['remain'] ? $json['remain'] : $json['reamin_mip']) . '条', $url);
                } else {
                    zmf::fp($json, 1);
                }
            } else {
                $this->message(0, '缺少百度推送码');
            }
        }
        $this->render('submitUrls');
    }

    public function actionClearMip() {
        if (isset($_POST['urls'])) {
            $urls = $_POST['urls'];
            if ($urls) {
                $api = 'http://mipcache.bdstatic.com/update-ping/c/';
                $postData = 'key='.zmf::config('mip_clear_key');
                $url = $api . urlencode($urls);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                $result = curl_exec($ch);
                curl_close($ch);
                zmf::test($result);
            }
        }
        $this->render('clearMip');
    }

    public function actionSubmitUrl() {
        $url = zmf::val('url', 1);
        if (!$url) {
            $this->jsonOutPut(0, '缺少链接');
        }
        $appStatus = zmf::config('appStatus');
        $baiduPushCode = zmf::config('baiduPushCode');
        if ($appStatus == '3' && $baiduPushCode != '') {
            $urls[] = $url;
            $json1 = tools::submitBaiduUrls($urls, 1, $baiduPushCode); //普通链接
            zmf::fp($json1, 1);
            $json2 = tools::submitBaiduUrls($urls, 2, $baiduPushCode); //mip
            zmf::fp($json2, 1);
            $this->jsonOutPut(1, '已提交');
        } else {
            $this->jsonOutPut(0, '未开放');
        }
    }

    public function actionRefreshCache() {
        if (isset($_POST['urls'])) {
            $urls = $_POST['urls'];
            $urlsArr = array_filter(explode(PHP_EOL, $urls));
            if (!empty($urlsArr)) {
                foreach ($urlsArr as $url){
                    $res=Aliyun::refreshCache($url);
                    zmf::fp($res,1);
                }
                $this->message(1, '已提交', Yii::app()->createUrl('admin/tools/refreshCache'));
            } else {
                $this->message(0, '请填写链接');
            }
        }
        $this->render('refreshUrls');
    }

    public function actionReferer() {
        $url = zmf::val('url', 1);
        $action = zmf::val('action', 1);
        $imgId = zmf::val('imgId', 2);
        $percent = zmf::val('percent', 2);
        if ($action && !$this->isAjax) {
            $this->message(0, '不允许');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0');
        // 在HTTP请求头中"Referer: "的内容。

        curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate, sdch");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //302redirect
        //如果不是微博的图片，暂且认为是微信图片
        if (strpos($url, 'sinaimg') === false) {
            //针对微信
            curl_setopt($ch, CURLOPT_REFERER, "https://mp.weixin.qq.com/");
            // 针对https的设置
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        }
        $data = curl_exec($ch);
        curl_close($ch);
        if (!$this->isAjax) {
            if ($percent > 0) {
                $ctime = zmf::now();
                $dir = zmf::uploadDirs($ctime, 'app', 'temp');
                zmf::createUploadDir($dir);
                $fileName = zmf::uuid() . '.jpg';
                file_put_contents($dir . $fileName, $data);
                tools::imagecropper($dir . $fileName, $percent);
                $data= file_get_contents($dir . $fileName);
                @unlink($dir . $fileName);
            }
            header('Content-type: image/jpg');
            echo $data;
        } else {
            $ctime = zmf::now();
            $dir = zmf::uploadDirs($ctime, 'app', 'article');
            zmf::createUploadDir($dir);
            $fileName = zmf::uuid() . '.jpg';
            file_put_contents($dir . $fileName, $data);
            if ($percent > 0) {
                tools::imagecropper($dir . $fileName, $percent);
            }
            $imgInfo = getimagesize($dir . $fileName);
            $size = filesize($dir . $fileName);
            $returnimg = zmf::uploadDirs($ctime, 'site', 'article') . $fileName;
            $data = array();
            $data['uid'] = zmf::uid();
            $data['logid'] = 0;
            $data['filePath'] = $fileName;
            $data['fileDesc'] = '';
            $data['classify'] = 'article';
            $data['cTime'] = $ctime;
            $data['status'] = Posts::STATUS_PASSED;
            $data['width'] = $imgInfo[0];
            $data['height'] = $imgInfo[1];
            $data['size'] = $size;
            $data['remote'] = $returnimg;
            $model = new Attachments();
            $model->attributes = $data;
            if ($model->save()) {
                $attachid = $model->id;
                $thumbnail = zmf::getThumbnailUrl($returnimg, 'c650.jpg');
                $outPutData = array(
                    'status' => 1,
                    'attachid' => $attachid,
                    'imgId' => $imgId,
                    'imgsrc' => $returnimg,
                    'thumbnail' => $thumbnail,
                );
                $json = CJSON::encode($outPutData);
                echo $json;
            }
        }
    }
    
    public function actionClearStatics(){
        $dir=Yii::app()->basePath.'/../common/static/';
        tools::rmDir($dir, true);
        exit();
    }

    public function actionClearHtml(){
        $type=zmf::val('type',1);
        if(!in_array($type,['web','mobile','mip'])){
            $type='web';
        }
        $dir=Yii::app()->basePath.'/runtime/siteHtml/'.$type.'/';
        tools::rmDir($dir, true);
        exit();
    }

}
