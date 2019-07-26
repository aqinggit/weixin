<?php

/**
 * @filename QuestionsController.php
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2017 阿年飞少
 * @datetime 2017-09-27 08:15:52 */
class QuestionsController extends Admin {

    public function init() {
        parent::init();
        $this->checkPower('questions');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $select = "id,uid,areaId,typeId,title,answers,`status`,bestAid,urlPrefix,cTime,updateTime";
        $model = new Questions;
        $criteria = new CDbCriteria();
        $id = zmf::val("id", 1);
        if ($id) {
            $criteria->addCondition("id=" . $id);
        }
        $uid = zmf::val("uid", 2);
        if ($uid) {
            $criteria->addCondition("uid=" . $uid);
        }
        $createUid = zmf::val("createUid", 2);
        if ($createUid) {
            $criteria->addCondition("createUid=" . $createUid);
        }
        $name = zmf::val('username', 1);
        if ($name) {
            $name = '%' . strtr($name, array('%' => '\%', '_' => '\_', '\\' => '\\\\')) . '%';
            $criteria->join = 'INNER JOIN {{users}} u ON t.uid=u.id';
            $criteria->addCondition("(u.truename LIKE '$name' OR u.phone LIKE '$name' OR u.qq LIKE '$name' OR u.weixin LIKE '$name')");
        }
        $title = trim(zmf::val("title", 1));
        if ($title) {
            $titleArr = array_filter(explode('+', $title));
            if (!empty($titleArr)) {
                foreach ($titleArr as $t) {
                    $criteria->addSearchCondition("title", $t);
                }
            }
        }
        $now=zmf::now();
        $startTime = zmf::val("startTime", 1);
        if ($startTime) {
            $startTime=strtotime($startTime,$now);
            $criteria->addCondition("cTime>=" . $startTime);
        }
        $endTime = zmf::val("endTime", 1);
        if ($endTime) {
            $endTime=strtotime($endTime,$now);
            $endTime+=86399;
        }
        if($endTime){
            $criteria->addCondition("cTime<=" . $endTime);
        }
        $status = zmf::val("status", 1);
        if ($status) {
            $criteria->addSearchCondition("status", $status);
        }
        $criteria->select = $select;
        $criteria->order = 'id DESC';
        $count = $model->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 30;
        $pager->applyLimit($criteria);
        $posts = $model->findAll($criteria);
        //取出现的用户
        $sql="SELECT u.id,u.truename FROM {{users}} u,{{questions}} p WHERE p.createUid=u.id GROUP BY p.createUid";
        $users=zmf::dbAll($sql);
        $users=CHtml::listData($users,'id','truename');
        $this->render('index', array(
            'pages' => $pager,
            'posts' => $posts,
            'model' => $model,
            'users' => $users,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $info = $this->loadModel($id);
        $info->content = Posts::text($info['content'], true, 'tc800wm');
        $this->render('view', array(
            'model' => $info,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($id = '') {
        if ($id) {
            $this->checkPower('updateQuestions');
            $model = $this->loadModel($id);
            if(!$model->hits){
                $model->hits=mt_rand(100,10000);
            }
        } else {
            $model = new Questions;
            $model->cTime = zmf::now();
            $model->hits = mt_rand(100, 999);
            $model->status = Posts::STATUS_STAYCHECK;
            $model->uid = Users::getRandomId();
            $model->createUid = $this->uid;
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Questions'])) {
            $now = zmf::now();
            $tags = isset($_POST['tags']) ? array_unique(array_filter($_POST['tags'])) : array();
            if (isset($_POST['Questions']['cTime']) && $_POST['Questions']['cTime'] != '') {
                $_POST['Questions']['cTime'] = strtotime($_POST['Questions']['cTime'], $now);
            } else {
                $_POST['Questions']['cTime'] = $now;
            }
            $filterContent = Posts::handleContent($_POST['Questions']['content'], TRUE, '<p><img><br><h1><h2><h3><h4><h5><h6>');
            $_POST['Questions']['content'] = $filterContent['content'];
            //如果没有上传封面图
            if (!$_POST['Questions']['faceId'] && !empty($filterContent['attachids'])) {
                $attkeys = array_filter(array_unique($filterContent['attachids']));
                if (!empty($attkeys)) {
                    $_POST['Questions']['faceUrl'] = Attachments::faceImg($attkeys[0], ''); //默认将文章中的第一张图作为封面图
                    $_POST['Questions']['faceId'] = $attkeys[0];
                }
            } elseif ($_POST['Questions']['faceId']) {
                $_POST['Questions']['faceUrl'] = Attachments::faceImg($_POST['Questions']['faceId'], ''); //默认将文章中的第一张图作为封面图
            }
            $model->attributes = $_POST['Questions'];
            if ($model->save()) {
                $realTags = array();
                if ($id) {
                    TagRelation::model()->deleteAll('logid=:logid AND classify=:classify', array(':logid' => $id, ':classify' => Column::CLASSIFY_QUESTION));
                }
                //自动加标签
                Tags::addContentLinks(array(
                    'title' => $model->title,
                    'content' => $model->content
                        ), Column::CLASSIFY_QUESTION, $model->id, false);
                //自动获取文章标签
                //todo
                //$tags[] = 264;
                $tags = array_unique($tags);
                if (!empty($tags)) {
                    foreach ($tags as $_tagid) {
                        $_tgAttr = array(
                            'logid' => $model->id,
                            'tagid' => $_tagid,
                            'classify' => Column::CLASSIFY_QUESTION
                        );
                        if (TagRelation::addRelation($_tgAttr)) {
                            $realTags[] = $_tagid;
                        }
                    }
                }
                $realTags = array_unique(array_filter($realTags));
                $_postTagids = join(',', $realTags);
                Questions::model()->updateByPk($model->id, array('tagids' => $_postTagids));
                //更新路径
                Questions::updateUrlPrefix($model->id);

                if (!$id) {
                    AdminLogs::addLog(array(
                        'logid' => $model->id,
                        'classify' => 'question',
                        'content' => '新增问题',
                    ));
                    Yii::app()->user->setFlash('addQuestionsSuccess', "保存成功！您可以继续添加。");
                } else {
                    AdminLogs::addLog(array(
                        'logid' => $model->id,
                        'classify' => 'question',
                        'content' => '更新问题',
                    ));
                }
                $this->redirect(array('index', 'id' => $model->id));
            }
        }
        $contentImgs = [];
        if ($id) {
            preg_match_all("/\[attach\](\d+)\[\/attach\]/i", $model['content'], $match);
            $imgIds = join(',', array_unique(array_filter($match[1])));
            $imgIds= zmf::filterIds($imgIds);
            if ($imgIds != '') {
                $_sql = 'SELECT id,remote,fileAlt FROM {{attachments}} WHERE id IN(' . $imgIds . ')';
                $contentImgs = Yii::app()->db->createCommand($_sql)->queryAll();
                foreach ($contentImgs as $key => $value) {
                    $contentImgs[$key]['remote'] = zmf::getThumbnailUrl($value['remote'], 'c650.jpg');
                }
            }
        }
        $this->render('create', array(
            'model' => $model,
            'tags' => $tags,
            'contentImgs' => $contentImgs,
        ));
    }

    public function actionCreateFromArticle($aid) {
        $articleInfo = Articles::getOne($aid);
        if (!$articleInfo) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        $model = new Questions;
        $modelAnswer = new Answers;
        $model->cTime = $model->updateTime = $articleInfo['cTime'];
        $model->hits = $articleInfo['hits'];
        $model->status = Posts::STATUS_STAYCHECK;
        $model->uid = $articleInfo['uid'];
        $model->typeId = $articleInfo['typeId'];
        $model->areaId = $articleInfo['areaId'];
        $model->title = $articleInfo['title'];
        $model->content = $articleInfo['desc'];
        $model->faceUrl = $articleInfo['faceImg'];
        //回答
        $modelAnswer->cTime = zmf::time();
        $modelAnswer->status = Posts::STATUS_PASSED;
        $modelAnswer->hits = mt_rand(100, 10000);
        $modelAnswer->content = $articleInfo['content'];

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Questions'])) {
            $now = zmf::now();
            $tags = isset($_POST['tags']) ? array_unique(array_filter($_POST['tags'])) : array();
            if (isset($_POST['Questions']['cTime']) && $_POST['Questions']['cTime'] != '') {
                $_POST['Questions']['cTime'] = strtotime($_POST['Questions']['cTime'], $now);
            } else {
                $_POST['Questions']['cTime'] = $now;
            }
            $filterContent = Posts::handleContent($_POST['Questions']['content'], TRUE, '<p><img><br><h1><h2><h3><h4><h5><h6>');
            $_POST['Questions']['content'] = $filterContent['content'];
            if (!$_POST['Questions']['faceUrl']) {
                $_POST['Questions']['faceUrl'] = !empty($filterContent['attachids']) ? $filterContent['attachids'][0] : '';
            }
            $model->attributes = $_POST['Questions'];
            //回答
            if (isset($_POST['Answers']['cTime']) && $_POST['Answers']['cTime'] != '') {
                $_POST['Answers']['cTime'] = strtotime($_POST['Answers']['cTime'], $now);
            } else {
                $_POST['Answers']['cTime'] = $now;
            }
            $filterContent = Posts::handleContent($_POST['Answers']['content'], TRUE, '<p><b><strong><img><br><h1><h2><h3><h4><h5><h6>');
            $_POST['Answers']['content'] = $filterContent['content'];
            if ($model->save()) {
                $_POST['Answers']['qid'] = $model->id;
                $_POST['Answers']['uid'] = Answers::getRandUser($model->id);
                $realTags = array();
                //自动获取文章标签
                //todo
                //$tags[] = 264;
                $tags = array_unique($tags);
                if (!empty($tags)) {
                    foreach ($tags as $_tagid) {
                        $_tgAttr = array(
                            'logid' => $model->id,
                            'tagid' => $_tagid,
                            'classify' => Column::CLASSIFY_QUESTION
                        );
                        if (TagRelation::addRelation($_tgAttr)) {
                            $realTags[] = $_tagid;
                        }
                    }
                }
                $realTags = array_unique(array_filter($realTags));
                $_postTagids = join(',', $realTags);
                Questions::model()->updateByPk($model->id, array('tagids' => $_postTagids));
                //更新路径
                Questions::updateUrlPrefix($model->id);
                //保存回答
                $modelAnswer->attributes = $_POST['Answers'];
                if ($modelAnswer->save()) {
                    Questions::updateStatAnswers($model->id);
                }
                AdminLogs::addLog(array(
                    'logid' => $model->id,
                    'classify' => 'question',
                    'content' => '从文章导入问题',
                ));
                $articleInfo->updateByPk($articleInfo['id'], array('status' => Posts::STATUS_DELED), 'status!=' . Posts::STATUS_PASSED);
                $this->redirect(array('index', 'id' => $model->id));
            }
        }
        $contentImgs = [];
        $this->render('createFromArticle', array(
            'model' => $model,
            'modelAnswer' => $modelAnswer,
            'tags' => $tags,
            'contentImgs' => $contentImgs,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $this->actionCreate($id);
    }

    /**
     * 根据标题采集
     * @param int $id
     */
    public function actionByTitle($id) {
        $info = $this->loadModel($id);
        $_title = zmf::val('title', 1);
        $title = $_title != '' ? $_title : $info['title'];
        $urls = $articles = [];
        if ($title != '') {
            $now = zmf::now();
            //采集标题
            $_page = zmf::val('page', 2);
            $page = $_page > 1 ? $_page : 1;
            for ($i = 0; $i < $page; ++$i) {
                $url = "http://wenda.so.com/search/?q={$title}&pn=" . $i;
                Yii::import('application.vendors.Curl.*');
                require_once 'Curl.php';
                $res = new Curl();
                $html = $res->get($url);
                preg_match_all('/<h3>(.*?)<\/h3>/si', $html, $matches);
                foreach ($matches[1] as $value) {
                    preg_match('/href="(.*?)"/si', $value, $_url);
                    $_arr = array(
                        'title' => trim(strip_tags($value)),
                        'url' => 'http://wenda.so.com' . $_url[1],
                        'type' => '360',
                        'time' => $info['cTime'] + mt_rand(-48, 0) * 3600,
                        'uid' => Users::getRandomId(),
                    );
                    $urls[] = $_arr;
                }
                $url = "http://wenwen.sogou.com/s/?w={$title}&pg=" . $i;
                $html = zmf::curlSogouWenwen($url);
                preg_match_all('/<h3\s+class="result-title sIt_title".*?[^>]>(.*?)<\/h3>/si', $html, $matches);
                foreach ($matches[1] as $value) {
                    preg_match('/href="(.*?)"/si', $value, $_url);
                    $_arr = array(
                        'title' => trim(strip_tags($value)),
                        'url' => 'http://wenwen.sogou.com' . $_url[1],
                        'type' => 'sogou',
                        'time' => $info['cTime'] + mt_rand(-48, 0) * 3600,
                        'uid' => Users::getRandomId(),
                    );
                    $urls[] = $_arr;
                }
            }
        }
        $data = array(
            'urls' => $urls,
            'articles' => $articles,
            'title' => $title,
            'info' => $info,
        );
        $this->render('byTitle', $data);
    }

    public function actionMultiReply($id) {
        $info = $this->loadModel($id);
        $tags = array_values(CHtml::listData(TagRelation::model()->findAll('logid=:logid AND classify="question"', array(
                            ':logid' => $id
                        )), 'id', 'tagid'));
        $posts = $_POST;
        $ptitles = $posts['ptitle'];
        $bestId = 0;
        $maxLen = 0;
        $info['cTime']=$info['cTime']>0 ? $info['cTime'] : zmf::now();
        foreach ($ptitles as $key => $_title) {
            $_time = $info['cTime'] + mt_rand(1, 100) * 600;
            $_content = $posts['pcontent'][$key];
            $attr = array(
                'uid' => $posts['puid'][$key],
                'createUid' => $this->uid,
                'qid' => $id,
                'content' => $_content,
                'platform' => Posts::PLATFORM_WEB,
                'status' => Posts::STATUS_PASSED,
                'hits' => mt_rand(80, 300),
                'cTime' => $_time,
                'updateTime' => $_time
            );
            $modelPost = new Answers;
            $modelPost->attributes = $attr;
            if ($modelPost->save()) {
                $_content = zmf::filterMark($_content);
                if (mb_strlen($_content) > $maxLen) {
                    $maxLen = mb_strlen($_content);
                    $bestId = $modelPost->id;
                }
                //自动加标签
                Tags::addContentLinks(array(
                    'title' => $info->title,
                    'content' => $posts['pcontent'][$key]
                        ), Column::CLASSIFY_QUESTION, $info->id, false);
                AdminLogs::addLog(array(
                    'logid' => $modelPost->id,
                    'classify' => 'answer',
                    'content' => '批量导入回答',
                ));
                $_info = Questions::findByTitle($_title);
                if (!$_info) {
                    $_attr = array(
                        'uid' => Answers::getRandUser(0),
                        'createUid' => $this->uid,
                        'typeId' => $info['typeId'],
                        'areaId' => $info['areaId'],
                        'title' => $_title,
                        'cTime' => zmf::now(),
                        'hits' => mt_rand(100,10000),
                        'updateTime' => zmf::now(),
                        'status' => Posts::STATUS_STAYCHECK,
                    );
                    $_model = new Questions;
                    $_model->attributes = $_attr;
                    if ($_model->save()) {
                        if (!empty($tags)) {
                            foreach ($tags as $_tagid) {
                                $_tgAttr = array(
                                    'logid' => $_model->id,
                                    'tagid' => $_tagid,
                                    'classify' => Column::CLASSIFY_QUESTION
                                );
                                if (TagRelation::addRelation($_tgAttr)) {
                                    $realTags[] = $_tagid;
                                }
                            }
                        }
                        $realTags = array_unique(array_filter($realTags));
                        $_postTagids = join(',', $realTags);
                        Questions::model()->updateByPk($_model->id, array('tagids' => $_postTagids));
                        //更新路径
                        Questions::updateUrlPrefix($_model->id);
                    }
                }
            }
        }
        if ($bestId && !$info['bestAid']) {
            Answers::model()->updateAll(array('isBest'=>0),'qid='.$info['id']);
            Answers::model()->updateByPk($bestId, array(
                'isBest' => 1
            ));
            Questions::model()->updateByPk($info->id, array(
                'bestAid' => $bestId,
                'status' => Posts::STATUS_PASSED,
                'createUid' => $info->createUid ? $info->createUid : $this->uid
            ));
        }
        Questions::updateStatAnswers($info->id);
        Questions::updateUrlPrefix($info->id);
        $this->redirect(array('answers/index', 'qid' => $info->id));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->checkPower('delQuestions');
        $type = zmf::val('type', 1);
        if (!in_array($type, array('del', 'pass'))) {
            throw new CHttpException(404, '参数有误');
        }
        $info = $this->loadModel($id);
        if ($info['status'] == Posts::STATUS_PASSED && $type == 'del') {
            $this->jsonOutPut(0, '已通过内容不能删除');
        }
        $attr=[];
        switch ($type) {
            case 'del':
                $attr=array(
                    'status'=>Posts::STATUS_DELED
                );
                break;
            case 'pass':
                $attr=array(
                    'status'=>Posts::STATUS_PASSED,
                    'createUid'=>$info->createUid>0 ? $info->createUid : $this->uid,
                    'cTime'=>$info->cTime>0 ? $info->cTime : zmf::now(),
                    'updateTime'=>zmf::now(),
                );
                break;
            default:
                $attr=array(
                    'status'=>Posts::STATUS_DELED
                );
                break;
        }
        $info->updateByPk($id, $attr);
        Questions::updateUrlPrefix($info['id']);
        Questions::updateStatAnswers($id);
        if ($type == 'del') {
            AdminLogs::addLog(array(
                'logid' => $id,
                'classify' => 'question',
                'content' => '删除问题',
            ));
        } else {
            AdminLogs::addLog(array(
                'logid' => $id,
                'classify' => 'question',
                'content' => '通过问题',
            ));
        }
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if ($this->isAjax) {
            $this->jsonOutPut(1, '已删除');
        } else {
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    public function actionRealDel($id) {
        $info = $this->loadModel($id)->delete();
        Answers::model()->deleteAll('qid=:qid', array(
            ':qid' => $id
        ));
        if ($this->isAjax) {
            $this->jsonOutPut(1, '已删除');
        } else {
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    public function actionLinkTags() {
        $_page = zmf::val('page', 2);
        $page = $_page < 1 ? 1 : $_page;
        $limit = 100;
        $start = ($page - 1) * $limit;
        $sql = "select id,title,`description`,content from {{questions}} ORDER BY id ASC LIMIT $start,$limit";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($items)) {
            $this->redirect(array('index'));
        }
        $tags = Tags::model()->findAll(array(
            'select'=>'id,title,nickname'
        ));
        $_tagArr=[];
        foreach ($tags as $tag) {
            $_tagArrTemp = array_filter(explode(',', $tag['nickname']));
            $_tagArrTemp[] = $tag['title'];
            $_tagArrTemp=array_unique($_tagArrTemp);
            foreach ($_tagArrTemp as $_title){
                $_tagArr[]=array(
                    'id'=>$tag['id'],
                    'title'=>$_title
                );
            }
        }
        foreach ($items as $item) {
            $_content=$item['title'].$item['description'].$item['content'];
            $_tags = [];
            foreach ($_tagArr as $_tag) {
                if (strpos($_content, $_tag['title']) !== false) {
                    $_tags[] = $_tag;
                }
            }
            if(!empty($_tags)){
                foreach($_tags as $_tag){
                    $_attr = array(
                        'logid' => $item['id'],
                        'classify' => Column::CLASSIFY_QUESTION,
                        'tagid' => $_tag['id'],
                    );
                    $_info = TagRelation::model()->findByAttributes($_attr);
                    if (!$_info) {
                        $_model = new TagRelation;
                        $_model->attributes = $_attr;
                        $_model->save();
                    }
                }
            }
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/questions/linkTags',array('page'=>$page+1)), 0);
    }

    public function actionUpdateUrl() {
        $_page = zmf::val('page', 2);
        $page = $_page < 1 ? 1 : $_page;
        $limit = 100;
        $start = ($page - 1) * $limit;
        $sql = "select id from " . Questions::tableName() . " ORDER BY id ASC LIMIT $start,$limit";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($items)) {
            $this->redirect(array('index'));
        }
        foreach ($items as $item) {
            Questions::updateUrlPrefix($item['id']);
            Questions::updateStatAnswers($item['id']);
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/questions/updateUrl', array('page' => ($page + 1))), 1);
    }

    public function actionSearch(){
        if (Yii::app()->request->isAjaxRequest && isset($_GET['q'])) {
            $name = trim(zmf::val('q', 1));
            $name = '%' . strtr($name, array('%' => '\%', '_' => '\_', '\\' => '\\\\')) . '%';
            $sql = "SELECT id,title FROM {{questions}} WHERE (title LIKE '$name') AND status=1 LIMIT 10";
            $items = Yii::app()->db->createCommand($sql)->queryAll();
            $returnVal = '';
            foreach ($items as $val) {
                $returnVal .= $val['title'] . '|' . $val['id'] .  "\n";
            }
            echo $returnVal;
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Questions('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Questions']))
            $model->attributes = $_GET['Questions'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Questions the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Questions::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Questions $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'questions-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
