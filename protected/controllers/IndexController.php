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
        $this->pageTitle =zmf::config('sitename');
        $this->render("index");
    }
}

