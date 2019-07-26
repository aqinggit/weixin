<?php

/**
 * @filename TdkController.php
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2017 阿年飞少
 * @datetime 2017-07-18 07:08:03 */
class TdkController extends Admin {

    public function init() {
        parent::init();
        $this->checkPower('tdk');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $select = "id,uid,title,url,cTime";
        $model = new Tdk;
        $criteria = new CDbCriteria();
        $id = zmf::val("id", 1);
        if ($id) {
            $criteria->addSearchCondition("id", $id);
        }
        $title = zmf::val("title", 1);
        if ($title) {
            $criteria->addSearchCondition("title", $title);
        }
        $url=zmf::val('url',1);
        if($url){
            $hashCode= md5(Tdk::returnHashLink($url));
            $criteria->addSearchCondition("hashCode", $hashCode);
        }
        $criteria->select = $select;
        $criteria->order = 'id DESC';
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
            $this->checkPower('updateTdk');
            $model = $this->loadModel($id);
        } else {
            $model = new Tdk;
            $url = zmf::val('url', 1);
            if ($url) {
                $model->url = $url;
            }
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Tdk'])) {
            if (strpos($_POST['Tdk']['url'],'http://') === false && strpos($_POST['Tdk']['url'],'https://') === false) {
                $_POST['Tdk']['url'] = 'http://' . $_POST['Tdk']['url'];
            }
            $_POST['Tdk']['hashUrl'] = Tdk::returnHashLink($_POST['Tdk']['url']);
            $_POST['Tdk']['hashCode'] = $_POST['Tdk']['hashUrl'] != '' ? md5($_POST['Tdk']['hashUrl']) : '';
            $filterContent = Posts::handleContent($_POST['Tdk']['content']);
            $attr = $_POST['Tdk'];
            $attr['content'] = $filterContent['content'];
            $model->attributes = $attr;
            $hasError = false;
            $_info = Tdk::findByPosition($_POST['Tdk']['url']);
            if ($id && $_info['id'] != $id && $_info) {
                $hasError = true;
            } elseif (!$id && $_info) {
                $hasError = true;
            }
            if ($hasError) {
                $model->addError('title', '已被占用');
            } elseif ($model->save()) {
                if (!$id) {
                    Yii::app()->user->setFlash('addTdkSuccess', "保存成功！您可以继续添加。");
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

    public function actionJump() {
        $url = zmf::val('url', 1);
        $info = Tdk::findByPosition($url);
        if ($info) {
            $this->redirect(array('update', 'id' => $info['id']));
        }
        $this->redirect(array('create', 'url' => $url));
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
        $this->checkPower('delTdk');
        $this->loadModel($id)->delete();

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
        $model = new Tdk('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Tdk']))
            $model->attributes = $_GET['Tdk'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Tdk the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Tdk::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Tdk $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'tdk-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
