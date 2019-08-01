<?php

/**
 * @filename assets.php 
 * @Description 统一处理css、js加载
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2015 阿年飞少 
 * @datetime 2015-6-2  14:15:47 
 */
class assets {

    /**
     * 加载js路径配置文件
     * @param type $type 应用类型
     */
    public function jsConfig($type = 'web', $module = 'web') {
        $c = Yii::app()->getController()->id;
        $a = Yii::app()->getController()->getAction()->id;
        $now=zmf::now();
        $arr['common'] = array(
            'baseUrl' => zmf::config('baseurl'),
            'hasLogin' => Yii::app()->user->isGuest ? 'false' : 'true',
            'loginUrl' => Yii::app()->createUrl('/site/login'),
            'module' => $module,
            'c' => $c,
            'a' => $a,
            'csrfToken' => Yii::app()->request->csrfToken,
            'requestTime' =>$now,
            'remaindSendSmsTime' => intval(zmf::getCookie('latestSmsTime')) - $now,
            'currentSessionId' => Yii::app()->session->sessionID,
            'addCommentUrl' => zmf::config('domain') . Yii::app()->createUrl('/xhr/addComment'),
            'setImgAltUrl' => zmf::config('domain') . Yii::app()->createUrl('/xhr/setImgAlt'), //设置图片描述
            'ajaxUrl' => zmf::config('domain') . Yii::app()->createUrl('/xhr/do'),
        );
        $regAndLogin=zmf::config('regAndLogin');
        $arr['web'] = array(
            'editor' => '',
            'allowImgTypes' => zmf::config('imgAllowTypes'),
            'allowImgPerSize' => zmf::formatBytes(zmf::config('imgMaxSize')),
            'perAddImgNum' => zmf::config('imgUploadNum'),
            'regAndLogin' => $regAndLogin>0 ? 1 : 0,
        );
        $arr['mobile'] = array(

        );
        $arr['admin'] = array(
            'editor' => '',
            'allowImgTypes' => zmf::config('imgAllowTypes'),
            'allowImgPerSize' => zmf::formatBytes(zmf::config('imgMaxSize')),
            'perAddImgNum' => zmf::config('imgUploadNum'),
            'perAddImgNum' => zmf::config('imgUploadNum'),
            'ajaxAttachesUrl' => zmf::config('domain') . Yii::app()->createUrl('admin/attachments/ajaxSelect'),
            'ajaxTagsUrl' => zmf::config('domain') . Yii::app()->createUrl('admin/attachments/ajaxTags'),
            'attachDetailUrl' => zmf::config('domain') . Yii::app()->createUrl('admin/attachments/detail'),
            'attachDelTagUrl' => zmf::config('domain') . Yii::app()->createUrl('admin/attachments/delTag'),
            'attachDelTagsUrl' => zmf::config('domain') . Yii::app()->createUrl('admin/attachments/delTags'),
            'attachAddTagUrl' => zmf::config('domain') . Yii::app()->createUrl('admin/attachments/addTag'),
            'attachAddMultiTagUrl' => zmf::config('domain') . Yii::app()->createUrl('admin/attachments/addMultiTag'),
            //'attachDelMultiTagUrl' => zmf::config('domain') . Yii::app()->createUrl('admin/attachments/delMultiTag'),
            'attachMultiDelUrl' => zmf::config('domain') . Yii::app()->createUrl('admin/attachments/multiDel'),
            'autoMatchTagUrl' => zmf::config('domain') . Yii::app()->createUrl('admin/tags/autoMatchTag'),
        );
        $attrs = array_merge($arr['common'], $arr[$type]);
        $longHtml = '<script>var zmf={';
        foreach ($attrs as $k => $v) {
            $longHtml .= $k . ":'" . $v . "',";
        }
        $longHtml .= '};</script>';
        echo $longHtml;
    }

    public function loadCssJs($type = 'web', $action = null) {
        if (!$action) {
            return;
        }
        $status = zmf::config('appStatus');
        if (YII_DEBUG) {
            $staticUrl = Yii::app()->baseUrl . '/common/static/';
            $coreStaticUrl = Yii::app()->baseUrl . '/common/static/';
            $fontsStaticUrl = Yii::app()->baseUrl . '/common/';
        } else {
            $_staticUrl = zmf::config('cssJsStaticUrl');
            $staticUrl = $_staticUrl ? $_staticUrl : Yii::app()->baseUrl . '/common/static/';
            $coreStaticUrl = $_staticUrl ? $_staticUrl : Yii::app()->baseUrl . '/common/static/';
            $fontsStaticUrl = $_staticUrl ? $_staticUrl : Yii::app()->baseUrl . '/common/';
        }
        $cs = Yii::app()->clientScript;
        if ($status != 3) {
            $cssDir = Yii::app()->basePath . '/../jsCssSrc/' . $type . '/css';
            $jsDir = Yii::app()->basePath . '/../jsCssSrc/' . $type . '/js';
            $coreCssDir = Yii::app()->basePath . '/../jsCssSrc/coreCss';
            $coreJsDir = Yii::app()->basePath . '/../jsCssSrc/coreJs';
            $destDir = Yii::app()->basePath . '/../common/static';
        } else {
            $cssDir = Yii::app()->basePath . '/../common/' . $type . '/css';
            $jsDir = Yii::app()->basePath . '/../common/' . $type . '/js';
            $coreCssDir = Yii::app()->basePath . '/../common/coreCss';
            $coreJsDir = Yii::app()->basePath . '/../common/coreJs';
            $destDir = Yii::app()->basePath . '/../common/static';
        }
        $cssArr = $jsArr = $coreCssArr = $coreJsArr = array();
        if ($type == 'web') {
            $coreCssArr = array(
                    'bootstrap',
                    'font-awesome',
            );
            $coreJsArr = array(
                    'bootstrap' => array('pos' => 'end'),
                    'jquery.pin' => array('pos' => 'end'),
                    //'owl-carousel' => array('pos' => 'end'),
            );
            $cssArr = array(
                'base',
                'questions',
            );
            $jsArr = array(
                'zmf'
            );
            if ($action == 'index') {
                $cssArr[] = 'index';
            } elseif ($action == 'login') {
                $cssArr[] = 'login';
                $jsArr[] = 'owl-carousel';
            }elseif ($action == 'search') {
                $cssArr[] = 'product';
                $cssArr[] = 'article';
                $cssArr[] = 'questions';
            }elseif ($action == 'keywords') {
                $cssArr[] = 'keyword';
            }elseif ($action == 'post') {
                $cssArr[] = 'post';
            }elseif ($action == 'posts') {
                $cssArr[] = 'posts';
            }
        } elseif ($type == 'mobile') {
            $coreJsArr = array(
                'jqMobile' => array('pos' => 'end'),
                'owl-carousel' => array('pos' => 'end'),
            );
            $coreCssArr = array(
                'weui',
                'font-awesome',
            );
            $cssArr = array(
                'mobile',
            );
            $jsArr = array(
                'mobile',
            );
            if ($action == 'index') {
                $cssArr[] = 'index';
            }elseif ($action == 'login') {
                $cssArr[] = 'login';
            }elseif ($action == 'area') {
                $cssArr[] = 'area';
            }elseif ($action == 'keywords') {
                $cssArr[] = 'rank';
            }
        } elseif ($type == 'admin') {
            $coreCssArr = array(
                'bootstrap',
                'font-awesome',
            );
            $coreJsArr = array(
                'bootstrap' => array('pos' => 'end'),
            );
            $cssArr = array(
                'admin',
            );
            $jsArr = array(
                'zmf',
                'admin',
            );
        } elseif ($type == 'mip') {
            $coreCssArr = array(
                'weui',
                'font-awesome',
            );
            $cssArr = array(
                'mobile',
            );
            if ($action == 'index') {
                $cssArr[] = 'index';
            }elseif ($action == 'login') {
                $cssArr[] = 'login';
            }elseif ($action == 'area') {
                $cssArr[] = 'area';
            }elseif ($action == 'keywords') {
                $cssArr[] = 'rank';
            }
        }
        $timeCssArr = $timeJsArr = $cssFilesArr = $jsFilesArr = [];
        //处理样式文件
        foreach ($coreCssArr as $coreFileName) {
            $cssFilesArr[] = $coreFileName;
            $timeCssArr[] = filemtime($coreCssDir . '/' . $coreFileName . '.css');
        }
        foreach ($cssArr as $cssFileName) {
            $cssFilesArr[] = $cssFileName;
            $timeCssArr[] = filemtime($cssDir . '/' . $cssFileName . '.css');
        }
        $cssFileTargetName = $type . '_' . $status . '_' . $action . '_' . md5(join('-', $cssFilesArr)) . '_' . max($timeCssArr) . '.css';
        //不存在文件时则创建Css文件
        if (!file_exists($destDir . '/' . $cssFileTargetName)) {
            $cssContent = '';
            foreach ($coreCssArr as $coreFileName) {
                $cssContent .= file_get_contents($coreCssDir . '/' . $coreFileName . '.css');
            }
            foreach ($cssArr as $cssFileName) {
                $cssContent .= file_get_contents($cssDir . '/' . $cssFileName . '.css');
            }
            file_put_contents($destDir . '/' . $cssFileTargetName, $cssContent);
        }
        if($type=='mip'){
            $cssStype = '<style mip-custom>';
            $cssStype.=file_get_contents($destDir . '/' . $cssFileTargetName);
            $cssStype .= '</style>';
            $cssStype = str_replace('../images', $staticUrl . 'images', $cssStype);
            $cssStype = str_replace('../fonts', $fontsStaticUrl . 'fonts', $cssStype);
            echo $cssStype;
        }else{
            $cs->registerCssFile($staticUrl . $cssFileTargetName);
        }
        //处理js文件
        foreach ($coreJsArr as $jsfile => $jsParams) {
            $jsFilesArr[] = $jsfile;
            $timeJsArr[] = filemtime($coreJsDir . '/' . $jsfile . '.js');
        }
        foreach ($jsArr as $jsFileName) {
            $jsFilesArr[] = $jsFileName;
            $timeJsArr[] = filemtime($jsDir . '/' . $jsFileName . '.js');
        }
        $jsFileTargetName = $type . '_' . $status . '_' . $action . '_' . md5(join('-', $jsFilesArr)) . '_' . max($timeJsArr) . '.js';
        if (!file_exists($destDir . '/' . $jsFileTargetName)) {
            $jsContent = '';
            foreach ($coreJsArr as $jsfile => $jsParams) {
                $jsContent .= file_get_contents($coreJsDir . '/' . $jsfile . '.js');
            }
            foreach ($jsArr as $jsFileName) {
                $jsContent .= file_get_contents($jsDir . '/' . $jsFileName . '.js');
            }
            file_put_contents($destDir . '/' . $jsFileTargetName, $jsContent);
        }
        if($type!='mip'){
            $cs->registerCoreScript('jquery');
            $cs->registerScriptFile($staticUrl . $jsFileTargetName, CClientScript::POS_END);
        }
    }

    public function loadPageCssJs($params) {
        $status = zmf::config('appStatus');
        if (YII_DEBUG) {
            $staticUrl = Yii::app()->baseUrl . ($status != 3 ? '/jsCssSrc/' : '/common/');
        } else {
            $_staticUrl = zmf::config('cssJsStaticUrl');
            $staticUrl = $_staticUrl ? $_staticUrl : Yii::app()->baseUrl . ($status != 3 ? '/jsCssSrc/' : '/common/');
        }
        $cs = Yii::app()->clientScript;
        $c = Yii::app()->getController()->id;
        $a = Yii::app()->getController()->getAction()->id;
        if ($status != 3) {
            $cssDir = Yii::app()->basePath . '/../jsCssSrc/css';
            $jsDir = Yii::app()->basePath . '/../jsCssSrc/js';
            $coreCssDir = Yii::app()->basePath . '/../jsCssSrc/coreCss';
            $coreJsDir = Yii::app()->basePath . '/../jsCssSrc/coreJs';
        } else {
            $cssDir = Yii::app()->basePath . '/../common/css';
            $jsDir = Yii::app()->basePath . '/../common/js';
            $coreCssDir = Yii::app()->basePath . '/../common/coreCss';
            $coreJsDir = Yii::app()->basePath . '/../common/coreJs';
        }
        $coreCssArr = $params['coreCss'];
        $cssArr = $params['css'];
        $coreJsArr = $params['coreJs'];
        $jsArr = $params['js'];

        if (!empty($coreCssArr)) {
            $coreCssDirArr = zmf::readDir($coreCssDir, false);
            foreach ($coreCssDirArr as $coreFileName) {
                foreach ($coreCssArr as $coreCssfile => $fileParams) {
                    if (strpos($coreFileName, $coreCssfile) !== false) {
                        $cs->registerCssFile($staticUrl . 'coreCss/' . $coreFileName);
                    }
                }
            }
        }
        if (!empty($cssArr)) {
            $cssDirArr = zmf::readDir($cssDir, false);
            foreach ($cssArr as $cssFileName) {
                foreach ($cssDirArr as $cssfile) {
                    if (strpos($cssfile, $cssFileName) !== false) {
                        $cs->registerCssFile($staticUrl . 'css/' . $cssfile);
                    }
                }
            }
        }
        if (!empty($coreJsArr)) {
            $coreJsDirArr = zmf::readDir($coreJsDir, false);
            foreach ($coreJsDirArr as $jsFileName) {
                foreach ($coreJsArr as $jsfile => $_pos) {
                    if ($jsfile == 'jquery') {
                        $cs->registerCoreScript('jquery');
                        continue;
                    }
                    if (strpos($jsFileName, $jsfile) !== false) {
                        if ($_pos == 'head') {
                            $pos = CClientScript::POS_HEAD;
                        } else {
                            $pos = CClientScript::POS_END;
                        }
                        $cs->registerScriptFile($staticUrl . 'coreJs/' . $jsFileName, $pos);
                    }
                }
            }
        }
        if (!empty($jsArr)) {
            $jsDirArr = zmf::readDir($jsDir, false);
            foreach ($jsArr as $jsFileName => $_pos) {
                foreach ($jsDirArr as $jsfile) {
                    if (strpos($jsfile, $jsFileName) !== false) {
                        if ($_pos == 'head') {
                            $pos = CClientScript::POS_HEAD;
                        } else {
                            $pos = CClientScript::POS_END;
                        }
                        $cs->registerScriptFile($staticUrl . 'js/' . $jsfile, $pos);
                    }
                }
            }
        }
    }

}
