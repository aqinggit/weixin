<?php

/**
 * This is the model class for table "{{tdk}}".
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-07-18 07:06:42
 * The followings are the available columns in table '{{tdk}}':
 * @property string $id
 * @property string $uid
 * @property string $title
 * @property string $desc
 * @property string $keywords
 * @property string $cTime
 */
class Tdk extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{tdk}}';
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
            array('url,hashUrl,hashCode', 'required'),
            array('uid, cTime', 'length', 'max' => 10),
            array('title, desc, keywords,navContent,url,hashUrl', 'length', 'max' => 255),
            array('hashCode', 'length', 'max' => 32),
            array('content', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, uid, title, desc, keywords, cTime', 'safe', 'on' => 'search'),
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
            'uid' => 'Uid',
            'title' => 'SEO标题',
            'desc' => 'SEO描述',
            'keywords' => 'SEO关键词',
            'cTime' => '创建时间',
            'navContent' => '一句话导航',
            'content' => '简介',
            'url' => '页面链接',
            'hashUrl' => '用于MD5的链接',
            'hashCode' => 'MD5',
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
        $criteria->compare('uid', $this->uid, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('desc', $this->desc, true);
        $criteria->compare('keywords', $this->keywords, true);
        $criteria->compare('cTime', $this->cTime, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Tdk the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getOne($id) {
        return self::model()->findByPk($id);
    }

    public static function returnHashLink($url = null) {
        if (!$url) {
            $url = zmf::config('domain') . Yii::app()->request->url;
        }
        $arr = parse_url($url);
        $str = $arr['scheme'] . '://' . $arr['host'] . $arr['path'];
        //去掉http://www
        $str = preg_replace('/((http|https):\/\/)[a-z0-9]+\./i', "", $str);
        //去掉末尾的翻页伪静态
        return preg_replace('#/(\d+)/$#', '/', $str);
    }

    /**
     * 根据位置获取Tdk设置
     * @return Tdk the static model class
     */
    public static function findByPosition($url = null) {
        $hashUrl = static::returnHashLink($url);
        if (!$hashUrl) {
            return;
        }
        $code = md5($hashUrl);
        $info = static::model()->find('hashCode=:hashCode', array(
            ':hashCode' => $code
        ));
        if ($info) {
            $info['navContent'] = Keywords::linkWords($info['navContent']);
            $info['content'] = Keywords::linkWords($info['content']);
            return $info;
        }
        return;
    }

}
