<?php

class Admin extends Controller {

    public $pageTitle;
    public $layout = 'main';
    public $menu = array();
    public $breadcrumbs = array();
    public $userInfo;
    public $uid;
    public $isAjax = false;
    public $referer = null;

    public function init() {
        parent::init();
        $passwdErrorTimes = zmf::getCookie('checkWithCaptcha');
        $time = zmf::config('adminErrorTimes');
        if ($time > 0) {
            if ($passwdErrorTimes >= $time) {
                header('Content-Type: text/html; charset=utf-8');
                echo '你暂时已被禁止访问';
                Yii::app()->end();
            }
        }
        if (Yii::app()->request->isAjaxRequest && Yii::app()->request->isPostRequest) {
            $this->isAjax = true;
        }
        self::_referer();
        $uid = zmf::uid();
        if ($uid) {
//            $randKey_cookie = zmf::getCookie('adminRandKey' . $uid);
//            $randKey_cache = zmf::getFCache('adminRandKey' . $uid);
//            $currentUrl = Yii::app()->request->url;
//            if ((!$randKey_cookie || ($randKey_cache != $randKey_cookie)) && strpos($currentUrl, '/login/') === false) {
//                if($this->isAjax){
//                    $this->jsonOutPut(0,'验证已过期，请重新验证');
//                }else{
//                    $this->message(0, '验证已过期，请重新验证', Yii::app()->createUrl('admin/login/form'));
//                }
//            }
            $this->userInfo = Users::getOne($uid);
            $this->uid=$uid;
        } else {
            if($this->isAjax){
                $this->jsonOutPut(0,'请先登录');
            }else{
                $this->message(0, '请先登录', Yii::app()->createUrl('/site/login'));
            }
        }
    }

    function _referer() {
        $currentUrl = Yii::app()->request->url;
        $arr = array(
            '/login/',
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
        $referer = zmf::getCookie('refererAdminUrl');
        if ($set) {
            zmf::setCookie('refererAdminUrl', $currentUrl, 86400);
        }
        if ($referer != '') {
            $this->referer = $referer;
        }else{
            $this->referer=Yii::app()->createurl('/admin/index/index');
        }
    }
}
