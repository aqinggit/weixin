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

    // Uncomment the following methods and override them if needed
    /*
    public function filters()
    {
        // return the filter configuration for this controller, e.g.:
        return array(
            'inlineFilterName',
            array(
                'class'=>'path.to.FilterClass',
                'propertyName'=>'propertyValue',
            ),
        );
    }

    public function actions()
    {
        // return external action classes, e.g.:
        return array(
            'action1'=>'path.to.ActionClass',
            'action2'=>array(
                'class'=>'path.to.AnotherActionClass',
                'propertyName'=>'propertyValue',
            ),
        );
    }
    */
}