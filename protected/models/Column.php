<?php

class Column extends CActiveRecord {

    const CLASSIFY_POST = 1;
    const CLASSIFY_PRODUCT = 2;
    const CLASSIFY_QUESTION = 3;
    const CLASSIFY_IMAGE = 4;//图片
    const CLASSIFY_CASE = 5;//案例

    public function tableName() {
        return '{{column}}';
    }

    public function rules() {
        return array(
            array('title,name', 'required'),
            array('name', 'unique'),
            array('status', 'default', 'setOnEmpty' => true, 'value' => Posts::STATUS_PASSED),
            array('order,classify,status,showNews', 'numerical', 'integerOnly' => true),
            array('tagids,nickname,seoTitle,seoDesc,seoKeywords,rankTitle,rankDesc,rankKeywords,sitepath,bgImgUrl,h2,h3', 'length', 'max' => 255),
            array('belongId,posts,bgImgId', 'length', 'max' => 10),
            array('title', 'length', 'max' => 32),
            array('name', 'length', 'max' => 16),
            array('name', 'unique'),
            array('title, name', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'belongInfo' => array(static::BELONGS_TO, 'Column', 'belongId'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'belongId' => '所属栏目',
            'title' => '栏目标题',
            'nickname' => '昵称',
            'name' => '路径',
            'order' => '排序',
            'classify' => '所属分类',
            'status' => '状态',
            'posts' => '作品数',
            'tagids' => '关联标签',
            'seoTitle' => 'SEO标题',
            'seoDesc' => 'SEO描述',
            'seoKeywords' => 'SEO关键词',
            'rankTitle' => 'rankTitle',
            'rankDesc' => 'rankDesc',
            'rankKeywords' => 'rankKeywords',
            'sitepath' => '层级路径',
            'showNews' => '显示新品',
            'bgImgId' => '背景图片ID',
            'bgImgUrl' => '背景图片',
            'h2' => '大标题',
            'h3' => '小标题',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('title', $this->title, true);
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function classify($type) {
        $arr = array(
            static::CLASSIFY_POST => '文章',
            //static::CLASSIFY_PRODUCT => '产品',
            static::CLASSIFY_QUESTION => '问答',
            static::CLASSIFY_IMAGE => '图片',
            static::CLASSIFY_CASE => '案例图库',
        );
        if ($type == 'admin') {
            return $arr;
        }
        return $arr[$type];
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getOne($keyid, $return = '') {
        if (!$keyid) {
            return false;
        }
        $item = static::model()->findByPk($keyid);
        if ($return != '') {
            return $item[$return];
        }
        return $item;
    }

    public static function findByName($name) {
        if (!$name) {
            return false;
        }
        return Column::model()->find('name=:name', array(':name' => $name));
    }

    public static function getByIds($ids) {
        $ids = join(',', array_unique(array_filter(explode(',', $ids))));
        if (!$ids) {
            return;
        }
        return Yii::app()->db->createCommand('SELECT id,title,`name` FROM {{column}} WHERE id IN(' . $ids . ')')->queryAll();
    }

    public static function listAll() {
        return CHtml::listData(static::model()->findAll(), 'id', 'title');
    }

    /**
     * 获取所有分类
     * @param bool $display
     * @return array
     */
    public static function getAll($display = false) {
        return $display ? static::model()->findAll(array(
                    'select' => 'id,title,name',
                    'condition' => 'status=1'
                )) : static::model()->findAll(array(
                    'select' => 'id,title,name'
        ));
    }

    public static function getFirst($limit = 0, $type = Column::CLASSIFY_PRODUCT) {
        return static::model()->findAll(array(
                    'select' => 'id,title,name,sitepath,h2,h3,bgImgUrl,showNews',
                    'condition' => 'belongId=0 AND classify=' . $type,
                    'limit' => $limit ? $limit : 1000
        ));
    }

    public static function listFirst($limit = 0) {
        $items = static::getFirst($limit);
        return CHtml::listData($items, 'id', 'title');
    }

    public static function listClassifyFirst($type) {
        return CHtml::listData(static::model()->findAll(array(
                            'select' => 'id,title',
                            'condition' => 'belongId=0 AND classify=' . $type,
                        )), 'id', 'title');
    }

    public static function getClassifyAll($type) {
        return static::model()->findAll(array(
                    'select' => 'id,title,name',
                    'condition' => 'classify=' . $type.' AND status=1',
        ));
    }

    public static function getChildrenIds($id, $limit = 0, $foreach = true) {
        $info = static::getOne($id);
        if (!$info) {
            return '';
        }
        $sql = "SELECT id,title,name FROM {{column}} WHERE sitepath LIKE '{$info['sitepath']}%' AND id!=" . $id . ($limit > 0 ? ' LIMIT ' . $limit : '');
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (!$foreach) {
            return $items;
        }
        return join(',', array_keys(CHtml::listData($items, 'id', 'title')));
    }

    /**
     * 根据某个分类获取上级及同级
     * @param array $columnInfo
     * @return array
     */
    public static function getOneBelongsAndChildren($columnInfo = null) {
        //取大分类
        $sql = "SELECT id,title,name,posts,sitepath FROM {{column}} WHERE belongId=0 AND status=1 AND classify=" . static::CLASSIFY_PRODUCT;
        $first = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($first)) {
            return;
        }
        if ($columnInfo) {
            if ($columnInfo['belongId'] > 0) {
                $arr = array_filter(explode('-', $columnInfo['sitepath']));
                $_site = $arr[0] . '-';
            } else {
                $_site = $columnInfo['sitepath'];
            }
        } else {
            $_site = $first[0]['sitepath'];
        }
        $sql = "SELECT id,title,name,belongId,posts FROM {{column}} WHERE sitepath LIKE '{$_site}%' AND status=1 AND classify=" . static::CLASSIFY_PRODUCT;
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($items as $key => $value) {
            if (!$value['belongId']) {
                unset($items[$key]);
                break;
            }
        }
        return array(
            'first' => $first,
            'children' => $items
        );
    }

    /**
     * 获取栏目路径
     * @param array $columnInfo
     * @return array
     */
    public static function getFullPath($columnInfo) {
        if (!$columnInfo['sitepath']) {
            return array();
        }
        $str = join(',', array_unique(array_filter(explode('-', $columnInfo['sitepath']))));
        if (!$str) {
            return array();
        }
        $sql = "SELECT id,title,name FROM {{column}} WHERE id IN($str)";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        return $items;
    }

    public static function getAllClassifyColumns() {
        $classes = static::classify('admin');
        $posts = [];
        foreach ($classes as $key => $value) {
            $_items = static::getClassifyAll($key);
            if (empty($_items)) {
                continue;
            }
            $posts[] = array(
                'id' => $key,
                'title' => $value,
                'items' => $_items
            );
        }
        return $posts;
    }

    public static function getProductTypes() {
        $first = static::getFirst(0, Column::CLASSIFY_PRODUCT);
        $posts = [];
        foreach ($first as $value) {
            $_items = static::getChildrenIds($value['id'], 0, false);
            //取部分分类的关联标签
            $tags=[];
            foreach ($_items as $k=>$_item){
                if($k>4){
                    break;
                }
                $_tags=Tags::getColumnTags($_item['id'],8);
                $tags[]=array(
                    'id'=>$_item['id'],
                    'title'=>$_item['title'],
                    'name'=>$_item['name'],
                    'items'=>$_tags
                );
            }
        }
        return $posts;
    }

    /**
     * 获取首页栏目文章
     * @return array
     */
    public static function getIndexPosts($limit = 9, $colsOnly = false) {

        //栏目文章
        $columns = Column::model()->findAll(array(
            'limit' => $limit,
            'select' => 'id,title,h2,h3,sitepath,name',
            'order'=>'`order` ASC',
            'condition'=>'classify='.static::CLASSIFY_POST
        ));
        if ($colsOnly) {
            return $columns;
        }
        $posts = array();
        foreach ($columns as $column) {
            $_posts = self::getColumnNewArticles($column, 9);
            $posts[] = array(
                'id' => $column['id'],
                'title' => $column['title'],
                'h2' => $column['h2'],
                'h3' => $column['h3'],
                'sitepath' => $column['sitepath'],
                'name' => $column['name'],
                'posts' => $_posts,
            );
        }
        return $posts;
    }

    /**
     * 获取栏目最新文章
     * @param Columns $column
     * @param int $limit
     * @return array
     */
    public static function getColumnNewArticles($column, $limit = 10, $imgSize = 'a120', $areaInfo = null) {
        if ($areaInfo) {
            $sql = "SELECT a.id,a.title,a.desc,a.faceImg,a.updateTime,a.hits,a.urlPrefix,'' AS tags FROM ".Articles::tableName()." a INNER JOIN ".Column::tableName()." c ON a.typeId=c.id INNER JOIN ".Area::tableName()." ar ON a.areaId=ar.id WHERE ar.sitepath LIKE '{$areaInfo['sitepath']}%' AND c.sitepath LIKE '{$column['sitepath']}%' AND a.status=1 ORDER BY a.cTime DESC LIMIT {$limit}";
        } else {
            $sql = "SELECT a.id,a.title,a.desc,a.faceImg,a.urlPrefix FROM ".Articles::tableName()." a,".Column::tableName()." c WHERE  c.sitepath LIKE '{$column['sitepath']}%' AND a.typeId=c.id AND a.status=1 ORDER BY a.cTime DESC LIMIT {$limit}";
        }
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (count($items) < $limit) {
            $_num = $limit - count($items);
            $_posts = Articles::getNews($_num);
            $items = !empty($items) ? array_merge($items, $_posts) : $_posts;
        }
        foreach ($items as $k => $val) {
            $items[$k]['faceImg'] = zmf::getThumbnailUrl($val['faceImg'], $imgSize);
        }
        return $items;
    }

}
