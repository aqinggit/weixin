<?php

/**
 * This is the model class for table "{{questions}}".
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2019 阿年飞少
 * @datetime 2019-08-04 09:57:24
 * The followings are the available columns in table '{{questions}}':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $status
 * @property integer $cTime
 * @property integer $uid
 * @property string $answers
 * @property integer $score
 * @property integer $type
 */
class Questions extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{questions}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, content, answers, score, type', 'required'),
            array('id, status, cTime, uid, score, type', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 255),
            array('content, answers', 'length', 'max' => 2550),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, content, status, cTime, uid, answers, score, type', 'safe', 'on' => 'search'),
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
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => '标题',
            'content' => '内容',
            'status' => '状态',
            'cTime' => '创建时间',
            'uid' => '创建人',
            'answers' => '答案',
            'score' => '分值',
            'type' => '类型',
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
        $criteria->compare('title', $this->title, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('cTime', $this->cTime);
        $criteria->compare('uid', $this->uid);
        $criteria->compare('answers', $this->answers, true);
        $criteria->compare('score', $this->score);
        $criteria->compare('type', $this->type);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Questions the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getOne($id)
    {
        return self::model()->findByPk($id);
    }

    public static function Type($key = -1)
    {
        $item = array(
            1 => '单选',
            2 => '多选',
            3 => '判断',
            4 => '问答',
        );
        if ($key > -1) {
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
            3 => '删除',
        );
        if ($key > -1) {
            return $item[$key];
        } else {
            return $item;
        }
    }
}
