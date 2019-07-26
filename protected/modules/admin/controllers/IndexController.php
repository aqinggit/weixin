<?php

class IndexController extends Admin {

    public function init() {
        parent::init();
        $this->checkPower('login');
    }

    public function actionIndex() {
        $statStrs = 'articles,questions,answers,date';
        $stats = SiteStat::model()->findAll(array(
            'select' => $statStrs,
            'limit' => 10,
            'order' => 'date DESC'
        ));
        $stats = CJSON::decode(CJSON::encode($stats));
        $stats = zmf::multi_array_sort($stats, 'date', SORT_ASC);
        $statStrArr = explode(',', $statStrs);
        $data["statStrArr"] = $statStrArr;
        $data['stats'] = $stats;
        $this->render('index', $data); 
    }

    public function actionStat() {
        $arr['articles'] = Articles::model()->count();
        $arr['questions'] = Questions::model()->count();
        
        $arr['comments'] = Comments::model()->count();
        $arr['favorites'] = Favorites::model()->count();
        $arr['feedbacks'] = Feedback::model()->count();
        $arr['users'] = Users::model()->count();
        $arr['attachments'] = Attachments::model()->count();
        $this->render('stat', $arr);
    }
    
    public function actionInfo(){
        $arr['serverSoft'] = $_SERVER['SERVER_SOFTWARE'];
        $arr['serverOS'] = PHP_OS;
        $arr['PHPVersion'] = PHP_VERSION;
        $arr['fileupload'] = ini_get('file_uploads') ? ini_get('upload_max_filesize') : '禁止上传';
        $dbsize = 0;
        $connection = Yii::app()->db;
        $sql = 'SHOW TABLE STATUS LIKE \'' . $connection->tablePrefix . '%\'';
        $command = $connection->createCommand($sql)->queryAll();
        foreach ($command as $table) {
            $dbsize += $table['Data_length'] + $table['Index_length'];
        }
        $mysqlVersion = $connection->createCommand("SELECT version() AS version")->queryAll();
        $arr['mysqlVersion'] = $mysqlVersion[0]['version'];
        $arr['dbsize'] = $dbsize ? zmf::formatBytes($dbsize) : '未知';
        $arr['serverUri'] = $_SERVER['SERVER_NAME'];
        $arr['maxExcuteTime'] = ini_get('max_execution_time') . ' 秒';
        $arr['maxExcuteMemory'] = ini_get('memory_limit');
        $arr['excuteUseMemory'] = function_exists('memory_get_usage') ? zmf::formatBytes(memory_get_usage()) : '未知';
        zmf::test($arr);
    }

}
