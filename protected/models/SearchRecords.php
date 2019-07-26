<?php

/**
 * This is the model class for table "{{search_records}}".
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-08-04 07:06:20
 * The followings are the available columns in table '{{search_records}}':
 * @property string $id
 * @property string $title
 * @property string $hash
 * @property string $times
 * @property string $cTime
 * @property string $updateTime
 * @property string $expiredTime
 * @property string $results
 */
class SearchRecords extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{search_records}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cTime,updateTime', 'default', 'setOnEmpty' => true, 'value' => zmf::now()),
            array('title', 'required'),
            array('title', 'length', 'max' => 255),
            array('hash', 'length', 'max' => 32),
            array('status', 'numerical', 'integerOnly' => true),
            array('times, cTime, updateTime, expiredTime', 'length', 'max' => 10),
            array('results', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, hash, times, cTime, updateTime, expiredTime, results', 'safe', 'on' => 'search'),
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

    public function beforeSave() {
        if ($this->title != '' && !$this->hash) {
            $this->hash = md5($this->title);
        }
        return true;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => '标题',
            'hash' => 'HASH',
            'times' => '搜索次数',
            'cTime' => '创建时间',
            'updateTime' => '更新时间',
            'expiredTime' => '过期时间',
            'results' => '查询结果',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('hash', $this->hash, true);
        $criteria->compare('times', $this->times, true);
        $criteria->compare('cTime', $this->cTime, true);
        $criteria->compare('updateTime', $this->updateTime, true);
        $criteria->compare('expiredTime', $this->expiredTime, true);
        $criteria->compare('results', $this->results, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SearchRecords the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getOne($id) {
        return self::model()->findByPk($id);
    }

    public static function findByHash($hash) {
        if (!$hash) {
            return;
        }
        return self::model()->find('`hash`=:hash', array(
                    ':hash' => $hash
        ));
    }

    /**
     * 保存记录
     * @param string $keyword
     * @return SearchRecords
     */
    public static function simpleAdd($keyword) {
        $now = zmf::now();
        $_hash = md5($keyword);
        $attr = array(
            'title' => $keyword,
            'hash' => $_hash,
            'times' => 1,
            'cTime' => $now,
            'updateTime' => $now,
            'expiredTime' => $now + 3600,
        );
        $_info = static::model()->findByHash($_hash);
        if ($_info) {
            return $_info;
        }
        $_model = new SearchRecords();
        $_model->attributes = $attr;
        if (!$_model->save()) {
            return;
        }
        return $_model;
    }
    
    /**
     * 随机获取搜索记录
     * @param type $limit
     * @return type
     */
    public static function getRandomItems($limit) {
        $items = static::model()->findAll(array(            
            'select' => 'id,title,hash',
            'condition'=>'status=1',
            'limit' => 100,            
            'order' => 'times DESC',            
        ));
        shuffle($items);
        if (count($items) > $limit) {
            return array_slice($items, 0, $limit);
        }
        return $items;
    }

}
