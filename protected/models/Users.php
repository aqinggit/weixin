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
class Users extends CActiveRecord
{

    public $newPassword;
    public $groupName;
    public $authorName;
    public $password2; //确认密码

    const DEFAULT_AVATAR = 'https://img2.chuxincw.com/siteinfo/2017/02/18/32DD3F5E-18B2-DA78-549C-9E7F89731A1B.png';

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{users}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('truename,password', 'required'),
            array('truename', "unique", 'message' => '用户名已经存在'),
            array('cTime', 'default', 'setOnEmpty' => true, 'value' => zmf::now()),
            array('status', 'default', 'setOnEmpty' => true, 'value' => Posts::STATUS_PASSED),
            array('platform', 'default', 'setOnEmpty' => true, 'value' => Posts::PLATFORM_WEB),
            array('ip', 'default', 'setOnEmpty' => true, 'value' => ip2long(Yii::app()->request->userHostAddress)),
            array('hits, sex, isAdmin, status,phoneChecked', 'numerical', 'integerOnly' => true),
            array('truename,ip,gold,levelTitle', 'length', 'max' => 16),
            array('cTime,authorId,favors,favord,favorAuthors,exp,level,groupid,powerGroupId,score', 'length', 'max' => 10),
            array('phone', 'length', 'max' => 11),
            array('certNumber', 'length', 'max' => 18, 'min' => '18'),
            array('password', 'length', 'max' => 32),
            array('contact,avatar,email,levelIcon', 'length', 'max' => 255),
            array('content', 'safe'),
            array('password2', 'compare', 'compareAttribute' => 'password', 'message' => '两次输入的密码不一致'),
            array('country,actualName,certType,certNumber,birthday,politicalStatus,nation,address,highestEdu,employmentStatus,serviceType,joinProject', 'required')
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'groupInfo' => array(static::BELONGS_TO, 'Group', 'groupid'),
            'powerGroupInfo' => array(self::BELONGS_TO, 'AdminTemplate', 'powerGroupId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
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
            'country' => '国家',
            'actualName' => '真实姓名',
            'certType' => '证件类型',
            'certNumber' => '证件号码',
            'birthday' => '出生日期',
            'politicalStatus' => '政治面貌',
            'nation' => '民族',
            'address' => '详细地址',
            'highestEdu' => '最高学历',
            'employmentStatus' => '从业状况',
            'serviceType' => '服务类型',
            'joinProject' => '加入项目',

        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Users the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave()
    {
        $pass = md5($this->password);
        $this->password = $pass;
        return true;
    }

    public static function getOne($id)
    {
        $sql = "SELECT * FROM {{users}} WHERE id=:id";
        $res = Yii::app()->db->createCommand($sql);
        $res->bindValue(':id', $id);
        $info = $res->queryRow();
        if ($info['groupid'] > 0) {
            $info['groupName'] = Group::getTitle($info['groupid']);
        }
        $info = static::updateUserStat($info);
        return $info;
    }

    public static function miniOne($id)
    {
        if (!$id) {
            return false;
        }
        return static::model()->find(array(
            'condition' => 'id=' . $id,
            'select' => 'id,truename,avatar'
        ));
    }

    public static function getUsername($id)
    {
        $info = static::getOne($id);
        return $info ? $info['truename'] : '';
    }

    public static function userSex($return)
    {
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

    public static function isAdmin($return)
    {
        $arr = array(
            '0' => '不是',
            '1' => '是',
        );
        if ($return == 'admin') {
            return $arr;
        }
        return $arr[$return];
    }

    public static function userStatus($return)
    {
        $arr = array(
            Posts::STATUS_NOTPASSED => '未激活',
            Posts::STATUS_PASSED => '正常',
            Posts::STATUS_STAYCHECK => '锁定',
            Posts::STATUS_DELED => '删除',
        );
        if ($return == 'admin') {
            return $arr;
        }
        return $arr[$return];
    }

    public static function findByName($truename)
    {
        $info = Users::model()->find('truename=:truename AND status=' . Posts::STATUS_PASSED, array(
            ':truename' => $truename
        ));
        return $info;
    }

    public static function findByPhone($phone)
    {
        $info = Users::model()->find('phone=:phone AND status=' . Posts::STATUS_PASSED, array(
            ':phone' => $phone
        ));
        return $info;
    }

    public static function findByEmail($email)
    {
        $info = Users::model()->find('email=:email AND status=' . Posts::STATUS_PASSED, array(
            ':email' => $email
        ));
        return $info;
    }

    public static function findOne($account)
    {
        $info = Users::model()->find('(email=:email OR phone=:email) AND status=' . Posts::STATUS_PASSED, array(
            ':email' => $account
        ));
        return $info;
    }

    public static function updateInfo($uid, $field, $value = '')
    {
        if (!$uid || !$field) {
            return false;
        }
        if (!in_array($field, array('password', 'groupid', 'level', 'score', 'exp'))) {
            return false;
        }
        $attr[$field] = $value;
        return Users::model()->updateByPk($uid, $attr);
    }

    public static function checkWealth($uid, $actionType, $totalCost)
    {
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

    public static function costWealth($uid, $actionType, $totalCost, $goodsInfo)
    {
        if (!static::checkWealth($uid, $actionType, $totalCost)) {
            return false;
        }
        if ($actionType == 'score') {
            $_attr = array(
                'uid' => $uid,
                'classify' => 'goods',
                'logid' => $goodsInfo['id'],
                'score' => (-1) * $totalCost
            );
            $_scoreLogModel = new ScoreLogs;
            $_scoreLogModel->attributes = $_attr;
            return $_scoreLogModel->save();
        } elseif ($actionType == 'gold') {
            //todo
            $totalWealth = 0;
        }
        return false;
    }

    /**
     * 更新用户的统计数据
     * @param array $info
     * @return array $info
     */
    public static function updateUserStat($info)
    {
        return $info;
    }

    public static function updateUserExp($userInfo)
    {
        if (!$userInfo['groupid']) {
            return false;
        }
        $info = GroupLevels::model()->find('gid=:gid AND (minExp<=:exp AND maxExp>=:exp)', array(
            ':gid' => $userInfo['groupid'],
            ':exp' => $userInfo['exp'],
        ));
        if (!$info) {
            return false;
        }
        //如果找到了，则认为该用户是这个等级的        
        return Users::model()->updateByPk($userInfo['id'], array(
            'level' => $info['id'],
            'levelTitle' => $info['title'],
            'levelIcon' => $info['icon'],
        ));
    }

    public static function getRandomId()
    {
        $min = zmf::config('randMinUser');
        $max = zmf::config('randMaxUser');
        return mt_rand($min, $max);
    }


    public static function Country($key = 0)
    {
        $item = array(
            '86' => '中国'
        );
        if ($key) {
            return $item[$key];
        } else {
            return $item;
        }

    }

    public static function CertType($key = 0)
    {
        $item = array(
            '1' => '内地居民身份证',
            '2' => '香港居民身份证',
            '3' => '澳门居民身份证',
            '4' => '台湾居民身份证',
            '5' => '护照',
        );
        if ($key) {
            return $item[$key];
        } else {
            return $item;
        }
    }

    public static function Sex($key = 0)
    {
        $item = array(
            '1' => '男',
            '2' => '女',
        );
        if ($key) {
            return $item[$key];
        } else {
            return $item;
        }
    }

    public static function Political($key = 0)
    {
        $item = array(
            '1' => '中国共产党党员',
            '2' => '中国共产党预备党员',
            '3' => '中国共产党党员（保留团籍）',
            '4' => '中国共产主义青年团团员',
            '5' => '中国国民党革命委员会会员',
            '6' => '中国国民党革命委员会会员',
            '7' => '中国民主建国会会员',
            '8' => '中国民主促进会会员',
            '9' => '中国农工民主党党员',
            '10' => '中国致公党党员',
            '11' => '九三学社社员',
            '12' => '台湾民主自治同盟盟员',
            '13' => '无党派民主人士',
            '14' => '中国少年先锋队队员',
            '15' => '群众',
        );
        if ($key) {
            return $item[$key];
        } else {
            return $item;
        }
    }

    public static function EdeGree($key = 0)
    {
        $item = array(
            0 => '请选择',
            1 => '博士研究生',
            2 => '硕士研究生',
            3 => '大学本科',
            4 => '大学专科',
            5 => '中等专科',
            6 => '职业高中',
            7 => '技工学校',
            8 => '高中',
            9 => '初中',
            10 => '小学',
            11 => '其他'
        );
        if ($key) {
            return $item[$key];
        } else {
            return $item;
        }
    }

    public static function Employment($key = 0)
    {
        $item = array(
            0 => '请选择',
            1 => '国家公务员（含参照、依照公务员管理）',
            2 => '专业技术人员',
            3 => '职员',
            4 => '企业管理人员',
            5 => '工人',
            6 => '农民',
            7 => '学生',
            8 => '教师',
            9 => '现役军人',
            10 => '自由职业者',
            11 => '个体经营者',
            12 => '无业人员',
            13 => '退（离）休人员',
            14 => '其他'
        );
        if ($key) {
            return $item[$key];
        } else {
            return $item;
        }
    }


    public static function Ethnicity($key = 0)
    {
        $item = array(
            '1' => '汉族',
            '2' => '蒙古族',
            '3' => '回族',
            '4' => '藏族',
            '5' => '维吾尔族',
            '6' => '苗族',
            '7' => '彝族',
            '8' => '壮族',
            '9' => '布依族',
            '10' => '朝鲜族',
            '11' => '满族',
            '12' => '侗族',
            '13' => '瑶族',
            '14' => '白族',
            '15' => '土家族',
            '16' => '哈尼族',
            '17' => '哈萨克族',
            '18' => '傣族',
            '19' => '黎族',
            '20' => '傈僳族',
            '21' => '佤族',
            '22' => '畲族',
            '23' => '高山族',
            '24' => '拉祜族',
            '25' => '水族',
            '26' => '东乡族',
            '27' => '纳西族',
            '28' => '景颇族',
            '29' => '柯尔克孜族',
            '30' => '土族',
            '31' => '达斡尔族',
            '32' => '仫佬族',
            '33' => '羌族',
            '34' => '布郎族',
            '35' => '撒拉族',
            '36' => '毛南族',
            '37' => '仡佬族',
            '38' => '锡伯族',
            '39' => '阿昌族',
            '40' => '普米族',
            '41' => '塔吉克族',
            '42' => '怒族',
            '43' => '乌孜别克',
            '44' => '俄罗斯族',
            '45' => '鄂温克族',
            '46' => '德昂族',
            '47' => '保安族',
            '48' => '裕固族',
            '49' => '京族',
            '50' => '塔塔尔族',
            '51' => '独龙族',
            '52' => '鄂伦春族',
            '53' => '赫哲族',
            '54' => '门巴族',
            '55' => '珞巴族',
            '56' => '基诺族',
            '57' => '其他',
            '58' => '外国血统中国籍人士',
        );
        if ($key) {
            return $item[$key];
        } else {
            return $item;
        }
    }

}
