<?php

/**
 * This is the model class for table "{{volunteers}}".
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2019 阿年飞少
 * @datetime 2019-08-01 21:45:43
 * The followings are the available columns in table '{{volunteers}}':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $truename
 * @property integer $cTime
 * @property double $score
 * @property integer $status
 * @property string $email
 * @property integer $cardIdType
 * @property integer $cardId
 * @property integer $sex
 * @property integer $birthday
 * @property integer $phone
 * @property integer $politics
 * @property integer $nation
 * @property string $address
 * @property integer $education
 * @property integer $work
 */
class Volunteers extends CActiveRecord
{

    public $password2;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{volunteers}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, password,password2, truename, cardIdType, cardId, phone, politics, nation, education, work,sex,birthday,address,email,volunteerType', 'required'),
            array('id, cTime, status, cardIdType, cardId, sex, birthday, phone, politics, nation, education, work,volunteerType', 'numerical', 'integerOnly' => true),
            array('score', 'numerical'),
            array('username, truename', 'length', 'max' => 16),
            array('password', 'length', 'max' => 32),
            array('email, address', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('truename,cardId, phone', 'safe', 'on' => 'search'),

            array('status', 'default', 'setOnEmpty' => true, 'value' => Users::STATUS_NOTPASSED),
            array('cTime', 'default', 'setOnEmpty' => true, 'value' => zmf::now()),
            array('ip', 'default', 'setOnEmpty' => true, 'value' => ip2long(Yii::app()->request->userHostAddress)),
            array('password2', 'compare', 'compareAttribute' => 'password', 'message' => '两次输入的密码不一致'),
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
            'id' => 'ID',
            'username' => '用户名',
            'password' => '密码',
            'truename' => '真实姓名',
            'cTime' => '注册时间',
            'score' => '评分',
            'status' => '状态',
            'email' => '邮箱',
            'cardIdType' => '身份证类型',
            'cardId' => '身份证号码',
            'sex' => '性别',
            'birthday' => '生日',
            'phone' => '手机',
            'politics' => '政治面貌',
            'nation' => '民族',
            'address' => '具体地址',
            'education' => '学历',
            'work' => '工作情况',
            'ip' => '注册ip',
            'password2' => '确认密码',
            'volunteerType' => '志愿者类型',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('truename', $this->truename, true);
        $criteria->compare('cardId', $this->cardId);
        $criteria->compare('phone', $this->phone);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Volunteers the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getOne($id)
    {
        return self::model()->findByPk($id);
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


    public static function VolunteerType($key = -1)
    {
        $item = array(
            0 => '请选择',
            1 => '平安建设志愿者',
            2 => '社会治理志愿者',
            3 => '法制宣传志愿者',
        );
        if ($key>=0) {
            return $item[$key];
        } else {
            return $item;
        }
    }

    public static function Status($key = -1)
    {
        $item = array(
            0 => '未审核',
            1 => '通过',
            2 => '注销',
            3 => '删除',
        );
        if ($key > -1) {
            return $item[$key];
        } else {
            return $item;
        }
    }

}
