<?php

class TempController extends Admin {

    public function actionIntoColumns() {
        $_page = zmf::val('page', 2);
        $page = $_page < 1 ? 1 : $_page;
        $limit = 100;
        $start = ($page - 1) * $limit;
        $sql = "select * from yzj_category ORDER BY id ASC LIMIT $start,$limit";
        $items = Yii::app()->oldDb->createCommand($sql)->queryAll();
        if (empty($items)) {
            exit('well done!!');
        }
        foreach ($items as $item) {
            $_attr = array(
                'id' => $item['id'],
                'belongid' => $item['pid'],
                'title' => "'" . mysql_escape_string($item['title']) . "'",
                'name' => "'" . mysql_escape_string($item['name']) . "'",
                'classify' => Column::CLASSIFY_POST,
                'seoTitle' => "'" . mysql_escape_string($item['meta_title']) . "'",
                'seoDesc' => "'" . mysql_escape_string($item['description']) . "'",
                'seoKeywords' => "'" . mysql_escape_string($item['keywords']) . "'",
                'rankTitle' => "'" . mysql_escape_string($item['rank_title']) . "'",
                'rankDesc' => "'" . mysql_escape_string($item['rank_description']) . "'",
                'rankKeywords' => "'" . mysql_escape_string($item['rank_keywords']) . "'",
            );
            $_str = 'INSERT INTO pre_column SET ';
            $i = 1;
            $len = count($_attr);
            foreach ($_attr as $_k => $v) {
                $_str .= "{$_k}=" . $v;
                if ($i != $len) {
                    $_str .= ',';
                }
                ++$i;
            }
            $_str .= ';';
            Yii::app()->db->createCommand($_str)->execute();
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/temp/intoColumns', array('page' => ($page + 1))));
    }

    public function actionIntoArticles() {
        ini_set("max_execution_time", "0");
        ini_set('memory_limit', '256M');
        $_page = zmf::val('page', 2);
        $page = $_page < 1 ? 1 : $_page;
        $limit = 100;
        $start = ($page - 1) * $limit;
        $sql = "select * from yzj_document WHERE model_id=2 ORDER BY id ASC LIMIT $start,$limit";
        $items = Yii::app()->oldDb->createCommand($sql)->queryAll();
        if (empty($items)) {
            exit('well done!!');
        }
        foreach ($items as $item) {
            //取正文
            $_sql = "SELECT content FROM yzj_document_article WHERE id=" . $item['id'];
            $_info = Yii::app()->oldDb->createCommand($_sql)->queryRow();
            if (!$_info) {
                continue;
            }
            $_attr = array(
                'typeId' => $item['category_id'],
                'uid' => $item['uid'],
                'title' => $item['title'],
                'desc' => $item['description'],
                'faceId' => $item['cover_id'],
                'hits' => mt_rand(100, 300),
                'cTime' => $item['create_time'],
                'updateTime' => $item['update_time'],
                'status' => $item['display'],
                'content' => $_info['content'],
                'tags' => $item['keywords'],
                'sourceUrl' => $item['getdatabyurl'],
            );
            $_model = new Articles();
            $_model->attributes = $_attr;
            if ($_model->save()) {
                
            } else {
                zmf::test($_model->getErrors());
            }
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/temp/intoArticles', array('page' => ($page + 1))), 0);
    }    

    public function actionIntoTags() {
        $_page = zmf::val('page', 2);
        $table = zmf::val('table', 1);
        if (!in_array($table, array('article', 'product', 'question'))) {
            $table = 'article';
        }
        $page = $_page < 1 ? 1 : $_page;
        $limit = 100;
        $start = ($page - 1) * $limit;
        if ($table == 'article') {
            $sql = "select id,tags from {{articles}} WHERE tags!='' ORDER BY id ASC LIMIT $start,$limit";
            $classify = Column::CLASSIFY_POST;
            $sep = ',';
        } elseif ($table == 'question') {
            $sql = "select id,tagids AS tags from {{questions}} WHERE tagids!='' ORDER BY id ASC LIMIT $start,$limit";
            $classify = Column::CLASSIFY_QUESTION;
            $sep = ',';
        }
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($items)) {
            if ($table == 'article') {
                $this->redirect(array('intoTags', 'table' => 'product'));
            } elseif ($table == 'product') {
                $this->redirect(array('intoTags', 'table' => 'question'));
            }
            exit('well done!!');
        }
        foreach ($items as $item) {
            if (!$item['tags']) {
                continue;
            }
            $_arr = array_filter(explode($sep, $item['tags']));
            foreach ($_arr as $_tag) {
                Tags::findAndAdd($_tag, $classify, $item['id']);
            }
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/temp/intoTags', array('page' => ($page + 1), 'table' => $table)), 0);
    }

    public function actionIntoPic() {
        ini_set("max_execution_time", "0");
        ini_set('memory_limit', '256M');
        $_page = zmf::val('page', 2);
        $page = $_page < 1 ? 1 : $_page;
        $limit = 100;
        $start = ($page - 1) * $limit;
        $sql = "select * from yzj_picture ORDER BY id ASC LIMIT $start,$limit";
        $items = Yii::app()->oldDb->createCommand($sql)->queryAll();
        if (empty($items)) {
            exit('well done!!');
        }
        foreach ($items as $item) {
            $_attr = array(
                'id' => $item['id'],
                'filePath' => "'" . '/Uploads/Picture/2/' . $item['path'] . "'",
                'classify' => "'" . $item['types'] . "'",
                'cTime' => $item['create_time']
            );
            $_str = 'INSERT INTO pre_attachments SET ';
            $i = 1;
            $len = count($_attr);
            foreach ($_attr as $_k => $v) {
                $_str .= "{$_k}=" . $v;
                if ($i != $len) {
                    $_str .= ',';
                }
                ++$i;
            }
            $_str .= ';';
            Yii::app()->db->createCommand($_str)->execute();
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/temp/intoPic', array('page' => ($page + 1))), 0);
    }

    public function actionUpdatePic() {
        $_page = zmf::val('page', 2);
        $table = zmf::val('table', 1);
        if (!in_array($table, array('article', 'product'))) {
            $table = 'article';
        }
        $page = $_page < 1 ? 1 : $_page;
        $limit = 100;
        $start = ($page - 1) * $limit;
        if ($table == 'article') {
            $sql = "select id,content from {{articles}} ORDER BY id ASC LIMIT $start,$limit";
            $classify = Column::CLASSIFY_POST;
            $sep = ',';
            $pattern = "/<[img|IMG].*?src=[\'|\"](.*?)[\'|\"].*?alt=[\'|\"](.*?)[\'|\"].*?[\/]?>/";
        } else {
            $sql = "select id,content from {{product_content}} ORDER BY id ASC LIMIT $start,$limit";
            $classify = Column::CLASSIFY_PRODUCT;
            $sep = ' ';
            $pattern = "/<[img|IMG].*?src=[\'|\"](.*?)[\'|\"].*?[\/]?>/";
        }
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($items)) {
            exit('well done!!');
        }
        foreach ($items as $item) {
            $imgs = $_imgs = $matchImgs = array();
            preg_match_all($pattern, $item['content'], $imgs);            
            if (!empty($imgs[0])) {
                foreach ($imgs[1] as $k=>$_val) {
                    $matchImgs[] = array(
                        'key'=>$imgs[0][$k],
                        'src'=>$_val,
                        'desc'=>$imgs[2][$k],
                    );
                }
            }
            if ($table == 'article') {
                $_pattern = "/<[img|IMG].*?src=[\'|\"](.*?)[\'|\"].*?[\/]?>/";
                preg_match_all($_pattern, $item['content'], $_imgs);
                if (!empty($_imgs[0])) {
                    foreach ($_imgs[1] as $k=>$_val) {
                        $matchImgs[] = array(
                            'key'=>$_imgs[0][$k],
                            'src'=>$_val
                        );
                    }
                }
            }
            foreach ($matchImgs as $_src) {
                $_attachAttr = array(
                    'logid' => $item['id'],
                    'classify' => $classify,
                    'filePath' => $_src['src'],
                    'fileDesc' => $_src['desc'],
                );
                $_modelAttach = new Attachments();
                $_modelAttach->attributes = $_attachAttr;
                if ($_modelAttach->save()) {
                    $_content = '[attach]' . $_modelAttach->id . '[/attach]';
                    $item['content'] = str_replace($_src['key'], $_content, $item['content']);
                }
            }
            $_info = Posts::handleContent($item['content']);            
            if ($table == 'article') {
                Articles::model()->updateByPk($item['id'], array('content' => $_info['content']));
            } else {
                ProductContent::model()->updateByPk($item['id'], array('content' => $_info['content']));
            }            
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/temp/updatePic', array('page' => ($page + 1), 'table' => $table)), 0);
    }

    public function actionIntoQuestions() {
        $_page = zmf::val('page', 2);
        $page = $_page < 1 ? 1 : $_page;
        $limit = 100;
        $start = ($page - 1) * $limit;
        $sql = "select * from yzj_faq_question ORDER BY id ASC LIMIT $start,$limit";
        $items = Yii::app()->oldDb->createCommand($sql)->queryAll();
        if (empty($items)) {
            exit('well done!!');
        }
        foreach ($items as $item) {
            //取正文
            $_sql = "SELECT * FROM yzj_faq_answer WHERE questionid=" . $item['id'];
            $_answers = Yii::app()->oldDb->createCommand($_sql)->queryAll();
            $_attr = array(
                'uid' => Users::getRandomId(),
                'typeId' => $item['category_id'],
                'title' => $item['title'],
                'content' => $item['content'],
                'cTime' => $item['create_time'],
                'updateTime' => $item['update_time'],
                'status' => $item['status'],
                'hits' => mt_rand(100, 300),
                'tagids' => $item['keywords'],
                'answers' => $item['answercount']
            );
            $_model = new Questions();
            $_model->attributes = $_attr;
            if ($_model->save()) {
                foreach ($_answers as $_answer) {
                    $_aattr = array(
                        'uid' => Users::getRandomId(),
                        'qid' => $_model->id,
                        'content' => $_answer['content'],
                        'status' => $_answer['status'],
                        'isBest' => $item['bestanswerid'] == $_answer['id'] ? 1 : 0,
                        'cTime' => $_answer['create_time'],
                        'updateTime' => $_answer['update_time'],
                    );
                    $_mmodel = new Answers;
                    $_mmodel->attributes = $_aattr;
                    if ($_mmodel->save()) {
                        if ($item['bestanswerid'] == $_answer['id']) {
                            $_model->updateByPk($_model->id, array(
                                'bestAid' => $_mmodel->id
                            ));
                        }
                    }
                }
            }
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/temp/intoQuestions', array('page' => ($page + 1))), 0);
    }

    public function actionIntoBrands() {
        $_page = zmf::val('page', 2);
        $page = $_page < 1 ? 1 : $_page;
        $limit = 100;
        $start = ($page - 1) * $limit;
        $sql = "select * from yzj_subdomain_brand ORDER BY id ASC LIMIT $start,$limit";
        $items = Yii::app()->oldDb->createCommand($sql)->queryAll();
        if (empty($items)) {
            exit('well done!!');
        }
        foreach ($items as $item) {
            $_attr = array(
                'faceImg' => $item['icon'],
                'title' => $item['title'],
                'description' => $item['jianshu'],
                'content' => $item['introduction'],
                'seoTitle' => $item['meta_title'],
                'seoDesc' => $item['description'],
                'seoKeywords' => $item['keywords'],
                'cTime' => $item['create_time'],
                'updateTime' => $item['create_time'],
            );
            $_model = new ProductBrands();
            $_model->attributes = $_attr;
            if ($_model->save(false)) {
                
            } else {
                zmf::test($_model->getErrors());
            }
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/temp/intoBrands', array('page' => ($page + 1))), 0);
    }

    public function actionIntoColumnTdk() {
        $columns = Column::model()->findAll();
        foreach ($columns as $column) {
            if (!$column['seoTitle']) {
                continue;
            }
            if ($column['classify'] == Column::CLASSIFY_POST) {
                $poi = 'article';
            } elseif ($column['classify'] == Column::CLASSIFY_PRODUCT) {
                $poi = 'product';
            } elseif ($column['classify'] == Column::CLASSIFY_QUESTION) {
                $poi = 'question';
            }
            $_attr = array(
                'title' => $column['seoTitle'],
                'desc' => $column['seoDesc'],
                'keywords' => $column['seoKeywords'],
                'position' => $poi,
                'classify' => 'column',
                'logid' => $column['id'],
            );
            $_model = new Tdk;
            $_model->attributes = $_attr;
            $_model->save();
        }
        exit('well done');
    }

    public function actionIntoUsers() {
        ini_set("max_execution_time", "0");
        ini_set('memory_limit', '256M');
        $_page = zmf::val('page', 2);
        $page = $_page < 1 ? 1 : $_page;
        $limit = 10;
        $start = ($page - 1) * $limit;
        $items = file(Yii::app()->basePath.'/runtime/users.txt');
        $posts=array_slice($items,$start,$limit);
        if (empty($posts)) {
            exit('well done!!');
        }
        foreach ($posts as $item) {
            $_arr=array_filter(explode('#',$item));
            if(count($_arr)!=2){
                continue;
            }
            $_arr[1]=trim($_arr[1]);
            $_avatar=tools::getWeixinImg($_arr[1],'avatar');
            if(!$_avatar){
                continue;
            }
            $_attr = array(
                'truename'=>trim($_arr[0]),
                'avatar'=>$_avatar,
                'password'=>'zmf',
            );
            $_model=new Users();
            $_model->attributes=$_attr;
            $_model->save();
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/temp/intoUsers', array('page' => ($page + 1))), 1);
    }

}
