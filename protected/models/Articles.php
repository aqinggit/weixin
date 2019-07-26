<?php

/**
 * This is the model class for table "{{articles}}".
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-10-14 08:37:15
 * The followings are the available columns in table '{{articles}}':
 * @property string $id
 * @property string $typeId
 * @property string $areaId
 * @property string $uid
 * @property string $title
 * @property string $desc
 * @property string $faceImg
 * @property string $hits
 * @property string $comments
 * @property string $favorites
 * @property string $cTime
 * @property integer $status
 * @property string $props
 * @property string $urlPrefix
 * @property string $tagids
 * @property string $content
 */
class Articles extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{articles}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('uid', 'default', 'setOnEmpty' => true, 'value' => zmf::uid()),
            array('updateTime', 'default', 'setOnEmpty' => true, 'value' => zmf::now()),
            array('title', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('typeId, areaId, uid, hits, comments, favorites, cTime,faceId,updateTime,toTime', 'length', 'max' => 10),
            array('title, desc, faceImg, tagids,tags,rowkey', 'length', 'max' => 255),
            array('urlPrefix', 'length', 'max' => 32),
            array('content', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, typeId, areaId, uid, title, desc, faceImg, hits, comments, favorites, cTime, status, urlPrefix, tagids, content', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'typeId' => '所属分类',            
            'areaId' => '地区',
            'uid' => '作者',
            'title' => '标题',
            'desc' => '简介',
            'faceId' => '封面图Id',
            'faceImg' => '封面图',
            'hits' => '点击',
            'comments' => '评论数',
            'favorites' => '收藏数',
            'cTime' => '发布时间',
            'updateTime' => '更新时间',
            'status' => '状态',
            'urlPrefix' => '路径',
            'tagids' => '标签',
            'tags' => '标签',
            'content' => '正文',
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
        $criteria->compare('typeId', $this->typeId, true);
        $criteria->compare('areaId', $this->areaId, true);
        $criteria->compare('uid', $this->uid, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('desc', $this->desc, true);
        $criteria->compare('faceImg', $this->faceImg, true);
        $criteria->compare('hits', $this->hits, true);
        $criteria->compare('comments', $this->comments, true);
        $criteria->compare('favorites', $this->favorites, true);
        $criteria->compare('cTime', $this->cTime, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('urlPrefix', $this->urlPrefix, true);
        $criteria->compare('tagids', $this->tagids, true);
        $criteria->compare('content', $this->content, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Articles the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {        
        return true;
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
            return;
        }
        $path = '';
        if ($info->areaId > 0) {
            $path = $info->areaInfo->name;        
        } elseif ($info->typeId > 0) {
            $path = $info->typeInfo->name;
        } 
        if(!$path){
            $path = 'article';
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
                'title'=>$keyword.'知识',
                'name'=>'article',
                'url'=>zmf::createUrl('index/articles')
            );
        }
        return $arr;
    }

    /**
     * 获取面包屑
     * @param Article $info
     * @return array
     */
    public static function getBreadcrumb($info) {
        if (!$info || (!$info['areaId'] && !$info['typeId'])) {
            return;
        }
        $breadcrumb = null;
        if ($info->areaId > 0) {
            $path = $info->areaInfo;
            $breadcrumb = array(
                'title' => $path['title'],
                'type' => 'area',
                'info' => $path,
                'urlArr' => array(
                    'index/index',
                    'colName' => $path['name']
                ),
            );
        }
        return $breadcrumb;
    }

    public static function getOne($id) {
        return static::model()->findByPk($id);
    }

    /**
     * 根据问题的标签获取相关文章
     * @param string|array $tagids 问题的ID
     * @param int $notInculed
     * @param int $limit
     * @param string $imgSize
     * @param bool $foreach
     * @return array
     */
    public static function getRelatedPosts($tagids, $notInculed = 0, $limit = 10, $imgSize = '',$foreach=true) {
        if (is_array($tagids)) {
            $str = join(',', array_keys(CHtml::listData($tagids, 'id', 'title')));
        } else {
            $str= zmf::filterIds($tagids);
        }
        if (!$str) {
            return array();
        }
        $sql = "SELECT p.id,count(p.id) AS times,p.title,p.urlPrefix,p.desc,p.faceImg,p.tagids,p.cTime FROM {{articles}} p,{{tag_relation}} tr WHERE tr.classify='".Column::CLASSIFY_POST."' AND tr.tagid IN({$str}) AND tr.logid=p.id " . ($notInculed ? " AND p.id!='{$notInculed}'" : '') . " AND p.status=1 GROUP BY p.id ORDER BY times DESC,p.cTime DESC LIMIT {$limit}";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if(!$foreach){
            return $items;
        }
        $posts = static::foreachArticles($items, $imgSize);
        return $posts;
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
        $sql = "SELECT p.id,count(p.id) AS times,p.title,p.urlPrefix,p.desc,p.faceImg,p.tagids FROM {{articles}} p LEFT JOIN {{tag_relation}} tr ON p.id=tr.logid LEFT JOIN {{tags}} t ON tr.tagid=t.id WHERE t.typeId='{$columnInfo['id']}' AND t.classify=".Column::CLASSIFY_PRODUCT." AND t.isDisplay=1 AND tr.classify=".Column::CLASSIFY_POST." AND p.status=1 GROUP BY p.id ORDER BY times DESC,p.cTime DESC LIMIT {$limit}";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        $posts = static::foreachArticles($items, $imgSize);
        return $posts;
    }

    /**
     * 根据产品分类关联的标签来获取内容
     * @param array $areaInfo 地区
     * @param int $limit
     * @param string $imgSize
     * @return array
     */
    public static function getAreaNewPosts($areaInfo, $limit = 10, $imgSize = '') {
        if (!$areaInfo) {
            return [];
        }
        $sql = "SELECT p.id,p.title,p.urlPrefix,p.desc,p.faceImg,p.tagids FROM {{articles}} p  LEFT JOIN {{area}} a ON a.id=p.areaId WHERE a.sitepath LIKE '{$areaInfo['sitepath']}%' AND p.status=1 ORDER BY p.cTime DESC LIMIT {$limit}";
        $items = zmf::dbAll($sql);
        $len=$limit-count($items);
        if($len>0){
            $temp=Articles::getNews($len,true);
            $items=!empty($items) ? array_merge($items,$temp) : $temp;
        }
        $posts = static::foreachArticles($items, $imgSize);
        return $posts;
    }

    /**
     * 获取文章栏目下最新的文章
     * @param $columnInfo
     * @param int $limit
     * @param string $imgSize
     * @return array
     */
    public static function getColumnNews($columnInfo,$limit = 10, $imgSize = '') {
        $sql = "SELECT a.id,a.typeId,a.title,a.desc,a.faceImg,a.hits,a.urlPrefix,'' AS tags,a.tagids FROM {{articles}} a WHERE a.typeId='{$columnInfo['id']}' AND a.`status`=1 ORDER BY a.cTime DESC LIMIT {$limit}";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        $posts = static::foreachArticles($items, $imgSize);
        return $posts;
    }

    /**
     * 随机获取某个栏目下文章ID
     * @param array $columnInfo
     * @param int $len
     * @param string $notInclude
     * @return array
     */
    public static function getRandColumnIds($columnId, $len = 10, $notInclude = '', $foreach = true) {
        $sql = "SELECT a.id,a.title,a.urlPrefix,a.desc,a.faceImg,a.cTime FROM {{articles}} a WHERE a.areaId=0 " . ($notInclude != '' ? " AND a.id NOT IN({$notInclude})" : '') . " AND a.typeId='{$columnId}' AND a.status=1 LIMIT 200";
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
     * 循环处理文章列表
     * @param array $posts
     * @param string $imgSize
     * @param array $pets
     * @param array $columns
     * @return array
     */
    public static function foreachArticles($posts, $imgSize = '', $columns = null) {
        if (!$columns) {
            $columns = Column::getAll();
        }
        foreach ($posts as $k => $digest) {
            $posts[$k]['faceImg'] = zmf::getThumbnailUrl($digest['faceImg'], $imgSize);
            $posts[$k]['tags'] = Tags::getAllByType(Column::CLASSIFY_POST, $digest['id']);
            foreach ($columns as $column) {
                if ($column['id'] == $digest['typeId']) {
                    $posts[$k]['columnInfo'] = $column;
                    break;
                }
            }
        }
        return $posts;
    }

    /**
     * 根据标题获取相似文章
     * @param string $title
     * @return array
     */
    public static function getMoreLikeThis($title, $passed = true,$select='id,title,urlPrefix') {
        Yii::import('application.vendors.phpanalysis.*');
        require_once 'phpanalysis.class.php';
        //初始化类
        PhpAnalysis::$loadInit = false;
        //是否预载全部词条
        $pri_dict = false;
        $pa = new PhpAnalysis('utf-8', 'utf-8', $pri_dict);
        //载入词典
        $pa->LoadDict();
        //执行分词
        $pa->SetSource($title);
        //多元切分
        $pa->differMax = false;
        //新词识别
        $pa->unitWord = false;
        //岐义处理
        $do_fork = true;
        $pa->StartAnalysis($do_fork);
        $str = $pa->GetFinallyKeywords(5);
        $arr = array_filter(explode(',', $str));
        if (empty($arr)) {
            return;
        }
        $like = array();
        foreach ($arr as $word) {
            $_word = '%' . strtr($word, array('%' => '\%', '_' => '\_', '\\' => '\\\\')) . '%';
            $like[] = "title LIKE '{$_word}'";
        }
        $likeStr = '(' . join(' OR ', $like) . ')';
        $sql = "SELECT {$select} FROM {{articles}} WHERE {$likeStr}" . ($passed ? ' AND status=' . Posts::STATUS_PASSED : '') . "  LIMIT 100";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        Yii::import('application.vendors.lcs.*');
        require_once 'lcs.php';
        $lcs = new LCS();
        foreach ($items as $k => $val) {
            $items[$k]['rate'] = $lcs->getSimilar($title, $val['title']);
        }
        $items = zmf::multi_array_sort($items, 'rate', SORT_DESC);
        return count($items) > 10 ? array_slice($items, 0, 10) : $items;
    }
    
    /**
     * 获取最新文章
     * @param int $limit
     * @param bool $noAreaId
     * @param string $notInclude
     * @return array
     */
    public static function getNews($limit = 10,$noAreaId=false,$notInclude='') {
        $sql = "SELECT a.id,a.typeId,a.title,a.desc,a.faceImg,a.hits,a.urlPrefix,'' AS tags,a.tagids FROM {{articles}} a WHERE ".($notInclude!='' ? "a.id NOT IN({$notInclude}) AND " : '').($noAreaId ? 'a.areaId=0 AND ' : '')."a.`status`=1 ORDER BY a.cTime DESC LIMIT {$limit}";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        return $items;
    }
    /**
     * 获取热门文章
     * @param int $limit
     * @return array
     */
    public static function getTops($limit = 10) {
        $sql = "SELECT a.id,a.typeId,a.title,a.desc,a.faceImg,a.hits,a.urlPrefix,'' AS tags,a.tagids FROM {{articles}} a WHERE a.`status`=1 ORDER BY a.hits DESC LIMIT {$limit}";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        return $items;
    }


    /**
     * 文章详情页面更多文章
     * 调用规则为：第一个标签的相关文章5篇＞当前文章分类最新补齐。
     * @param $articleInfo
     * @param $tagInfo
     * @param int $limit
     * @param string $imgSize
     * @return array
     */
    public static function articleDetailPage($articleInfo,$tagInfo,$limit=5,$imgSize=''){
        $articles=static::getRelatedPosts($tagInfo['id'],$articleInfo['id'],$limit,$imgSize);
        $len=$limit-count($articles);
        if($len>0){
            $temp=static::getColumnNews(array('id'=>$articleInfo['typeId']),$len,$imgSize);
            $articles=!empty($articles) ? array_merge($articles,$temp) : $temp;
        }
        return $articles;
    }

    public static function getAreaArticles($areaInfo,$limit=10,$imgSize=''){
        $articles=[];
        if($areaInfo){
            $sql = "SELECT a.id,a.typeId,a.title,a.desc,a.faceImg,a.hits,a.urlPrefix,'' AS tags,a.tagids FROM {{articles}} a,{{area}} ar WHERE ar.sitepath LIKE '{$areaInfo['sitepath']}%' AND a.areaId=ar.id AND a.`status`=1 ORDER BY a.cTime DESC LIMIT {$limit}";
            $articles=zmf::dbAll($sql);
        }
        $len=$limit-count($articles);
        if($len>0){
            $temp=static::getNews($len);
            $articles=!empty($articles) ? array_merge($articles,$temp) : $temp;
        }
        return $articles;
    }

    /**
     * 地区下按热门标签获取文章
     * @param $areaInfo
     * @param int $tagNum
     * @param int $articleNum
     * @param string $imgSize
     */
    public static function getAreaIndexArticles($areaInfo,$tagNum=6,$articleNum=9,$imgSize='a120'){
        $tags=Tags::model()->findAll([
            'condition'=>'toped=1',
            'select'=>'id,title,name',
            'limit'=>$tagNum
        ]);
        $posts=[];
        $idsArr=[];
        foreach($tags as $tag){
            $idsStr=join(',',$idsArr);
            $sql = "SELECT a.id,a.typeId,a.title,a.desc,a.faceImg,a.hits,a.urlPrefix,'' AS tags,a.tagids FROM {{articles}} a INNER JOIN {{tag_relation}} tr ON tr.logid=a.id INNER JOIN {{area}} ar ON a.areaId=ar.id WHERE tr.tagId='{$tag['id']}' AND tr.classify='".Column::CLASSIFY_POST."' AND ar.sitepath LIKE '{$areaInfo['sitepath']}%' AND ".($idsStr!='' ? "a.id NOT IN({$idsStr}) AND " : '')."a.`status`=1 ORDER BY a.cTime DESC LIMIT {$articleNum}";
            $_articles=zmf::dbAll($sql);
            $_arIdsTemp=array_keys(CHtml::listData($_articles,'id',''));
            $idsArr=!empty($idsArr) ? array_merge($idsArr,$_arIdsTemp) : $_arIdsTemp;
            $idsArr=array_unique($idsArr);
            $_len=$articleNum-count($_articles);
            if($_len>0){
                $_temp=Articles::getNews($_len,true,join(',',$idsArr));
                $_articles=!empty($_articles) ? array_merge($_articles,$_temp) : $_temp;
            }
            $_arIdsTemp=array_keys(CHtml::listData($_articles,'id',''));
            $idsArr=!empty($idsArr) ? array_merge($idsArr,$_arIdsTemp) : $_arIdsTemp;
            $idsArr=array_unique($idsArr);
            foreach ($_articles as $k=>$v){
                $_articles[$k]['faceImg']=zmf::getThumbnailUrl($v['faceImg'],$imgSize);
            }
            $posts[]=[
                'id'=>$tag['id'],
                'title'=>$tag['title'],
                'name'=>$tag['name'],
                'posts'=>$_articles,
            ];
        }
        return $posts;
    }

}
