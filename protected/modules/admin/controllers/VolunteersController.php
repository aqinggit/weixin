<?php
/**
 * @filename VolunteersController.php
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2019 阿年飞少
 * @datetime 2019-08-01 22:51:23
 */

class VolunteersController extends Admin
{

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        //$this->checkPower('volunteers');
        $select = "id,name,password,truename,cTime,score,status,company,cardIdType,cardId,sex,age,phone,politics,nation,address,education,work,volunteerType";
        $model = new Users();
        $criteria = new CDbCriteria();

        $truename = zmf::val("truename", 1);
        if ($truename) {
            $criteria->addSearchCondition("truename", $username);
        }
        $phone = zmf::val("phone", 1);
        if ($phone) {
            $criteria->addSearchCondition("phone", $username);
        }


        if (zmf::val('type') == 'nopass') {
            $criteria->addCondition('status =0');
        }

        $time = zmf::val('time', 2
        );
        if ($time) {
            $startTime = $time . '-1-1';
            $startTime = strtotime($startTime);
            $endTime = ($time + 1) . '-1-1';
            $endTime = strtotime($endTime);

        }
        $startCount = zmf::val('startCount', 1);
        $endCount = zmf::val('endCount', 1);
        $startScore = zmf::val('startScore', 1);
        $endScore = zmf::val('endScore', 1);


        if (zmf::val('key')) {
            if ($startScore != '' && $endScore == '') {
                $endScore = 999999;
            }

            if ($startScore == '' && $endScore != '') {
                $startScore = -0.1;
            }

            if ($startCount != '' && $endCount == '') {
                $endCount = 999999;
            }

            if ($startCount == '' && $endCount != '') {
                $startCount = -0.1;
            }
        }


        //对应志愿者管理员才会显示对应的志愿者
        $powerTypes = [];
        if ($this->checkPower('volunteerType1', '', true)) {
            $powerTypes[] = 1;
        }
        if ($this->checkPower('volunteerType2', '', true)) {
            $powerTypes[] = 2;
        }
        if ($this->checkPower('volunteerType3', '', true)) {
            $powerTypes[] = 3;
        }
        $criteria->addInCondition('volunteerType', $powerTypes);


        $criteria->addCondition('status !=3');
        $criteria->select = $select;
        $count = $model->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 30;
        $pager->applyLimit($criteria);
        $posts = $model->findAll($criteria);
        $ids = [];
        foreach ($posts as $K => $post) {
            $where = '';
            if ($time) {
                $where .= "cTime >= {$startTime} AND cTime <= {$endTime} AND ";
            }

            $sql = "select count(*) as t,SUM(score) as m From pre_volunteer_active WHERE {$where} vid = {$post->id} AND status = 1";
            $items = Yii::app()->db->createCommand($sql)->queryRow();
            $post->activityCount = $items['t'] ? $items['t'] : 0;
            $post->activityScore = $items['m'] ? $items['m'] : 0;


            if ($post->activityCount < $startCount && $startCount != '') {
                unset($posts[$K]);
                continue;
            }
            if ($post->activityCount > $endCount && $endCount != '') {
                unset($posts[$K]);
                continue;
            }
            if ($post->activityScore < $startScore && $startScore != '') {
                unset($posts[$K]);
                continue;
            }
            if ($post->activityScore > $endScore && $endScore != '') {
                unset($posts[$K]);
                continue;
            }
            $ids[] = $post->id;
        }
        $ids = join(',', $ids);
        $posts->count = count($posts);
        $this->render('index', array(
            'pages' => $pager,
            'posts' => $posts,
            'model' => $model,
            'ids' => $ids
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
            //$this->checkPower('updateVolunteers');
            $model = $this->loadModel($id);
            $this->checkOutTypePower($model);
        } else {
            //$this->checkPower('addVolunteers');
            $model = new Users();
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Users'])) {
            $data = $_POST['Users'];
            if (!$data['password2']) {
                $data['password2'] = $data['password'];
            } else {
                $data['password'] = md5($data['password']);
                $data['password2'] = md5($data['password2']);
            }
            if (!$data['birthday']) {
                unset($data['birthday']);
            }

            $model->attributes = $data;
            if ($data['birthday']) {
                $model->birthday = strtotime($model->birthday);
            }
            $this->checkOutTypePower($model);
            if ($model->save()) {
                if (!$id) {
                    Yii::app()->user->setFlash('addVolunteersSuccess', "保存成功！您可以继续添加。");
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
        //$this->checkPower('delVolunteers');
        $this->loadModel($id)->updateByPk($id, array('status' => Users::STATUS_DELED));

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if ($this->isAjax) {
            $this->jsonOutPut(1, '已删除');
        } else {
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    public function actionDelList()
    {
        //$this->checkPower('delVolunteers');
        $ids = zmf::val('ids');
        $ids = explode(',', $ids);
        foreach ($ids as $id) {
            $model = $this->loadModel($id);

            $model->updateByPk($id, array('status' => Users::STATUS_DELED));
        }
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if ($this->isAjax) {
            $this->jsonOutPut(1, '已删除');
        } else {
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    public function actionPass($id)
    {
        //$this->checkPower('delVolunteers');
        $model = $this->loadModel($id);
        $model->updateByPk($id, array('status' => Users::STATUS_PASSED));

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if ($this->isAjax) {
            $this->jsonOutPut(1, '已通过');
        } else {
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Volunteers the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Users::model()->findByPk($id);
        $this->checkOutTypePower($model);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Volunteers $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'volunteers-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function checkOutTypePower($model)
    {

        if ($model->volunteerType == 1) {
            $this->checkPower('volunteerType1');
        }
        if ($model->volunteerType == 2) {
            $this->checkPower('volunteerType3');
        }
        if ($model->volunteerType == 3) {
            $this->checkPower('volunteerType2');
        }
    }
}
