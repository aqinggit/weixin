<?php

/**
 * This is the model class for table "{{users}}".
 *
 * The followings are the available columns in table '{{users}}':
 * @property integer $id
 * @property string $truename
 * @property string $password
 * @property string $contact
 * @property string $avatar
 * @property string $content
 * @property integer $hits
 * @property integer $sex
 * @property integer $isAdmin
 * @property integer $status
 */
class Users extends CActiveRecord {

    public $newPassword;
    public $groupName;
    public $authorName;

    const STATUS_NOTPASSED = 0;
    const STATUS_PASSED = 1;
    const STATUS_STAYCHECK = 2;
    const STATUS_DELED = 3;
    //关于来源
    const PLATFORM_UNKOWN = 0;
    const PLATFORM_WEB = 1;
    const PLATFORM_MOBILE = 2;
    const PLATFORM_ANDROID = 3;
    const PLATFORM_IOS = 4;
    const PLATFORM_WEAPP = 5; //微信小程序

    //案例分类
    const CLASSIFY_CASE = 1;//案例
    const CLASSIFY_GALLERY = 2;//图库

    const DEFAULT_AVATAR = 'https://img2.chuxincw.com/siteinfo/2017/02/18/32DD3F5E-18B2-DA78-549C-9E7F89731A1B.png';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{users}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('truename,password', 'required'),
            array('cTime', 'default', 'setOnEmpty' => true, 'value' => zmf::now()),
            array('status', 'default', 'setOnEmpty' => true, 'value' => Users::STATUS_PASSED),
            array('platform', 'default', 'setOnEmpty' => true, 'value' => Users::PLATFORM_WEB),
            array('ip', 'default', 'setOnEmpty' => true, 'value' => ip2long(Yii::app()->request->userHostAddress)),
            array('hits, sex, isAdmin, status,phoneChecked', 'numerical', 'integerOnly' => true),
            array('truename,ip,gold,levelTitle', 'length', 'max' => 16),
            array('cTime,authorId,favors,favord,favorAuthors,exp,level,groupid,powerGroupId,score', 'length', 'max' => 10),
            array('phone', 'length', 'max' => 11),
            array('password', 'length', 'max' => 32),
            array('contact,avatar,email,levelIcon', 'length', 'max' => 255),
            array('content', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'powerGroupInfo' => array(self::BELONGS_TO, 'AdminTemplate', 'powerGroupId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'truename' => '用户昵称',
            'phone' => '手机号码',
            'email' => '邮箱地址',
            'password' => '账号密码',
            'newPassword' => '新密码',
            'contact' => '联系方式',
            'avatar' => '用户头像',
            'content' => '个人简介',
            'hits' => '点击次数',
            'sex' => '性别',
            'isAdmin' => '是否管理员',
            'status' => '状态',
            'ip' => '注册IP',
            'cTime' => '注册时间',
            'authorId' => '作者ID',
            'favors' => '粉丝数',
            'favord' => '关注了',
            'favorAuthors' => '收藏作者数',
            'phoneChecked' => '手机号是否已验证',
            'score' => '总积分',
            'gold' => '总金币',
            'exp' => '总经验',
            'level' => '用户等级',
            'levelTitle' => '等级',
            'levelIcon' => '等级图标',
            'groupid' => '用户组',
            'platform' => '来源',
            'powerGroupId' => '权限分组',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Users the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getOne($id) {
        $sql = "SELECT * FROM {{users}} WHERE id=:id";
        $res = Yii::app()->db->createCommand($sql);
        $res->bindValue(':id', $id);
        $info = $res->queryRow();
        $info = static::updateUserStat($info);
        return $info;
    }

    public static function miniOne($id) {
        if(!$id){return false;}
        return static::model()->find(array(
            'condition'=>'id='.$id,
            'select'=>'id,truename,avatar'
        ));
    }

    public static function getUsername($id) {
        $info = static::getOne($id);
        return $info ? $info['truename'] : '';
    }

    public static function userSex($return) {
        $arr = array(
            '0' => '未公开',
            '1' => '男',
            '2' => '女',
        );
        if ($return == 'admin') {
            return $arr;
        }
        return $arr[$return];
    }

    public static function isAdmin($return) {
        $arr = array(
            '0' => '不是',
            '1' => '是',
        );
        if ($return == 'admin') {
            return $arr;
        }
        return $arr[$return];
    }

    public static function userStatus($return) {
        $arr = array(
            Users::STATUS_NOTPASSED => '未激活',
            Users::STATUS_PASSED => '正常',
            Users::STATUS_STAYCHECK => '锁定',
            Users::STATUS_DELED => '删除',
        );
        if ($return == 'admin') {
            return $arr;
        }
        return $arr[$return];
    }

    public static function findByName($truename) {
        $info = Users::model()->find('truename=:truename AND status=' . Users::STATUS_PASSED, array(
            ':truename' => $truename
        ));
        return $info;
    }

    public static function findByPhone($phone) {
        $info = Users::model()->find('phone=:phone AND status=' . Users::STATUS_PASSED, array(
            ':phone' => $phone
        ));
        return $info;
    }

    public static function findByEmail($email) {
        $info = Users::model()->find('email=:email AND status=' . Users::STATUS_PASSED, array(
            ':email' => $email
        ));
        return $info;
    }

    public static function findOne($account) {
        $info = Users::model()->find('(email=:email OR phone=:email) AND status=' . Users::STATUS_PASSED, array(
            ':email' => $account
        ));
        return $info;
    }

    public static function updateInfo($uid, $field, $value = '') {
        if (!$uid || !$field) {
            return false;
        }
        if (!in_array($field, array('password', 'groupid', 'level', 'score', 'exp'))) {
            return false;
        }
        $attr[$field] = $value;
        return Users::model()->updateByPk($uid, $attr);
    }

    public static function checkWealth($uid, $actionType, $totalCost) {
        if (!$uid || !$actionType || !$totalCost) {
            return false;
        }
        if ($actionType == 'score') {
            $totalWealth = 0;
        } elseif ($actionType == 'gold') {
            $totalWealth = 0;
        }
        if ($totalWealth >= $totalCost) {
            return TRUE;
        }
        return false;
    }


    /**
     * 更新用户的统计数据
     * @param array $info
     * @return array $info
     */
    public static function updateUserStat($info) {
        return $info;
    }


    public static function getRandomId(){
        $min= zmf::config('randMinUser');
        $max = zmf::config('randMaxUser');
        return mt_rand($min, $max);
    }

}
