<?php

/**
 * This is the model class for table "{{ads}}".
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2016 阿年飞少 
 * @datetime 2016-07-25 04:22:17
 * The followings are the available columns in table '{{ads}}':
 * @property string $id
 * @property integer $uid
 * @property string $title
 * @property string $description
 * @property string $url
 * @property string $faceimg
 * @property string $faceUrl
 * @property string $startTime
 * @property string $expiredTime
 * @property string $position
 * @property string $classify
 * @property string $hits
 * @property string $order
 * @property integer $status
 * @property string $cTime
 */
class Ads extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{ads}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('uid', 'default', 'setOnEmpty' => true, 'value' => zmf::uid()),
            array('cTime', 'default', 'setOnEmpty' => true, 'value' => zmf::now()),
            array('status', 'default', 'setOnEmpty' => true, 'value' => Posts::STATUS_PASSED),
            array('uid,position,classify', 'required'),
            array('uid, status,platform', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 50),
            array('description, url, faceUrl', 'length', 'max' => 255),
            array('faceimg, startTime, expiredTime, hits, order, cTime', 'length', 'max' => 10),
            array('position, classify,color,bgColor', 'length', 'max' => 16),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, uid, title, description, url, faceimg, faceUrl, startTime, expiredTime, position, classify, hits, order, status, cTime', 'safe', 'on' => 'search'),
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
            'uid' => '创建者',
            'title' => '标题',
            'description' => '描述',
            'url' => '链接地址',
            'faceimg' => '封面图ID',
            'faceUrl' => '封面图',
            'startTime' => '开始时间',
            'expiredTime' => '结束时间',
            'position' => '位置',
            'classify' => '分类',
            'hits' => '点击',
            'order' => '排序',
            'status' => '状态',
            'cTime' => '创建时间',
            'platform' => '限制平台',
            'color' => '字体颜色',
            'bgColor' => '背景颜色',
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
        $criteria->compare('uid', $this->uid);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('faceimg', $this->faceimg, true);
        $criteria->compare('faceUrl', $this->faceUrl, true);
        $criteria->compare('startTime', $this->startTime, true);
        $criteria->compare('expiredTime', $this->expiredTime, true);
        $criteria->compare('position', $this->position, true);
        $criteria->compare('classify', $this->classify, true);
        $criteria->compare('hits', $this->hits, true);
        $criteria->compare('order', $this->order, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('cTime', $this->cTime, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Ads the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function colPositions($return = '') {
        $positions = array(
            'navbar' => '顶部轮播图',
            'nav1' => '顶部小图1',
            'nav2' => '顶部小图2',
            'nav3' => '顶部小图3',
            'nav4' => '顶部小图4',
            //版块            
            'article'=>'文章主页',
            'question'=>'问答主页',
            //其他
            'reg'=>'登录注册轮播图',  
        );
        if ($return != 'admin') {
            return $positions[$return];
        } else {
            return $positions;
        }
    }

    public static function adsStyles($return = '') {
        $arr = array(
            //'flash' => '轮播图',
            'img' => '单图',
            //'txt' => '纯文字',
        );
        if ($return != 'admin') {
            return $arr[$return];
        } else {
            return $arr;
        }
    }

    public static function exPlatform($return = '') {
        $arr = array(
            '0' => '不限',
            '1' => 'PC',
            '2' => '手机端',
        );
        if ($return != 'admin') {
            return $arr[$return];
        } else {
            return $arr;
        }
    }

    public static function getAllByPo($po, $type = 'img', $isMobile = false, $limit = 10,$imgSize='') {
        if (!$po || !$type) {
            return false;
        }
        $where = "AND classify='{$type}'";        
        if($isMobile){
            $where.=" AND (platform=0 OR platform=2)";
        }else{
            $where.=" AND (platform=0 OR platform=1)";
        }
        $now = zmf::now();
        $sql = "SELECT title,description,url,faceUrl,bgColor,color FROM {{ads}} WHERE position='{$po}' {$where} AND ((startTime=0 OR startTime<=$now) AND (expiredTime=0 OR expiredTime>=$now)) AND status=1 ORDER BY `order` DESC  LIMIT {$limit}";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if($imgSize!=''){
            foreach ($items as $key => $value) {
                $items[$key]['faceUrl']=zmf::getThumbnailUrl($value['faceUrl'],$imgSize);
            }
        }
        return $items;
    }
    
    
    public static function getByPois($str,$isMobile=false,$imgSize=''){
        $arr= array_unique(array_filter(explode(',', $str)));
        if(empty($arr)){
            return [];
        }
        $posts=[];
        foreach ($arr as $key => $_poi) {
            $_items= static::getAllByPo($_poi,'img',$isMobile,5,$imgSize);
            $posts[$_poi]=$_items;
        }
        return $posts;
    }

}
