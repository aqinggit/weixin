<?php

/**
 * This is the model class for table "{{search_words}}".
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2018 阿年飞少 
 * @datetime 2018-02-08 06:26:40
 * The followings are the available columns in table '{{search_words}}':
 * @property string $id
 * @property string $title
 * @property string $url
 * @property string $order
 * @property string $cTime
 * @property string $updateTime
 * @property integer $status
 * @property string $color
 */
class SearchWords extends CActiveRecord {

    const POI_NAV=1;
    const POI_DROPDOWN=2;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{search_words}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cTime,updateTime', 'default', 'setOnEmpty' => true, 'value' => zmf::now()),
            array('title, url', 'required'),
            array('status,position', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 32),
            array('url', 'length', 'max' => 255),
            array('order, cTime, updateTime', 'length', 'max' => 10),
            array('color', 'length', 'max' => 8),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, url, order, cTime, updateTime, status, color', 'safe', 'on' => 'search'),
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
            'title' => '关键词',
            'url' => '链接',
            'order' => '排序',
            'cTime' => '创建时间',
            'updateTime' => '更新时间',
            'status' => '显示',
            'color' => '颜色',
            'position' => '位置',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('order', $this->order, true);
        $criteria->compare('cTime', $this->cTime, true);
        $criteria->compare('updateTime', $this->updateTime, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('color', $this->color, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SearchWords the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getOne($id) {
        return self::model()->findByPk($id);
    }

    /**
     * 按位置获取热门词
     * @param int $limit
     * @param int $poi
     * @return array
     */
    public static function getWords($limit=10,$poi=SearchWords::POI_NAV){
        return static::model()->findAll(array(
            'condition'=>'status=1 AND position=:poi',
            'order'=>'`order` ASC',
            'select'=>'id,title,url',
            'limit'=>$limit,
            'params'=>array(
                ':poi'=>$poi
            )
        ));
    }

    /**
     * 位置
     * @param string $type
     * @return array|mixed
     */
    public static function exPoi($type){
        $arr=array(
            static::POI_NAV=>'导航',
            static::POI_DROPDOWN=>'下拉',
        );
        return $type=='admin' ? $arr : $arr[$type];
    }

}
