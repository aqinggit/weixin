<?php

/**
 * @filename PostsController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2016 阿年飞少 
 * @datetime 2016-11-04 11:02:05 */
class PostsController extends Admin {

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $return = Posts::detail($id, $this->userInfo, true, 'c800');
        $info = $return['info'];
        $this->render('view', array(
            'info' => $info,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($id = '') {
        if ($id) {
            //$this->checkPower('updatePosts');
            $model = $this->loadModel($id);
            $this->pageTitle = '案例编辑 - [' . $model->title . ']';
        } else {
            //$this->checkPower('addPosts');
            $model = new Posts;
            $model->hits = mt_rand(100, 999);
            $model->order = zmf::now();
            $this->pageTitle = '新增案例';
        }
        $now=zmf::now();
        if (isset($_POST['Posts'])) {
            $tags = isset($_POST['tags']) ? array_unique(array_filter($_POST['tags'])) : array();
            //处理文本
            $filterTitle = Posts::handleContent($_POST['Posts']['title'], FALSE);
            $filterContent = Posts::handleContent($_POST['Posts']['content']);
            $attr = $_POST['Posts'];
            $attr['title'] = $filterTitle['content'];
            $attr['content'] = $filterContent['content'];
            $attr['imgs'] = count($filterContent['attachids']);
            $attkeys = array();
            //如果没有上传封面图
            if (!$attr['faceImg'] && !empty($filterContent['attachids'])) {
                $attkeys = array_filter(array_unique($filterContent['attachids']));
                if (!empty($attkeys)) {
                    $attr['faceUrl'] = Attachments::faceImg($attkeys[0], ''); //默认将文章中的第一张图作为封面图
                    $attr['faceImg'] = $attkeys[0];
                }
            } elseif ($attr['faceImg']) {
                $attr['faceUrl'] = Attachments::faceImg($attr['faceImg'], ''); //默认将文章中的第一张图作为封面图
            }
            if ($attr['cTime']) {
                $attr['cTime'] = strtotime($attr['cTime'], $now);
            }
            $model->attributes = $attr;
            if ($model->save()) {
                //保存标签
                $tags = array_unique($tags);
                if (!empty($tags)) {
                    foreach ($tags as $_tagid) {
                        $_tgAttr = array(
                            'logid' => $model->id,
                            'tagid' => $_tagid,
                            'classify' => Column::CLASSIFY_CASE
                        );
                        if (TagRelation::addRelation($_tgAttr)) {
                            $realTags[] = $_tagid;
                        }
                        //将标签绑定到图片上
                        if (!empty($filterContent['attachids'])) {
                            foreach ($filterContent['attachids'] as $_imgid) {
                                $_attr = array(
                                    'logid' => $_imgid,
                                    'tagid' => $_tagid,
                                    'classify' => Column::CLASSIFY_IMAGE
                                );
                                TagRelation::addRelation($_attr);
                            }
                        }
                    }
                }
                //将上传的图片置为通过
                Attachments::model()->updateAll(array('status' => Posts::STATUS_DELED), 'logid=:logid AND classify=:classify', array(':logid' => $model->id, ':classify' => Column::CLASSIFY_CASE));
                if (!empty($attkeys)) {
                    $attstr = join(',', $attkeys);
                    $attstr= zmf::filterIds($attstr);
                    if ($attstr != '') {
                        Attachments::model()->updateAll(array('status' => Posts::STATUS_PASSED, 'logid' => $model->id), 'id IN(' . $attstr . ')');
                    }
                }
                //自动加标签
                Tags::addContentLinks(array(
                    'title' => $model->title,
                    'content' => $model->content
                ), Column::CLASSIFY_CASE, $model->id, false);
                $realTags = array_unique(array_filter($realTags));
                $_postTagids = join(',', $realTags);
                $model->updateByPk($model->id, array('tagids' => $_postTagids));

                //更新路径
                Posts::updateUrlPrefix($model->id);

                if (!$id) {
                    AdminLogs::addLog(array(
                        'logid' => $model->id,
                        'classify' => 'post',
                        'content' => '新增案例',
                    ));
                } else {
                    $_info = AdminLogs::addLog(array(
                        'logid' => $model->id,
                        'classify' => 'post',
                        'content' => '更新案例',
                    ));
                }
                $this->redirect(array('index', 'id' => $model->id));
            }
        }
        $contentImgs = $weixinImgs = [];
        if ($id) {
            preg_match_all("/\[attach\](\d+)\[\/attach\]/i", $model['content'], $match);
            $imgIds = join(',', array_unique(array_filter($match[1])));
            if ($imgIds != '') {
                $_sql = 'SELECT id,remote,fileDesc FROM {{attachments}} WHERE id IN(' . $imgIds . ')';
                $contentImgs = Yii::app()->db->createCommand($_sql)->queryAll();
                foreach ($contentImgs as $key => $value) {
                    $contentImgs[$key]['remote'] = zmf::getThumbnailUrl($value['remote'], 'a120');
                }
            }

            $model['content'] = str_replace(array(
                '[wximg]</p>',
                '[wximg]</h1>',
                '[wximg]</strong>',
            ), array(
                '[/wximg]</p>',
                '[/wximg]</h1>',
                '[/wximg]</strong>',
            ), $model['content']);
            preg_match_all("/\[wximg\](.*?)\[\/wximg\]/si", $model['content'], $match);
            foreach ($match[1] as $k => $url) {
                $weixinImgs[] = $url;
                $model['content'] = str_replace($match[0][$k], '<p>图片' . ($k + 1) . '</p>', $model['content']);
            }
            $model->content = zmf::text(array('action' => 'edit'), $model['content'], false, 'c650.jpg');
        }
        $this->render('create', array(
            'model' => $model,
            'contentImgs' => $contentImgs,
            'weixinImgs' => $weixinImgs,
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
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        //$this->checkPower('delPosts');
        $this->loadModel($id)->updateByPk($id, array('status' => Posts::STATUS_DELED));
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if ($this->isAjax) {
            $this->jsonOutPut(1, '已删除');
        } else {
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //$this->checkPower('posts');
        $select = "id,uid,areaId,title,`top`,urlPrefix,hits,cTime,updateTime";
        $model = new Posts;
        $criteria = new CDbCriteria();
        $title = zmf::val("title", 1);
        if ($title) {
            $criteria->addSearchCondition('title', $title);
        }
        $criteria->addCondition('status=' . Posts::STATUS_PASSED);
        $criteria->order = '`order` DESC';
        $criteria->select = $select;
        $count = $model->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 30;
        $pager->applyLimit($criteria);
        $posts = $model->findAll($criteria);
        $this->render('index', array(
            'pages' => $pager,
            'posts' => $posts,
            'model' => $model
        ));
    }

    public function actionAll() {
        $this->checkPower('posts');
        $model = new Posts;
        $tagids = zmf::val('tagid', 1);
        $tagids = array_unique(array_filter(explode(',', $tagids)));
        $_limitIdsArr = $selectedTagsArr = array();
        if (!empty($tagids)) {
            foreach ($tagids as $k => $_tagid) {
                if ($k > 0 && empty($_limitIdsArr)) {
                    break;
                }
                if ($k == 0) {
                    $_sql = 'SELECT a.id,a.uid FROM {{attachments}} a,{{tag_relation}} tr WHERE tr.tagid="' . $_tagid . '" AND tr.classify="posts" AND tr.logid=a.id';
                    $_items = Yii::app()->db->createCommand($_sql)->queryAll();
                    $_limitIdsArr = array_keys(CHtml::listData($_items, 'id', 'uid'));
                } else {
                    $_limitIds = join(',', $_limitIdsArr);
                    if (!$_limitIds) {
                        $_limitIdsArr = array();
                        break;
                    }
                    $_sql = 'SELECT a.id,a.uid FROM {{attachments}} a,{{tag_relation}} tr WHERE tr.tagid="' . $_tagid . '" AND tr.classify="posts" AND tr.logid IN(' . $_limitIds . ') AND tr.logid=a.id';
                    $_items = Yii::app()->db->createCommand($_sql)->queryAll();
                    $_limitIdsArr = array_keys(CHtml::listData($_items, 'id', 'uid'));
                }
            }
            $idsStr = join(',', $_limitIdsArr);
            if ($idsStr != '') {
                $sql = "SELECT p.id,p.uid,p.imgs,p.title,p.faceUrl,p.tagids,p.areaId,p.cTime FROM {{posts}} p,{{tag_relation}} tr WHERE p.classify=" . Posts::CLASSIFY_MATERIAL . " AND p.id IN({$idsStr}) AND tr.classify='posts' AND tr.logid=p.id AND p.status=1 GROUP BY p.id ORDER BY p.cTime DESC";
            } else {
                $sql = '';
            }
            $_sql2 = 'SELECT id,title FROM {{tags}} WHERE id IN(' . (join(',', $tagids)) . ')';
            $selectedTagsArr = Yii::app()->db->createCommand($_sql2)->queryAll();
        } else {
            $sql = "SELECT id,uid,imgs,title,faceUrl,tagids,areaId,cTime FROM {{posts}} WHERE classify=" . Posts::CLASSIFY_MATERIAL . " AND status=1 ORDER BY cTime DESC";
        }
        $pageInfo = Posts::getAll(array(
                    'sql' => $sql
        ));
        $posts = $pageInfo['posts'];
        $tags = Tags::getAll();
        $this->render('sucai', array(
            'pages' => $pageInfo['pages'],
            'posts' => $posts,
            'model' => $model,
            'tags' => $tags,
            'selectedTags' => $tagids,
            'selectedTagsArr' => $selectedTagsArr,
        ));
    }

    public function actionOrder() {
        $type = zmf::val('type', 1);
        if (!in_array($type, array('all'))) {
            $type = 'all';
        }
        switch ($type) {
            case 'all':
                $posts = Posts::model()->findAll(array(
                    'condition' => 'status=1',
                    'order' => '`order` DESC'
                ));
                break;
            default:
                break;
        }
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
        $type = zmf::val('type', 1);
        if (!$type) {
            $this->jsonOutPut(0, '缺少参数');
        }
        $arr = array_filter(explode('#', $ids));
        if (empty($arr)) {
            $this->jsonOutPut(0, '操作对象不能为空');
        }
        $s = $e = 0;
        if ($type == 'all') {
            $field = 'order';
        } else {
            $field = 'order';
        }
        $now = zmf::now();
        foreach ($arr as $k => $v) {
            $_order = $now - ($k + 1) * 1000;
            $data = array(
                $field => $_order
            );
            $_info = Posts::model()->updateByPk($v, $data);
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

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Posts('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Posts']))
            $model->attributes = $_GET['Posts'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionSetStatus($id) {
        $type = zmf::val('type', 1);
        if (!in_array($type, array('digest', 'top'))) {
            throw new CHttpException(403, '不允许的分类');
        }
        $now = zmf::now();
        if ($type == 'digest') {
            $field = 'digestTime';
        } else {
            $field = 'top';
        }
        $this->loadModel($id)->updateByPk($id, array($field => $now));
        if ($this->isAjax) {
            $this->jsonOutPut(1, '已删除');
        } else {
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Posts the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Posts::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Posts $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'posts-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    //批量修改老案例数据的方法
        public function actionDetail(){
        $_page = zmf::val('page', 2);
        $page = $_page < 1 ? 1 : $_page;
        $limit = 30;
        $start = ($page - 1) * $limit;
        $sql = "select * from {{posts}} ORDER BY id ASC LIMIT $start,$limit";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($items)) {
            echo '没有了';exit;
        }
        $posts = new Posts();
        foreach ($items as $item){
            if(strpos($item['content'],'[video]')){
                $cont = $item['content'];
                preg_match_all("/\[video\](\d+)\[\/video\]/i", $cont, $match);
                $videoId = $match[1][0];
                $str = "[video]{$videoId}[/video]";
                $arr['content'] = str_replace($str,"",$cont);
                $arr['videoId'] = $videoId;
               $posts->updateByPk($item['id'],$arr);
            }
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('/zmf/posts/Detail', array('page' => ($page + 1))),1);
    }

}
