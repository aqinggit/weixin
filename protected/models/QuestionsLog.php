<?php

/**
 * This is the model class for table "{{questions_log}}".
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2019 阿年飞少
 * @datetime 2019-09-09 00:00:18
 * The followings are the available columns in table '{{questions_log}}':
 * @property integer $id
 * @property integer $cTime
 * @property integer $status
 * @property string $phone
 * @property string $questions
 * @property string $answers
 * @property string $ip
 * @property integer $socre
 * @property integer $street
 * @property integer $department
 */
class QuestionsLog extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{questions_log}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('phone, questions, answers, socre', 'required'),
            array('id, cTime, status, socre,street,department', 'numerical', 'integerOnly' => true),
            array('ip', 'default', 'setOnEmpty' => true, 'value' => ip2long(Yii::app()->request->userHostAddress)),
            array('cTime', 'default', 'setOnEmpty' => true, 'value' => zmf::now()),
            array('status', 'default', 'setOnEmpty' => true, 'value' => Users::STATUS_PASSED),
            array('phone', 'length', 'max' => 13),
            array('questions, answers, ip', 'length', 'max' => 2550),
            array('phone,ip', 'safe', 'on' => 'search'),
            array('phone', 'match', 'pattern' => '/^[1][34578][0-9]{9}$/'),
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
            'cTime' => '时间',
            'status' => '状态',
            'phone' => '手机号码',
            'questions' => '问题',
            'answers' => '回答',
            'ip' => 'Ip',
            'socre' => '得分',
            'street' => '街道',
            'department' => '部门',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('cTime', $this->cTime);
        $criteria->compare('status', $this->status);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('questions', $this->questions, true);
        $criteria->compare('answers', $this->answers, true);
        $criteria->compare('ip', $this->ip, true);
        $criteria->compare('socre', $this->socre);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return QuestionsLog the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getOne($id)
    {
        return self::model()->findByPk($id);
    }
}
