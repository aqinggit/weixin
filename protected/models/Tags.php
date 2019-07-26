<?php

class Tags extends CActiveRecord {

    public function tableName() {
        return '{{tags}}';
    }

    public function rules() {
        return array(
            array('title,classify', 'required'),
            //array('name,title', 'unique'),
            array('cTime,order', 'default', 'setOnEmpty' => true, 'value' => zmf::now()),
            array('hits,cTime,posts,length,order,typeId', 'length', 'max' => 10),
            array('isDisplay,toped', 'numerical', 'integerOnly' => true),
            array('title,nickname', 'length', 'max' => 255),
            array('name, classify', 'length', 'max' => 32),
            array('status', 'numerical', 'integerOnly' => true),
            array('title, name', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'typeInfo' => array(static::BELONGS_TO, 'Column', 'typeId'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => '标签名',
            'name' => '路径',
            'classify' => '分类',
            'hits' => '点击',
            'cTime' => '创建时间',
            'status' => '状态',
            'posts' => '文章数量',
            'length' => '标签长度',
            'nickname' => '昵称',
            'isDisplay' => '是否显示',
            'order' => '排序',
            'typeId' => '主分类',
            'toped' => '首页推荐',
        );
    }

    public function beforeSave() {
        if (!$this->name) {
            $this->name = zmf::pinyin($this->title);
        }
        $this->length = mb_strlen($this->title, 'GBK');
        return true;
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function suggestTags($keyword, $limit = 10, $type = '') {
        if (!$keyword) {
            return false;
        }
        $items = Tags::model()->findAll(array(
            'condition' => '(title LIKE :keyword OR name LIKE :keyword)' . ($type != '' ? " AND classify='{$type}'" : ''),
            'order' => 'length ASC',
            'limit' => $limit,
            'params' => array(
                ':keyword' => '%' . strtr($keyword, array('%' => '\%', '_' => '\_', '\\' => '\\\\')) . '%'
            ),
        ));

        return $items;
    }

    /**
     * 查询一条
     * @param int $id
     * @return object
     */
    public static function getOne($id) {
        return static::model()->findByPk($id);
    }

    public static function getSimpleInfo($keyid) {
        return static::model()->findByPk($keyid);
    }

    /**
     * 查找标签，没有则新增
     * @param type $title
     * @param type $classify
     * @param type $logid
     * @return boolean
     */
    public static function findAndAdd($title, $classify, $logid) {
        $title = zmf::filterInput($title, 't', 1);
        if (!$title) {
            return false;
        }
        $info = Tags::model()->find('title=:title', array(':title' => $title));
        if (!$info) {
            $_data = array(
                'title' => $title,
                'name' => zmf::pinyin($title),
                'classify' => Column::CLASSIFY_POST,
                'status' => Posts::STATUS_PASSED,
                'length' => mb_strlen($title, 'GBK')
            );
            $modelB = new Tags;
            $modelB->attributes = $_data;
            if ($modelB->save()) {
                $tagid = $modelB->id;
            }
        } else {
            $tagid = $info['id'];
        }
        if ($tagid && $logid) {
            $_info = TagRelation::model()->find('tagid=:tagid AND logid=:logid AND classify=:classify', array(':tagid' => $tagid, ':logid' => $logid, ':classify' => $classify));
            if (!$_info) {
                $_tagre = array(
                    'tagid' => $tagid,
                    'logid' => $logid,
                    'classify' => $classify
                );
                $modelC = new TagRelation;
                $modelC->attributes = $_tagre;
                $modelC->save();
            }
        }
        return $tagid;
    }

    /**
     * 保存关联记录
     * @param int $tagid
     * @param int $logid
     * @param int $classify
     * @return boolean
     */
    public static function addRelation($tagid, $logid, $classify) {
        if (!$tagid || !$logid || !$classify) {
            return false;
        }
        $_info = TagRelation::model()->find('tagid=:tagid AND logid=:logid AND classify=:classify', array(':tagid' => $tagid, ':logid' => $logid, ':classify' => $classify));
        if (!$_info) {
            $_tagre = array(
                'tagid' => $tagid,
                'logid' => $logid,
                'classify' => $classify
            );
            $modelC = new TagRelation;
            $modelC->attributes = $_tagre;
            return $modelC->save();
        }
        return true;
    }

    /**
     * 获取分类标签
     * @param int $classify
     * @return array
     */
    public static function getClassifyTags($classify, $limit = 50, $foreach = true) {
        $items = Tags::model()->findAll(array(
            'condition' => 'classify=:class AND isDisplay=1',
            'params' => array(
                ':class' => $classify
            ),
            'select' => 'id,title,name',
            'limit' => $limit
        ));
        return $foreach ? CHtml::listData($items, 'id', 'title') : $items;
    }

    /**
     * 按分类获取所有标签
     * @return array
     */
    public static function getAllTags() {
        $classify = Column::classify('admin');
        $items = [];
        foreach ($classify as $_c => $t) {
            $_items = static::getClassifyTags($_c,10000,false);
            if (!empty($_items)) {
                $items[] = array(
                    'title' => $t,
                    'type' => $_c,
                    'items' => $_items
                );
            }
        }
        return $items;
    }

    /**
     * 获取分类所有标签
     * @param bool $display
     * @param int $limit
     * @return array
     */
    public static function getClassifyAllTags($display = false, $limit = 0) {
        return Tags::model()->findAll(array(
                    'condition' => ($display ? 'isDisplay=1' : ''),
                    'select' => 'id,title,nickname,name',
                    'order' => '`order` ASC',
                    'limit' => $limit > 0 ? $limit : 10000
        ));
    }
    
    /**
     * 获取所有标签
     * @param bool $display
     * @param int $limit
     * @return array
     */
    public static function getTags($display = false, $limit = 0) {
        return Tags::model()->findAll(array(
                    'condition' => ($display ? 'isDisplay=1' : ''),
                    'select' => 'id,title,nickname,name',
                    'order' => '`order` ASC',
                    'limit' => $limit > 0 ? $limit : 10000
        ));
    }

    /**
     * 根据ID串获取标签
     * @param string $ids
     * @return array
     */
    public static function getByIds($ids) {
        $ids = zmf::filterIds($ids);
        if (!$ids) {
            return false;
        }
        $sql = "SELECT id,title,name FROM {{tags}} WHERE id IN($ids) ORDER BY FIELD(id,$ids)";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        return $items;
    }

    /**
     * 根据路径获取标签
     * @param string $name
     * @return Tags
     */
    public static function findByName($name) {
        $info = self::model()->find(array(
            'condition' => 'name=:site',
            'params' => array(
                ':site' => $name
            )
        ));
        return $info;
    }

    /**
     * 内容自动加链接
     * @param array $contentArr
     * @param string $table
     * @param int $logid
     * @param bool $overwrite
     * @return boolean
     */
    public static function addContentLinks($contentArr, $table, $logid, $overwrite = false) {
        $tags = static::getTags();
        $_tags = [];
        foreach ($tags as $tag) {
            $_tagArr = array_unique(array_filter(explode(',', $tag['nickname'])));
            $_tagArr[] = $tag['title'];
            foreach ($_tagArr as $_tagTitle) {
                if (strpos($contentArr['title'], $_tagTitle) !== false) {
                    $_tags[] = $tag['id'];
                }
                if (strpos($contentArr['content'], $_tagTitle) !== false) {
                    $_tags[] = $tag['id'];
                }
            }
        }
        if ($overwrite) {
            TagRelation::model()->deleteAll('logid=:id AND classify=:classify', array(':classify' => $table, ':id' => $logid));
        }
        $_tags = array_filter(array_unique($_tags));
        //更新所有标签
        if ($overwrite) {
            $_realTags = [];
            if (!empty($_tags)) {
                foreach ($_tags as $_id) {
                    $_attr = array(
                        'logid' => $logid,
                        'classify' => $table,
                        'tagid' => $_id,
                    );
                    $_model = new TagRelation;
                    $_model->attributes = $_attr;
                    if ($_model->save()) {
                        $_realTags[] = $_id;
                    }
                }
            }
            if ($table == 'article') {
                Articles::model()->updateByPk($logid, array(
                    'tagids' => join(',', $_realTags)
                ));
            }
        } else {
            if (!empty($_tags)) {
                foreach ($_tags as $_id) {
                    static::addRelation($_id, $logid, $table);
                }
            }
        }
        return true;
    }

    /**
     * 获取文章的标签
     * @param string $type
     * @param int $logid
     * @return array
     */
    public static function getAllByType($type, $logid) {
        if (!$type || !$logid) {
            return;
        }
        $sql = "SELECT t.id,t.title,t.name FROM {{tags}} t,{{tag_relation}} tr WHERE tr.logid=:logid AND tr.classify=:class AND tr.tagid=t.id AND t.isDisplay=1 ORDER BY t.order ASC";
        $db = Yii::app()->db->createCommand($sql);
        $db->bindValues(array(
            ':logid' => $logid,
            ':class' => $type
        ));
        return $db->queryAll();
    }

    /**
     * 随机获取标签
     * @param type $limit
     * @return type
     */
    public static function getRandomItems($limit, $classify = 'posts') {
        $tags = Tags::model()->findAll(array(
            'condition' => 'classify=:classify AND isDisplay=1', //只关联文章标签,bug
            'select' => 'id,title,name',
            'limit' => 100,
            'params' => array(
                ':classify' => $classify
            )
        ));
        shuffle($tags);
        if (count($tags) > $limit) {
            return array_slice($tags, 0, $limit);
        }
        return $tags;
    }

    /**
     * 页面底部随机标签
     * @param int $len
     * @return array
     */
    public static function getFooterRandomItems($len = 10) {
        $key = 'footer-random-tags';
        $items = zmf::getFCache($key);
        if ($items) {
            return $items;
        }
        $items = static::getRandomItems($len);
        if (count($items) == $len) {
            zmf::setFCache($key, $items, 86400);
        }
        return $items;
    }

    /**
     * 返回某类所有出现过的标签
     * @param int $classify
     * @param int $tagClassify
     * @param int $limit
     * @return array
     */
    public static function getAllLinked($classify, $tagClassify = Column::CLASSIFY_POST,$limit=50) {
        if (!$classify) {
            return [];
        }
        $sql = "SELECT t.id,t.title,t.name,count(t.id) AS times FROM {{tags}} t INNER JOIN {{tag_relation}} tr ON tr.tagid=t.id WHERE tr.classify='{$classify}' AND t.classify='{$tagClassify}' AND t.isDisplay=1  GROUP BY tr.tagid ORDER BY times DESC LIMIT ".$limit;
        return zmf::dbAll($sql);
    }

    /**
     * 获取分类关联的标签
     * @param int $typeId
     * @param int $limit
     * @return array
     */
    public static function getColumnTags($typeId, $limit = 10) {
        return Tags::model()->findAll(array(
                    'condition' => 'typeId=:typeId AND isDisplay=1',
                    'select' => 'id,title,nickname,name',
                    'order' => '`order` ASC',
                    'limit' => $limit,
                    'params' => array(
                        ':typeId' => $typeId
                    )
        ));
    }
    
    /**
     * 获取所有产品栏目的标签
     * @return array
     */
    public static function getAllByColumns(){
        $columns= Column::getFirst(0, Column::CLASSIFY_PRODUCT);
        $posts=[];
        foreach($columns as $col){
            $_sql="SELECT t.id,t.title,t.name FROM {{tags}} t,{{column}} c WHERE c.sitepath LIKE '{$col['sitepath']}%' AND c.id=t.typeId AND t.classify=".Column::CLASSIFY_PRODUCT." AND t.isDisplay=1";
            $_tags= zmf::dbAll($_sql);
            if(!empty($_tags)){
                $posts[]=array(
                    'id'=>$col['id'],
                    'title'=>$col['title'],
                    'name'=>$col['name'],
                    'tags'=>$_tags,
                );
            }            
        }
        return $posts;
    }

    /**
     * 返回某个标签前后的标签
     * @param array $tagInfo
     * @param int $limit
     * @return array
     */
    public static function getTagAroundItems($tagInfo,$limit=5){
        if(!$tagInfo){
            return [];
        }
        $prev="SELECT id,title,name FROM {{tags}} WHERE id<'{$tagInfo['id']}' AND isDisplay=1 AND classify='".$tagInfo['classify']."' ORDER BY id DESC LIMIT ".$limit;
        $next="SELECT id,title,name FROM {{tags}} WHERE id>'{$tagInfo['id']}' AND isDisplay=1 AND classify='".$tagInfo['classify']."' ORDER BY id ASC LIMIT ".$limit;
        $prevs=zmf::dbAll($prev);
        $nexts=zmf::dbAll($next);
        return array_merge($prevs,$nexts);
    }

}
