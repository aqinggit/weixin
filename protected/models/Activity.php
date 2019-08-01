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
 * @property integer $activityTime
 * @property string $place
 * @property integer $uid
 * @property integer $score
 * @property string $faceImg
 */
class Activity extends CActiveRecord
{
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
			array('id, title, content, cTime, status, activityTime, place, uid, score, faceImg', 'required'),
			array('id, cTime, status, activityTime, uid, score', 'numerical', 'integerOnly'=>true),
			array('title, content, place, faceImg', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, content, cTime, status, activityTime, place, uid, score, faceImg', 'safe', 'on'=>'search'),
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
			'activityTime' => '活动时间',
			'place' => '活动地点',
			'uid' => '创建人',
			'score' => '评分',
			'faceImg' => '封面图',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('cTime',$this->cTime);
		$criteria->compare('status',$this->status);
		$criteria->compare('activityTime',$this->activityTime);
		$criteria->compare('place',$this->place,true);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('score',$this->score);
		$criteria->compare('faceImg',$this->faceImg,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Activity the static model class
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
