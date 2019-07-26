<?php

/**
 * @filename AnswersController.php
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2017 阿年飞少
 * @datetime 2017-09-27 08:15:35 */
class AnswersController extends Admin {
    public function init() {
        parent::init();
        $this->checkPower('answers');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $select = "id,uid,qid,content,favors,platform,status,isBest,hits,comments,cTime,updateTime";
        $model = new Answers;
        $criteria = new CDbCriteria();
        $id = zmf::val("id", 1);
        if ($id) {
            $criteria->addCondition("id=" . $id);
        }
        $uid = zmf::val("uid", 1);
        if ($uid) {
            $criteria->addCondition("uid=" . $uid);
        }
        $qid = zmf::val("qid", 1);
        if ($qid) {
            $criteria->addCondition("qid=" . $qid);
        }
        $status = zmf::val("status", 1);
        if ($status) {
            $criteria->addCondition("status=" . $status);
        }
        $isBest = zmf::val("isBest", 1);
        if ($isBest) {
            $criteria->addCondition("isBest=" . $isBest);
        }
        $title = zmf::val("content", 1);
        if ($title) {
            $criteria->addSearchCondition("content", $title);
        }
        $criteria->select = $select;
        $criteria->order = 'cTime DESC';
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

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($id = '') {
        if ($id) {
            $model = $this->loadModel($id);
            $model->cTime= zmf::time($model->cTime);
        } else {
            $model = new Answers;
            $qid = zmf::val('qid', 2);
            if (!$qid) {
                throw new CHttpException(404, '请选择问题');
            }
            $model->qid = $qid;
            $model->cTime = zmf::time();
            $model->status = Posts::STATUS_PASSED;
            $model->uid = Answers::getRandUser($qid);
            $model->hits = mt_rand(100, 200);
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Answers'])) {
            $now = zmf::now();
            if (isset($_POST['Answers']['cTime']) && $_POST['Answers']['cTime'] != '') {
                $_POST['Answers']['cTime'] = strtotime($_POST['Answers']['cTime'], $now);
            } else {
                $_POST['Answers']['cTime'] = $now;
            }
            $filterContent = Posts::handleContent($_POST['Answers']['content'], TRUE, '<p><b><strong><img><br><h1><h2><h3><h4><h5><h6>');
            $_POST['Answers']['content'] = $filterContent['content'];
            $model->attributes = $_POST['Answers'];
            if ($model->save()) {
                //自动加标签
                Tags::addContentLinks(array(
                    'title' => '',
                    'content' => $model->content
                        ), 'question', $model->qid, false);
                Questions::updateStatAnswers($model->qid);
                if (!$id) {
                    AdminLogs::addLog(array(
                        'logid' => $model->id,
                        'classify' => 'answer',
                        'content' => '新增回答',
                    ));
                    Yii::app()->user->setFlash('addAnswersSuccess', "保存成功！您可以继续添加。");
                    $this->redirect(array('create', 'qid' => $model->qid));
                } else {
                    AdminLogs::addLog(array(
                        'logid' => $model->id,
                        'classify' => 'answer',
                        'content' => '更新回答',
                    ));
                    $this->redirect(array('index', 'qid' => $model->qid));
                }
            }
        }
        
        $this->render('create', array(
            'model' => $model,
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

    public function actionSetBest($id) {
        $type = zmf::val('type', 1);
        if (!in_array($type, array('do', 'cancel'))) {
            throw new CHttpException(404, '参数有误');
        }
        switch ($type) {
            case 'do':
                $status = 1;
                break;
            case 'cancel':
                $status = 0;
                break;
            default:
                $status = 0;
                break;
        }
        $info = $this->loadModel($id);
        if ($type == 'do') {
            $status = 1;
            //取消其他答案的最佳
            Answers::model()->updateAll(array('isBest' => 0), 'qid=:qid', array(
                ':qid' => $info['qid']
            ));
            $info->updateByPk($id, array('isBest' => $status, 'status' => Posts::STATUS_PASSED));
            Questions::model()->updateByPk($info['qid'], array(
                'bestAid' => $id
            ));
            Questions::updateStatAnswers($info['qid']);
            AdminLogs::addLog(array(
                'logid' => $id,
                'classify' => 'answer',
                'content' => '上架回答',
            ));
        } else {
            $status = 0;
            $info->updateByPk($id, array('isBest' => $status));
            Questions::model()->updateByPk($info['qid'], array(
                'bestAid' => 0
            ));
            AdminLogs::addLog(array(
                'logid' => $id,
                'classify' => 'answer',
                'content' => '下架回答',
            ));
        }
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if ($this->isAjax) {
            $this->jsonOutPut(1, '已删除');
        } else {
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->checkPower('delAnswers');
        $type = zmf::val('type', 1);
        if (!in_array($type, array('del', 'pass'))) {
            throw new CHttpException(404, '参数有误');
        }
        switch ($type) {
            case 'del':
                $status = Posts::STATUS_DELED;
                break;
            case 'pass':
                $status = Posts::STATUS_PASSED;
                break;
            default:
                $status = Posts::STATUS_DELED;
                break;
        }
        $info = $this->loadModel($id);
        $info->updateByPk($id, array('status' => $status));
        Questions::updateStatAnswers($info['qid']);
        if ($type == 'del') {
            AdminLogs::addLog(array(
                'logid' => $id,
                'classify' => 'answer',
                'content' => '删除回答',
            ));
        } else {
            AdminLogs::addLog(array(
                'logid' => $id,
                'classify' => 'answer',
                'content' => '通过回答',
            ));
        }
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if ($this->isAjax) {
            $this->jsonOutPut(1, '已删除');
        } else {
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Answers('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Answers']))
            $model->attributes = $_GET['Answers'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Answers the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Answers::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Answers $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'answers-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
