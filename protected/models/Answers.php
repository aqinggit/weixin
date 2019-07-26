<?php

/**
 * This is the model class for table "{{answers}}".
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-09-27 08:15:20
 * The followings are the available columns in table '{{answers}}':
 * @property string $id
 * @property string $uid
 * @property string $qid
 * @property string $content
 * @property string $favors
 * @property integer $platform
 * @property integer $status
 * @property integer $isBest
 * @property string $hits
 * @property string $comments
 * @property string $cTime
 * @property string $updateTime
 */
class Answers extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{answers}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('uid,createUid', 'default', 'setOnEmpty' => true, 'value' => zmf::uid()),
            array('cTime,updateTime', 'default', 'setOnEmpty' => true, 'value' => zmf::now()),
            array('status', 'default', 'setOnEmpty' => true, 'value' => Posts::STATUS_PASSED),
            array('uid, qid, content', 'required'),
            array('platform, status, isBest', 'numerical', 'integerOnly' => true),
            array('uid, qid, favors, hits, comments, cTime, updateTime,createUid', 'length', 'max' => 10),
            array('content', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, uid, qid, content, favors, platform, status, isBest, hits, comments, cTime, updateTime', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'userInfo' => array(self::BELONGS_TO, 'Users', 'uid'),
            'questionInfo' => array(self::BELONGS_TO, 'Questions', 'qid'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'uid' => '作者',
            'qid' => '所属问题',
            'content' => '回答内容',
            'favors' => '赞',
            'platform' => '平台',
            'status' => '状态',
            'isBest' => '最佳回答',
            'hits' => '点击',
            'comments' => '评论数',
            'cTime' => '回答时间',
            'updateTime' => '最近更新',
            'createUid' => '创建人',
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
        $criteria->compare('qid', $this->qid, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('favors', $this->favors, true);
        $criteria->compare('platform', $this->platform);
        $criteria->compare('status', $this->status);
        $criteria->compare('isBest', $this->isBest);
        $criteria->compare('hits', $this->hits, true);
        $criteria->compare('comments', $this->comments, true);
        $criteria->compare('cTime', $this->cTime, true);
        $criteria->compare('updateTime', $this->updateTime, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Answers the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getOne($id) {
        return self::model()->findByPk($id);
    }

    /**
     * 根据回答获取不同的用户
     * @param int $qid
     * @return int
     */
    public static function getRandUser($qid) {
        $min = zmf::config('randMinUser');
        $max = zmf::config('randMaxUser');
        $min = $min > 0 ? $min : 0;
        $max = $max > 0 ? $max : 0;
        if ($qid) {
            $sql = "SELECT u.id FROM {{users}} u,{{answers}} a WHERE a.qid='{$qid}' AND (u.id>'{$min}' AND u.id<'{$max}') AND a.uid!=u.id GROUP BY u.id";
            $items = Yii::app()->db->createCommand($sql)->queryAll();
            if(!empty($items)){
                $arr = CHtml::listData($items, 'id', '');
                $index = array_rand($arr);
            }else{
                $index = mt_rand($min, $max);
            }            
        } else {
            $index = mt_rand($min, $max);
        }
        return $index;
    }
    
    public static function getQuestionLasted($id){
        return static::model()->find(array(
            'condition'=>'qid=:id AND status=1',
            'params'=>array(
                ':id'=>$id
            ),
            'order'=>'cTime DESC'
        ));
    }

}
