<?php

/**
 * This is the model class for table "{{volunteer_active}}".
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2019 阿年飞少 
 * @datetime 2019-08-07 08:52:56
 * The followings are the available columns in table '{{volunteer_active}}':
 * @property integer $id
 * @property integer $vid
 * @property integer $aid
 * @property double $score
 * @property integer $cTime
 * @property integer $status
 */
class VolunteerActive extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{volunteer_active}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vid, aid', 'required'),
			array('vid, aid, cTime, status', 'numerical', 'integerOnly'=>true),
			array('score', 'numerical'),
            array('cTime', 'default', 'setOnEmpty' => true, 'value' => zmf::now()),
            array('status', 'default', 'setOnEmpty' => true, 'value' => Users::STATUS_NOTPASSED),
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
		    'ActivityInfo' => array(self::BELONGS_TO, 'Activity', 'aid'),
		    'UsersInfo' => array(self::BELONGS_TO, 'Users', 'vid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'vid' => '志愿者',
			'aid' => '活动',
			'score' => '评分',
			'cTime' => '申请时间',
			'status' => '状态',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('vid',$this->vid);
		$criteria->compare('aid',$this->aid);
		$criteria->compare('score',$this->score);
		$criteria->compare('cTime',$this->cTime);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VolunteerActive the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function getOne($id)
	{
		return self::model()->findByPk($id);
	}
}
