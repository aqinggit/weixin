<?php
class UserController extends Q{
    public function init(){
        parent::init();
        if(!$this->uid){
            $this->redirect(array('site/login'));
        }
        $this->layout='user';
        $this->currentModule='user';
        $this->pageTitle='个人中心 - '.zmf::config('sitename');
    }

    public function actionIndex(){
        $this->render('index',array(
        ));
    }

    public function actionNotice(){
        $this->mobileTitle='信息通知';
        $this->pageTitle='消息通知 - '.zmf::config('sitename');
        $this->render('notice',array(

        ));
    }

    public function actionSecurity(){
        $this->mobileTitle='账户安全';
        $this->pageTitle='账户安全 - '.zmf::config('sitename');
        $this->render('security',array(

        ));
    }

    public function actionProfile(){
        $this->mobileTitle='个人资料';
        $this->pageTitle='个人资料 - '.zmf::config('sitename');
        $this->render('profile',array(

        ));
    }



}