<?php
/**
 * @filename ArticlesWeixinController.php
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2019 阿年飞少
 * @datetime 2019-07-26 20:54:56
 */

class ArticlesWeixinController extends Admin
{

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        //$this->checkPower('articlesweixin');
        $select = "id,user_id,title,content,cTime,status,score";
        $model = new ArticlesWeixin;
        $criteria = new CDbCriteria();
        $id = zmf::val("id", 1);
        if ($id) {
            $criteria->addSearchCondition("id", $id);
        }
        $user_id = zmf::val("user_id", 1);
        if ($user_id) {
            $criteria->addSearchCondition("user_id", $user_id);
        }
        $title = zmf::val("title", 1);
        if ($title) {
            $criteria->addSearchCondition("title", $title);
        }
        $content = zmf::val("content", 1);
        if ($content) {
            $criteria->addSearchCondition("content", $content);
        }
        $cTime = zmf::val("cTime", 1);
        if ($cTime) {
            $criteria->addSearchCondition("cTime", $cTime);
        }
        $status = zmf::val("status", 1);
        if ($status) {
            $criteria->addSearchCondition("status", $status);
        }
        $score = zmf::val("score", 1);
        if ($score) {
            $criteria->addSearchCondition("score", $score);
        }
        $criteria->addCondition("status !=3");//查询条件

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
            //$this->checkPower('updateArticlesWeixin');
            $model = $this->loadModel($id);
        } else {
            //$this->checkPower('addArticlesWeixin');
            $model = new ArticlesWeixin;
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['ArticlesWeixin'])) {
            $model->attributes = $_POST['ArticlesWeixin'];
            if ($model->save()) {
                if (!$id) {
                    Yii::app()->user->setFlash('addArticlesWeixinSuccess', "保存成功！您可以继续添加。");
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
        //$this->checkPower('delArticlesWeixin');
        $this->loadModel($id)->updateByPk($id, array('status' => Posts::STATUS_DELED));

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if ($this->isAjax) {
            $this->jsonOutPut(1, '已删除');
        } else {
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
    public function actionPass($id)
    {
        //$this->checkPower('delArticlesWeixin');
        $this->loadModel($id)->updateByPk($id, array('status' => Posts::STATUS_PASSED));

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if ($this->isAjax) {
            $this->jsonOutPut(1, '已通过');
        } else {
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new ArticlesWeixin('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ArticlesWeixin']))
            $model->attributes = $_GET['ArticlesWeixin'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ArticlesWeixin the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = ArticlesWeixin::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ArticlesWeixin $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'articles-weixin-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
