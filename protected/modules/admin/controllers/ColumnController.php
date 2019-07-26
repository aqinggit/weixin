<?php

/**
 * @filename ColumnController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2016 阿年飞少 
 * @datetime 2016-05-10 16:32:06 */
class ColumnController extends Admin {
    public function init() {
        parent::init();
        $this->checkPower('column');
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
            $this->checkPower('updateColumn');
            $model = $this->loadModel($id);
        } else {
            $model = new Column;
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Column'])) {            
            if($_POST['Column']['bgImgId']){
                $_POST['Column']['bgImgUrl'] = Attachments::faceImg($_POST['Column']['bgImgId'],''); //默认将文章中的第一张图作为封面图
            }
            $model->attributes = $_POST['Column'];
            $hasError=false;
            $_name=$_POST['Column']['name'];
            $info=Sitepath::findByName($_name);
            if ($info['logid'] == $id && $info['classify']=='column') {
            }elseif($info){
                $hasError = true;
            }
            if ($hasError) {
                $model->addError('name', '已被占用');
            } elseif ($model->save()) {
                Sitepath::updateOne('column',$model->id,$model->name);
                if (!$id) {
                    Yii::app()->user->setFlash('addColumnSuccess', "保存成功！你可以继续添加。");
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
        $this->checkPower('delColumn');
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function actionIndex() {
        $select = "id,title,name,belongId,classify";
        $model = new Column();
        $criteria = new CDbCriteria();
        $classify= zmf::val('classify',2);
        if($classify){
            $criteria->addCondition('classify='.$classify);
        }
        $title= zmf::val('title',1);
        if($title){
            $criteria->addSearchCondition('title',$title);
        }
        $name = zmf::val('name', 1);
        if ($name) {
            $criteria->addCondition("name='{$name}'");
        }
        $criteria->select = $select;
        $criteria->order = 'id ASC';
        $count = $model->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 30;
        $pager->applyLimit($criteria);
        $posts = $model->findAll($criteria);
        $this->render('index', array(
            'model' => $model,
            'pages' => $pager,
            'posts' => $posts,
        ));
    }
    
    public function actionUpdatePosts() {
        set_time_limit(0);
        $sql = 'update {{column}} c,(select tagid,count(id) AS total from {{tag_relation}} WHERE classify="column" GROUP BY tagid) as temp set c.posts=temp.total where c.id=temp.tagid';
        $info = Yii::app()->db->createCommand($sql)->execute();
        zmf::test($info);
    }
    
    public function actionUpdatePath() {
        $_page = zmf::val('page', 2);        
        $page = $_page < 1 ? 1 : $_page;
        $limit = 30;
        $start = ($page - 1) * $limit;        
        $sql = "SELECT id,belongId,sitepath FROM {{column}} ORDER BY belongId ASC,id ASC LIMIT $start,$limit";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($items)) {
            $this->redirect(array('index'));
        }
        foreach ($items as $item) {
            $_path = '';
            if ($item['belongId'] > 0) {
                $_beinfo = Column::model()->findByPk($item['belongId']);
                if (!$_beinfo) {
                    continue;
                }
                $_path = $_beinfo['sitepath'] . $item['id'] . '-';
            } else {
                $_path = $item['id'] . '-';
            }
            Column::model()->updateByPk($item['id'], array('sitepath' => $_path));
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/column/updatePath', array('page' => ($page + 1))), 0);
    }
    
    public function actionSearch() {
        if (Yii::app()->request->isAjaxRequest && isset($_GET['q'])) {
            $name = trim(zmf::val('q', 1));
            $name = '%' . strtr($name, array('%' => '\%', '_' => '\_', '\\' => '\\\\')) . '%';
            $sql = "SELECT id,title FROM ". Column::tableName()." WHERE title LIKE '$name' LIMIT 10";
            $items = Yii::app()->db->createCommand($sql)->queryAll();
            $returnVal = '';
            foreach ($items as $val) {
                $returnVal .= $val['title'] . '|' . $val['id'] . "\n";
            }
            echo $returnVal;
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Column('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Column']))
            $model->attributes = $_GET['Column'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Column the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Column::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Column $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'column-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
