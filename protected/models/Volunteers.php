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
			array('id, username, password, truename, cTime, score, status, email, cardIdType, cardId, sex, birthday, phone, politics, nation, address, education, work', 'required'),
			array('id, cTime, status, cardIdType, cardId, sex, birthday, phone, politics, nation, education, work', 'numerical', 'integerOnly'=>true),
			array('score', 'numerical'),
			array('username, password, truename', 'length', 'max'=>16),
			array('email, address', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, password, truename, cTime, score, status, email, cardIdType, cardId, sex, birthday, phone, politics, nation, address, education, work', 'safe', 'on'=>'search'),
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
			'username' => '用户名',
			'password' => '密码',
			'truename' => '真实姓名',
			'cTime' => '注册时间',
			'score' => '自愿评分',
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('truename',$this->truename,true);
		$criteria->compare('cTime',$this->cTime);
		$criteria->compare('score',$this->score);
		$criteria->compare('status',$this->status);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('cardIdType',$this->cardIdType);
		$criteria->compare('cardId',$this->cardId);
		$criteria->compare('sex',$this->sex);
		$criteria->compare('birthday',$this->birthday);
		$criteria->compare('phone',$this->phone);
		$criteria->compare('politics',$this->politics);
		$criteria->compare('nation',$this->nation);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('education',$this->education);
		$criteria->compare('work',$this->work);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Volunteers the static model class
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
