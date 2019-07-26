<?php

/**
 * This is the model class for table "{{site_info}}".
 * 站点信息，如关于我们等
 * The followings are the available columns in table '{{site_info}}':
 * @property string $id
 * @property string $uid
 * @property string $colid
 * @property string $faceimg
 * @property string $code
 * @property string $title
 * @property string $content
 * @property string $hits
 * @property string $cTime
 * @property string $updateTime
 * @property integer $status
 */
class SiteInfo extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{site_info}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('uid', 'default', 'setOnEmpty' => true, 'value' => zmf::uid()),
            array('colid,title', 'required'),
            array('code', 'unique'),
            array('status', 'default', 'setOnEmpty' => true, 'value' => Posts::STATUS_PASSED),
            array('status', 'numerical', 'integerOnly' => true),
            array('cTime,updateTime', 'default', 'setOnEmpty' => true, 'value' => zmf::now()),
            array('uid, colid, faceimg, hits, cTime, updateTime', 'length', 'max' => 10),
            array('code', 'length', 'max' => 16),
            array('title', 'length', 'max' => 255),
            array('content', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, uid, colid, faceimg, code, title, content, hits, cTime, updateTime, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'colInfo' => array(static::BELONGS_TO, 'SiteinfoColumns', 'colid'),
            'authorInfo' => array(static::BELONGS_TO, 'Users', 'uid'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'uid' => '作者',
            'colid' => '所属分类',
            'faceimg' => '封面图',
            'code' => '文章路径',
            'title' => '标题',
            'content' => '正文',
            'hits' => '点击',
            'cTime' => '创建时间',
            'updateTime' => '更新时间',
            'status' => '状态',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SiteInfo the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function exTypes($type) {
        $arr = array(
            'about' => '关于本站或关于我',
            'copyright' => '版权说明',
            'cooperation' => '合作',
            'appeal' => '申诉',
            'terms' => '本站协议',
            'contact' => '联系我们',
        );
        if ($type == 'admin') {
            return $arr;
        }
        return $arr[$type];
    }

    /**
     * 根据code返回文章
     * @param string $code
     * @return SiteInfo
     */
    public static function findByCode($code, $full = false) {
        if (!$code) {
            return;
        }
        return static::model()->find(array(
                    'condition' => 'code=:code',
                    'select' => $full ? '*' : 'id,title',
                    'params' => array(
                        ':code' => $code
                    )
        ));
    }

    public static function getOne($id) {
        return static::model()->findByPk($id);
    }

    public static function getColArticles($colid, $limit = 10) {
        return static::model()->findAll(array(
                    'condition' => 'colid=:colid',
                    'params' => array(
                        ':colid' => $colid
                    ),
                    'select' => 'id,title',
                    'order' => 'id ASC',
                    'limit' => $limit
        ));
    }

    /**
     * 获取所有栏目的文章
     * @param int $columnLimit
     * @param int $articleLimit
     * @return array
     */
    public static function getColumnsArticles($columnLimit = 5, $articleLimit = 10) {
        $columns = SiteinfoColumns::listAll($columnLimit);
        $posts = [];
        foreach ($columns as $id => $title) {
            $items = static::getColArticles($id, $articleLimit);
            if (empty($items)) {
                continue;
            }
            $posts[$id] = array(
                'id' => $id,
                'title' => $title,
                'items' => $items,
            );
        }
        return $posts;
    }

    /**
     * 根据code输出链接
     * @param string $code
     * @param string $type
     * @return string
     */
    public static function echoCodeLink($code, $type = 'link') {
        $info = static::findByCode($code);
        if ($info) {
            if ($type == 'link') {
                return zmf::createUrl('/site/info', array('id' => $info['id']));
            } else {
                return zmf::link($info['title'], array('/site/info', 'id' => $info['id']), array('target' => '_blank', 'ref' => 'nofollow'));
            }
        } else {
            if ($type == 'link') {
                return 'javascript:;';
            } else {
                return '';
            }
        }
    }

}
