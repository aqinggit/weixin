<?php

/**
 * @filename SearchWordsController.php
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2018 阿年飞少
 * @datetime 2018-02-08 06:26:51 */
class SearchWordsController extends Admin {

    public function init() {
        parent::init();
        $this->checkPower('searchWords');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //$this->checkPower('searchwords');
        $select = "id,title,url,color,position";
        $model = new SearchWords;
        $criteria = new CDbCriteria();
        $title = zmf::val("title", 1);
        if ($title) {
            $criteria->addSearchCondition("title", $title);
        }
        $url = zmf::val("url", 1);
        if ($url) {
            $criteria->addSearchCondition("url", $url);
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
            $this->checkPower('updateSearchWords');
            $model = $this->loadModel($id);
        } else {
            //$this->checkPower('addSearchWords');
            $model = new SearchWords;
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['SearchWords'])) {
            $model->attributes = $_POST['SearchWords'];
            if ($model->save()) {
                if (!$id) {
                    Yii::app()->user->setFlash('addSearchWordsSuccess', "保存成功！您可以继续添加。");
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
        $this->checkPower('delSearchWords');
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
    public function actionAdmin() {
        $model = new SearchWords('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SearchWords']))
            $model->attributes = $_GET['SearchWords'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SearchWords the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = SearchWords::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param SearchWords $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'search-words-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
