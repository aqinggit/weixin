<?php

/**
 * @filename KeywordsController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2016 阿年飞少 
 * @datetime 2016-12-12 20:01:56 */
class KeywordsController extends Admin {

    public function init() {
        parent::init();
        $this->checkPower('keywords');
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
            $this->checkPower('updateKeywords');
            $model = $this->loadModel($id);
        } else {
            $model = new Keywords;
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Keywords'])) {
            if ($_POST['Keywords']['url'] != '' && strpos($_POST['Keywords']['url'], 'http://') === false && strpos($_POST['Keywords']['url'], 'https://') === false) {
                $_POST['Keywords']['url'] = 'http://' . $_POST['Keywords']['url'];
            }
            $model->attributes = $_POST['Keywords'];
            if ($model->save()) {
                Keywords::cacheWords();
                if (!$id) {
                    Yii::app()->user->setFlash('addKeywordsSuccess', "保存成功！您可以继续添加。");
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
        $this->checkPower('delKeywords');
        $this->loadModel($id)->deleteByPk($id);
        Keywords::cacheWords();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if ($this->isAjax) {
            $this->jsonOutPut(1, '已删除');
        } else {
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
    
    public function actionDeleteAll() {
        Keywords::model()->deleteAll();
        Keywords::cacheWords();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if ($this->isAjax) {
            $this->jsonOutPut(1, '已删除');
        } else {
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
    
    public function actionUpdateCache(){
        Keywords::cacheWords();        
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
        $select = "id,title,len,url,hash";
        $model = new Keywords;
        $criteria = new CDbCriteria();
        $title = zmf::val("title", 1);
        if ($title) {
            $criteria->addSearchCondition("title", $title);
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
        $sql = "select id,title,name,nickname,classify from {{tags}} WHERE isDisplay=1 ORDER BY id ASC LIMIT $start,$limit";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($items)) {
            $this->redirect(array('index'));
        }
        foreach ($items as $item) {
            $url = zmf::config('domain') . Yii::app()->createUrl('/index/index', array('colName' => $item['name']));
            //同时导入昵称
            $_tagArr = array_unique(array_filter(explode(',', $item['nickname'])));
            $_tagArr[] = $item['title'];
            foreach ($_tagArr as $_tagTitle) {
                $_attr = array(
                    'title' => $_tagTitle,
                    'url' => $url
                );
                $_model1 = new Keywords;
                $_model1->attributes = $_attr;
                $_model1->save();
            }
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/keywords/intoTags', array('page' => ($page + 1))), 1);
    }

    public function actionIntoColumn() {
        $_page = zmf::val('page', 2);
        $page = $_page < 1 ? 1 : $_page;
        $limit = 100;
        $start = ($page - 1) * $limit;
        $sql = "select id,title,name,nickname,classify from {{column}} WHERE status=1 ORDER BY id ASC LIMIT $start,$limit";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($items)) {
            $this->redirect(array('index'));
        }
        foreach ($items as $item) {
            $url = zmf::config('domain') . Yii::app()->createUrl('/index/index', array('colName' => $item['name']));
            //同时导入昵称
            $_tagArr = array_unique(array_filter(explode(',', $item['nickname'])));
            $_tagArr[] = $item['title'];
            foreach ($_tagArr as $_tagTitle) {
                $_attr = array(
                    'title' => $_tagTitle,
                    'url' => $url
                );
                $_model1 = new Keywords;
                $_model1->attributes = $_attr;
                $_model1->save();
            }
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/keywords/intoColumn', array('page' => ($page + 1))), 1);
    }

    public function actionIntoArea() {
        $_page = zmf::val('page', 2);
        $page = $_page < 1 ? 1 : $_page;
        $limit = 100;
        $start = ($page - 1) * $limit;
        $sql = "select id,title,name from {{area}} WHERE opened=1 ORDER BY id ASC LIMIT $start,$limit";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($items)) {
            $this->redirect(array('index'));
        }
        $areaKeywords=zmf::config('areaKeywords');
        $areaKeywordsArr=array_unique(array_filter(explode(',',$areaKeywords)));
        foreach ($items as $item) {
            $url = zmf::config('domain') . Yii::app()->createUrl('/index/index', array('colName' => $item['name']));
            $_tagArr=[];
            $_tagArr[] = $item['title'];
            foreach($areaKeywordsArr as $k){
                $_tagArr[] = $item['title'].$k;
            }
            foreach ($_tagArr as $_tagTitle) {
                $_attr = array(
                    'title' => $_tagTitle,
                    'url' => $url
                );
                $_model1 = new Keywords;
                $_model1->attributes = $_attr;
                $_model1->save();
            }
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/keywords/intoArea', array('page' => ($page + 1))), 1);
    }

    public function actionMulti() {
        $model = new Tags;
        if (isset($_POST['items']) && !empty($_POST['items'])) {
            $titles = $_POST['items'];
            $titlesArr = array_unique(array_filter(explode(PHP_EOL, $titles)));
            foreach ($titlesArr as $_title) {
                $_arr=array_filter(explode('#',$_title));
                if(count($_arr)!=2){
                    continue;
                }
                $_attr = array(
                    'title' => trim($_arr[0]),
                    'url' => trim($_arr[1])
                );
                $_model1 = new Keywords;
                $_model1->attributes = $_attr;
                $_model1->save();
            }
            Yii::app()->user->setFlash('addKeywordsSuccess', "已批量导入！您可以继续添加或前往完善。");
            $this->redirect(array('multi'));
        }
        $this->render('multi', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Keywords('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Keywords']))
            $model->attributes = $_GET['Keywords'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Keywords the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Keywords::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Keywords $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'keywords-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
