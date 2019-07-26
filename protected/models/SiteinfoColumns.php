<?php

/**
 * This is the model class for table "{{siteinfo_columns}}".
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2018 阿年飞少 
 * @datetime 2018-03-02 01:58:17
 * The followings are the available columns in table '{{siteinfo_columns}}':
 * @property integer $id
 * @property string $title
 * @property string $order
 * @property string $cTime
 */
class SiteinfoColumns extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{siteinfo_columns}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cTime,order', 'default', 'setOnEmpty' => true, 'value' => zmf::now()),
            array('title', 'required'),
            array('title', 'length', 'max' => 255),
            array('order, cTime', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, order, cTime', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => '标题',
            'order' => '排序',
            'cTime' => '时间',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('order', $this->order, true);
        $criteria->compare('cTime', $this->cTime, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SiteinfoColumns the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getOne($id) {
        return self::model()->findByPk($id);
    }
    
    public static function listAll($limit=0){
        return CHtml::listData(static::model()->findAll(array(
            'order'=>'`order` ASC',
            'limit'=>$limit>0 ? $limit : 1000
        )), 'id', 'title');
    }

}
