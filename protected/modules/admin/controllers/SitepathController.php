<?php
/**
 * @filename SitepathController.php
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2018 阿年飞少
 * @datetime 2018-06-07 14:10:00
 */

class SitepathController extends Admin
{
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
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
        if ($this->isAjax) {
            $this->jsonOutPut(1, '已删除');
        } else {
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $select = "id,logid,classify,name";
        $model = new Sitepath;
        $criteria = new CDbCriteria();
        $logid=zmf::val('logid',1);
        $classify=zmf::val('classify',1);
        $name=zmf::val('name',1);
        if($logid){
            $criteria->addCondition("logid='{$logid}'");
        }
        if($classify){
            $criteria->addCondition("classify='{$classify}'");
        }
        if($name){
            $criteria->addCondition("name='{$name}'");
        }
        $criteria->select = $select;
        $criteria->order='id DESC';
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

    public function actionIntoTags() {
        $_page = zmf::val('page', 2);
        $page = $_page < 1 ? 1 : $_page;
        $limit = 100;
        $start = ($page - 1) * $limit;
        $sql = "select id,name from {{tags}} ORDER BY id ASC LIMIT $start,$limit";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($items)) {
            $this->redirect(array('index'));
        }
        foreach ($items as $item) {
            $_attr = array(
                'logid' => $item['id'],
                'classify' => 'tag',
                'name' => $item['name'],
            );
            $_model1 = new Sitepath();
            $_model1->attributes = $_attr;
            $_model1->save();
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/sitepath/intoTags', array('page' => ($page + 1))), 1);
    }

    public function actionIntoColumn() {
        $_page = zmf::val('page', 2);
        $page = $_page < 1 ? 1 : $_page;
        $limit = 100;
        $start = ($page - 1) * $limit;
        $sql = "select id,name from {{column}} ORDER BY id ASC LIMIT $start,$limit";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($items)) {
            $this->redirect(array('index'));
        }
        foreach ($items as $item) {
            $_attr = array(
                'logid' => $item['id'],
                'classify' => 'column',
                'name' => $item['name'],
            );
            $_model1 = new Sitepath();
            $_model1->attributes = $_attr;
            $_model1->save();
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/sitepath/intoColumn', array('page' => ($page + 1))), 1);
    }

    public function actionIntoArea() {
        $_page = zmf::val('page', 2);
        $page = $_page < 1 ? 1 : $_page;
        $limit = 100;
        $start = ($page - 1) * $limit;
        $sql = "select id,name from {{area}} WHERE `name`!='' ORDER BY id ASC LIMIT $start,$limit";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($items)) {
            $this->redirect(array('index'));
        }
        foreach ($items as $item) {
            $_attr = array(
                'logid' => $item['id'],
                'classify' => 'area',
                'name' => $item['name'],
            );
            $_model1 = new Sitepath();
            $_model1->attributes = $_attr;
            $_model1->save();
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/sitepath/intoArea', array('page' => ($page + 1))), 1);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Sitepath('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Sitepath']))
            $model->attributes = $_GET['Sitepath'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Sitepath the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Sitepath::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Sitepath $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sitepath-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
