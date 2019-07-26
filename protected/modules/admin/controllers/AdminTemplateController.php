<?php

/**
 * @filename AdminTemplateController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-05-25 03:09:04 */
class AdminTemplateController extends Admin {
    public function init() {
        parent::init();
        $this->checkPower('adminTemplate');
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
            $model->powers= explode(',', $model->powers);
        } else {
            $model = new AdminTemplate;
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['AdminTemplate'])) {
            if(!empty($_POST['AdminTemplate']['powers'])){
                $_POST['AdminTemplate']['powers']= join(',', array_unique(array_filter($_POST['AdminTemplate']['powers'])));
            }else{
                $_POST['AdminTemplate']['powers']='';
            }
            $model->attributes = $_POST['AdminTemplate'];
            if ($model->save()) {
                if (!$id) {
                    Yii::app()->user->setFlash('addAdminTemplateSuccess', "保存成功！您可以继续添加。");
                    $this->redirect(array('create'));
                } else {
                    //清空管理组成员的权限
                    $users= Users::model()->findAll(array(
                        'condition'=>'powerGroupId='.$model->id,
                        'select'=>'id'
                    ));
                    foreach($users as $user){
                        $key = 'adminPowers' . $user['id'];
                        zmf::delFCache($key);
                    }
                    $this->redirect(array('index'));
                }
            }
        }
        $powers= Admins::getDesc('admin');
        $this->render('create', array(
            'model' => $model,
            'powers' => $powers,
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
        $this->loadModel($id)->delete();

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
        $select = "id,title";
        $model = new AdminTemplate;
        $criteria = new CDbCriteria();
        $id = zmf::val("id", 1);
        if ($id) {
            $criteria->addSearchCondition("id", $id);
        }
        $title = zmf::val("title", 1);
        if ($title) {
            $criteria->addSearchCondition("title", $title);
        }
        $powers = zmf::val("powers", 1);
        if ($powers) {
            $criteria->addSearchCondition("powers", $powers);
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
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new AdminTemplate('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['AdminTemplate']))
            $model->attributes = $_GET['AdminTemplate'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return AdminTemplate the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = AdminTemplate::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param AdminTemplate $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'admin-template-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
