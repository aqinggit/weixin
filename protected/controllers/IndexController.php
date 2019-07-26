<?php

class IndexController extends Q
{
    public function init()
    {
        parent::init();
        $this->selectNav = 'index';
    }

    public function actionIndex()
    {
        $this->render("index");
    }
}

