<?php

class SiteController extends Q {

    public function actions() {
        $cookieInfo = zmf::getCookie('checkWithCaptcha');
        if ($cookieInfo == '1') {
            return array(
                'captcha' => array(
                    'class' => 'CCaptchaAction',
                    'backColor' => 0xFFFFFF,
                    'minLength' => '2', // 最少生成几个字符
                    'maxLength' => '3', // 最多生成几个字符
                    'height' => '30',
                    'width' => '60'
                ),
                'page' => array(
                    'class' => 'CViewAction',
                ),
            );
        }
    }

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            $currentUrl = Yii::app()->request->url;
            if (Yii::app()->request->isAjaxRequest) {
                $outPutData = array(
                    'status' => 0,
                    'msg' => $error['message'],
                    'code' => $error['code']
                );
                $json = CJSON::encode($outPutData);
                header("Content-type:application/json;charset=UTF-8");
                echo $json;
                Yii::app()->end();
            }elseif (strpos($currentUrl, '/api/')!==false) {
                $outPutData = array(
                    'status' => $error['code'],
                    'msg' => $error['message'],
                    'code' => $error['code']
                );
                $json = CJSON::encode($outPutData);
                header("Content-type:application/json;charset=UTF-8");
                echo $json;
                Yii::app()->end();
            } else {
                $this->layout = 'common';
                $this->pageTitle = '提示';
                $this->render('error', $error);
            }
        }
    }

    public function actionLogin() {
        if (!Yii::app()->user->isGuest) {
            $this->message(0, '你已登录，请勿重复操作');
        }
        if($this->webTheme=='mip'){
            $this->redirect(zmf::createUrl('site/login',null,'mobileDomain'));
        }
        if ($this->isMobile) {
            $this->layout = 'common';
        }
        $canLogin = true;
        $ip = Yii::app()->request->getUserHostAddress();
        $cacheKey = 'loginErrors-' . $ip;
        $errorTimes = zmf::getFCache($cacheKey);
        if ($errorTimes >= 5) {
            $canLogin = false;
        }
        $this->pageTitle = '欢迎回来-' . zmf::config('sitename');
        $this->mobileTitle = '登录';
        $this->currentModule='login';
        $this->render('login', array(
            'canLogin' => $canLogin,
        ));
    }

    public function actionLogout() {
        if (Yii::app()->user->isGuest) {
            $this->message(0, '你尚未登录');
        }
        Yii::app()->user->logout();
        $this->redirect(zmf::config('baseurl'));
    }

    public function actionReg() {
        if (!Yii::app()->user->isGuest) {
            $this->redirect($this->referer);
        }
        if($this->webTheme=='mip'){
            $this->redirect(zmf::createUrl('site/reg',null,'mobileDomain'));
        }
        if ($this->isMobile) {
            $this->layout = 'common';
        }
        $ip = ip2long(Yii::app()->request->userHostAddress);
        if (zmf::actionLimit('reg', $ip, 5, 86400, true, true)) {
            throw new CHttpException(403, '你的操作太频繁，请明天再来吧');
        }
        $this->pageTitle = '欢迎注册-' . zmf::config('sitename');
        $this->mobileTitle = '注册';
        $this->currentModule='login';
        $this->render('reg');
    }

    public function actionForgot() {
        if ($this->isMobile) {
            $this->layout = 'common';
        }
        $this->referer = Yii::app()->createUrl('site/login');
        $this->pageTitle = '找回密码';
        $this->currentModule='login';
        $this->render('forgot', $data);
    }

    /**
     * 跳转统计
     */
    public function actionTo(){
        $type=  zmf::val('type',1);
        if($type=='meiqia'){
            $this->redirect('');
        }else{
            $qq= zmf::config('siteQQ');
            if($this->isMobile){
                $this->redirect('mqqwpa://im/chat?chat_type=wpa&uin='.$qq.'&version=1&src_type=web');
            }else{
                $this->redirect('http://wpa.qq.com/msgrd?v=3&uin='.$qq.'&site=qq&menu=yes');
            }
        }
    }
    
    public function actionTxt(){
        $filename=zmf::val('fileName',1);
        if($filename=='robots'){
            header("Content-type:text/plain;charset=utf-8");
            echo zmf::config('robots');
            Yii::app()->end();
        }
        $dir=Yii::app()->basePath.'/runtime/siteTxt/'.$filename.'.txt';
        if(!file_exists($dir)){
            $this->page404();
        }
        $info= file_get_contents($dir);
        header("Content-type:text/plain;charset=utf-8");
        echo $info;
    }


}
