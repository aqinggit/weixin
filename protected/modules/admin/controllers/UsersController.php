<?php

/**
 * @filename TagsController.php
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2015 阿年飞少
 * @datetime 2016-1-4  12:54:36
 */
class UsersController extends Admin
{

    public function init()
    {
        parent::init();
        $this->checkPower('users');
    }

    public function actionIndex()
    {
        $criteria = new CDbCriteria();
        $truename = zmf::val('truename', 1);
        if ($truename) {
            $criteria->addSearchCondition('truename', $truename);
        }
        $phone = zmf::val('phone', 2);
        if ($phone) {
            $criteria->addSearchCondition('phone', $phone);
        }
        $email = zmf::val('email', 1);
        if ($email) {
            $criteria->addSearchCondition('email', $email);
        }
        $criteria->order = 'id DESC';
        $model = new Users;
        $count = $model->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 30;
        $pager->applyLimit($criteria);
        $posts = $model->findAll($criteria);

        $this->render('index', array(
            'pages' => $pager,
            'posts' => $posts,
            'model' => $model,
        ));
    }

    public function actionCreate($id = '')
    {
        if ($id) {
            $model = Users::model()->findByPk($id);
            if (!$model) {
                $this->message(0, '你所编辑的用户不存在');
            }
            $isNew = false;
        } else {
            $model = new Users;
            $isNew = true;
        }
        if (isset($_POST['Users'])) {
            if ($isNew) {
                $_POST['Users']['password'] = md5($_POST['Users']['password']);
            } elseif ($_POST['Users']['password'] != $model->password) {
                $_POST['Users']['password'] = md5($_POST['Users']['password']);
            }
            //判断能否设置用户组
            if (!$this->checkPower('admins', $this->uid, true)) {
                unset($_POST['Users']['isAdmin']);
                unset($_POST['Users']['powerGroupId']);
            }
            $model->attributes = $_POST['Users'];
            $model->password2 = md5($model->password2);
            if ($model->save()) {
                $this->redirect(array('users/index'));
            }
        }
        $this->render('create', array(
            'model' => $model
        ));
    }

    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionUpdate($id)
    {
        $this->actionCreate($id);
    }

    public function loadModel($id)
    {
        $model = Users::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionAdmins()
    {
        $this->checkPower('admins');
        $criteria = new CDbCriteria();
        $criteria->select = 'id,truename,powerGroupId';
        $criteria->addCondition('isAdmin=1');
        $count = Users::model()->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 30;
        $pager->applyLimit($criteria);
        $posts = Users::model()->findAll($criteria);

        $this->render('admins', array(
            'pages' => $pager,
            'posts' => $posts,
        ));
    }

    public function actionSetadmin($id = '')
    {
        $this->checkPower('setAdmin');
        $mine = array();
        $model = new Admins();
        if ($id) {
            $pinfos = $model->findAll('uid=:uid', array(':uid' => $id));
            $model->uid = $id;
            if ($pinfos) {
                $mine = array_keys(CHtml::listData($pinfos, 'powers', ''));
            }
        }
        if (isset($_POST['Admins'])) {
            $url = Yii::app()->createUrl('admin/users/admins');
            $uid = $_POST['Admins']['uid'];
            if (!$uid) {
                $model->addError('uid', 'uid不能为空');
            } else {
                $powers = array_unique(array_filter($_POST['powers']));
                Admins::model()->deleteAll('uid=:uid', array(':uid' => $uid));
                zmf::delFCache('adminPowers' . $uid);
                if (empty($powers)) {
                    $this->message(1, '操作成功', $url);
                } else {
                    foreach ($powers as $p) {
                        $_attr = array(
                            'uid' => $uid,
                            'powers' => $p
                        );
                        $m = new Admins;
                        $m->attributes = $_attr;
                        $m->save();
                    }
                    $this->message(1, '操作成功', $url);
                }
            }
        }
        $data = array(
            'model' => $model,
            'mine' => $mine,
        );
        $this->render('setadmin', $data);
    }

    public function actionDeladmin($id)
    {
        $this->checkPower('delAdmin');
        Admins::model()->deleteAll('uid=:uid', array(':uid' => $id));
        Users::model()->updateByPk($id, array('isAdmin' => 0, 'powerGroupId' => 0));
        $this->redirect(array('users/admins'));
    }

    public function actionNotice($id)
    {
        $model = new Notification;
        $model->uid = $id;
        $model->type = 'system';
        $model->new = 1;
        $model->cTime = zmf::now();
        if (isset($_POST['Notification'])) {
            $model->attributes = $_POST['Notification'];
            if ($model->save()) {
                if (!$id) {
                    Yii::app()->user->setFlash('addNotificationSuccess', "保存成功！您可以继续添加。");
                    $this->redirect(array('create'));
                } else {
                    $this->redirect(array('index'));
                }
            }
        }
        $this->render('notice', array(
            'model' => $model,
        ));
    }

    public function actionSearch()
    {
        $from = zmf::val('from', 1);
        if (Yii::app()->request->isAjaxRequest && isset($_GET['q'])) {
            $name = trim(zmf::val('q', 1));
            $name = '%' . strtr($name, array('%' => '\%', '_' => '\_', '\\' => '\\\\')) . '%';
            $sql = "SELECT id,truename FROM {{users}} WHERE (truename LIKE '$name' OR phone LIKE '$name' OR email LIKE '$name') AND status=1 LIMIT 10";
            $items = Yii::app()->db->createCommand($sql)->queryAll();
            $returnVal = '';
            foreach ($items as $val) {
                $returnVal .= $val['truename'] . '|' . $val['id'] . "\n";
            }
            echo $returnVal;
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
}
