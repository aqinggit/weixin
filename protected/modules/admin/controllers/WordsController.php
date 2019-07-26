<?php

/**
 * @filename WordsController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2016 阿年飞少 
 * @datetime 2016-06-01 05:28:02 */
class WordsController extends Admin {

    public function init() {
        parent::init();
        $this->checkPower('words');
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
            $this->checkPower('updateWords');
            $model = $this->loadModel($id);
        } else {
            $model = new Words;
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Words'])) {
            $model->attributes = $_POST['Words'];
            $urlsArr = array_filter(explode(PHP_EOL, $_POST['Words']['word']));
            if (!empty($urlsArr)) {
                foreach ($urlsArr as $_word) {
                    $_arr = array_filter(explode('#', $_word));
                    $_attr = array(
                        'word' => $_arr[0],
                        'type' => $_POST['Words']['type'],
                        'replaceTo' => $_arr[1],
                        'action' => $_POST['Words']['action'],
                    );
                    $_model = new Words;
                    $_model->attributes = $_attr;
                    $_model->save();
                }
                Words::createWordsCache();
                Yii::app()->user->setFlash('addWordsSuccess', "保存成功！您可以继续添加。");
                $this->redirect(array('create'));
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
        $model = $this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Words'])) {
            $model->attributes = $_POST['Words'];
            if ($model->save()) {
                Words::createWordsCache();
                $this->redirect(array('index'));
            }
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->checkPower('delWords');
        $this->loadModel($id)->delete();
        Words::createWordsCache();
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
        $select = "id,word,replaceTo,`action`,type,`len`,uid";
        $model = new Words;
        $criteria = new CDbCriteria();
        $word = zmf::val("word", 1);
        if ($word) {
            $criteria->addSearchCondition("word", $word);
        }
        $type = zmf::val("type", 1);
        if ($type) {
            $criteria->addSearchCondition("type", $type);
        }
        $uid = zmf::val("uid", 1);
        if ($uid) {
            $criteria->addSearchCondition("uid", $uid);
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

    public function actionReplace($id) {
        $info = $this->loadModel($id);
        $url = Yii::app()->createUrl('admin/words/index');
        if ($info['action'] != Words::ACTION_REPLACE) {
            $this->message(0, '不是替换项', $url);
        }
        $type = zmf::val('type', 1);
        $num = $this->_replace($type, $info['word'], $info['replaceTo']);
        $this->message(1, '已替换' . $num, $url);
    }

    public function actionReplaceAll() {
        $url = Yii::app()->createUrl('admin/words/index');
        $type = zmf::val('type', 1);
        if (!in_array($type, array('tips', 'answers', 'articles'))) {
            $this->message(0, '不允许的分类', $url);
        }
        $_page = zmf::val('page', 2);
        $page = $_page < 1 ? 1 : $_page;
        $limit = 100;
        $start = ($page - 1) * $limit;
        $sql = "select id,word,replaceTo FROM {{words}} WHERE `action`=" . Words::ACTION_REPLACE . " ORDER BY `len` DESC,id ASC LIMIT $start,$limit";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($items)) {
            $this->redirect(array('index'));
        }
        $num = 0;
        foreach ($items as $value) {
            $num += $this->_replace($type, $value['word'], $value['replaceTo']);
        }
        $this->message(1, '已处理'.$num.'，即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/words/replaceAll', array('page' => ($page + 1),'type'=>$type)), 1);
    }

    private function _replace($type, $word, $to) {
        $url = Yii::app()->createUrl('admin/words/index');
        if (!in_array($type, array('tips', 'answers', 'articles'))) {
            $this->message(0, '不允许的分类', $url);
        }
        $_a0 = zmf::trimText($word);
        $_a1 = zmf::trimText($to);
        $sql = "UPDATE {{" . $type . "}} SET content=REPLACE(content,'{$_a0}','{$_a1}')";
        $num = Yii::app()->db->createCommand($sql)->execute();
        return $num;
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Words('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Words']))
            $model->attributes = $_GET['Words'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Words the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Words::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Words $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'words-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
