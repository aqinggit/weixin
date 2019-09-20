<?php
/**
 * @filename QuestionsLogController.php
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2019 阿年飞少
 * @datetime 2019-09-09 00:00:30
 */

class QuestionsLogController extends Admin
{

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        //$this->checkPower('questionslog');
        $select = "id,cTime,status,phone,questions,answers,ip,socre";
        $model = new QuestionsLog;
        $criteria = new CDbCriteria();
        $phone = zmf::val("phone", 1);
        if ($phone) {
            $criteria->addSearchCondition("phone", $phone);
        }

        $socre = zmf::val("socre", 1);
        if ($socre) {
            $criteria->addSearchCondition("socre", $socre);
        }

        $startTime = zmf::val("startTime", 3);
        if ($startTime) {
            $_startTIme = strtotime($startTime);
            $criteria->addCondition("cTime >= {$_startTIme}");
        }

        $endTime = zmf::val("endTime", 3);
        if ($endTime) {
            $_endTime = strtotime($endTime) + 86400 - 1;
            $criteria->addCondition("cTime <= {$_endTime}");
        }

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
            //$this->checkPower('updateQuestionsLog');
            $model = $this->loadModel($id);
        } else {
            //$this->checkPower('addQuestionsLog');
            $model = new QuestionsLog;
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['QuestionsLog'])) {
            $model->attributes = $_POST['QuestionsLog'];
            if ($model->save()) {
                if (!$id) {
                    Yii::app()->user->setFlash('addQuestionsLogSuccess', "保存成功！您可以继续添加。");
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
        //$this->checkPower('delQuestionsLog');
        $this->loadModel($id)->updateByPk($id, array('status' => Posts::STATUS_DELED));

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
        $model = new QuestionsLog('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['QuestionsLog']))
            $model->attributes = $_GET['QuestionsLog'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return QuestionsLog the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = QuestionsLog::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param QuestionsLog $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'questions-log-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
