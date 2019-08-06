<?php

class ActivityController extends Q
{
    public function actionIndex()
    {
        $items = Activity::model()->findAll('status = 1');
        $data = [
            'items' => $items
        ];
        $this->render('list', $data);
    }

    public function actionDetail()
    {
        $id = zmf::val('id');
        $item = Activity::getOne($id);
        if (!$item || $item['status'] != 1) {
            throw new CHttpException(404, '这场活动不存在,或者已经结束');
        }
        $data = [
            'item' => $item
        ];
        $this->render('detail', $data);
    }

    public function actionApply()
    {
        if (Yii::app()->user->isGuest) {
            $this->redirect(zmf::createUrl('weixin/login'));
        }
        $aid = zmf::val('aid',);
        $active = Activity::getOne($aid);
        if (!$active || $active['status'] != 1){
            throw new CHttpException(404, '这场活动不存在,或者已经结束');
        }

        $sql = ""


        $uid = zmf::uid();

    }

}