<?php
/**
 * @filename ActivityController.php
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2019 阿年飞少
 * @datetime 2019-08-01 22:50:41
 */

class ActivityController extends Admin
{

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        //$this->checkPower('activity');
        $select = "id,title,content,cTime,status,startTime,place,uid,score,faceImg";
        $model = new Activity;
        $criteria = new CDbCriteria();
        $title = zmf::val("title", 1);
        if ($title) {
            $criteria->addSearchCondition("title", $title);
        }
        $uid = zmf::val("uid", 1);
        if ($uid) {
            $criteria->addSearchCondition("uid", $uid);
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
            //$this->checkPower('updateActivity');
            $model = $this->loadModel($id);
        } else {
            //$this->checkPower('addActivity');
            $model = new Activity;
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Activity'])) {
            $data = $_POST['Activity'];
            if ($data['startTime']) {
                $data['startTime'] = strtotime($data['startTime']);
            } else {
                $data['startTime'] = $model->startTime;
            }
            if ($data['endTime']) {
                $data['endTime'] = strtotime($data['endTime']);
            } else {
                $data['endTime'] = $model->endTime;
            }

            $model->attributes = $data;

            if ($model->save()) {
                if (!$id) {
                    Yii::app()->user->setFlash('addActivitySuccess', "保存成功！您可以继续添加。");
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
        //$this->checkPower('delActivity');
        $this->loadModel($id)->updateByPk($id, array('status' => Activity::DEL));

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if ($this->isAjax) {
            $this->jsonOutPut(1, '已删除');
        } else {
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    public function actionPass($id)
    {
        //$this->checkPower('delActivity');
        $this->loadModel($id)->updateByPk($id, array('status' => Activity::PASS));

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if ($this->isAjax) {
            $this->jsonOutPut(1, '已通过');
        } else {
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    public function actionRecruit($id)
    {
        //$this->checkPower('delActivity');
        $this->loadModel($id)->updateByPk($id, array('status' => Activity::Recruit));

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if ($this->isAjax) {
            $this->jsonOutPut(1, '已开始招募');
        } else {
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }


    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Activity('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Activity']))
            $model->attributes = $_GET['Activity'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Activity the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Activity::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Activity $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'activity-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
