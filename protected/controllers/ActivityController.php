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
        $aid = zmf::val('aid');
        $uid = zmf::uid();
        $now = zmf::now();
        $active = Activity::getOne($aid);
        if (!$active || $active['status'] != 1) {
            throw new CHttpException(404, '这场活动不存在,或者已经结束');
        }

        $item = VolunteerActive::model()->find("vid ={$uid} AND aid ={$aid}");

        if ($active['volunteerType'] != $this->userInfo['volunteerType'])
        {
            throw new CHttpException(403, '您申请的活动和您的自愿者类型不符合');
        }


        if ($item) {
            throw new CHttpException(403, '您已经申请过了，请耐心等待审核');
        } else {
            $item = new VolunteerActive();
            $item->vid = $uid;
            $item->aid = $aid;
            if ($item->save()) {
                $this->render('ApplySuccess');
            } else {
                throw new CHttpException(403, '申请失败!');
            }
        }


    }

}