<?php
/**
 * @filename QuestionsController.php
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2019 阿年飞少
 * @datetime 2019-09-05 09:44:29
 */

class QuestionsController extends Admin
{

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        //$this->checkPower('questions');
        $select = "id,title,content,status,cTime,uid,answers,analysis,score,type";
        $model = new Questions;
        $criteria = new CDbCriteria();
        $id = zmf::val("id", 1);
        if ($id) {
            $criteria->addSearchCondition("id", $id);
        }
        $title = zmf::val("title", 1);
        if ($title) {
            $criteria->addSearchCondition("title", $title);
        }
        $content = zmf::val("content", 1);
        if ($content) {
            $criteria->addSearchCondition("content", $content);
        }
        $status = zmf::val("status", 1);
        if ($status) {
            $criteria->addSearchCondition("status", $status);
        }
        $cTime = zmf::val("cTime", 1);
        if ($cTime) {
            $criteria->addSearchCondition("cTime", $cTime);
        }
        $uid = zmf::val("uid", 1);
        if ($uid) {
            $criteria->addSearchCondition("uid", $uid);
        }
        $answers = zmf::val("answers", 1);
        if ($answers) {
            $criteria->addSearchCondition("answers", $answers);
        }
        $analysis = zmf::val("analysis", 1);
        if ($analysis) {
            $criteria->addSearchCondition("analysis", $analysis);
        }
        $score = zmf::val("score", 1);
        if ($score) {
            $criteria->addSearchCondition("score", $score);
        }
        $type = zmf::val("type", 1);
        if ($type) {
            $criteria->addSearchCondition("type", $type);
        }
        $criteria->addCondition('status != 3');
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

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($id = '')
    {
        if ($id) {
            //$this->checkPower('updateQuestions');
            $model = $this->loadModel($id);
        } else {
            //$this->checkPower('addQuestions');
            $model = new Questions;
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Questions'])) {
            $model->attributes = $_POST['Questions'];
            if ($model->save()) {
                if (!$id) {
                    Yii::app()->user->setFlash('addQuestionsSuccess', "保存成功！您可以继续添加。");
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

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $this->actionCreate($id);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        //$this->checkPower('delQuestions');
        $this->loadModel($id)->updateByPk($id, array('status' => Users::STATUS_DELED));

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
    public function actionAdmin()
    {
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
    public function loadModel($id)
    {
        $model = Questions::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Questions $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'questions-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
