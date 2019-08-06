<?php

/**
 * This is the model class for table "{{activity}}".
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2019 阿年飞少
 * @datetime 2019-08-01 21:50:46
 * The followings are the available columns in table '{{activity}}':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $cTime
 * @property integer $status
 * @property integer $startTime
 * @property string $place
 * @property integer $uid
 * @property integer $score
 * @property string $faceImg
 */
class Activity extends CActiveRecord
{
    const PASS = 1;
    const NOPASS = 0;
    const DEL = 3;
    const Recruit = 4;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{activity}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, content, count, place,startTime,endTime,phone,responsible,volunteerType', 'required'),
            array('id, cTime, status, count, uid, score', 'numerical', 'integerOnly' => true),
            array('title, content, place, faceImg', 'length', 'max' => 255),
            // The following rule is used by search().
            array('id, title', 'safe', 'on' => 'search'),
            array('status', 'default', 'setOnEmpty' => true, 'value' => Users::STATUS_NOTPASSED),
            array('cTime', 'default', 'setOnEmpty' => true, 'value' => zmf::now()),
            array('uid', 'default', 'setOnEmpty' => true, 'value' => zmf::uid()),
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
            'UserInfo' => array(self::BELONGS_TO, 'Users', 'uid'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => '标题',
            'content' => '正文',
            'cTime' => '创建时间',
            'status' => '状态',
            'count' => '招募人数',
            'startTime' => '开始时间',
            'endTime' => '结束时间',
            'responsible' => '负责人姓名',
            'phone' => '负责人手机号码',
            'place' => '活动地点',
            'uid' => '创建人',
            'score' => '评分',
            'faceImg' => '封面图',
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
        $criteria->compare('title', $this->title, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Activity the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getOne($id)
    {
        return self::model()->findByPk($id);
    }

    public static function Status($key = -1)    {
        $item = array(
            0 => '未审核',
            1 => '通过',
            3 => '删除',
        );
        if ($key > -1) {
            return $item[$key];
        } else {
            return $item;
        }
    }

}
