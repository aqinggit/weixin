<?php

/**
 * 前台共用类
 */
class Q extends Controller {

    public $layout = 'main';
    public $referer;
    public $uid;
    public $userInfo;
    public $selectNav = null;
    public $currentModule = 'notSet';
    public $platform;
    public $isMobile = false;
    public $keywords; //页面SEO关键词
    public $mobileTitle;
    public $pageDescription; //页面seo描述
    public $seoMetaContent = ''; //智能摘要
    public $baiduJsonLD = ''; //百度JSON_LD数据
    public $page = 1;
    public $pageSize = 30;
    public $isAjax = false;
    public $searchType = '';
    public $searchKeyword = '';
    public $rightBtns = array(); //手机版导航条右侧按钮
    public $returnUrl = ''; //左侧返回按钮的返回链接
    public $showLeftBtn = true; //左侧返回按钮
    public $showTopbar = true;
    public $adminLogin = false;
    public $links; //友链
    public $footerTags;//页面底部相关标签
    public $footerRanks;//页面底部相关排行榜
    public $navContent = ''; //一句话导航
    public $pageContent = ''; //页面富文本介绍
    public $spider = null; //蜘蛛
    public $areaInfo=null;//地区
    public $enableCSRF=false;//是否开启csrf验证
    public $webTheme='web';
    public $htmlCache=false;

    public function beforeAction($action) {
        $this->validateCsrfToken();
        return parent::beforeAction($action);
    }

    function init() {
        parent::init();
        Yii::app()->theme = 'web';
        //判断蜘蛛
        $this->spider = zmf::checkSpider();
        $this->htmlCache=zmf::config('siteHtmlCache');
        //判断手机版，不强制跳转
        if (zmf::config('mobile')) {
            $isMobile=false;
            if (zmf::checkmobile($this->platform)) {
                $isMobile = true;
            }
            $host = $_SERVER['HTTP_HOST'];
            $mhost = zmf::config('mobileDomain'); //手机版网站
            $miphost = zmf::config('mipDomain'); //mip版网站
            $whost = zmf::config('domain');//PC版网站
            if (('http://' . $host) == $miphost && $miphost!='') {//是mip版
                Yii::app()->theme = 'mip';
                $this->webTheme='mip';
                $this->spider='baidu';
                $this->isMobile = true;
            } elseif (('http://' . $host) == $mhost && $mhost!='') {//是手机版的链接
                Yii::app()->theme = 'mobile';
                $this->webTheme='mobile';
                $this->isMobile = true;
            } elseif (('http://' . $host) == $whost && $mhost!='' && $isMobile) {//是电脑版的链接
                $currentUrl = Yii::app()->request->url;
                $newUrl = $mhost . str_replace('http://' . $host, '', $currentUrl);
                $this->redirect($newUrl);
            }
        }
        //根据UA判断
        $s = zmf::config('closeAllSpider');
        if ($s > 0) {
            $ua = strtolower(Yii::app()->request->userAgent);
            if (stripos($ua, 's' . 'pi' . 'd' . 'er') !== false) {
                throw new CHttpException(503, '页' . '面' . '暂' . '时' . '无' . '法' . '访' . '问');
            }
        }
        //ajax
        if (Yii::app()->request->isAjaxRequest && Yii::app()->request->isPostRequest) {
            $this->isAjax = true;
        }
        $page = zmf::val('page', 2);
        $this->page = $page >= 1 ? $page : 1;
        self::_referer();
        $uid = zmf::uid();
        if ($uid) {
            $this->uid = $uid;
            $this->userInfo = Users::getOne($uid);
            if ($this->userInfo['status'] != Posts::STATUS_PASSED) {
                Yii::app()->user->logout();
                unset($this->uid);
                unset($this->userInfo);
            }
        }
    }

    function _referer() {
        $currentUrl = Yii::app()->request->url;
        $arr = array(
            'login',
            'site/',
            '/error/',
            '/attachments/',
            '/weibo/',
            '/qq/',
            '/weixin/',
            '/user/index',
            '/search/',
        );
        $set = true;
        if ($set) {
            foreach ($arr as $val) {
                if (!$set) {
                    break;
                }
                if (strpos($currentUrl, $val) !== false) {
                    $set = false;
                    break;
                }
            }
        }
        if ($set && Yii::app()->request->isAjaxRequest) {
            $set = false;
        }
        $referer = zmf::getCookie('refererUrl');
        if ($set) {
            zmf::setCookie('refererUrl', $currentUrl, 86400);
        }
        if ($referer != '') {
            $this->referer = $referer;
        }
    }

    public function onlyOnPc() {
        if ($this->isMobile) {
            $this->layout = 'common';
            $this->render('//common/onlyOnPc');
            Yii::app()->end();
        }
    }

    public function checkUserStatus($return = FALSE) {
        $msg = $url = '';
        if (!$this->uid) {
            $msg = '请先登录';
            $url = Yii::app()->createUrl('site/login');
        } else {
            if (!$this->userInfo['groupid']) {
                $msg = '请先选择你的角色';
                $url = Yii::app()->createUrl('user/joinGroup');
            } elseif (!$this->userInfo['phoneChecked']) {
                $_groupInfo = Group::getOne($this->userInfo['groupid']);
                if (!$_groupInfo) {
                    $msg = '请先选择你的角色';
                    $url = Yii::app()->createUrl('user/joinGroup');
                } elseif ($_groupInfo['isAuthor']) {
                    $msg = '请先验证你的手机号';
                    $url = Yii::app()->createUrl('user/setting', array('action' => 'checkPhone'));
                }
            }
        }
        if ($return) {
            if ($msg != '') {
                return array(
                    'msg' => $msg,
                    'url' => $url,
                );
            } else {
                return true;
            }
        } else {
            if ($this->isAjax && $msg != '') {
                $this->jsonOutPut(0, $msg);
            } elseif ($msg != '') {
                $this->message(0, $msg, $url);
            }
        }
    }
    
    public function page404($msg=null){        
        throw new CHttpException(404, $msg ? $msg : 'The requested page does not exist.');
    }

    //验证csrf
    protected function validateCsrfToken() {
        if ($this->enableCSRF == true) {
            Yii::app()->request->enableCsrfValidation = true; //属性改为true，以便CHtml::beginForm()生成csrf_token
            try {
                Yii::app()->request->validateCsrfToken(null); //验证csrf
            } catch (Exception $e) {
                Yii::app()->handleException($e);
            }
        }
    }

    private function echoHtml(){
        if($this->htmlCache && !$this->isAjax && static::_checkUrlCache()){
            $currentUrl = zmf::config('domain') . Yii::app()->request->url;
            $hashCode=md5($currentUrl);
            $theme=$this->webTheme;
            $dir=Yii::app()->basePath.'/runtime/siteHtml/'.$theme.'/';
            zmf::createUploadDir($dir);
            $fileName=$dir.$hashCode.'.html';
            $time=filectime($fileName);
            $now=zmf::now();
            $cacheTime=zmf::config('siteHtmlCacheTime');
            $cacheTime=$cacheTime>0 ? $cacheTime : 0;
            if(file_exists($fileName) && ($now-$time)<$cacheTime){
                echo file_get_contents($fileName);
                Yii::app()->end();
            }
        }
    }

    private function cacheHtml($content){
        if($this->htmlCache && !$this->isAjax && static::_checkUrlCache()){
            $currentUrl = zmf::config('domain') . Yii::app()->request->url;
            $hashCode=md5($currentUrl);
            $theme=$this->webTheme;
            $dir=Yii::app()->basePath.'/runtime/siteHtml/'.$theme.'/';
            zmf::createUploadDir($dir);
            $fileName=$dir.$hashCode.'.html';
            file_put_contents($fileName,$content);
        }
        echo $content;
        Yii::app()->end();
    }

    private function _checkUrlCache() {
        $currentUrl = Yii::app()->request->url;
        $urlStr=zmf::config('notCacheUrls');
        if(!$urlStr){
            return false;
        }
        $arr = explode(PHP_EOL,$urlStr);
        $set = true;
        if ($set) {
            foreach ($arr as $val) {
                if (!$set) {
                    break;
                }
                if (strpos($currentUrl, $val) !== false) {
                    $set = false;
                    break;
                }
            }
        }
        if ($set && Yii::app()->request->isAjaxRequest) {
            $set = false;
        }
        return $set;
    }

    public function render($view,$data=null,$return=false){
        $content=parent::render($view,$data,true);
        static::cacheHtml($content);
    }

}
