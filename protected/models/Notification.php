<?php

class Notification extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{notification}}';
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cTime', 'default', 'setOnEmpty' => true, 'value' => zmf::now()),
            array('uid, new, authorid, from_id, from_num', 'numerical', 'integerOnly' => true),
            array('type, from_idtype', 'length', 'max' => 20),
            array('author', 'length', 'max' => 15),
            array('cTime', 'length', 'max' => 10),
            array('content', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'userInfo' => array(static::BELONGS_TO, 'Users', 'uid'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'uid' => '谁收到',
            'type' => '类型',
            'new' => '是否未读',
            'authorid' => '谁发的',
            'author' => '谁发的',
            'content' => '内容',
            'cTime' => '创建时间',
            'from_id' => 'From',
            'from_idtype' => 'From Idtype',
            'from_num' => 'From Num',
        );
    }

    public static function add($params = array()) {
        $data = array(
            'uid' => $params['uid'],
            'authorid' => $params['authorid'],
            'content' => $params['content'],
            'new' => 1,
            'type' => $params['type'],
            'cTime' => zmf::now(),
            'from_id' => $params['from_id'],
            'from_idtype' => $params['from_idtype'],
            'from_num' => 1
        );
        if ($params['uid'] == $params['authorid']) {
            return false;
        }
        $model = new Notification();
        //2016修改为不计条数            
        $model->attributes = $data;
        return $model->save();
    }

    public function getNum() {
        $uid = zmf::uid();
        if (!$uid) {
            return '0';
        }
        $num = Notification::model()->count('new=1 AND uid=:uid', array(':uid' => $uid));
        if ($num > 0) {
            return $num;
        } else {
            return '0';
        }
    }

    public static function exTypes($type) {
        $arr = array(
            'comment' => '评论',
            'favorite' => '点赞',
            'system' => '系统',
        );
        if ($type == 'admin') {
            return $arr;
        }
        return $arr[$type];
    }

}
