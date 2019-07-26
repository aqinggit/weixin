<?php

class ArticleWeixinController extends Q
{

    public function init()
    {
        parent::init();
        $this->selectNav = 'index';
    }

    public function actionIndex()
    {
        $id = zmf::val('id');

        $data = ArticlesWeixin::getOne($id);
        //zmf::test($data->userInfo);
        $this->render('index', ['data' => $data]);
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