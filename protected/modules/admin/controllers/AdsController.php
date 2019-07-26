<?php

/**
 * @filename AdsController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2016 阿年飞少 
 * @datetime 2016-07-25 04:22:45 */
class AdsController extends Admin {
    
    public function init() {
        parent::init();
        $this->checkPower('ads');
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
            $this->checkPower('updateAds');
            $model = $this->loadModel($id);
        } else {
            $model = new Ads;
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Ads'])) {
            $now=  zmf::now();
            if (isset($_POST['Ads']['startTime'])) {
                $_POST['Ads']['startTime'] = strtotime($_POST['Ads']['startTime'],$now);
            }
            if (isset($_POST['Ads']['expiredTime'])) {
                $_POST['Ads']['expiredTime'] = strtotime($_POST['Ads']['expiredTime'],$now);
            }            
            if($_POST['Ads']['faceimg']){
                $_POST['Ads']['faceUrl'] = Attachments::faceImg($_POST['Ads']['faceimg'],''); 
            }
            $model->attributes = $_POST['Ads'];
            if ($model->save()) {
                if (!$id) {
                    Yii::app()->user->setFlash('addAdsSuccess', "保存成功！您可以继续添加。");
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
        $this->checkPower('delAds');
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $select = "id,title,url,startTime,expiredTime,position,platform,status";
        $model = new Ads();
        $criteria = new CDbCriteria();
        $criteria->select = $select;
        $criteria->addCondition('status!='.Posts::STATUS_DELED);
        $count = $model->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 30;
        $pager->applyLimit($criteria);
        $posts = $model->findAll($criteria);
        $this->render('index', array(
            'model' => $model,
            'pages' => $pager,
            'posts' => $posts,
            'selectArr' => explode(',', $select),
        ));
    }
    
    public function actionClose($id) {
        $status=  zmf::val('status',2);
        $this->loadModel($id)->updateByPk($id, array('status'=>$status));

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Ads('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Ads']))
            $model->attributes = $_GET['Ads'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Ads the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Ads::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Ads $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'ads-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
