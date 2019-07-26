<?php

/**
 * This is the model class for table "{{posts}}".
 *
 * The followings are the available columns in table '{{posts}}':
 * The followings are the available columns in table '{{posts}}':
 * @property integer $id
 * @property string $typeId
 * @property string $uid
 * @property string $title
 * @property string $keywords
 * @property string $content
 * @property string $faceImg
 * @property string $faceUrl
 * @property integer $classify
 * @property string $comments
 * @property string $favorites
 * @property integer $top
 * @property string $hits
 * @property string $tagids
 * @property integer $status
 * @property string $cTime
 * @property string $updateTime
 */
class Posts extends CActiveRecord {

    const STATUS_NOTPASSED = 0;
    const STATUS_PASSED = 1;
    const STATUS_STAYCHECK = 2;
    const STATUS_DELED = 3;
    //关于来源
    const PLATFORM_UNKOWN = 0;
    const PLATFORM_WEB = 1;
    const PLATFORM_MOBILE = 2;
    const PLATFORM_ANDROID = 3;
    const PLATFORM_IOS = 4;
    const PLATFORM_WEAPP = 5; //微信小程序

    //案例分类
    const CLASSIFY_CASE = 1;//案例
    const CLASSIFY_GALLERY = 2;//图库

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return '{{posts}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('uid', 'default', 'setOnEmpty' => true, 'value' => zmf::uid()),
            array('cTime,updateTime,order', 'default', 'setOnEmpty' => true, 'value' => zmf::now()),
            array('status', 'default', 'setOnEmpty' => true, 'value' => self::STATUS_PASSED),
            array('uid,title,content', 'required'),
            array('classify, top, status', 'numerical', 'integerOnly' => true),
            array('typeId, uid, faceImg, comments, favorites, hits, cTime, updateTime,digestTime,top,areaId,order,videoId', 'length', 'max' => 10),
            array('author', 'length', 'max' => 16),
            array('urlPrefix', 'length', 'max' => 32),
            array('imgs,videos', 'length', 'max' => 5),
            array('desc,content', 'safe'),
            array('title, keywords, faceUrl, tagids', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, typeId, uid, title, keywords, content, faceImg, faceUrl, classify, comments, favorites, top, hits, tagids, status, cTime, updateTime', 'safe', 'on' => 'search'),
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
            'areaInfo' => array(self::BELONGS_TO, 'Area', 'areaId'),
            'columnInfo' => array(self::BELONGS_TO, 'Column', 'typeId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'typeId' => '栏目',
            'uid' => '作者',
            'areaId' => '所属地区',
            'title' => '标题',
            'author' => '作者',
            'keywords' => '关键词',
            'desc' => '介绍',
            'content' => '正文',
            'faceImg' => '封面图',
            'faceUrl' => '封面图',
            'classify' => '分类',
            'comments' => '评论数',
            'favorites' => '收藏数',
            'top' => '是否置顶',
            'imgs' => '图片数',
            'videos' => '视频数',
            'hits' => '阅读数',
            'tagids' => '标签组',
            'status' => '状态',
            'cTime' => '创建时间',
            'updateTime' => '最近更新时间',
            'digestTime' => '精品',
            'order' => '排序',
            'videoId' => '视频',
            'urlPrefix' => '路径',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Posts the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getOne($id) {
        return static::model()->findByPk($id);
    }

    public static function exStatus($type) {
        $arr = array(
            static::STATUS_NOTPASSED => '存草稿',
            static::STATUS_PASSED => '正常',
            static::STATUS_STAYCHECK => '待审核',
        );
        if ($type == 'admin') {
            return $arr;
        }
        return $arr[$type];
    }
    
    public static function exTotalStatus($type) {
        $arr = array(
            static::STATUS_NOTPASSED => '存草稿',
            static::STATUS_PASSED => '正常',
            static::STATUS_STAYCHECK => '待审核',
            static::STATUS_DELED => '已删除',
        );
        if ($type == 'admin') {
            return $arr;
        }
        return $arr[$type];
    }

    public static function exPlatform($type) {
        $arr = array(
            static::PLATFORM_UNKOWN => '未知',
            static::PLATFORM_WEB => '网页',
            static::PLATFORM_MOBILE => '移动端',
            static::PLATFORM_ANDROID => '安卓客户端',
            static::PLATFORM_IOS => 'iOS客户端',
            static::PLATFORM_WEAPP => '微信小程序',
        );
        if ($type == 'admin') {
            return $arr;
        }
        return $arr[$type];
    }

    public static function exClassify($type) {
        $arr = array(
            static::CLASSIFY_CASE => '案例',
            static::CLASSIFY_GALLERY => '图库'
        );
        if ($type == 'admin') {
            return $arr;
        }
        return $arr[$type];
    }

    public static function encode($id, $type = 'post') {
        return zmf::jiaMi($id . '#' . $type);
    }

    public static function decode($code) {
        $_de = zmf::jieMi($code);
        $_arr = explode('#', $_de);
        return array(
            'id' => $_arr[0],
            'type' => $_arr[1],
        );
    }
    public static function checkCode($code,$type) {
        $_de = zmf::jieMi($code);
        $_arr = explode('#', $_de);
        if($_arr[1]==$type){
            return $_arr[0];
        }else{
            return false;
        }
    }

    /**
     * 更新查看次数
     * @param int $keyid 对象ID
     * @param string $type 对象类型
     * @param int $num 更新数量
     * @param string $field 更新字段
     * @return boolean
     */
    public static function updateCount($keyid, $type, $num = 1, $field = 'hits') {
        if (!$keyid || !$type || !in_array($type, array('Articles','Users','Attachments','Questions','Posts'))) {
            return false;
        }
        $model = new $type;
        return $model->updateCounters(array($field => $num), ':id=id', array(':id' => $keyid));
    }

    /**
     * 处理内容
     * @param type $content
     * @return type
     */
    public static function handleContent($content, $fullText = TRUE, $allowTags = '<b><strong><em><span><a><p><u><i><img><br><br/><div><blockquote><h1><h2><h3><h4><h5><h6><ol><ul><li><hr>') {
        if ($fullText) {
            $pattern = '/<img[\s\S]+?(data|mapinfo|video)=("|\')([^\2]+?)\2[^>]+?>/i';
            preg_match_all($pattern, $content, $matches);
            $arr_attachids = $arr_videoids = array();
            if (!empty($matches[0])) {
                foreach ($matches[0] as $key => $val) {
                    $_type = $matches[1][$key];
                    if ($_type == 'data') {//处理图片
                        $thekey = $matches[3][$key];
                        $imgsrc = $matches[0][$key];
                        $content = str_ireplace("{$imgsrc}", '[attach]' . $thekey . '[/attach]', $content);
                        $arr_attachids[] = $thekey;
                    } elseif ($_type == 'video') {//处理视频
                        $thekey = $matches[3][$key];
                        $imgsrc = $matches[0][$key];
                        $content = str_ireplace("{$imgsrc}", '[video]' . $thekey . '[/video]', $content);
                        $arr_videoids[] = $thekey;
                    } elseif ($_type == 'mapinfo') {//处理地图信息
                        $thekey = $matches[3][$key];
                        $imgsrc = $matches[0][$key];
                        $content = str_ireplace("{$imgsrc}", '[map]' . $thekey . '[/map]', $content);
                    }
                }
            }
            $content = strip_tags($content, $allowTags);
            $replace = array(
                "/style=\"[^\"]*?\"/i",
                "/<p><span>\&nbsp\;<\/span><\/p>/i",
                "/<p>\&nbsp\;<\/p>/i",
                "/<p><\/p>/i",
                "/　/i",
            );
            $to = array(
                ''
            );
            $content = preg_replace($replace, $to, $content);
            $content = zmf::removeEmoji($content);            
        } else {
            $content = strip_tags($content);
            $content = zmf::removeEmoji($content);
            $replace = array(
                "/　/i",
            );
            $to = array(
                ''
            );
            $content = preg_replace($replace, $to, $content);
        }
        $status = Posts::STATUS_PASSED;
        if (Words::checkWords($content)) {
            $status = Posts::STATUS_STAYCHECK;
        }
        $data = array(
            'content' => $content,
            'attachids' => !empty($arr_attachids) ? $arr_attachids : array(),
            'videoIds' => $arr_videoids,
            'status' => $status,
        );
        return $data;
    }

    public static function getAll($params, &$pages, &$comLists) {
        $sql = $params['sql'];
        if (!$sql) {
            return false;
        }
        $pageSize = $params['pageSize'];
        $_size = isset($pageSize) ? intval($pageSize) : 30;
        $com = Yii::app()->db->createCommand($sql)->query();
        //添加限制，最多取1000条记录
        //todo，按不同情况分不同最大条数
        $total = $com->rowCount > 1000 ? 1000 : $com->rowCount;
        $pages = new CPagination($total);
        $criteria = new CDbCriteria();
        $pages->pageSize = $_size;
        $pages->applylimit($criteria);
        $com = Yii::app()->db->createCommand($sql . " LIMIT :offset,:limit");
        $com->bindValue(':offset', $pages->currentPage * $pages->pageSize);
        $com->bindValue(':limit', $pages->pageSize);
        $comLists = $com->queryAll();
    }

    public static function getByPage($params) {
        $sql = $params['sql'];
        if (!$sql) {
            return false;
        }
        $pageSize = (is_numeric($params['pageSize']) && $params['pageSize'] > 0) ? $params['pageSize'] : 30;
        $page = (is_numeric($params['page']) && $params['page'] > 1) ? $params['page'] : 1;
        $bindValues = !empty($params['bindValues']) ? $params['bindValues'] : array();
        $bindValues[':offset'] = intval(($page - 1) * $pageSize);
        $bindValues[':limit'] = intval($pageSize);
        $com = Yii::app()->db->createCommand($sql . " LIMIT :offset,:limit");
        $com->bindValues($bindValues);
        $posts = $com->queryAll();
        return $posts;
    }

    public static function getTopsByTag($tagid, $limit = 5) {
        $sql = "SELECT p.id,p.title FROM {{posts}} p,{{tag_relation}} tr WHERE tr.tagid='{$tagid}' AND tr.classify='posts' AND tr.logid=p.id AND p.status=" . static::STATUS_PASSED . " ORDER BY hits DESC LIMIT {$limit}";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        return $items;
    }

    public static function getTops($notId, $classify = Posts::CLASSIFY_CASE, $limit = 5) {
        $sql = "SELECT id,title,faceUrl,urlPrefix,`desc` FROM {{posts}} WHERE classify='{$classify}' AND id!='{$notId}' AND status=" . Posts::STATUS_PASSED . " ORDER BY hits DESC LIMIT {$limit}";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        return $items;
    }

    /**
     * 根据标签获取相关案例
     * @param string|array $tagids 问题的ID
     * @param int $classify
     * @param int $notInculed
     * @param int $limit
     * @param string $imgSize
     * @param bool $foreach
     * @return array
     */
    public static function getRelatedPosts($tagids,$classify=Posts::CLASSIFY_CASE, $notInculed = 0, $limit = 10, $imgSize = '',$foreach=true) {
        if (is_array($tagids)) {
            $str = join(',', array_keys(CHtml::listData($tagids, 'id', 'title')));
        } else {
            $str= zmf::filterIds($tagids);
        }
        if (!$str) {
            return array();
        }
        $sql = "SELECT p.id,count(p.id) AS times,p.title,p.urlPrefix,p.desc,p.faceUrl,p.tagids FROM {{posts}} p,{{tag_relation}} tr WHERE tr.classify='".$classify."' AND tr.tagid IN({$str}) AND tr.logid=p.id " . ($notInculed ? " AND p.id!='{$notInculed}'" : '') . " AND p.status=1 GROUP BY p.id ORDER BY times DESC,p.cTime DESC LIMIT {$limit}";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if(!$foreach){
            return $items;
        }
        $posts = static::foreachPosts($items, $imgSize);
        return $posts;
    }

    public static function favorite($code, $from = 'web', $userInfo = array()) {
        if (!$code) {
            return array('status' => 0, 'msg' => '数据不全，请核实');
        }
        $codeArr=static::decode($code);
        if (!is_numeric($codeArr['id']) || $codeArr['id'] < 1 || !in_array($codeArr['type'], array('product'))) {
            return array('status' => 0, 'msg' => '暂不允许的分类');
        }
        $id = $codeArr['id'];
        $type = $codeArr['type'];
        if (!$userInfo['id']) {
            $uid = zmf::uid();
            $userInfo = Users::getOne($uid);
        } else {
            $uid = $userInfo['id'];
        }
        if (!$uid) {
            return array('status' => 0, 'msg' => '请先登录');
        }
        if (zmf::actionLimit('favorite-' . $type, $id)) {
            return array('status' => 0, 'msg' => '操作太频繁，请稍后再试');
        }
        $postInfo=null;
        if ($type != 'forum') {
            if (!$postInfo || $postInfo['status'] != Posts::STATUS_PASSED) {
                return array('status' => 0, 'msg' => '你所操作的内容不存在');
            }
        }
        $attr = array(
            'uid' => $uid,
            'logid' => $id,
            'classify' => $type
        );
        $info = Favorites::model()->findByAttributes($attr);
        if ($info) {
            if (Favorites::model()->deleteByPk($info['id'])) {
                return array('status' => 1, 'msg' => '已取消收藏', 'state' => 3);
            } else {
                return array('status' => 0, 'msg' => '取消收藏失败', 'state' => 4);
            }
        } else {
            $attr['cTime'] = zmf::now();
            $model = new Favorites();
            $model->attributes = $attr;
            if ($model->save()) {
                return array('status' => 1, 'msg' => '收藏成功', 'state' => 1);
            } else {
                return array('status' => 0, 'msg' => '收藏失败', 'state' => 2);
            }
        }
    }

    public static function updateCommentsNum($id) {
        if (!$id) {
            return false;
        }
        $num = Comments::model()->count("logid=:logid AND classify='posts' AND `status`=" . Posts::STATUS_PASSED, array(
            ':logid' => $id
        ));
        return Posts::model()->updateByPk($id, array('comments' => $num));
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
            $path = $info->columnInfo->name;
        }
        if(!$path){
            $path = 'case';
        }
        $info->updateByPk($info['id'], array(
            'urlPrefix' => $path
        ));
        return $path;
    }
    
    /**
     * 返回格式化后案例的内容
     * @param string $content
     * @param bool $lazyload
     * @param int $size
     * @param int $fileWidth
     * @return string
     */
    public static function text($content, $lazyload = false, $size = 'c650.jpg', $fileWidth = 0, $params = array()) {
        if (!$content) {
            return $content;
        }
        $isMobile = zmf::checkmobile($platform);
        if (strpos($content, '[attach]') !== false) {
            preg_match_all("/\[attach\](\d+)\[\/attach\]/i", $content, $match);
            if (!empty($match[1])) {
                $_imgIndex = 0;
                $_imgNumberIndex = 1;
                foreach ($match[1] as $key => $val) {
                    $thekey = $match[0][$key];
                    $src = Attachments::getOne($val);
                    $_fileAlt = '';
                    if ($src['fileDesc'] != '') {
                        $_fileAlt = $src['fileDesc'];
                    } elseif (!empty($params['tags']) || $params['title'] != '') {
                        $_fileAlt = $params['tags'][$_imgIndex]['title'];
                        if (count($params['tags']) < ($_imgIndex + 1)) {
                            $_number = zmf::getNumberText($_imgNumberIndex);
                            $_fileAlt = $params['title'] . $_number;
                            ++$_imgNumberIndex;
                        }
                        ++$_imgIndex;
                    }
                    if ($src) {
                        $_imgurl = Attachments::getUrl($src, $size);
                        if (!$isMobile) {
                            $imgurl = '<p>';
                        } else {
                            $imgurl = '';
                        }
                        if ($lazyload) {
                            $_extra = '';
                            if ($fileWidth) {
                                $_width = $_height = 0;
                                if ($src['width'] <= $fileWidth) {
                                    $_width = $src['width'];
                                    $_height = $src['height'];
                                } else {
                                    $_width = $fileWidth;
                                }
                                $_extra = " width='" . $_width . "px'";
                            }
                            $imgurl .= "<img src='" . zmf::lazyImg() . "' alt='". strip_tags($_fileAlt)."' class='lazy' data-original='{$_imgurl}'$_extra/>";
                        } else {
                            $imgurl .= "<img src='{$_imgurl}' alt='". strip_tags($_fileAlt)."' class='img-responsive'>";
                        }
                        if (!$isMobile) {
                            $imgurl .= '</p>';
                        } else {
                            $imgurl .= '';
                        }
                        $content = str_replace("{$thekey}", $imgurl, $content);
                    } else {
                        $content = str_replace("{$thekey}", '', $content);
                    }
                }
            }
        }
        //加链接
        $content = Keywords::linkWords($content);        
        return $content;
    }
    
    public static function mipText($content, $size = 'c650.jpg', $params = array()) {
        if (!$content) {
            return $content;
        }
        if (strpos($content, '[attach]') !== false) {
            preg_match_all("/\[attach\](\d+)\[\/attach\]/i", $content, $match);
            if (!empty($match[1])) {
                $_imgIndex = 0;
                $_imgNumberIndex = 1;
                foreach ($match[1] as $key => $val) {
                    $thekey = $match[0][$key];
                    $src = Attachments::getOne($val);
                    $_fileAlt = '';
                    if ($src['fileDesc'] != '') {
                        $_fileAlt = $src['fileDesc'];
                    } elseif (!empty($params['tags']) || $params['title'] != '') {
                        $_fileAlt = $params['tags'][$_imgIndex]['title'];
                        if (count($params['tags']) < ($_imgIndex + 1)) {
                            $_number = zmf::getNumberText($_imgNumberIndex);
                            $_fileAlt = $params['title'] . $_number;
                            ++$_imgNumberIndex;
                        }
                        ++$_imgIndex;
                    }
                    if ($src) {
                        $_imgurl = Attachments::getUrl($src, $size);                        
                        $imgurl = "<mip-img src='{$_imgurl}' alt='". strip_tags($_fileAlt)."' class='img-responsive' popup></mip-img>";                        
                        $content = str_replace("{$thekey}", $imgurl, $content);
                    } else {
                        $content = str_replace("{$thekey}", '', $content);
                    }
                }
            }
        }
        //加链接
        $content = Keywords::linkWords($content);        
        return $content;
    }

    public static function kdText($content, $size = 'c650') {
        if (strpos($content, '[attach]') !== false) {
            preg_match_all("/\[attach\](\d+)\[\/attach\]/i", $content, $match);
            if (!empty($match[1])) {
                foreach ($match[1] as $key => $val) {
                    $thekey = $match[0][$key];
                    $src = Attachments::getOne($val);
                    if ($src) {
                        $_imgurl = Attachments::getUrl($src, $size);
                        $imgurl = "<p><img src='{$_imgurl}'></p>";
                        $content = str_replace("{$thekey}", $imgurl, $content);
                    } else {
                        $content = str_replace("{$thekey}", '', $content);
                    }
                }
            }
        }
        $wordsArr=explode(',',zmf::config('kd_replace_words'));
        mb_internal_encoding("UTF-8");
        mb_regex_encoding("UTF-8");
        foreach ($wordsArr as $_w){
            $_arr=explode('#',$_w);
            $replaces[]=$_arr[0];
            $to[]=$_arr[1];
            $content=mb_ereg_replace($_arr[0],$_arr[1],$content);
        }
        return $content;
    }
    
    /**
     * 只返回内容中的图片
     * @param string $content
     * @param string $size
     * @return array
     */
    public static function contentImgs($content, $size = 'c650.jpg') {
        if (!$content) {
            return $content;
        }
        $imags=[];
        if (strpos($content, '[attach]') !== false) {
            preg_match_all("/\[attach\](\d+)\[\/attach\]/i", $content, $match);
            if (!empty($match[1])) {
                foreach ($match[1] as $key => $val) {
                    $src = Attachments::getOne($val);
                    if($src){
                        $_imgurl = Attachments::getUrl($src, $size);
                        $imags[]=[
                            'id'=>$src['id'],
                            'fileDesc'=>$src['fileDesc'],
                            'remote'=>$_imgurl
                        ];
                    }
                }
            }
        }
        return $imags;
    }

    public static function getTopes($classify,$limit = 6, $areaInfo = array(),$isMobile=false,$imgSize='') {
        $field='top';
        if ($areaInfo) {
            $sql = "SELECT p.id,p.title,p.faceUrl,p.tagids,p.areaId,p.urlPrefix,p.desc,p.imgs,p.cTime FROM {{posts}} p,{{area}} a WHERE p.{$field}>0 AND p.classify='{$classify}' AND p.areaId=a.id AND a.sitepath LIKE '{$areaInfo['sitepath']}%' AND p.status=1 ORDER BY p.{$field} DESC LIMIT {$limit}";
        } else {
            $sql = "SELECT id,title,faceUrl,tagids,areaId,urlPrefix,`desc`,imgs,cTime FROM {{posts}} WHERE `{$field}`>0 AND classify='{$classify}' AND status=1 ORDER BY `{$field}` DESC LIMIT {$limit}";
        }
        $digestes = Yii::app()->db->createCommand($sql)->queryAll();
        $len = count($digestes);
        //如果在地区首页且数量不达标则取其他案例补齐
        if ($areaInfo && $len < $limit) {
            if ($len > 0) {
                $_limit = $limit - $len;
                $idstr = join(',', array_keys(CHtml::listData($digestes, 'id', 'title')));
                $_sql = "SELECT id,title,faceUrl,tagids,areaId,urlPrefix,`desc`,imgs FROM {{posts}} WHERE `{$field}`>0 AND classify='{$classify}' AND id NOT IN($idstr) AND status=1 ORDER BY `{$field}` DESC LIMIT {$_limit}";
                $_digestes = Yii::app()->db->createCommand($_sql)->queryAll();
                $digestes = array_merge($digestes, $_digestes);
            } else {
                $digestes = Posts::getTopes($classify,$limit, null);
            }
        }
        return Posts::foreachPosts($digestes,$imgSize);
    }

    public static function foreachPosts($posts, $imgSize = 'c360') {
        //取标签
        $str = join(',', CHtml::listData($posts, 'id', 'tagids'));
        $tagidStr = join(',', array_unique(array_filter(explode(',', $str))));
        $postsTags = array();
        if ($tagidStr != '') {
            $_postsTags = Tags::getByIds($tagidStr);
            foreach($_postsTags as $_v){
                $postsTags[$_v['id']]=$_v;
            }
        }
        //取地区
        $areaStr = join(',', CHtml::listData($posts, 'id', 'areaId'));
        $_postsAreas = Area::getByIds($areaStr);
        $postsAreas = CHtml::listData($_postsAreas, 'id', 'title');
        $postsAreaName = CHtml::listData($_postsAreas, 'id', 'name');
        foreach ($posts as $k => $digest) {
            if ($imgSize != '') {
                $posts[$k]['faceUrl'] = zmf::getThumbnailUrl($digest['faceUrl'], $imgSize);
            }
            $_tagArr = array();
            if ($digest['tagids'] != '') {
                $_arr = array_unique(array_filter(explode(',', $digest['tagids'])));
                foreach ($_arr as $_tid) {
                    if(array_key_exists($_tid,$postsTags)){
                        $_tagArr[$_tid] = zmf::link($postsTags[$_tid]['title'], array('index/index', 'colName' => $postsTags[$_tid]['name']), array('target' => '_blank'));
                    }
                }
            }
            $_len = count($_tagArr);
            $posts[$k]['tags'] = $_len > 0 ? ($_len > 2 ? join('、', array_slice($_tagArr, 0, 2)) : join('、', $_tagArr)) : '';
            //取地区
            $posts[$k]['areaTitle'] = $digest['areaId'] > 0 ? $postsAreas[$digest['areaId']] : '';
            $posts[$k]['areaName'] = $digest['areaId'] > 0 ? $postsAreaName[$digest['areaId']] : '';
        }
        return $posts;
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
            $path = $info->columnInfo;
            $arr=array(
                'title'=>$path['title'],
                'name'=>$path['name'],
                'url'=>zmf::createUrl('index/index',array('colName'=>$path['name']))
            );
        }else{
            $arr=array(
                'title'=>$keyword.$info['classify']==Posts::CLASSIFY_CASE ? '案例' : '图库',
                'name'=>'case',
                'url'=>zmf::createUrl('index/posts')
            );
        }
        return $arr;
    }

    /**
     * 获取最新的案例图库
     * @param int $limit
     * @param string $imgSize
     * @return mixed
     */
    public static function getNews($limit=5,$imgSize=''){
        $sql = "SELECT id,title,faceUrl,tagids,areaId,urlPrefix,`desc`,imgs FROM {{posts}} WHERE status=1 ORDER BY cTime DESC LIMIT {$limit}";
        $digestes = Yii::app()->db->createCommand($sql)->queryAll();
        return Posts::foreachPosts($digestes,$imgSize);
    }

}
