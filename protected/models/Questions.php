<?php

/**
 * This is the model class for table "{{questions}}".
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-09-27 08:15:20
 * The followings are the available columns in table '{{questions}}':
 * @property string $id
 * @property string $uid
 * @property string $typeId
 * @property string $areaId
 * @property string $title
 * @property string $faceUrl
 * @property string $seotitle
 * @property string $description
 * @property string $keywords
 * @property string $bestAid
 * @property string $cTime
 * @property string $updateTime
 * @property integer $status
 * @property string $hits
 * @property string $tagids
 * @property string $content
 * @property string $urlPrefix
 */
class Questions extends CActiveRecord {

    public $answerInfo;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{questions}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('uid,createUid', 'default', 'setOnEmpty' => true, 'value' => zmf::uid()),
            array('cTime', 'default', 'setOnEmpty' => true, 'value' => zmf::now()),
            array('status', 'default', 'setOnEmpty' => true, 'value' => Posts::STATUS_PASSED),
            array('uid, title', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('uid, typeId,areaId,bestAid, cTime, updateTime, hits,answers,faceId,createUid', 'length', 'max' => 10),
            array('title, faceUrl, description, tagids, urlPrefix', 'length', 'max' => 255),
            array('content', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, uid, typeId, areaId, title, faceUrl, description, bestAid, cTime, updateTime, status, hits, tagids, content, urlPrefix', 'safe', 'on' => 'search'),
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
            'areaInfo' => array(static::BELONGS_TO, 'Area', 'areaId'),
            'typeInfo' => array(static::BELONGS_TO, 'Column', 'typeId'),
            'answerInfo' => array(self::BELONGS_TO, 'Answers', 'bestAid'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'uid' => '作者',
            'createUid' => '创建人',
            'typeId' => '分类',
            'areaId' => '地区',
            'title' => '标题',
            'faceUrl' => '封面图',
            'faceId' => '封面图',
            'description' => '描述',
            'bestAid' => '最佳回答',
            'cTime' => '发表时间',
            'updateTime' => '更新时间',
            'status' => '状态',
            'hits' => '点击',
            'tagids' => '标签',
            'content' => '正文',
            'urlPrefix' => '链接',
            'answers' => '回答数',
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
        $criteria->compare('typeId', $this->typeId, true);
        $criteria->compare('areaId', $this->areaId, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('faceUrl', $this->faceUrl, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('bestAid', $this->bestAid, true);
        $criteria->compare('cTime', $this->cTime, true);
        $criteria->compare('updateTime', $this->updateTime, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('hits', $this->hits, true);
        $criteria->compare('tagids', $this->tagids, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('urlPrefix', $this->urlPrefix, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Questions the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        if(!$this->cTime){
            $this->cTime=zmf::now();
        }
        if(!$this->updateTime){
            $this->updateTime=zmf::now();
        }
        return true;
    }

    public static function getOne($id) {
        return self::model()->findByPk($id);
    }

    /**
     * 根据标题判断是否存在此问题
     * @param string $text
     * @return Questions the static model class
     */
    public static function findByTitle($text) {
        $text = '%' . strtr($text, array('%' => '\%', '_' => '\_', '\\' => '\\\\')) . '%';
        return static::model()->find("title LIKE '{$text}'");
    }

    /**
     * 更新文章链接前缀
     * @param int $id
     * @param object $info
     * @return bool
     */
    public static function updateUrlPrefix($id, $info = null) {
        if (!$info) {
            $info = static::model()->findByPk($id);
        }
        if (!$info || $info['status']!=Posts::STATUS_PASSED) {
            return;
        } elseif ($info['urlPrefix'] != '') {
            return $info['urlPrefix'];
        }
        $path = '';
        if ($info->areaId > 0) {
            $path = $info->areaInfo->name;
        } elseif ($info->typeId > 0) {
            $path = $info->typeInfo->name;
        }
        if (!$path) {
            $path = 'question';
        }
        $info->updateByPk($info['id'], array(
            'urlPrefix' => $path
        ));
        return $path;
    }

    /**
     * 返回当前的url层级
     * @param int $id
     * @param null $info
     * @return array
     */
    public static function getPathInfo($id, $info = null){
        if (!$info) {
            $info = static::model()->findByPk($id);
        }
        if (!$info) {
            return;
        } elseif (!$info['urlPrefix']) {
            return;
        }
        $arr=[];
        $keyword=zmf::config('mainKeyword');
        if ($info->areaId > 0) {
            $path = $info->areaInfo;
            $arr=array(
                'title'=>$path['title'].$keyword,
                'name'=>$path['name'],
                'url'=>zmf::createUrl('index/index',array('colName'=>$path['name']))
            );
        } elseif ($info->typeId > 0) {
            $path = $info->typeInfo;
            $arr=array(
                'title'=>$path['title'],
                'name'=>$path['name'],
                'url'=>zmf::createUrl('index/index',array('colName'=>$path['name']))
            );
        }else{
            $arr=array(
                'title'=>$keyword.'问答',
                'name'=>'question',
                'url'=>zmf::createUrl('index/questions')
            );
        }
        return $arr;
    }

    /**
     * 更新问题回答数
     * @param int $qid
     * @return bool
     */
    public static function updateStatAnswers($qid) {
        $num = Answers::model()->count('qid=:qid AND status=1', array(
            ':qid' => $qid
        ));
        //取最新更新时间
        $sql = "SELECT MAX(cTime) AS time FROM {{answers}} WHERE qid='10000' AND status=1";
        $info = Yii::app()->db->createCommand($sql)->queryRow();
        return static::model()->updateByPk($qid, array(
                    'answers' => $num,
                    'updateTime' => $info['time'] > 0 ? $info['time'] : 0,
        ));
    }

    /**
     * 随机获取某个栏目下没有地区的文章ID
     * @param array $columnInfo
     * @param int $len
     * @param string $notInclude
     * @return array
     */
    public static function getRandItems($len = 10, $notInclude = '', $foreach = true) {
        $sql = "SELECT q.id,q.title,q.urlPrefix,q.content,q.hits,q.answers FROM {{questions}} q WHERE q.status=1 " . ($notInclude != '' ? " AND q.id NOT IN({$notInclude})" : '') . " ORDER BY q.cTime DESC LIMIT 100";
        $posts = Yii::app()->db->createCommand($sql)->queryAll();
        if ($foreach) {
            $idsArr = array_keys(CHtml::listData($posts, 'id', ''));
            shuffle($idsArr);
        } else {
            shuffle($posts);
            $idsArr = $posts;
        }
        if (count($idsArr) > $len) {
            return array_slice($idsArr, 0, $len);
        }
        return $idsArr;
    }

    /**
     * 根据问题的标签获取相关文章
     * @param string $tagids 问题的ID
     * @param int $limit
     * @return array
     */
    public static function getRelatedPosts($tagids, $limit = 10, $imgSize = '') {
        $str = join(',', array_keys(CHtml::listData($tagids, 'id', 'title')));
        if (!$str) {
            return array();
        }
        $sql = "SELECT p.id,count(p.id) AS times,p.title,p.urlPrefix,p.desc,p.faceImg FROM {{articles}} p,{{tag_relation}} tr WHERE tr.classify='" . Column::CLASSIFY_POST . "' AND tr.tagid IN({$str}) AND tr.logid=p.id AND p.status=1 GROUP BY p.id ORDER BY times DESC,p.cTime DESC LIMIT {$limit}";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        $posts = Articles::foreachArticles($items, $imgSize);
        return $posts;
    }

    /**
     * 最新带回答的问答
     * @param int $limit
     * @return array
     */
    public static function getLatest($limit = 10) {
        $sql = "SELECT q.id,q.title,q.urlPrefix,a.content,q.answers FROM {{questions}} q,{{answers}} a WHERE a.isBest=1 AND a.status=1 AND a.qid=q.id AND q.status=1 GROUP BY a.qid ORDER BY q.cTime DESC LIMIT {$limit}";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        return $items;
    }

    /**
     * 返回最新问答
     * @param int $limit
     * @param bool $foreach
     * @param bool $noAreaId
     * @return array
     */
    public static function getNews($limit = 10,$foreach=false,$noAreaId=false) {
        $sql = "SELECT q.id,q.title,q.urlPrefix,q.hits,q.answers,q.content,q.bestAid,q.tagids FROM {{questions}} q WHERE ".($noAreaId ? 'q.areaId=0 AND ' : '')."q.status=1 ORDER BY q.cTime DESC LIMIT {$limit}";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if($foreach){
            $items=static::foreachPosts($items);
        }
        return $items;
    }
    /**
     * 返回热门问答
     * @param int $limit
     * @return array
     */
    public static function getTops($limit = 10) {
        $sql = "SELECT q.id,q.title,q.urlPrefix,q.hits,q.answers,q.content,q.bestAid,q.tagids FROM {{questions}} q WHERE q.status=1 ORDER BY q.hits DESC LIMIT {$limit}";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        return $items;
    }

    /**
     * 获取首页更新
     * @param type $limit
     * @return array
     */
    public static function getIndexLatest($limit = 10) {
        $sql = "SELECT q.id,q.title,q.urlPrefix,a.content,q.answers FROM {{questions}} q INNER JOIN {{answers}} a ON a.qid=q.id INNER JOIN {{column}} c ON q.typeId=c.id WHERE a.isBest=1 AND a.status=1 AND q.status=1 GROUP BY a.qid ORDER BY q.cTime DESC LIMIT {$limit}";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        return $items;
    }

    /**
     * @param $areaInfo
     * @param int $limit
     * @param bool $foreach
     * @return array
     */
    public static function getByArea($areaInfo, $limit = 10,$foreach=false) {
        $items=[];
        if($areaInfo){
            $sql = "SELECT q.id,q.title,q.urlPrefix,q.hits,q.answers,q.content,q.bestAid,q.tagids FROM {{questions}} q  INNER JOIN {{area}} ar ON q.areaId=ar.id WHERE ar.sitepath LIKE '{$areaInfo['sitepath']}%' AND  q.status=1 ORDER BY q.cTime DESC LIMIT {$limit}";
            $items = zmf::dbAll($sql);
        }
        $len=$limit-count($items);
        if ($len>0) {
            $temp=static::getNews($len,false,true);
            $items = !empty($items) ? array_merge($items, $temp) : $temp;
        }
        if($foreach){
            $items=static::foreachPosts($items,'');
        }
        return $items;
    }

    /**
     * 获取栏目页问题
     * 1、有地区栏目取交集
     * 2、不足条数取该栏目下没有绑定地区的
     * 3、还不足条数则随机取几条
     * @param Columns $columnInfo
     * @param Area $areaInfo
     * @param int $limit
     * @return array
     */
    public static function getByAreaAndColumn($columnInfo, $areaInfo = null, $limit = 10) {
        $_pathArr = array_filter(explode('-', $columnInfo['columnPath']));
        $columnPath = $_pathArr[0] . '-';
        if ($areaInfo) {
            $sql = "SELECT q.id,q.title,q.urlPrefix,a.content,q.answers FROM {{questions}} q INNER JOIN {{answers}} a ON a.qid=q.id INNER JOIN {{area}} ar ON q.areaId=ar.id INNER JOIN {{columns}} c ON q.typeId=c.id WHERE ar.sitepath LIKE '{$areaInfo['sitepath']}%' AND c.columnPath LIKE '{$columnPath}%' AND a.isBest=1 AND a.status=1 AND q.status=1 GROUP BY a.qid ORDER BY q.cTime DESC LIMIT {$limit}";
            $items = Yii::app()->db->createCommand($sql)->queryAll();
        } else {
            $sql = "SELECT q.id,q.title,q.urlPrefix,a.content,q.answers FROM {{questions}} q INNER JOIN {{answers}} a ON a.qid=q.id INNER JOIN {{columns}} c ON q.typeId=c.id WHERE c.columnPath LIKE '{$columnPath}%' AND a.isBest=1 AND a.status=1 AND q.status=1 GROUP BY a.qid ORDER BY q.cTime DESC LIMIT {$limit}";
            $items = Yii::app()->db->createCommand($sql)->queryAll();
        }
        if (count($items) < $limit) {
            $idsStr = join(',', array_keys(CHtml::listData($items, 'id', '')));
            $_num = $limit - count($items);
            $sql = "SELECT q.id,q.title,q.urlPrefix,a.content,q.answers FROM {{questions}} q INNER JOIN {{answers}} a ON a.qid=q.id INNER JOIN {{columns}} c ON q.typeId=c.id WHERE " . ($idsStr != '' ? "q.id NOT IN({$idsStr}) AND " : '') . "c.columnPath LIKE '{$columnPath}%' AND a.isBest=1 AND a.status=1 " . ($areaInfo ? " AND q.areaId=0 " : '') . " AND q.status=1 GROUP BY a.qid ORDER BY q.cTime DESC LIMIT {$_num}";
            $_posts = Yii::app()->db->createCommand($sql)->queryAll();
            $items = array_merge($items, $_posts);
        }
        if (count($items) < $limit) {
            $idsStr = join(',', array_keys(CHtml::listData($items, 'id', '')));
            $_num = $limit - count($items);
            $_posts = static::getRandItems($_num, $idsStr, false);
            $items = array_merge($items, $_posts);
        }
        return $items;
    }

    /**
     * 根据标签获取问题
     * @param array $tagids
     * @param int $limit
     * @param string $notInclude
     * @return array
     */
    public static function getByTags($tagids, $limit = 10, $notInclude = '',$foreach=false) {
        if (is_array($tagids)) {
            $str = join(',', array_keys(CHtml::listData($tagids, 'id', 'title')));
        } else {
            $str = zmf::filterIds($tagids);
        }
        if (!$str) {
            return array();
        }
        $sql = "SELECT q.id,q.title,q.urlPrefix,q.content,count(q.id) AS times,q.hits,q.answers,q.tagids,q.cTime FROM {{questions}} q INNER JOIN {{tag_relation}} tr ON q.id=tr.logid WHERE tr.tagid IN({$str}) AND tr.classify='" . Column::CLASSIFY_QUESTION . "' " . ($notInclude != '' ? "AND q.id NOT IN({$notInclude})" : '') . " AND q.status=1 GROUP BY q.id ORDER BY q.cTime DESC,times DESC LIMIT {$limit}";
        $items = zmf::dbAll($sql);
        if (count($items) < $limit) {
            $idsStr = join(',', array_keys(CHtml::listData($items, 'id', '')));
            $_num = $limit - count($items);
            $_posts = static::getRandItems($_num, $idsStr, false);
            $items = array_merge($items, $_posts);
        }        
        return $foreach ? static::foreachPosts($items) : $items;
    }

    /**
     * 根据产品分类关联的标签来获取内容
     * @param array $columnInfo 产品分类
     * @param int $limit
     * @param string $imgSize
     * @return array
     */
    public static function getColumnRelatedPosts($columnInfo, $limit = 10, $imgSize = '') {
        if (!$columnInfo) {
            return [];
        }
        $sql = "SELECT q.id,q.title,q.urlPrefix,q.content,count(q.id) AS times,q.hits,q.answers,q.tagids FROM {{questions}} q LEFT JOIN {{tag_relation}} tr ON q.id=tr.logid LEFT JOIN {{tags}} t ON tr.tagid=t.id WHERE t.typeId='{$columnInfo['id']}' AND t.classify=".Column::CLASSIFY_PRODUCT." AND t.isDisplay=1 AND tr.classify=".Column::CLASSIFY_QUESTION." AND q.status=1 GROUP BY q.id ORDER BY times DESC,q.cTime DESC LIMIT {$limit}";
        $items = zmf::dbAll($sql);
        $posts = static::foreachPosts($items, $imgSize);
        return $posts;
    }

    /**
     * 循环处理问题列表
     * @param array $posts
     * @param string $imgSize
     * @param array $columns
     * @return array
     */
    public static function foreachPosts($posts, $imgSize = '', $columns = null) {
        if (!$columns) {
            $columns = Column::getAll();
        }
        foreach ($posts as $k => $digest) {
            $posts[$k]['faceImg'] = $digest['faceImg'] ? zmf::getThumbnailUrl($digest['faceImg'], $imgSize) : '';
            $posts[$k]['tags'] = Tags::getAllByType(Column::CLASSIFY_QUESTION, $digest['id']);
            foreach ($columns as $column) {
                if ($column['id'] == $digest['typeId']) {
                    $posts[$k]['columnInfo'] = $column;
                    break;
                }
            }
            $posts[$k]['content'] = zmf::subStr($digest['content'], 140);
            $_anInfo = null;
            if ($digest['bestAid'] > 0) {
                $_anInfo = Answers::getOne($digest['bestAid']);
            } else {
                $_anInfo = Answers::getQuestionLasted($digest['id']);
            }
            $_userInfo = Users::miniOne($_anInfo['uid']);
            $_userInfo['avatar'] = $_userInfo['avatar'] ? zmf::getThumbnailUrl($_userInfo['avatar'], 'a120') : zmf::getGravatar($_userInfo['truename']);
            $posts[$k]['answerInfo'] = array(
                'userInfo' => $_userInfo,
                'answer' => $_anInfo
            );
        }
        return $posts;
    }

}
