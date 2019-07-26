<?php

/**
 * This is the model class for table "{{msg}}".
 *
 * The followings are the available columns in table '{{msg}}':
 * @property string $id
 * @property string $uid
 * @property string $phone
 * @property string $code
 * @property string $content
 * @property integer $expiredTime
 * @property string $type
 */

Yii::import('application.vendors.dysms.*');
require_once 'SignatureHelper.php';

use Aliyun\DySDKLite\SignatureHelper;

class Msg extends CActiveRecord
{

    const ACTIVE_PASSED = 1; //验证通过
    const ACTIVE_ERROR = 0; //验证错误
    const ACTIVE_EXPIRED = -1; //已过期
    const TYPE_SMS = 1;
    const TYPE_VOICE = 2;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{msg}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('phone, code, expiredTime, type', 'required'),
            array('expiredTime,cTime,status,sendType,voiceStatus', 'numerical', 'integerOnly' => true),
            array('uid, phone', 'length', 'max' => 11),
            array('voiceId,appInfo', 'length', 'max' => 32),
            array('code,appType', 'length', 'max' => 8),
            array('content', 'length', 'max' => 255),
            array('type,cTime', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('uid, phone', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => '短信ID',
            'uid' => '用户ID',
            'phone' => '电话号码',
            'code' => '验证码',
            'content' => '短信内容',
            'expiredTime' => '过期时间',
            'type' => '业务类型',
            'cTime' => '生成时间',
            'status' => '短信状态',
            'sendType' => '发送类别',
            'voiceStatus' => '语音接听状态',
            'voiceId' => '语言消息ID',
            'appInfo' => '软件版本',
            'appType' => '软件类型',
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
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $criteria = new CDbCriteria;
        $criteria->compare('uid', $this->uid, true);
        $criteria->compare('phone', $this->phone, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Msg the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function returnTemplate($type)
    {
        switch ($type) {
            case 'reg':
                $content = 'SMS_133155758';
                break;
            case 'forget':
                $content = 'SMS_133155758';
                break;
            case 'dapipi':
                $content = 'SMS_133155758';
                break;
            default :
                $content = 'SMS_133155758';
                break;
        }
        return $content;
    }

    public static function exTypes($type)
    {
        $arr = array(
            'reg' => '注册',
            'forget' => '找回密码',
            'exphone' => '更换手机',
            'checkPhone' => '验证手机',
        );
        if ($type == 'admin') {
            return $arr;
        }
        return $arr[$type];
    }

    /**
     * 用户发送短信验证码
     * @param type $userData
     * @param type $type
     * @return boolean
     */
    public static function initSend($userData, $type, $platform = '', $appinfo = '')
    {
        //时间有效期
        $_time = zmf::now();
        $time = $_time + 15 * 60;
        $code = zmf::simpleRand(4);
        $template = Msg::returnTemplate($type);
        $attr = array(
            'uid' => $userData['id'],
            'phone' => $userData['phone'],
            'type' => $type,
            'sendType' => Msg::TYPE_SMS,
            'code' => $code,
            'expiredTime' => $time,
            'cTime' => $_time,
            'content' => $template,
            'appInfo' => $appinfo,
            'appType' => $platform,
        );
        $model = new Msg();
        $model->attributes = $attr;
        if ($model->save()) {
            $params = array(
                'phone' => $userData['phone'],
                'code' => $code,
                'template' => $template,
            );
            $status = Msg::sendOne($params);
            return $status;
        }
        return false;
    }

    /**
     * 自定义短信参数
     * @param array $userData
     * @param string $type
     * @param array $params
     * @return boolean
     */
    public static function sendWithParams($userData, $type, $params)
    {
        //时间有效期
        $_time = zmf::now();
        $template = Msg::returnTemplate($type);
        $attr = array(
            'uid' => $userData['id'],
            'phone' => $userData['phone'],
            'type' => $type,
            'sendType' => Msg::TYPE_SMS,
            'code' => $type,
            'expiredTime' => $_time,
            'cTime' => $_time,
            'content' => $template,
        );
        $model = new Msg();
        $model->attributes = $attr;
        if ($model->save()) {
            $attr = array(
                'sign' => '简居客家具',
                'phone' => $userData['phone'],
                'attr' => $params,
                'template' => $template,
            );
            return Msg::sendMsg($attr);
        }
        return false;
    }

    public static function sendOne($params)
    {
        $attr = array(
            'sign' => '简居客家居',
            'phone' => $params['phone'],
            'attr' => array(
                'code' => $params['code']
            ),
            'template' => $params['template'],
        );
        return Msg::sendMsg($attr);
    }

    public static function sendMsg($attr)
    {
        $params = array();

        // *** 需用户填写部分 ***
        // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
        $accessKeyId = "LTAI3gcMe9IqR57p";
        $accessKeySecret = "Ec1AI0ZZKFnCkyoTySY0QuYjDGXETm";
        // fixme 必填: 短信接收号码
        $params["PhoneNumbers"] = $attr['phone'];
        // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $params["SignName"] = $attr['sign'];
        // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $params["TemplateCode"] = $attr['template'];
        // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
        $params['TemplateParam'] = $attr['attr'];
        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if (!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }
        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new SignatureHelper();
        // 此处可能会抛出异常，注意catch
        try {
            $content = $helper->request(
                $accessKeyId,
                $accessKeySecret,
                "dysmsapi.aliyuncs.com",
                array_merge($params, array(
                    "RegionId" => "cn-hangzhou",
                    "Action" => "SendSms",
                    "Version" => "2017-05-25",
                ))
            );
            return $content->Code == 'OK';
        } catch (Exception $e) {
            zmf::fp($e, 1);
            return false;
        }
    }

    /**
     * 根据手机号判断当天已发送短信数量
     * @param type $phone
     * @return type
     */
    public static function statByPhone($phone)
    {
        $now = zmf::now();
        $time = strtotime(zmf::time($now, 'Y-m-d'), $now);
        $count = Msg::model()->count('phone=:p AND cTime>=:t AND cTime<=:n', array(':p' => $phone, ':t' => $time, ':n' => $now));
        return $count;
    }

    /**
     * 转换短信发送状态
     * @param type $type
     * @return string
     */
    public static function sendTypes($type)
    {
        $arr = array(
            static::TYPE_SMS => '短信',
            static::TYPE_VOICE => '语音'
        );
        return $arr[$type];
    }

    /**
     * 语音状态转换
     * @param type $type
     * @return string
     */
    public static function voiceStatus($type)
    {
        $arr = array(
            '1' => '已接听', //真实返回数据为0,1,2
            '2' => '未接通',
            '3' => '呼叫失败',
            '0' => '--',
            '-1' => '已挂断',
        );
        return $arr[$type];
    }

    public static function smsStatus($type)
    {
        $arr = array(
            static::ACTIVE_ERROR => '发送',
            static::ACTIVE_EXPIRED => '已过期',
            static::ACTIVE_PASSED => '已使用',
        );
        if ($type == 'admin') {
            return $arr;
        }
        return $arr[$type];
    }

    /**
     * 查询短信记录
     * @param string $type
     * @param int $phone
     * @param bool $useable 是否必须为未使用的记录
     * @return mixed
     */
    public static function findOne($type, $phone, $useable = false)
    {
        $now = zmf::now();
        $sendInfo = Msg::model()->find(array(
            'condition' => 'phone=:phone AND type=:type AND expiredTime>=:now ' . ($useable ? ' AND status=0' : ''),
            'params' => array(
                ':phone' => $phone,
                ':type' => $type,
                ':now' => $now,
            ),
            'order' => 'cTime DESC'
        ));
        return $sendInfo;
    }


}
