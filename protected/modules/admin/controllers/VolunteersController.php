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
        $select = "id,username,password,truename,cTime,score,status,email,cardIdType,cardId,sex,birthday,phone,politics,nation,address,education,work";
        $model = new Volunteers;
        $criteria = new CDbCriteria();
        $id = zmf::val("id", 1);
        if ($id) {
            $criteria->addSearchCondition("id", $id);
        }
        $username = zmf::val("username", 1);
        if ($username) {
            $criteria->addSearchCondition("username", $username);
        }
        $password = zmf::val("password", 1);
        if ($password) {
            $criteria->addSearchCondition("password", $password);
        }
        $truename = zmf::val("truename", 1);
        if ($truename) {
            $criteria->addSearchCondition("truename", $truename);
        }
        $cTime = zmf::val("cTime", 1);
        if ($cTime) {
            $criteria->addSearchCondition("cTime", $cTime);
        }
        $score = zmf::val("score", 1);
        if ($score) {
            $criteria->addSearchCondition("score", $score);
        }
        $status = zmf::val("status", 1);
        if ($status) {
            $criteria->addSearchCondition("status", $status);
        }
        $email = zmf::val("email", 1);
        if ($email) {
            $criteria->addSearchCondition("email", $email);
        }
        $cardIdType = zmf::val("cardIdType", 1);
        if ($cardIdType) {
            $criteria->addSearchCondition("cardIdType", $cardIdType);
        }
        $cardId = zmf::val("cardId", 1);
        if ($cardId) {
            $criteria->addSearchCondition("cardId", $cardId);
        }
        $sex = zmf::val("sex", 1);
        if ($sex) {
            $criteria->addSearchCondition("sex", $sex);
        }
        $birthday = zmf::val("birthday", 1);
        if ($birthday) {
            $criteria->addSearchCondition("birthday", $birthday);
        }
        $phone = zmf::val("phone", 1);
        if ($phone) {
            $criteria->addSearchCondition("phone", $phone);
        }
        $politics = zmf::val("politics", 1);
        if ($politics) {
            $criteria->addSearchCondition("politics", $politics);
        }
        $nation = zmf::val("nation", 1);
        if ($nation) {
            $criteria->addSearchCondition("nation", $nation);
        }
        $address = zmf::val("address", 1);
        if ($address) {
            $criteria->addSearchCondition("address", $address);
        }
        $education = zmf::val("education", 1);
        if ($education) {
            $criteria->addSearchCondition("education", $education);
        }
        $work = zmf::val("work", 1);
        if ($work) {
            $criteria->addSearchCondition("work", $work);
        }

        if (zmf::val('type')!='all'){
            $criteria->addCondition('status =0');
        }

        $criteria->addCondition('status !=3');
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
            //$this->checkPower('updateVolunteers');
            $model = $this->loadModel($id);
        } else {
            //$this->checkPower('addVolunteers');
            $model = new Volunteers;
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Volunteers'])) {
            $data = $_POST['Volunteers'];
            if (!$data['password2']) {
               $data['password2'] = $data['password'];
            }else{
                $data['password'] = md5($data['password']);
                $data['password2'] = md5($data['password2']);
                zmf::test($data['password2']);
            }
            if (!$data['birthday']){
               unset($data['birthday']);
            }

            $model->attributes = $data;
            if ($data['birthday']){
                $model->birthday = strtotime($model->birthday);
            }

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

    public function actionPass($id)
    {
        //$this->checkPower('delVolunteers');
        $this->loadModel($id)->updateByPk($id, array('status' => Users::STATUS_PASSED));

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
        $model = new Volunteers('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Volunteers']))
            $model->attributes = $_GET['Volunteers'];

        $this->render('admin', array(
            'model' => $model,
        ));
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
        $model = Volunteers::model()->findByPk($id);
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
}
