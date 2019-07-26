<?php

/**
 * @filename SearchRecordsController.php
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2017 阿年飞少
 * @datetime 2017-08-04 08:16:05 */
class SearchRecordsController extends Admin {

    public function init() {
        parent::init();
        $this->checkPower('searchRecords');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $select = "id,title,updateTime,times,status,hash";
        $model = new SearchRecords;
        $criteria = new CDbCriteria();        
        $title = zmf::val("title", 1);
        if ($title) {
            $criteria->addSearchCondition("title", $title);
        }
        $hash = zmf::val("hash", 1);
        if ($hash) {
            $criteria->addSearchCondition("hash", $hash);
        }
        $criteria->select = $select;
        $criteria->order = 'updateTime DESC';
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
            $this->checkPower('updateSearchRecords');
            $model = $this->loadModel($id);
        } else {
            $model = new SearchRecords;
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['SearchRecords'])) {
            $model->attributes = $_POST['SearchRecords'];
            if ($model->save()) {
                if (!$id) {
                    Yii::app()->user->setFlash('addSearchRecordsSuccess', "保存成功！您可以继续添加。");
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
    public function actionUpdate($id) {
        $this->actionCreate($id);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->checkPower('delSearchRecords');
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if ($this->isAjax) {
            $this->jsonOutPut(1, '已删除');
        } else {
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
    
    public function actionSetStatus($id) {
        $info = $this->loadModel($id);
        $type = zmf::val('type', 1);
        if (!in_array($type, array('del', 'pass'))) {
            throw new CHttpException(404, '参数有误');
        }
        switch ($type) {
            case 'del':
                $status = Posts::STATUS_NOTPASSED;
                break;
            case 'pass':
                $status = Posts::STATUS_PASSED;
                break;
            default:
                $status = Posts::STATUS_NOTPASSED;
                break;
        }
        $info->updateByPk($id, array('status' => $status));
        if ($this->isAjax) {
            $this->jsonOutPut(1, '已标记');
        } else {
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new SearchRecords('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SearchRecords']))
            $model->attributes = $_GET['SearchRecords'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SearchRecords the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = SearchRecords::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param SearchRecords $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'search-records-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
