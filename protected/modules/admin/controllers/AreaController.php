<?php

/**
 * @filename AreaController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-11-16 13:49:15 */
class AreaController extends Admin {
    public function init() {
        parent::init();
        $this->checkPower('area');
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
        } else {
            $model = new Area;
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Area'])) {
            $model->attributes = $_POST['Area'];
            $hasError=false;
            $info=Sitepath::findByName($_POST['Area']['name']);
            if ($info['logid'] == $id && $info['classify']=='area') {
            }elseif($info){
                $hasError = true;
            }
            if ($hasError) {
                $model->addError('name', '已被占用');
            } elseif ($model->save()) {
                Sitepath::updateOne('area',$model->id,$model->name);
                if (!$id) {
                    Yii::app()->user->setFlash('addAreaSuccess', "保存成功！您可以继续添加。");
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
     * 首页地区
     */
    public function actionSetStatus($id) {
        $info = Area::model()->findByPk($id);
        if (!$info) {
            $this->message(0, '地区不存在');
        }
        $type = zmf::val('type', 1);
        if (!in_array($type, array('opened'))) {
            $this->message(0, '不允许的分类');
        }
        if (!$info['name']) {
            $this->message(0, '请先设置地区域名');
        }
        $value = $info[$type] == 1 ? 0 : 1;
        if ($info->updateByPk($id, array(
                    $type => $value
                ))) {
            $this->message(1, '已修改', null, 1);
        }
        $this->message(0, '设置失败，可能是未作更改');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $select = "id,title,belongId,opened,name,sitepath";
        $belongId = zmf::val('belongId',2);
        $criteria = new CDbCriteria();
        $criteria->order = 'id ASC';
        $title = zmf::val('title', 1);
        $type = zmf::val('type', 1);
        if ($title) {
            $criteria->addSearchCondition('title', $title);
        }
        $name = zmf::val('name', 1);
        if ($name) {
            $criteria->addCondition("name='{$name}'");
        }
        if($type=='opened'){
            $criteria->addCondition('opened=1');
            $criteria->order='belongId ASC,id ASC';
        }elseif ($type != 'all') {
            if (!$belongId) {
                $criteria->addCondition('belongId=0');
            }else{
                $criteria->addCondition('belongId=' . $belongId);
            }
        } else {
            $_beInfo= Area::model()->findByPk($belongId);
            if($_beInfo){
                $criteria->addCondition("sitepath LIKE '{$_beInfo['sitepath']}%'");
            }
            $criteria->order = 'LENGTH(name) DESC';
        }
        $model = new Area;
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
    
    public function actionSearch() {
        $from=zmf::val('from',1);
        if (Yii::app()->request->isAjaxRequest && isset($_GET['q'])) {
            $name = $_GET['q'];
            $criteria = new CDbCriteria;
            $criteria->condition = "(title LIKE :keyword OR name LIKE :keyword) AND opened=1";            
            $criteria->params = array(':keyword' => '%' . strtr($name, array('%' => '\%', '_' => '\_', '\\' => '\\\\')) . '%');
            $criteria->limit = 10;
            $criteria->order='id ASC';
            $userArray = Area::model()->findAll($criteria);
            $returnVal = '';
            foreach ($userArray as $userAccount) {
                $_btitle = '';
                if ($userAccount['belongId'] > 0) {
                    $_beinfo = Area::model()->findByPk($userAccount['belongId']);
                    if ($_beinfo) {
                        $_btitle = '(' . $_beinfo['title'] . ')';
                    }
                }
                $returnVal .= $userAccount->getAttribute('title') . $_btitle . '|' . $userAccount->getAttribute('id') . "\n";
            }
            echo $returnVal;
        }
    }

    public function actionUpdatePath() {
        $_page = zmf::val('page', 2);        
        $page = $_page < 1 ? 1 : $_page;
        $limit = 30;
        $start = ($page - 1) * $limit;        
        $sql = "SELECT id,belongId,sitepath FROM {{area}} ORDER BY belongId ASC,id ASC LIMIT $start,$limit";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($items)) {
            $this->redirect(array('index'));
        }
        foreach ($items as $item) {
            $_path = '';
            if ($item['belongId'] > 0) {
                $_beinfo = Area::model()->findByPk($item['belongId']);
                if (!$_beinfo) {
                    continue;
                }
                $_path = $_beinfo['sitepath'] . $item['id'] . '-';
            } else {
                $_path = $item['id'] . '-';
            }
            Area::model()->updateByPk($item['id'], array('sitepath' => $_path));
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/area/updatePath', array('page' => ($page + 1))), 0);
    }
    
    public function actionUpdateName() {
        $_page = zmf::val('page', 2);        
        $page = $_page < 1 ? 1 : $_page;
        $limit = 1000;
        $start = ($page - 1) * $limit;        
        $sql = "SELECT id,title FROM {{area}} where opened=1 and name='' ORDER BY id ASC LIMIT $limit";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($items)) {
            $this->redirect(array('index'));
        }
        foreach ($items as $item) {
            $_path= zmf::pinyin($item['title']);
            Area::model()->updateByPk($item['id'], array('name' => $_path));
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/area/updateName', array('page' => ($page + 1))), 0);
    }
    
    public function actionUpdateChar() {
        $_page = zmf::val('page', 2);
        $page = $_page < 1 ? 1 : $_page;
        $limit = 30;
        $start = ($page - 1) * $limit;
        $sql = "SELECT id,title,name,firstChar FROM {{area}} where opened=1 ORDER BY id ASC LIMIT {$start},$limit";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($items)) {
            exit('well done');
        }
        foreach ($items as $item) {
            if ($item['name'] && $item['firstChar']) {
                continue;
            }
            $_name = $item['name'];
            if (!$item['name']) {
                $_name = zmf::pinyin($item['title']);
            }
            $karr = zmf::chararray($_name);
            $_char = $karr[0][0];
            $_attr = array(
                'name' => $_name,
                'firstChar' => $_char
            );
            Area::model()->updateByPk($item['id'], $_attr);
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/area/updateChar', array('page' => ($page + 1))), 1);
    }
    
    public function actionUpdatePoi() {
        $_page = zmf::val('page', 2);        
        $page = $_page < 1 ? 1 : $_page;
        $limit = 100;
        $start = ($page - 1) * $limit;        
        $sql = "SELECT a.sitepath FROM {{area}} a,{{position}} p WHERE p.areaId=a.id ORDER BY p.id ASC LIMIT $start,$limit";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($items)) {
            $this->redirect(array('index'));
        }
        foreach ($items as $item) {
            $_ids= join(',',array_unique(array_filter(explode('-', $item['sitepath']))));
            if($_ids!=''){
                Area::model()->updateCounters(array(
                    'poi'=>1
                ), 'id IN('.$_ids.')');
            }
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/area/updatePoi', array('page' => ($page + 1))), 0);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Area('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Area']))
            $model->attributes = $_GET['Area'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Area the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Area::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Area $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'area-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
