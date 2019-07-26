<?php

/**
 * This is the model class for table "{{weixin}}".
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2016 阿年飞少 
 * @datetime 2016-04-12 04:51:40
 * The followings are the available columns in table '{{weixin}}':
 * @property string $id
 * @property string $openid
 * @property string $unionid
 * @property string $username
 * @property string $avatar
 * @property string $sex
 * @property string $data
 * @property string $cTime
 * @property string $updateTime
 * @property string $ip
 * @property string $ipInfo
 */
class Weixin extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{weixin}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cTime,updateTime', 'default', 'setOnEmpty' => true, 'value' => zmf::now()),
            array('ip', 'default', 'setOnEmpty' => true, 'value' => ip2long(Yii::app()->request->userHostAddress)),
            array('openid, username', 'required'),
            array('openid, unionid, username, avatar, sex, ipInfo,access_token,refresh_token', 'length', 'max' => 255),
            array('cTime, updateTime,uid,expires,pid', 'length', 'max' => 10),
            array('ip', 'length', 'max' => 16),
            array('data', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, openid, unionid, username, avatar, sex, data, cTime, updateTime, ip, ipInfo', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'openid' => '微信ID',
            'unionid' => '微信ID',
            'username' => '微信名',
            'avatar' => '微信头像',
            'sex' => '性别',
            'data' => '微信信息',
            'cTime' => '创建时间',
            'updateTime' => '更新时间',
            'ip' => 'IP',
            'ipInfo' => 'IP信息',
            'uid' => '所属用户',
            'pid' => '所属商户',
            'access_token' => 'access_token',
            'refresh_token' => 'refresh_token',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('uid', $this->uid, true);
        $criteria->compare('openid', $this->openid, true);
        $criteria->compare('unionid', $this->unionid, true);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('avatar', $this->avatar, true);
        $criteria->compare('sex', $this->sex, true);
        $criteria->compare('data', $this->data, true);
        $criteria->compare('cTime', $this->cTime, true);
        $criteria->compare('updateTime', $this->updateTime, true);
        $criteria->compare('ip', $this->ip, true);
        $criteria->compare('ipInfo', $this->ipInfo, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Weixin the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 将获取的微信信息存入数据库
     * @param type $params
     * @return type
     */
    public static function addCookie($params) {
        $attr = array(
            'uid' => $params['uid'],
            'openid' => $params['openid'],
            'unionid' => $params['unionid'],
            'access_token' => $params['access_token'],
            'refresh_token' => $params['refresh_token'],
            'expires' => $params['expires'],
            'app' => $params['app'],
            'web' => $params['web'],
            'data' => $params['data']
        );
        $model = new Weixin;
        $model->attributes = $attr;
        return $model->save();
    }

    /**
     * 获取微信TOKEN
     * @return array
     */
    public static function getAcessToken() {
        $appid = zmf::config('weixin_app_id');
        $secret = zmf::config('weixin_app_key');
        if (!$appid || !$secret) {
            return array(
                'status' => 0,
                'msg' => '缺少微信配置信息'
            );
        }
        $token = zmf::getFCache("weixin-access-token");
        if (!$token) {
            $token_url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $appid . '&secret=' . $secret;
            Yii::import('application.vendors.Curl.*');
            require_once 'Curl.php';
            $res = new Curl();
            $info = $res->get($token_url);
            if (!$info) {
                return array(
                    'status' => 0,
                    'msg' => '获取微信TOKEN失败'
                );
            }
            $arr = CJSON::decode($info, true);
            if ($arr['errcode'] != '' || $arr['errcode'] != 0) {
                return array(
                    'status' => 0,
                    'msg' => $arr['errmsg']
                );
            } else {
                $token = $arr['access_token'];
                zmf::setFCache('weixin-access-token', $arr['access_token'], 3600);
            }
        }
        return array(
            'status' => 1,
            'msg' => $token
        );
    }

    public static function getIndustry() {
        $tokenInfo = self::getAcessToken();
        if (!$tokenInfo['status']) {
            return $tokenInfo;
        }
        $token_url = 'https://api.weixin.qq.com/cgi-bin/template/get_industry?access_token=' . $tokenInfo['msg'];
        Yii::import('application.vendors.Curl.*');
        require_once 'Curl.php';
        $res = new Curl();
        $info = $res->get($token_url);
        zmf::test(CJSON::decode($info, true));
    }

    public static function getAllPrivateTemplate() {
        $tokenInfo = self::getAcessToken();
        if (!$tokenInfo['status']) {
            return $tokenInfo;
        }
        $token_url = 'https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token=' . $tokenInfo['msg'];
        Yii::import('application.vendors.Curl.*');
        require_once 'Curl.php';
        $res = new Curl();
        $info = $res->get($token_url);
        zmf::test(CJSON::decode($info, true));
    }

    public static function sendTemplateMsg($openid, $msgData, $url = '', $templateId = '') {
        if (!$templateId) {
            return false;
        }
        $data = array(
            'touser' => $openid,
            'template_id' => $templateId,
            'url' => $url,
            'data' => $msgData
        );
        $dataStr = CJSON::encode($data);
        $tokenInfo = self::getAcessToken();
        if (!$tokenInfo['status']) {
            zmf::delFCache('weixin-access-token');
            return $tokenInfo;
        }
        $token_url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $tokenInfo['msg'];
        Yii::import('application.vendors.Curl.*');
        require_once 'Curl.php';
        $res = new Curl();
        $info = $res->post($token_url, $dataStr);
        $infoArr = CJSON::decode($info, true);
        if ($infoArr['errmsg'] != 'ok') {
            zmf::fp(zmf::time());
            zmf::fp($infoArr, 1);
            zmf::delFCache('weixin-access-token');
            return false;
        }
        return true;
    }

    public static function sendWeixinMsg($action, $data, $url = '') {
        $templateId = '';
        if (!in_array($action, array('weixinNewOrder', 'weixinNewPaid'))) {
            return false;
        } elseif ($action == 'weixinNewOrder') {
            $templateId = 'EAAyQN2Gq9jIzCG1pJrzk11-bAX8KmGRscpoDJiEtYs';
        } elseif ($action == 'weixinNewPaid') {
            $templateId = '-gVPpvMRI7wQHEWImkicNlA3iD_E895jVIf6q4e5mj0';
        }
        $sql = "SELECT wx.openid FROM {{weixin}} wx,{{admins}} a WHERE a.powers='{$action}' AND a.uid=wx.uid";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($items)) {
            return false;
        }
        foreach ($items as $val) {
            self::sendTemplateMsg($val['openid'], $data, $url, $templateId);
        }
        return true;
    }    

}
