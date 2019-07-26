<?php

/**
 * This is the model class for table "{{sitepath}}".
 *
 * The followings are the available columns in table '{{sitepath}}':
 * @property string $id
 * @property string $logid
 * @property string $classify
 * @property string $name
 */
class Sitepath extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{sitepath}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('logid, classify, name', 'required'),
			array('name', 'unique'),
			array('logid', 'length', 'max'=>10),
			array('classify', 'length', 'max'=>16),
			array('name', 'length', 'max'=>32),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, logid, classify, name', 'safe', 'on'=>'search'),
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
			'id' => '关系ID',
			'logid' => '对象',
			'classify' => '分类',
			'name' => '路径',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('logid',$this->logid,true);
		$criteria->compare('classify',$this->classify,true);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Sitepath the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * 根据路径查找
     * @param $name
     * @return array|mixed|null
     */
	public static function findByName($name){
	    if(!$name){
	        return null;
        }
	    return static::model()->find('name=:name',array(
	        ':name'=>$name
        ));
    }

    /**
     * 更新记录
     * @param string $type
     * @param int $id
     * @param string $name
     * @return bool
     */
    public static function updateOne($type,$id,$name){
	    $info=static::findByName($name);
	    if($info['classify']==$type && $info['logid']==$id && $info['name']==$name){//全等
	        return true;
        }elseif($info){//路径已经存在，则不更新
	        return false;
        }
        $model=new Sitepath();
	    $model->attributes=array(
            'logid' => $id,
            'classify' => $type,
            'name' => $name,
        );
	    return $model->save();
    }
}
