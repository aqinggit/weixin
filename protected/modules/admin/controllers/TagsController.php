<?php

/**
 * @filename TagsController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2015 阿年飞少 
 * @datetime 2016-1-4  12:54:36 
 */
class TagsController extends Admin {

    public function init() {
        parent::init();
        $this->checkPower('tags');
    }

    public function actionIndex() {
        $select = "id,title,classify,`name`,isDisplay,typeId,toped";
        $model = new Tags();
        $criteria = new CDbCriteria();
        $title = zmf::val("title", 1);
        if ($title) {
            $criteria->addSearchCondition("title", $title, true, 'OR');
            $criteria->addSearchCondition("name", $title, true, 'OR');
            $criteria->addSearchCondition("nickname", $title, true, 'OR');
        }
        $classify = zmf::val("classify", 1);
        if ($classify) {
            $criteria->addCondition("classify='{$classify}'");
        }
        $toped = zmf::val("toped", 2);
        if ($toped>0) {
            $criteria->addCondition("toped>0");
        }
        $name = zmf::val('name', 1);
        if ($name) {
            $criteria->addCondition("name='{$name}'");
        }
        $criteria->select = $select;
        $criteria->order = '`id` DESC';
        $count = $model->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 30;
        $pager->applyLimit($criteria);
        $posts = $model->findAll($criteria);
        $this->render('index', array(
            'model' => $model,
            'pages' => $pager,
            'posts' => $posts,
        ));
    }

    public function actionCreate($id = '') {
        if ($id) {
            $this->checkPower('updateTags');
            $model = Tags::model()->findByPk($id);
            if (!$model) {
                $this->message(0, '该标签不存在');
            }
        } else {
            $model = new Tags;
        }
        if (isset($_POST['Tags'])) {
            $_POST['Tags']['nickname'] = str_replace('，', ',', $_POST['Tags']['nickname']);
            $model->attributes = $_POST['Tags'];
            $_name = $_POST['Tags']['name'];
            $hasError = false;
            $info=Sitepath::findByName($_name);
            if ($info['logid'] == $id && $info['classify']=='tag') {
            }elseif($info){
                $hasError = true;
            }
            if ($hasError) {
                $model->addError('name', '已被占用');
            } elseif ($model->save()) {
                Sitepath::updateOne('tag',$model->id,$model->name);
                if (!$id) {
                    Yii::app()->user->setFlash('addTagsSuccess', "保存成功！您可以继续添加。");
                    $this->redirect(array('create'));
                } else {
                    $this->redirect(array('index'));
                }
            }
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionMulti() {
        $model = new Tags;
        if (isset($_POST['Tags'])) {
            $titles = $_POST['Tags']['title'];
            $classify = $_POST['Tags']['classify'];
            $titlesArr = array_unique(array_filter(explode(PHP_EOL, $titles)));
            foreach ($titlesArr as $_title) {
                $pinyin=zmf::pinyin($_title,true);
                $_info=Tags::findByName($pinyin);
                $_attr = array(
                    'title' => $_title.($_info ? uniqid() : ''),
                    'classify' => $classify,
                    'name' => ($_info ? uniqid() : $pinyin),
                );
                $_model = new Tags();
                $_model->attributes = $_attr;
                $_model->save();
            }
            Yii::app()->user->setFlash('addTagsSuccess', "已批量导入！您可以继续添加或前往完善。");
            $this->redirect(array('multi'));
        }
        $this->render('multi', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $this->actionCreate($id);
    }

    public function actionDelete($id) {
        $this->checkPower('delTags');
        $this->loadModel($id)->delete();
        TagRelation::model()->deleteAll('tagid=:tagid', array(
            ':tagid' => $id
        ));
        if ($this->isAjax) {
            $this->jsonOutPut(1, '已删除');
        } else {
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    public function actionUpdateName() {
        if (!$this->isAjax) {
            $this->jsonOutPut(0, '不允许');
        }
        $id = zmf::val('id', 2);
        $_name = zmf::val('name', 1);
        if(!$id || !$_name){
            $this->jsonOutPut(0, '缺少参数');
        }
        $colinfo = Column::findByName($_name);
        $taginfo = Tags::findByName($_name);
        $areainfo = Area::findByName($_name);
        if (($id && $taginfo['id'] != $id && $taginfo) || ($colinfo || $areainfo)) {
            $hasError = true;
        }
        if($hasError){
            $this->jsonOutPut(0, '已重复');
        }
        if(Tags::model()->updateByPk($id, array('name'=>$_name))){
            $this->jsonOutPut(1, '已更新');
        }
        $this->jsonOutPut(0, '更新失败');
    }
    
    public function actionUpdateColumn() {
        if (!$this->isAjax) {
            $this->jsonOutPut(0, '不允许');
        }
        $typeId = zmf::val('typeId', 2);
        $tagId = zmf::val('tagId', 2);
        if(!$typeId || !$tagId){
            $this->jsonOutPut(0, '缺少参数');
        }
        if(Tags::model()->updateByPk($tagId, array('typeId'=>$typeId))){
            $this->jsonOutPut(1, '已更新');
        }
        $this->jsonOutPut(0, '可能未作更改');
    }

    public function actionLinkArticles() {
        $type=zmf::val('type',1);
        $id=zmf::val('id',2);
        if($id){
            $tagInfo = $this->loadModel($id);
        }else{
            $tagInfo=Tags::model()->find(array(
                'order'=>'id ASC'
            ));
            $type='all';
        }
        $_page = zmf::val('page', 2);
        $page = $_page < 1 ? 1 : $_page;
        $limit = 100;
        $start = ($page - 1) * $limit;
        $sql = "select id,title,`desc`,content FROM {{articles}} WHERE status=1 ORDER BY id ASC LIMIT $start,$limit";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($items)) {
            if($type=='all'){
                $_info=Tags::model()->find(array(
                    'condition'=>'id>'.$tagInfo['id'],
                    'order'=>'id ASC'
                ));
                if($_info){
                    $this->redirect(array('linkArticles','id'=>$_info['id'],'type'=>$type));
                }
            }
            $this->redirect(array('index'));
        }
        foreach ($items as $item) {
            $_hasTag = false;
            $_tagArr = array_unique(array_filter(explode(',', $tagInfo['nickname'])));
            $_tagArr[] = $tagInfo['title'];
            foreach ($_tagArr as $_tagTitle) {
                if (strpos($item['title'], $_tagTitle) !== false) {
                    $_hasTag = true;
                }
                if (strpos($item['desc'], $_tagTitle) !== false) {
                    $_hasTag = true;
                }
                if (strpos($item['content'], $_tagTitle) !== false) {
                    $_hasTag = true;
                }
            }
            if ($_hasTag) {
                $_attr = array(
                    'logid' => $item['id'],
                    'classify' => Column::CLASSIFY_POST,
                    'tagid' => $tagInfo['id'],
                );
                $_info = TagRelation::model()->findByAttributes($_attr);
                if (!$_info) {
                    $_model = new TagRelation;
                    $_model->attributes = $_attr;
                    $_model->save();
                }
            }
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/tags/linkArticles', array('id' => $tagInfo['id'], 'page' => ($page + 1),'type'=>$type)), 0);
    }

    public function actionLinkQuestions() {
        $type=zmf::val('type',1);
        $id=zmf::val('id',2);
        if($id){
            $tagInfo = $this->loadModel($id);
        }else{
            $tagInfo=Tags::model()->find(array(
                'order'=>'id ASC'
            ));
            $type='all';
        }
        $_page = zmf::val('page', 2);
        $page = $_page < 1 ? 1 : $_page;
        $limit = 100;
        $start = ($page - 1) * $limit;
        $sql = "select id,title,description,content FROM {{questions}} WHERE status=1 ORDER BY id ASC LIMIT $start,$limit";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($items)) {
            if($type=='all'){
                $_info=Tags::model()->find(array(
                    'condition'=>'id>'.$tagInfo['id'],
                    'order'=>'id ASC'
                ));
                if($_info){
                    $this->redirect(array('linkQuestions','id'=>$_info['id'],'type'=>$type));
                }
            }
            $this->redirect(array('index'));
        }
        foreach ($items as $item) {
            $_attr = array(
                'logid' => $item['id'],
                'classify' => Column::CLASSIFY_QUESTION,
                'tagid' => $tagInfo['id'],
            );
            //如果已经有这个标签则直接跳过
            $_info = TagRelation::model()->findByAttributes($_attr);
            if ($_info) {
                continue;
            }
            $_hasTag = false;
            $_tagArr = array_unique(array_filter(explode(',', $tagInfo['nickname'])));
            $_tagArr[] = $tagInfo['title'];
            foreach ($_tagArr as $_tagTitle) {
                if (strpos($item['title'], $_tagTitle) !== false) {
                    $_hasTag = true;
                }
                if (strpos($item['desc'], $_tagTitle) !== false) {
                    $_hasTag = true;
                }
                if (strpos($item['content'], $_tagTitle) !== false) {
                    $_hasTag = true;
                }
            }
            //如果问题的主体里没有找到这个标签，则到回答里查找
            if (!$_hasTag) {
                $_answers = Answers::model()->findAll('qid=:id AND status=1', array(':id' => $item['id']));
                foreach ($_answers as $_answer) {
                    foreach ($_tagArr as $_tagTitle) {
                        if (strpos($_answer['content'], $_tagTitle) !== false) {
                            $_hasTag = true;
                        }
                    }
                }
            }
            if ($_hasTag) {
                $_model = new TagRelation;
                $_model->attributes = $_attr;
                $_model->save();
            }
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/tags/linkQuestions', array('id' =>$tagInfo['id'], 'page' => ($page + 1),'type'=>$type)), 0);
    }

    public function actionOrder() {
        $type = zmf::val('type', 1);
        $posts = Tags::model()->findAll(array(
            'condition' => 'classify=:class',
            'order' => '`order` ASC',
            'params' => array(
                ':class' => $type
            )
        ));
        $this->render('order', array(
            'posts' => CHtml::listData($posts, 'id', 'title'),
            'type' => $type
        ));
    }

    public function actionChangeOrder() {
        $ids = $_POST['ids'];
        if ($ids == '') {
            $this->jsonOutPut(0, '操作对象不能为空');
        }
        $arr = array_filter(explode('#', $ids));
        if (empty($arr)) {
            $this->jsonOutPut(0, '操作对象不能为空');
        }
        $s = $e = 0;
        $field = 'order';
        $now = zmf::now();
        foreach ($arr as $k => $v) {
            $_order = $now + ($k + 1) * 1000;
            $data = array(
                $field => $_order
            );
            $_info = Tags::model()->updateByPk($v, $data);
            if ($_info) {
                $s += 1;
            } else {
                $e += 1;
            }
        }
        if ($s == count($arr)) {
            $this->jsonOutPut(1, '排序成功');
        } elseif ($e > 0 AND $e < count($arr)) {
            $this->jsonOutPut(1, '部分排序成功');
        } else {
            $this->jsonOutPut(0, '排序失败，可能是未做修改');
        }
    }

    public function actionSearch() {
        if (Yii::app()->request->isAjaxRequest && isset($_GET['q'])) {
            $name = trim(zmf::val('q', 1));
            $name = '%' . strtr($name, array('%' => '\%', '_' => '\_', '\\' => '\\\\')) . '%';
            $sql = "SELECT id,title FROM " . Tags::tableName() . " WHERE title LIKE '$name' ORDER BY length ASC LIMIT 10";
            $items = Yii::app()->db->createCommand($sql)->queryAll();
            $returnVal = '';
            foreach ($items as $val) {
                $returnVal .= $val['title'] . '|' . $val['id'] . "\n";
            }
            echo $returnVal;
        }
    }

    public function actionAutoMatchTag() {
        if (!$this->isAjax) {
            $this->jsonOutPut(0, '不被允许的操作');
        }
        $content = zmf::val('content', 1);
        $tags = Tags::getTags();
        $_tags = [];
        foreach ($tags as $tag) {
            $_tagArr = array_unique(array_filter(explode(',', $tag['nickname'])));
            $_tagArr[] = $tag['title'];
            foreach ($_tagArr as $_tagTitle) {
                if (strpos($content, $_tagTitle) !== false) {
                    $_tags[] = $tag;
                }
            }
        }
        $html = '';
        foreach ($_tags as $_tag) {
            $html .= $this->renderPartial('/tags/_formItem', array('data' => $_tag), true);
        }
        $this->jsonOutPut(1, array(
            'tags' => $_tags,
            'html' => $html,
        ));
    }

    public function loadModel($id) {
        $model = Tags::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
