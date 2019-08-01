<?php

class SiteController extends Admin {

    public function actionUrls() {
        $domain = zmf::config('domain');
        $_url = '';
        $table = zmf::val('table', 1);        
        $startTime = zmf::val('startTime', 1);
        $endTime = zmf::val('endTime', 1);
        $now = zmf::now();
        if ($startTime) {
            $startTime = strtotime(zmf::time(strtotime($startTime, $now),'Y/m/d'),$now);
        }
        if ($endTime) {
            $endTime = strtotime(zmf::time(strtotime($endTime, $now),'Y/m/d'),$now) + 86399;
        }
        $where='';
        if($startTime){
            $where.=" AND cTime>='{$startTime}'";
        }
        if($endTime){
            $where.=" AND cTime<='{$endTime}'";
        }
        if (in_array($table, array('all', 'articles'))) {
            $sql = "SELECT id,urlPrefix FROM {{articles}} WHERE status=1 {$where} ORDER BY id ASC";
            $posts = Yii::app()->db->createCommand($sql)->queryAll();
            foreach ($posts as $val) {
                $_url .= $domain . Yii::app()->createUrl('/article/view', array('id' => $val['id'], 'urlPrefix' => $val['urlPrefix'])) . PHP_EOL;
            }
        }
        if (in_array($table, array('all', 'questions'))) {
            $sql = "SELECT id,urlPrefix FROM {{questions}} WHERE status=1 {$where} ORDER BY id ASC";
            $posts = Yii::app()->db->createCommand($sql)->queryAll();
            foreach ($posts as $val) {
                $_url .= $domain . Yii::app()->createUrl('/questions/view', array('id' => $val['id'], 'urlPrefix' => $val['urlPrefix'])) . PHP_EOL;
            }
        }
        if (in_array($table, array('all', 'search'))) {
            $sql = "SELECT id,hash FROM {{search_records}} WHERE status=1 {$where} ORDER BY id ASC";
            $posts = Yii::app()->db->createCommand($sql)->queryAll();
            foreach ($posts as $val) {
                $_url .= $domain . Yii::app()->createUrl('/search/do', array('logCode' => $val['hash'])) . PHP_EOL;
            }
        }
        if (in_array($table, array('all', 'tags'))) {
            $sql = "SELECT id,`name`,classify FROM {{tags}} WHERE isDisplay=1 ORDER BY id ASC";
            $posts = Yii::app()->db->createCommand($sql)->queryAll();
            foreach ($posts as $val) {
                $_url .= $domain . Yii::app()->createUrl('/index/index', array('colName' => $val['name'])) . PHP_EOL;
            }
        }
        if (in_array($table, array('all', 'columns'))) {
            $sql = "SELECT id,`name` FROM {{column}} WHERE status=1 ORDER BY id ASC";
            $posts = Yii::app()->db->createCommand($sql)->queryAll();
            foreach ($posts as $val) {
                $_url .= $domain . Yii::app()->createUrl('/index/index', array('colName' => $val['name'])) . PHP_EOL;
            }
        }
        $this->render('urls', array(
            'urls' => $_url,
            'startTime' => $startTime,
            'endTime' => $endTime,
        ));
    }

    public function actionUpdateStat() {
        $now = zmf::now();
        $today = strtotime(zmf::time($now, 'Y-m-d'), $now);
        for ($i = 1; $i <= 10; $i++) {
            $_today = $today - 86400 * ($i - 1);
            $_yesterday = $_today - 86400;
        }
        echo 'well done!!';
    }

    public function actionLogs() {
        $select = "id,uid,logid,classify,content,cTime";
        $model = new AdminLogs;
        $criteria = new CDbCriteria();
        $uid = zmf::val("uid", 2);
        if ($uid) {
            $criteria->addCondition("uid='$uid'");
        }        
        $classify = zmf::val("table", 1);
        if ($classify) {
            $criteria->addCondition("classify='$classify'");
        }
        $logid = zmf::val("logid", 2);
        if ($logid) {
            $criteria->addCondition("logid='$logid'");
        }
        $startTime = zmf::val('startTime', 1);
        $endTime = zmf::val('endTime', 1);
        $now = zmf::now();
        if ($startTime) {
            $startTime = strtotime(zmf::time(strtotime($startTime, $now),'Y/m/d'),$now);
            if($startTime){
                $criteria->addCondition("cTime>='{$startTime}'");
            }
        }
        if ($endTime) {
            $endTime = strtotime(zmf::time(strtotime($endTime, $now),'Y/m/d'),$now) + 86399;
            if($endTime){
                $criteria->addCondition("cTime<='{$endTime}'");
            }
        }
        $criteria->select = $select;
        $criteria->order = 'id DESC';
        $count = $model->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 30;
        $pager->applyLimit($criteria);
        $posts = $model->findAll($criteria);
        $this->render('logs', array(
            'pages' => $pager,
            'posts' => $posts,
            'model' => $model,
            'startTime' => $startTime,
            'endTime' => $endTime,
        ));
    }
    
    public function actionStatLogs(){
        $select = "id,uid,logid,classify,content,cTime";
        $model = new AdminLogs;
        $criteria = new CDbCriteria();
        $uid = zmf::val("uid", 2);
        if ($uid) {
            $criteria->addCondition("uid='$uid'");
        }        
        $startTime = zmf::val('startTime', 1);
        $endTime = zmf::val('endTime', 1);
        $now = zmf::now();
        if ($startTime) {
            $startTime = strtotime(zmf::time(strtotime($startTime, $now),'Y/m/d'),$now);
            if($startTime){
                $criteria->addCondition("cTime>='{$startTime}'");
            }
        }
        if ($endTime) {
            $endTime = strtotime(zmf::time(strtotime($endTime, $now),'Y/m/d'),$now) + 86399;
            if($endTime){
                $criteria->addCondition("cTime<='{$endTime}'");
            }
        }
        $posts = $model->findAll($criteria);
        $userTotal=$userTotalLogs=$classify=$users=[];
        foreach($posts as $post){
            $userTotal[$post['uid']]+=1;
            $userTotalLogs[$post['uid']][$post['classify']][$post['classify'].$post['logid']]+=1;
            $classify[$post['classify']][$post['classify'].$post['logid']]+=1;
        }
        foreach($userTotalLogs as $k=>$item){
            foreach($item as $_k=>$_item){
                $item[$_k]=count($_item);
            }
            $userTotalLogs[$k]=$item;
        }
        foreach ($classify as $key => $_classify) {
            $classify[$key]=count($_classify);
        }
        $uids=join(',', array_keys($userTotal));
        if($uids!=''){
            $_users= Users::model()->findAll("id IN({$uids})");
            $users= CHtml::listData($_users, 'id', 'truename');
        }
        $this->render('statLogs',array(
            'userTotal'=>$userTotal,
            'userTotalLogs'=>$userTotalLogs,
            'classify'=>$classify,
            'users'=>$users,
        ));        
    }

}
