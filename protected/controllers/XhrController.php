<?php

class XhrController extends Q
{

    public function init()
    {
        parent::init();
        if (!Yii::app()->request->isAjaxRequest) {
            $this->jsonOutPut(0, Yii::t('default', 'forbiddenaction'));
        }
    }

    private function checkLogin()
    {
        if (Yii::app()->user->isGuest) {
            $this->jsonOutPut(0, Yii::t('default', 'loginfirst'));
        }
    }

    public function actionDo()
    {
        $action = zmf::val('action', 1);
        if (!in_array($action, array('saveUploadImg', 'favorite', 'report', 'sendSms', 'checkSms', 'login', 'reg', 'setStatus', 'getNotice', 'ajax', 'exPhone', 'exPasswd', 'search', 'checkLoginHtml', 'loginVolunteers'))) {
            $this->jsonOutPut(0, Yii::t('default', 'forbiddenaction'));
        }
        $this->$action();
    }

    private function ajax()
    {
        $data = zmf::val('data', 1);
        if (!$data) {
            $this->jsonOutPut(0, '缺少参数~');
        }
        $arr = Users::decode($data);
        switch ($arr['type']) {
            default:
                $this->jsonOutPut(0, '不被允许的操作~');
                break;
        }
    }

    /**
     * 保存已上传图片入库
     */
    public function saveUploadImg()
    {
        $this->checkLogin();
        $type = zmf::val('type', 1);
        if (!isset($type) || !in_array($type, array('posts', 'faceImg'))) {
            $this->jsonOutPut(0, '请设置上传所属类型' . $type);
        }
        $filePath = zmf::val('filePath', 1);
        $fileSize = zmf::val('fileSize', 2);
        $logid = zmf::val('logid', 2);
        $pathArr = pathinfo($filePath);
        if (!$filePath || !$fileSize || !$pathArr['basename']) {
            $this->jsonOutPut(0, '保存图片失败');
        }
        $fullDir = zmf::attachBase('site', $type) . $filePath;
        $imgInfo = file_get_contents($fullDir . '?imageInfo');
        $imgInfoArr = CJSON::decode($imgInfo, 'true');
        if (!$imgInfoArr) {
            $this->jsonOutPut(0, '获取图片信息失败');
        }
        $width = $imgInfoArr['width'];
        $height = $imgInfoArr['height'];
        if (in_array($imgInfoArr['orientation'], array('Right-top', 'Left-bottom'))) {
            $width = $imgInfoArr['height'];
            $height = $imgInfoArr['width'];
        }
        $data = array();
        $data['uid'] = zmf::uid();
        $data['logid'] = $logid;
        $data['filePath'] = $pathArr['basename']; //文件名
        $data['fileDesc'] = '';
        $data['classify'] = $type;
        $data['cTime'] = zmf::now();
        $data['status'] = Users::STATUS_PASSED;
        $data['width'] = $width;
        $data['height'] = $height;
        $data['size'] = $fileSize;
        $data['remote'] = $fullDir;
        $model = new Attachments;
        $model->attributes = $data;
        if ($model->save()) {
            $attachid = $model->id;
            $returnimg = zmf::getThumbnailUrl($fullDir, 'a120', $type);
            $_attr = array(
                'id' => $attachid,
                'imgUrl' => $returnimg,
                'desc' => ''
            );
            $html = '';
            if ($type == 'posts') {
                $html = $this->renderPartial('/posts/_addImg', array('data' => $_attr), true);
            }
            $outPutData = array(
                'status' => 1,
                'attachid' => $attachid,
                'imgsrc' => $returnimg,
                'imgOriginal' => $fullDir,
                'html' => $html,
            );
            $json = CJSON::encode($outPutData);
            echo $json;
        } else {
            $this->jsonOutPut(0, '写入数据库错误');
        }
    }

    /**
     * 保存图片描述
     */
    public function actionSetImgAlt()
    {
        $this->checkLogin();
        if (!$this->isAjax) {
            $this->jsonOutPut(0, '不被允许的操作');
        }
        $id = zmf::val('id', 2);
        $alt = zmf::val('content', 1);
        if (!$id) {
            $this->jsonOutPut(0, '缺少参数');
        }
        if (Attachments::model()->updateByPk($id, array('fileDesc' => $alt))) {
            $this->jsonOutPut(1, '已更新');
        } else {
            $this->jsonOutPut(0, '更新失败，可能是未做修改');
        }
    }

    /**
     * 举报
     */
    private function report()
    {
        $data = array();
        $logid = zmf::val('logid', 2);
        $type = zmf::val('type', 1);
        $desc = zmf::val('reason', 1);
        $contact = zmf::val('contact', 1);
        $url = zmf::val('url', 1);
        $allowType = array('book', 'chapter', 'tip', 'comment', 'post', 'user', 'author', 'postPosts');
        if (!in_array($type, $allowType)) {
            $this->jsonOutPut(0, '暂不允许的分类');
        }
        if (!$logid) {
            $this->jsonOutPut(0, '缺少参数');
        }
        //一个小时内最多只能对同一对象举报4次
        if (zmf::actionLimit('report', $type . '-' . $logid, 3, 3600)) {
            $this->jsonOutPut(0, '我们已收到你的举报，请勿频繁操作');
        }

        $data['logid'] = $logid;
        $data['classify'] = $type;
        $info = false;
        if ($this->uid) {
            $data['uid'] = $this->uid;
            $info = Reports::model()->findByAttributes($data);
        }
        if ($info) {
            $data['desc'] = $info['desc'] . $desc;
            $data['contact'] = $info['contact'] . $contact;
            $data['status'] = Users::STATUS_STAYCHECK;
            $data['times'] = $info['times'] + 1;
            $data['cTime'] = zmf::now();
            if (Reports::model()->updateByPk($info['id'], $data)) {
                $this->jsonOutPut(1, '感谢你的举报');
            }
            $this->jsonOutPut(1, '感谢你的举报');
        } else {
            $data['url'] = $url;
            $data['desc'] = $desc;
            $data['contact'] = $contact;
            $data['status'] = Users::STATUS_STAYCHECK;
            $data['times'] = 1;
            $fm = new Reports();
            $fm->attributes = $data;
            if ($fm->save()) {
                $this->jsonOutPut(1, '感谢你的举报');
            } else {
                $this->jsonOutPut(0, '举报失败，请稍后重试');
            }
        }
    }

    /**
     * 发送短信
     */
    private function sendSms()
    {
        $phone = zmf::val('phone', 2);
        $type = zmf::val('type', 1);
        if (!in_array($type, array('reg', 'forget', 'login', 'order', 'exphone', 'expasswd'))) {
            $this->jsonOutPut(0, '不被允许的类型:' . $type);
        }
        $ip = zmf::getUserIp();
        zmf::fp($ip);
        $this->jsonOutPut(0, '短信发送太频繁，请稍后再试');
        if (in_array($type, array('exphone', 'expasswd'))) {
            $this->checkLogin();
        }
        if ($type == 'expasswd') {
            $phone = $this->userInfo['phone'];
        } else {
            if (!$phone) {
                $this->jsonOutPut(0, '请输入手机号');
            }
        }
        if (!zmf::checkPhoneNumber($phone)) {
            $this->jsonOutPut(0, '请输入正确的手机号');
        }
        $now = zmf::now();
        $_time = intval(zmf::getCookie('latestSmsTime')) - $now;
        if ($_time > 0) {
            $this->jsonOutPut(0, '短信发送太频繁，请稍后再试');
        }
        $_valiCode = zmf::val('valicode', 1);
        //bug
        $uinfo = array();
        if ($type == 'login') {
            if ($this->uid) {
                $this->jsonOutPut(0, '您已登录，请勿重复操作');
            }
            $uinfo = Users::findByPhone($phone);
            if (!$uinfo) {
                $this->jsonOutPut(0, '查无此人，请核实');
            }
        } elseif ($type == 'reg') {
            //验证手机号是否已被注册
            $info = Users::findByPhone($phone);
            if ($info) {
                $this->jsonOutPut(0, '该手机号已被注册');
            }
            $this->userInfo['phone'] = $phone;
        } elseif ($type == 'exphone') {
            if ($phone == $this->userInfo['phone']) {
                $this->jsonOutPut(0, '号码未作修改');
            }
            //验证手机号是否已被注册
            $info = Users::findByPhone($phone);
            if ($info) {
                $this->jsonOutPut(0, '该手机号已被注册');
            }
            $this->userInfo['phone'] = $phone;
        }
        $sendInfo = Msg::findOne($type, $phone, true);
        if ($sendInfo) {
            $params = array(
                'phone' => $phone,
                'code' => $sendInfo['code'],
                'template' => Msg::returnTemplate($type),
            );
            $status = Msg::sendOne($params);
            if ($status) {
                //记录下次发短信时间
                zmf::setCookie('latestSmsTime', $now + 60, 60);
                $this->jsonOutPut(1, '发送成功');
            } else {
                $this->jsonOutPut(0, '发送失败');
            }
        }
        if (in_array($type, array('login', 'order'))) {
            $this->userInfo['phone'] = $phone;
        }
        $count = Msg::statByPhone($phone);
        if ($count >= 5) {
            $this->jsonOutPut(0, '此号码今天的短信次数已用完');
        }
        //将该手机号及该操作下的所有短信置为已过期
        //Msg::model()->updateAll(array('status' => -1), 'phone=:p AND type=:type AND status=0', array(':p' => $phone, ':type' => $type));
        //发送一条短信验证码
        $res = Msg::initSend($this->userInfo, $type);
        if ($res) {
            if ($type == 'exphone') {
                //记录操作
                //UserLog::add($this->uid, '发送短信请求更换手机');
            } elseif ($type == 'forget') {
                //记录操作
                //UserLog::add($this->uid, '发送短信请求找回密码');
            }
            //记录下次发短信时间
            zmf::setCookie('latestSmsTime', $now + 60, 60);
            //缓存
            $this->jsonOutPut(1, '发送成功');
        } else {
            zmf::fp('发送短信失败-----');
            zmf::fp($res, 1);
            $this->jsonOutPut(0, '发送失败');
        }
    }

    private function checkValidate()
    {
        $code = zmf::val('valicode', 1);
        if (!$code) {
            $this->jsonOutPut(0, '请输入校验码');
        }
        $session = Yii::app()->session;
        $session->open();
        $_validateCode = '';
        foreach ($session as $_key => $_session) {
            if (strpos($_key, 'site.captcha') !== false && strpos($_key, 'site.captchacount') === false) {
                $_validateCode = $_session;
                break;
            }
        }
        if ($this->userInfo['isAdmin']) {
            foreach ($session as $_key => $_session) {
                if (strpos($_key, 'zmf/users.captcha') !== false && strpos($_key, 'zmf/users.captchacount') === false) {
                    $_validateCode = $_session;
                    break;
                }
            }
        }
        if (!$_validateCode) {
            $this->jsonOutPut(0, '缺少校验码');
        } elseif ($_validateCode != $code) {
            $this->jsonOutPut(-9, '校验码错误');
        }
        $this->jsonOutPut(1, '输入正确');
    }

    private function login()
    {
        if ($this->uid) {
            $this->jsonOutPut(1, '已登录');
        }
        $ip = ip2long(Yii::app()->request->userHostAddress);
        if (zmf::actionLimit('login', $ip, 60, 86400, 1, 1)) {
            $this->jsonOutPut(0, '错误操作太频繁，请稍后再试');
        }
        $phone = zmf::val('phone', 2);
        $type = zmf::val('type', 1);
        $value = zmf::val('value', 1);
        $_valiCode = zmf::val('_valiCode', 1);
        $bind = zmf::val('bind', 1);
        if (!in_array($bind, array('weixin'))) {
            $bind = '';
        }
        if (!$phone || !$type || !$value) {
            $this->jsonOutPut(0, '缺少参数');
        } elseif (!in_array($type, array('passwd', 'sms'))) {
            $this->jsonOutPut(0, '参数错误');
        } elseif (!zmf::checkPhoneNumber($phone)) {
            $this->jsonOutPut(0, '请输入正确的手机号');
        }

        $uinfo = Users::findByPhone($phone);
        if (!$uinfo || $uinfo['status'] != Users::STATUS_PASSED) {
            $this->jsonOutPut(0, '该号码暂未注册，请先注册');
        }
        if ($type == 'sms') {
            $sendInfo = Msg::findOne('login', $phone);
            if (!$sendInfo) {
                zmf::actionLimit('login', $ip, 60, 86400, 1);
                $this->jsonOutPut(0, '请先发送验证码');
            } elseif ($sendInfo['status'] == 1) {
                $this->jsonOutPut(0, '验证码已使用');
            } elseif ($sendInfo['code'] != $value) {
                $this->jsonOutPut(0, '验证码错误');
            }
            //更新短信记录
            Msg::model()->updateByPk($sendInfo['id'], array('status' => 1));
        } else {
            if ($uinfo['password'] != md5($value)) {
                zmf::actionLimit('login', $ip, 60, 86400, 1);
                $this->jsonOutPut(0, '密码错误');
            }
        }
        if ($bind == 'weixin' && $this->fromWeixin) {
            $wx_data = zmf::getCookie('userWeixinData');
            $wxDataArr = unserialize($wx_data);
            if (!empty($wxDataArr) && $wxDataArr['openid'] != '') {
                //判断是否已经绑定过了
                $weixinInfo = Weixin::model()->find(array(
                    'condition' => 'openid=:uid',
                    'params' => array(
                        ':uid' => $wxDataArr['openid']
                    )
                ));
                if ($weixinInfo) {
                    if ($weixinInfo['uid'] > 0) {
                        zmf::delCookie('userWeixinData');
                        $this->jsonOutPut(0, '该账号已绑定其他微信');
                    }
                }
            }
        } else {
            $bind = '';
        }
        $password = $uinfo['password'];
        //自动登录
        $_identity = new U($phone, $password);
        $_identity->simpleAuth();
        if ($_identity->errorCode === U::ERROR_NONE) {
            $duration = 2592000; //一个月
            if (Yii::app()->user->login($_identity, $duration)) {
                $uid = zmf::uid();
                $now = zmf::now();
                if ($uid) {
                    //是否已微信登录
                    if ($weixinInfo) {
                        Weixin::model()->updateByPk($weixinInfo['id'], array('uid' => $uid));
                        Users::model()->updateByPk($uid, array(
                            'bindWeixin' => 1
                        ));
                    }
                    //删除微信信息
                    zmf::delCookie('userWeixinData');
                }
            } else {
                $this->jsonOutPut(0, '登录失败，请重试');
            }
        }
        if ($this->referer) {
            $url = $this->referer;
        } else {
            $url = zmf::config('baseurl');
        }
        $this->jsonOutPut(1, $url);
    }

    private function reg()
    {
        if ($this->uid) {
            $this->jsonOutPut(0, '您已登录，请勿此操作');
        }
        $ip = ip2long(Yii::app()->request->userHostAddress);
        if (zmf::actionLimit('reg', $ip, 60, 86400, 1, 1)) {
            $this->jsonOutPut(0, '您的操作太频繁，请明天再来吧');
        }
        $phone = zmf::val('phone', 2);
        $code = zmf::val('code', 2);
        $name = zmf::val('name', 1);
        $passwd = zmf::val('passwd', 1);
        $_valiCode = zmf::val('_valiCode', 1);
        $bind = zmf::val('bind', 1);
        if (!in_array($bind, array('weixin'))) {
            $bind = '';
        }
        if (!$phone || !$code || !$name || !$passwd) {
            $this->jsonOutPut(0, '缺少参数');
        } elseif (!zmf::checkPhoneNumber($phone)) {
            $this->jsonOutPut(0, '请输入正确的手机号');
        } elseif (strlen($passwd) < 6) {
            $this->jsonOutPut(0, '密码长度不短于6位');
        } elseif (!$_valiCode) {
            //$this->jsonOutPut(0, '请输入校验码');
        }
//        $passwd=substr($phone, -6, 6);
//        $session = Yii::app()->session;
//        $session->open();
//        $_validateCode = '';
//        foreach ($session as $_key => $_session) {
//            if (strpos($_key, 'site.captcha') !== false && strpos($_key, 'site.captchacount') === false) {
//                $_validateCode = $_session;
//                break;
//            }
//        }
//        if (!$_validateCode) {
//            $this->jsonOutPut(0, '缺少校验码');
//        } elseif ($_validateCode != $_valiCode) {
//            $this->jsonOutPut(-9, '校验码错误');
//        }
        $uinfo = Users::findByPhone($phone);
        if ($uinfo && $uinfo['status'] == Users::STATUS_PASSED) {
            $this->jsonOutPut(0, '此号码已被占用');
        }
        $sendInfo = Msg::findOne('reg', $phone);
        if (!$sendInfo) {
            $this->jsonOutPut(0, '请先发送验证码');
        } elseif ($sendInfo['status'] == 1) {
            $this->jsonOutPut(0, '验证码已使用');
        } elseif ($sendInfo['code'] != $code) {
            $this->jsonOutPut(0, '验证码错误');
        }
        $inputData = array(
            'truename' => $name,
            'password' => md5($passwd),
            'phone' => $phone,
            'platform' => $this->isMobile ? 2 : 1,
            'from' => $this->isMobile ? Users::PLATFORM_MOBILE : Users::PLATFORM_WEB
        );
        if ($bind == 'weixin' && $this->fromWeixin) {
            $wx_data = zmf::getCookie('userWeixinData');
            $wxDataArr = unserialize($wx_data);
            if (!empty($wxDataArr) && $wxDataArr['openid'] != '') {
                //判断是否已经绑定过了
                $weixinInfo = Weixin::model()->find(array(
                    'condition' => 'openid=:uid',
                    'params' => array(
                        ':uid' => $wxDataArr['openid']
                    )
                ));
                if ($weixinInfo) {
                    if ($weixinInfo['uid'] > 0) {
                        $this->jsonOutPut(0, '该微信已经绑定过用户');
                    } else {
                        $inputData['avatar'] = $wxDataArr['headimgurl'];
                    }
                }
            } else {
                $bind = '';
            }
        } else {
            $bind = '';
        }
        $modelUser = new Users();
        $modelUser->attributes = $inputData;
        if ($modelUser->save()) {
            zmf::actionLimit('reg', $ip, 60, 86400, true);
            $_model = new FrontLogin;
            $_model->phone = $phone;
            $_model->password = $passwd;
            $_model->login();
            if ($this->referer == '') {
                $url = zmf::config('baseurl');
            } else {
                $url = $this->referer;
            }
            //更新短信记录
            Msg::model()->updateByPk($sendInfo['id'], array('status' => 1));
            //绑定微信
            if ($weixinInfo) {
                Weixin::model()->updateByPk($weixinInfo['id'], array('uid' => Yii::app()->user->id));
                Users::model()->updateByPk(Yii::app()->user->id, array(
                    'bindWeixin' => 1
                ));
            }
            //删除微信信息
            zmf::delCookie('userWeixinData');
            $this->jsonOutPut(1, $url);
        } else {
            $this->jsonOutPut(0, '非常抱歉，系统错误，请稍后重试');
        }
    }

    /**
     * 获取提醒
     */
    private function getNotice()
    {
        $this->checkLogin();
        //$noticeNum = Notification::getNum();
        $cartNum = ShoppingCart::getNum();
        $arr = array(
            'status' => 1,
            'notices' => $noticeNum ? $noticeNum : 0,
            'cartNum' => $cartNum,
        );
        echo CJSON::encode($arr);
        Yii::app()->end();
    }

    /**
     * 意见反馈
     */
    public function actionFeedback()
    {
        $content = zmf::val('content', 1);
        if (!$content) {
            $this->jsonOutPut(0, '内容不能为空哦~');
        }
        //一个小时内最多只能反馈5条
        if (zmf::actionLimit('feedback', '', 5, 3600)) {
            $this->jsonOutPut(0, '操作太频繁，请稍后再试');
        }
        if ($this->uid) {
            //获取用户组的权限
            $powerAction = 'feedback';
            $powerInfo = GroupPowers::checkPower($this->userInfo, $powerAction);
            if (!$powerInfo['status']) {
                $this->jsonOutPut(0, $powerInfo['msg']);
            }
        }
        $attr['uid'] = $this->uid;
        $attr['type'] = 'web';
        $attr['contact'] = zmf::val('email', 1);
        $attr['appinfo'] = zmf::val('url', 1);
        $attr['sysinfo'] = Yii::app()->request->userAgent;
        $attr['content'] = $content;
        $model = new Feedback();
        $model->attributes = $attr;
        if ($model->validate()) {
            if ($model->save()) {
                if ($this->uid) {
                    //记录用户操作
                    $jsonData = CJSON::encode(array(
                        'contact' => $attr['contact'],
                        'content' => $content,
                    ));
                    $attr = array(
                        'uid' => $this->uid,
                        'logid' => $model->id,
                        'classify' => $powerAction,
                        'data' => $jsonData,
                        'action' => $powerAction,
                        'score' => $powerInfo['msg']['score'],
                        'exp' => $powerInfo['msg']['exp'],
                        'display' => $powerInfo['msg']['display'],
                    );
                    if (UserAction::simpleRecord($attr)) {
                        //判断本操作是否同属任务
                        Task::addTaskLog($this->userInfo, $powerAction);
                    }
                }
                $this->jsonOutPut(1, '感谢你的反馈');
            } else {
                $this->jsonOutPut(1, '感谢你的反馈');
            }
        } else {
            $this->jsonOutPut(0, '反馈失败，请重试');
        }
    }

    /**
     * 收藏
     */
    private function favorite()
    {
        $data = zmf::val('data', 1);
        $ckinfo = Users::favorite($data, 'web', $this->userInfo);
        $this->jsonOutPut($ckinfo['state'], $ckinfo['msg']);
    }

    private function exPhone()
    {
        $this->checkLogin();
        $phone = zmf::val('phone', 2);
        $code = zmf::val('code', 2);
        if (!$phone || !$code) {
            $this->jsonOutPut(0, '缺少参数');
        } elseif (!zmf::checkPhoneNumber($phone)) {
            $this->jsonOutPut(0, '请输入正确的手机号');
        } elseif ($this->userInfo['phone'] == $phone) {
            $this->jsonOutPut(1, '未作改动');
        }
        $_uinfo = Users::findByPhone($phone);
        if ($_uinfo) {
            $this->jsonOutPut(0, '该手机号已被注册');
        }
        $now = zmf::now();
        $sendInfo = Msg::model()->find('uid=:uid AND phone=:p AND type=:t AND code=:code AND expiredTime>=:now', array(':uid' => $this->uid, ':p' => $this->userInfo['phone'], ':t' => 'exphone', ':code' => $code, ':now' => $now));
        if (!$sendInfo) {
            $this->jsonOutPut(0, '验证码错误，请重试');
        } elseif ($sendInfo['expiredTime'] < $now) {
            $this->jsonOutPut(0, '验证码已过期，请重新发送');
        }
        if (Users::model()->updateByPk($this->uid, array('phone' => $phone))) {
            $this->jsonOutPut(1, '修改成功');
        } else {
            $this->jsonOutPut(0, '未知错误，修改失败');
        }
    }

    private function exPasswd()
    {
        $this->checkLogin();
        $passwd = zmf::val('passwd', 1);
        $code = zmf::val('code', 2);
        if (!$passwd || !$code) {
            $this->jsonOutPut(0, '缺少参数');
        } elseif (strlen($passwd) < 6) {
            $this->jsonOutPut(0, '密码不能短于6位');
        }
        $now = zmf::now();
        $sendInfo = Msg::model()->find('uid=:uid AND phone=:p AND type=:t AND code=:code AND expiredTime>=:now', array(':uid' => $this->uid, ':p' => $this->userInfo['phone'], ':t' => 'expasswd', ':code' => $code, ':now' => $now));
        if (!$sendInfo) {
            $this->jsonOutPut(0, '验证码错误，请重试');
        } elseif ($sendInfo['expiredTime'] < $now) {
            $this->jsonOutPut(0, '验证码已过期，请重新发送');
        }
        if (Users::model()->updateByPk($this->uid, array('password' => md5($passwd)))) {
            $this->jsonOutPut(1, '修改成功');
        } else {
            $this->jsonOutPut(0, '未知错误，修改失败');
        }
    }

    private function search()
    {
        $keyword = zmf::val('keyword', 1);
        if (!$keyword) {
            $this->jsonOutPut(0, '请输入关键词');
        }
        $name = '%' . strtr($keyword, array('%' => '\%', '_' => '\_', '\\' => '\\\\')) . '%';
        $sql = "SELECT id,title,`name` FROM " . Tags::tableName() . " WHERE title LIKE '$name' AND isDisplay=1 LIMIT 10";
        $items = zmf::dbAll($sql);
        if (empty($items)) {
            $this->jsonOutPut(0, '暂无相关结果');
        }
        $str = '';
        foreach ($items as $item) {
            $str .= zmf::link($item['title'], array('index/index', 'colName' => $item['name']), array('target' => '_blank', 'class' => '_search_item'));
        }
        $this->jsonOutPut(1, $str);
    }

    public function checkLoginHtml()
    {
        if ($this->uid) {
            $html = $this->renderPartial('/site/_loginNav', array(), true);
            $this->jsonOutPut(1, $html);
        }
        $this->jsonOutPut(0, '');
    }


    private function loginVolunteers()
    {
        if ($this->uid) {
            $this->jsonOutPut(1, '已登录');
        }
        $ip = ip2long(Yii::app()->request->userHostAddress);
        if (zmf::actionLimit('login', $ip, 60, 86400, 1, 1)) {
            $this->jsonOutPut(0, '错误操作太频繁，请稍后再试');
        }

        $username = zmf::val('username', 1);
        $password = zmf::val('password', 1);
        if (!$username || !$password) {
            $this->jsonOutPut(0, '参数不完整');
        }
        $password = md5($password);
        //自动登录
        $data = Users::findByUsernameV($username, $password);
        if (!$data) {
            $data = Users::findByPhoneV($username, $password);
        }

        if (!$data) {
            $this->jsonOutPut(0, '用户名或者密码错误');
        }

        if ($data['status'] == Users::STATUS_NOTPASSED){
            $this->jsonOutPut(0, '您的账号还没有通过审核，请耐心等待');
        }

        $_identity = new U($data->phone, $password);
        $_identity->simpleAuth();
        if ($_identity->errorCode === U::ERROR_NONE) {
            $duration = 2592000; //一个月
            if (Yii::app()->user->login($_identity, $duration))
            {
                $uid = zmf::uid();
            }else{
                $this->jsonOutPut(0, '登录失败，请重试');

            }
        }
        if ($this->referer) {
            $url = $this->referer;
        } else {
            $url = zmf::config('baseurl');
        }
        $this->jsonOutPut(1, $url);

    }
}
