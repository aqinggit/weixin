<?php

class LoginController extends Admin{

    public function actionForm(){
        $this->layout='common';
        if (isset($_POST['code']) && $_POST['code']!='') {
            $code=$_POST['code'];
            $_code=zmf::config('houtaiCode');
            if($code==$_code && $_code!=''){
                $key=zmf::randMykeys(8);
                zmf::setCookie('adminRandKey' . $this->uid,$key,31536000);
                zmf::setFCache('adminRandKey' . $this->uid,$key,31536000);
                $this->redirect($this->referer);
            }
        }
        $this->render('form');
    }

}