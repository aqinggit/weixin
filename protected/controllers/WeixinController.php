<?php

/**
 * @filename WeixinController.php
 * @Description 微信登陆
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2015 阿年飞少
 * @datetime 2015-5-29  10:03:15
 */
Yii::import('application.vendors.weixin.*');
require_once 'weixin.class.php';

class WeixinController extends Q
{

    private $cookieTime = 86400;
    private $wx;
    private $currentAction;

    public function init()
    {
        parent::init();
        $wxId = zmf::config('weixin_app_id');
        $wxSecret = zmf::config('weixin_app_key');
        $callback = zmf::config('weixin_app_callback');
        $action = zmf::val('action', 1); //操作类型，是登录、注册、绑定、投票
        if (in_array($action, array('getInfo', 'login', 'reg', 'bind'))) {
            $this->currentAction = $action;
        }
        $from = zmf::val('from', 1); //来源，官网和合作商
        if (!in_array($from, array('web', 'mcenter'))) {
            $from = 'web';
        }
//        if (!$wxId || !$wxSecret || !$callback) {
//            throw new CHttpException(404, '暂未开放');
//        }
        $referer = zmf::val('referer', 1);
        $this->referer = $referer ? $referer : $this->referer;
        $callback .= '?action=' . $this->currentAction . '&from=' . $from . '&referer=' . $this->referer;
        $this->wx = new weixinSdk($wxId, $wxSecret, $callback);
        $this->pageTitle = '微信 - ' . zmf::config('sitename');
        $this->isMobile = true;
    }

    public function actionReg()
    {
        if (!Yii::app()->user->isGuest) {
            $this->redirect(zmf::createUrl('weixin/main'));
        }
        if ($this->isMobile) {
            $this->layout = 'common';
        }

        $this->pageTitle = '欢迎注册-' . zmf::config('sitename');
        $this->mobileTitle = '注册';
        $this->currentModule = 'login';

        $model = new Users();
        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $model->birthday = strtotime($model->birthday);
            $model->password = md5($model->password);
            $model->password2 = md5($model->password2);
            $model->status = 0;
            if ($model->validate()) {
                if ($model->save()) {
                    $this->render('success', array('truename' => $model->truename));
                } else {
                    $this->message(0, '系统原因,注册失败!', $this->referer);
                }
            }
        }
        $this->render('reg', array('model' => $model));

    }

    public function actionLogin()
    {
        if (!Yii::app()->user->isGuest) {
            $this->message(0, '你已登录，请勿重复操作');
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
        $this->mobileTitle = '登录';
        $this->currentModule = 'login';
        $this->render('login', array(
            'canLogin' => $canLogin,
        ));

    }

    public function actionLogOut()
    {
        Yii::app()->user->logout();
        $this->redirect(zmf::createUrl('weixin/main'));
    }

    public function actionForget()
    {

        $cardId = zmf::val('cardId');
        $phone = zmf::val('phone');
        $password = zmf::val('password');
        if ($_POST) {
            if (!$cardId || !$phone || !$password) {
                $this->message(0, '请完善您的信息', zmf::createUrl('/weixin/forget'));
            }
            $user = Users::model()->find("phone = {$phone}");
            if ($user) {
                if ($user['cardId'] === $cardId) {
                    if (Users::model()->updateByPk($user->id, ['password' => md5($password)])) {
                        $this->message(1, '密码重置成功', zmf::createUrl('/weixin/main'));
                    } else {
                        $this->message(0, '重置失败!');
                    }
                }
            } else {
                $this->message(0, '您的输入的手机还没有注册');
            }

        }


        $this->mobileTitle = '找回密码';
        $this->currentModule = 'login';
        $this->render('forget');
    }

    public function actionIndex()
    {
        if (Yii::app()->user->isGuest) {
            $this->redirect(zmf::createUrl('weixin/login'));
        }

    }

    public function actionMain()
    {

        $this->pageTitle = '个人中心-' . zmf::config('sitename');

        if (Yii::app()->user->isGuest) {
            $this->redirect(zmf::createUrl('weixin/login'));
        }

        $uid = zmf::uid();
        $model = new Activity;
        $criteria = new CDbCriteria();
        $criteria->join = 'JOIN pre_volunteer_active as va ON va.aid=t.id ';
        $criteria->addCondition("va.vid = {$uid}");
        $criteria->addCondition('t.status != 3');
        $criteria->select = 't.id,t.title,t.place,t.count,va.status';
        $criteria->order='t.cTime DESC';
        $activity = $model->findAll($criteria);


        $now = zmf::now();
        $startTime = zmf::time($now,'Y');
        $startTime = $startTime . '-1-1';
        $endTime = ($startTime + 1) .'-1-1';
        $startTime = strtotime($startTime);
        $endTime = strtotime($endTime) -1;
        $where = "cTime >= {$startTime} AND cTime <= {$endTime} AND ";

        $sql = "select count(*) as t,SUM(score) as m From pre_volunteer_active WHERE {$where} vid = {$uid} AND status = 1";
        $items = Yii::app()->db->createCommand($sql)->queryRow();
        $activityCount = $items['t'] ? $items['t'] : 0;
        $activityScore = $items['m'] ? $items['m'] : 0;

        $data = [
            'activity'  =>$activity,
            'activityCount'=>$activityCount,
            'activityScore'=>$activityScore
        ];
        $this->render('main', $data);


    }


    public function actionCallback()
    {
        $wx_data = zmf::getCookie('userWeixinData');
        if (!$wx_data) {
            $res = $this->wx->getAccessToken();
            if ($res['status'] == 0) {
                $this->message(0, $res['data']);
            }
            $token = $res['data'];
            if ($token['openid'] && $token['access_token']) {//获取用户信息
                $resuinfo = $this->wx->getUserInfo($token['openid'], $token['access_token']);
                if ($resuinfo['status'] == 0) {
                    $this->message(0, $resuinfo['data']);
                }
                $uinfo = $resuinfo['data'];
            }
            $data = array_merge($token, $uinfo);
            $strdata = serialize($data);
            zmf::setCookie('userWeixinData', $strdata, $this->cookieTime);
            zmf::setFCache('userWeixinData-' . $data['openid'], $strdata, $this->cookieTime);
        } else {
            $data = unserialize($wx_data);
            $strdata = $wx_data;
            zmf::setFCache('userWeixinData-' . $data['openid'], $wx_data, $this->cookieTime);
        }
        //0415添加，微信回调后都写入数据库
        $uinfo = Weixin::model()->find('openid=:uid', array(':uid' => $data['openid']));
        $attr = array(
            'openid' => $data['openid'],
            'unionid' => $data['unionid'],
            'username' => $data['nickname'],
            'avatar' => $data['headimgurl'],
            'access_token' => $data['access_token'],
            'refresh_token' => $data['refresh_token'],
            'expires' => $data['expires'],
            'sex' => $data['sex'],
            'data' => $strdata,
        );
        if (!$uinfo) {
            $model = new Weixin;
            $model->attributes = $attr;
            $model->save();
        } else {
            Weixin::model()->updateByPk($uinfo['id'], $attr);
        }
        //获取用户之前的意图，是注册、登录还是绑定
        $action = zmf::val('action', 1);
        //'login', 'reg', 'bind',
        if (!in_array($action, array('getInfo', 'login', 'reg', 'bind'))) {
            throw new CHttpException(404, '缺少参数');
        }
        $from = zmf::val('from', 1); //来源，官网和合作商
        if (!in_array($from, array('web', 'mcenter'))) {
            $from = 'web';
        }
        if ($from == 'mcenter') {
            $urlData = array(
                'openid' => $data['openid'],
                'action' => $action,
                'hash' => '',
            );
            $url = 'http://hezuo.tell520.com/weixin/callback?' . (http_build_query($urlData));
            $this->redirect($url);
        }
        if (in_array($action, array('login', 'reg')) && $this->uid) {
            $this->message(0, '您已登录，请勿该操作', $this->referer);
        } elseif ($action == 'bind' && !$this->uid) {
            $this->redirect(array('site/login', 'bind' => 'weixin'));
        }
        $openid = $data['openid'];
        if (!$openid) {
            zmf::delCookie('userWeixinData');
            throw new CHttpException(404, '获取用户信息失败，请重试');
        }
        //查询是否用微信登录过
        //获取用户信息不需要判断是否绑定
        if ($action != 'getInfo') {
            $bindInfo = Weixin::model()->find("openid=:unid", array(':unid' => $openid));
        }
        if ($action == 'login') {
            //确实绑定过微信，则直接登录
            if ($bindInfo && $bindInfo['uid'] > 0) {
                $this->loginWithWeixin($bindInfo, $data);
            } else {
                //没有绑定过就跳转到注册页面
                $this->redirect(array('site/reg', 'bind' => 'weixin'));
            }
        } elseif ($action == 'reg') {
            //绑定过微信就直接登录
            if ($bindInfo && $bindInfo['uid'] > 0) {
                $this->loginWithWeixin($bindInfo, $data);
            } else {
                //没有绑定过就跳转到注册页面
                $this->redirect(array('site/reg', 'bind' => 'weixin'));
            }
        } elseif ($action == 'bind') {
            $uid = $this->uid;
            if ($bindInfo && $bindInfo['uid'] > 0 && $bindInfo['uid'] != $this->uid) {
                throw new CHttpException(403, '该微信已经绑定其他账户');
            } else {
                if (empty($bindInfo)) {
                    throw new CHttpException(404, '获取微信信息错误，请重试');
                } elseif ($bindInfo['uid'] == $this->uid) {
                    Users::model()->updateByPk($uid, array('bindWeixin' => 1));
                    $this->redirect($this->referer);
                } else {
                    if (Weixin::model()->updateByPk($bindInfo['id'], array('uid' => $uid))) {
                        Users::model()->updateByPk($uid, array('bindWeixin' => 1));
                        $this->redirect($this->referer);
                    } else {
                        throw new CHttpException(404, '写入数据时错误，请重试');
                    }
                }
            }
        } elseif ($action == 'getInfo') {
            $this->redirect($this->referer);
        }
    }

    private function loginWithWeixin($bindInfo, $data = array())
    {
        $userInfo = Users::getOne($bindInfo['uid']);
        if ($userInfo) {
            $_identity = new U($userInfo['phone'], $userInfo['password']);
            $_identity->simpleAuth();
            $duration = 3600 * 24 * 30; // 30 days
            Yii::app()->user->login($_identity, $duration);
            if ($this->referer == '') {
                $this->referer = array('users/index');
            }
            $this->redirect($this->referer);
        } else {
            throw new CHttpException(404, '您所绑定的用户已不存在');
        }
    }


}
