<?php
/**
 * @filename VolunteerActiveController.php
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2019 阿年飞少
 * @datetime 2019-08-07 09:24:37
 */

class VolunteerActiveController extends Admin
{

    public function init()
    {
        $this->checkPower('ActiveBindVolunteer');
        parent::init(); // TODO: Change the autogenerated stub
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        //$this->checkPower('volunteeractive');
        $select = "id,vid,aid,score,cTime,status";
        $model = new VolunteerActive;
        $criteria = new CDbCriteria();
        $id = zmf::val("id", 1);
        if ($id) {
            $criteria->addSearchCondition("id", $id);
        }
        $vid = zmf::val("vid", 1);
        if ($vid) {
            $criteria->addSearchCondition("vid", $vid);
        }
        $aid = zmf::val("aid", 1);
        if ($aid) {
            $criteria->addSearchCondition("aid", $aid);
        }
        $score = zmf::val("score", 1);
        if ($score) {
            $criteria->addSearchCondition("score", $score);
        }
        $cTime = zmf::val("cTime", 1);
        if ($cTime) {
            $criteria->addSearchCondition("cTime", $cTime);
        }
        $status = zmf::val("status", 1);
        if ($status) {
            $criteria->addSearchCondition("status", $status);
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
            //$this->checkPower('updateVolunteerActive');
            $model = $this->loadModel($id);
        } else {
            //$this->checkPower('addVolunteerActive');
            $model = new VolunteerActive;
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['VolunteerActive'])) {
            $model->attributes = $_POST['VolunteerActive'];
            if ($model->save()) {
                if (!$id) {
                    Yii::app()->user->setFlash('addVolunteerActiveSuccess', "保存成功！您可以继续添加。");
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
        //$this->checkPower('delVolunteerActive');
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
        $model = new VolunteerActive('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['VolunteerActive']))
            $model->attributes = $_GET['VolunteerActive'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return VolunteerActive the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = VolunteerActive::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param VolunteerActive $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'volunteer-active-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }


    public function actionPass($id)
    {
        //$this->checkPower('delVolunteers');
        $this->loadModel($id)->updateByPk($id, array('status' => Users::STATUS_PASSED));

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if ($this->isAjax) {
            $this->jsonOutPut(1, '已通过');
        } else {
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }


}