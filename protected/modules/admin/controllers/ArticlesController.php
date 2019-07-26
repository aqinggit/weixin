<?php

/**
 * @filename ArticlesController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-10-14 08:37:28 */
class ArticlesController extends Admin {
    public function init() {
        parent::init();
        $this->checkPower('articles');
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($id = '') {
        $now = zmf::now();
        if ($id) {
            $this->checkPower('updateArticles');
            $model = $this->loadModel($id);
            if ($model->status == Posts::STATUS_DELED) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
            if(!$model->hits){
                $model->hits = mt_rand(100, 300);
            }
        } else {
            $model = new Articles;
            $model->hits = mt_rand(100, 300);
            $model->uid = Users::getRandomId();
            $model->status = Posts::STATUS_PASSED;
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Articles'])) {
            $tags = isset($_POST['tags']) ? array_unique(array_filter($_POST['tags'])) : array();
            //处理文本
            $filterTitle = Posts::handleContent($_POST['Articles']['title'], FALSE);
            $filterContent = Posts::handleContent($_POST['Articles']['content']);
            $attr = $_POST['Articles'];
            $attr['title'] = $filterTitle['content'];
            $attr['content'] = $filterContent['content'];
            $attkeys = array();
            //如果没有上传封面图
            if (!$attr['faceId'] && !empty($filterContent['attachids'])) {
                $attkeys = array_filter(array_unique($filterContent['attachids']));
                if (!empty($attkeys)) {
                    $attr['faceImg'] = Attachments::faceImg($attkeys[0], ''); //默认将文章中的第一张图作为封面图
                    $attr['faceId'] = $attkeys[0];
                }
            } elseif ($attr['faceId']) {
                $attr['faceImg'] = Attachments::faceImg($attr['faceId'], ''); //默认将文章中的第一张图作为封面图
            }
            if ($attr['cTime']) {
                $attr['cTime'] = strtotime($attr['cTime'], $now);
            }
            $model->attributes = $attr;
            if ($model->save()) {
                //保存标签
                $tags = array_unique($tags);
                if (!empty($tags)) {
                    foreach ($tags as $_tagid) {
                        $_tgAttr = array(
                            'logid' => $model->id,
                            'tagid' => $_tagid,
                            'classify' => Column::CLASSIFY_POST
                        );
                        if (TagRelation::addRelation($_tgAttr)) {
                            $realTags[] = $_tagid;
                        }
                        //将标签绑定到图片上
                        if (!empty($filterContent['attachids'])) {
                            foreach ($filterContent['attachids'] as $_imgid) {
                                $_attr = array(
                                    'logid' => $_imgid,
                                    'tagid' => $_tagid,
                                    'classify' => Column::CLASSIFY_IMAGE
                                );
                                TagRelation::addRelation($_attr);
                            }
                        }
                    }
                }
                //将上传的图片置为通过
                Attachments::model()->updateAll(array('status' => Posts::STATUS_DELED), 'logid=:logid AND classify=:classify', array(':logid' => $model->id, ':classify' => Column::CLASSIFY_POST));
                if (!empty($attkeys)) {
                    $attstr = join(',', $attkeys);
                    $attstr= zmf::filterIds($attstr);
                    if ($attstr != '') {
                        Attachments::model()->updateAll(array('status' => Posts::STATUS_PASSED, 'logid' => $model->id), 'id IN(' . $attstr . ')');
                    }
                }
                //自动加标签
                Tags::addContentLinks(array(
                    'title' => $model->title,
                    'content' => $model->content
                        ), Column::CLASSIFY_POST, $model->id, false);
                $realTags = array_unique(array_filter($realTags));
                $_postTagids = join(',', $realTags);
                $model->updateByPk($model->id, array('tagids' => $_postTagids));

                //更新路径
                Articles::updateUrlPrefix($model->id);

                if (!$id) {
                    AdminLogs::addLog(array(
                        'logid' => $model->id,
                        'classify' => 'article',
                        'content' => '新增文章',
                    ));
                } else {
                    $_info = AdminLogs::addLog(array(
                                'logid' => $model->id,
                                'classify' => 'article',
                                'content' => '更新文章',
                    ));
                }
                $this->redirect(array('index', 'id' => $model->id));
            }
        }
        $contentImgs = $weixinImgs = [];
        if ($id) {
            preg_match_all("/\[attach\](\d+)\[\/attach\]/i", $model['content'], $match);
            $imgIds = join(',', array_unique(array_filter($match[1])));
            if ($imgIds != '') {
                $_sql = 'SELECT id,remote,fileDesc FROM {{attachments}} WHERE id IN(' . $imgIds . ')';
                $contentImgs = Yii::app()->db->createCommand($_sql)->queryAll();
                foreach ($contentImgs as $key => $value) {
                    $contentImgs[$key]['remote'] = zmf::getThumbnailUrl($value['remote'], 'a120');
                }
            }

            $model['content'] = str_replace(array(
                '[wximg]</p>',
                '[wximg]</h1>',
                '[wximg]</strong>',
                    ), array(
                '[/wximg]</p>',
                '[/wximg]</h1>',
                '[/wximg]</strong>',
                    ), $model['content']);
            preg_match_all("/\[wximg\](.*?)\[\/wximg\]/si", $model['content'], $match);
            foreach ($match[1] as $k => $url) {
                $weixinImgs[] = $url;
                $model['content'] = str_replace($match[0][$k], '<p>图片' . ($k + 1) . '</p>', $model['content']);
            }
            $model->content = zmf::text(array('action' => 'edit'), $model['content'], false, 'c650.jpg');
        }
        $this->render('create', array(
            'model' => $model,
            'tags' => $tags,
            'contentImgs' => $contentImgs,
            'weixinImgs' => $weixinImgs,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $this->actionCreate($id);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->checkPower('delArticles');
        $info = $this->loadModel($id);
        if ($info['status'] == Posts::STATUS_PASSED) {
            $this->jsonOutPut(0, '已通过内容不能删除');
        }
        $info->updateByPk($id, array('status' => Posts::STATUS_DELED));
        AdminLogs::addLog(array(
            'logid' => $id,
            'classify' => 'article',
            'content' => '删除文章',
        ));
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if ($this->isAjax) {
            $this->jsonOutPut(1, '已删除');
        } else {
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    public function actionGetByAjax() {
        if (!$this->isAjax) {
            $this->jsonOutPut(0, '不被允许');
        }
        $type = zmf::val('type', 1);
        $url = zmf::val('url', 1);
        if ($type == '360') {
            Yii::import('application.vendors.Curl.*');
            require_once 'Curl.php';
            $res = new Curl();
            $html = $res->get($url);
            preg_match('/<div\s+class="resolved-cnt.*?[^>]>(.*?)<\/div>/si', $html, $matches);
            $content = $this->_replace($matches[1]);
            $this->jsonOutPut(1, $content);
        } elseif ($type == 'sogou') {
            $html = zmf::curlSogouWenwen($url);
            preg_match_all('/<pre\s+class="replay\-info\-txt.*?[^>]>(.*?)<\/pre>/si', $html, $matches);
            $content = '';
            foreach ($matches[1] as $val) {
                $content .= strip_tags($val) . PHP_EOL;
            }
            $this->jsonOutPut(1, $content);
        }
        $this->jsonOutPut(0, '不被允许的分类');
    }

    private function _replace($content){
        $content=htmlspecialchars_decode($content);
        $content=str_replace(array(
            '<p></p>',
            '</p>',
            '&nbsp;',
            ' ',
            '@@',
        ),array(
            '',
            '</p>@',
            '',
            '',
            '@',
        ),$content);
        $content=strip_tags($content);
        $content=str_replace(array(
            '@',
            '	',
        ),array(
            PHP_EOL,
            ''
        ),$content);
        return $content;
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $select = "id,typeId,areaId,uid,title,hits,comments,favorites,cTime,status,urlPrefix,toTime";
        $model = new Articles;
        $criteria = new CDbCriteria();
        $id = zmf::val("id", 2);
        if ($id) {
            $criteria->addCondition("id=" . $id);
        }
        $uid = zmf::val("uid", 2);
        if ($uid) {
            $criteria->addCondition("uid=" . $uid);
        }
        $typeId = zmf::val("typeId", 1);
        if ($typeId) {
            $criteria->addCondition("typeId=" . $typeId);
        }
        $title = trim(zmf::val("title", 1));
        if ($title) {
            $titleArr = array_filter(explode('+', $title));
            if (!empty($titleArr)) {
                foreach ($titleArr as $t) {
                    $criteria->addSearchCondition("title", $t);
                }
            }
        }
        $now=zmf::now();
        $startTime = zmf::val("startTime", 1);
        if ($startTime) {
            $startTime=strtotime($startTime,$now);
            $criteria->addCondition("cTime>=" . $startTime);
        }
        $endTime = zmf::val("endTime", 1);
        if ($endTime) {
            $endTime=strtotime($endTime,$now);
            $endTime+=86399;
        }
        if($endTime){
            $criteria->addCondition("cTime<=" . $endTime);
        }
        $status = zmf::val("status", 2);
        if ($status) {
            $criteria->addCondition("status='$status'");
        } else {
            $criteria->addCondition('status!=' . Posts::STATUS_DELED);
        }
        $criteria->select = $select;
        $criteria->order = 'id DESC';
        $count = $model->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 30;
        $pager->applyLimit($criteria);
        $posts = $model->findAll($criteria);
        //取出现的用户
        $sql="SELECT u.id,u.truename FROM {{users}} u,{{articles}} p WHERE p.uid=u.id GROUP BY p.uid";
        $users=zmf::dbAll($sql);
        $users=CHtml::listData($users,'id','truename');

        $this->render('index', array(
            'pages' => $pager,
            'posts' => $posts,
            'model' => $model,
            'startTime' => $startTime,
            'endTime' => $endTime,
            'users' => $users,
        ));
    }

    public function actionSetStatus($id) {
        $info = $this->loadModel($id);
        $type = zmf::val('type', 1);
        if (!in_array($type, array('passed'))) {
            throw new CHttpException(403, '不被允许的操作');
        }
        $attr=[];
        if ($type == 'passed') {
            $now=zmf::now();
            $attr=array(
                'status'=>Posts::STATUS_PASSED,
                'cTime'=>$info->cTime>0 ? $info->cTime : $now,
                'updateTime'=>$now,
                'uid'=>$info->uid>0 ? $info->uid : $this->uid,
            );
            $status = Posts::STATUS_PASSED;
        }
        //更新路径
        $info->updateByPk($id, $attr);
        Articles::updateUrlPrefix($info['id']);
        AdminLogs::addLog(array(
            'logid' => $id,
            'classify' => 'article',
            'content' => '通过文章',
        ));
        if ($this->isAjax) {
            $this->jsonOutPut(1, '已标记');
        } else {
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    /**
     * 更新文章路径
     */
    public function actionUpdateUrl() {
        $_page = zmf::val('page', 2);
        $page = $_page < 1 ? 1 : $_page;
        $limit = 100;
        $start = ($page - 1) * $limit;
        $sql = "select id,areaId,typeId from {{articles}} WHERE status=1 ORDER BY id ASC LIMIT $start,$limit";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($items)) {
            $this->redirect(array('index'));
        }
        foreach ($items as $item) {
            Articles::updateUrlPrefix($item['id']);
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/articles/updateUrl', array('page' => ($page + 1))), 1);
    }

    /**
     * 更新文章所属栏目
     */
    public function actionUpdateColumn() {
        $_page = zmf::val('page', 2);
        $_refresh = zmf::val('refresh', 2);
        $page = $_page < 1 ? 1 : $_page;
        $refresh = $_refresh < 1 ? 1 : $_refresh;
        $limit = 10;
        $start = ($page - 1) * $limit;
        $sql = "select id,title,nickname from {{column}} ORDER BY id ASC LIMIT $start,$limit";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($items)) {
            $this->redirect(array('index'));
        }
        foreach ($items as $item) {
            $_tagArr = array_unique(array_filter(explode(',', $item['nickname'])));
            $_tagArr[] = $item['title'];
            $_arr = array_filter(array_unique($_tagArr));
            foreach ($_arr as $_title) {
                $_sql = 'UPDATE {{articles}} set typeId="' . $item['id'] . '" WHERE typeId=0 AND title LIKE "%' . $_title . '%"';
                Yii::app()->db->createCommand($_sql)->execute();
            }
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/articles/updateColumn', array('page' => ($page + 1))), 0);
    }

    /**
     * 根据文章内容更新文章所属栏目
     */
    public function actionUpdateColumn2() {
        $_page = zmf::val('page', 2);
        $_refresh = zmf::val('refresh', 2);
        $page = $_page < 1 ? 1 : $_page;
        $refresh = $_refresh < 1 ? 1 : $_refresh;
        $limit = 10;
        $start = ($page - 1) * $limit;
        $sql = "select id,content from {{articles}} ORDER BY id ASC LIMIT $start,$limit";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($items)) {
            $this->redirect(array('index'));
        }
        $sql = "select id,title,nickname from {{column}}";
        $columns = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($items as $item) {
            $fid = 0;
            foreach ($columns as $col) {
                $_tagArr = array_unique(array_filter(explode(',', $col['nickname'])));
                $_tagArr[] = $col['title'];
                $_arr = array_filter(array_unique($_tagArr));
                foreach ($_arr as $_title) {
                    if (strpos($item['content'], $_title) !== false) {
                        $fid = $col['id'];
                        break(2);
                    }
                }
            }
            if ($fid) {
                Articles::model()->updateByPk($item['id'], array(
                    'typeId' => $fid
                ));
            }
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/articles/updateColumn2', array('page' => ($page + 1))), 0);
    }

    public function actionRemoveA() {
        $_page = zmf::val('page', 2);
        $page = $_page < 1 ? 1 : $_page;
        $limit = 100;
        $start = ($page - 1) * $limit;
        $sql = "select id,content from {{articles}} WHERE content like '%[/link]%' ORDER BY id ASC LIMIT $start,$limit";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($items)) {
            $this->redirect(array('index'));
        }
        foreach ($items as $item) {
            $_content = preg_replace("/\[link=([^\]]+?)\](.+?)\[\/link\]/i", "$2", $item['content']);
            //$_content=preg_replace("/\[url=([^\]]+?)\](.+?)\[\/url\]/i", "$2", $_content);
            Articles::model()->updateByPk($item['id'], array('content' => $_content));
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/articles/removeA'), 0);
    }

    public function actionUpdateTagIds() {
        $_page = zmf::val('page', 2);
        $page = $_page < 1 ? 1 : $_page;
        $limit = 100;
        $start = ($page - 1) * $limit;
        $sql = "select id from {{articles}} ORDER BY id ASC LIMIT $start,$limit";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($items)) {
            $this->redirect(array('index'));
        }
        foreach ($items as $item) {
            $_items = TagRelation::model()->findAll(array(
                'condition' => 'logid=:logid AND classify=' . Column::CLASSIFY_POST,
                'params' => array(
                    ':logid' => $item['id']
                ),
                'select' => 'id,tagid'
            ));
            Articles::model()->updateByPk($item['id'], array(
                'tagids' => join(',', CHtml::listData($_items, 'id', 'tagid'))
            ));
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/articles/updateTagIds', array('page' => ($page + 1))), 0);
    }

    public function actionCaiji() {
        set_time_limit(0);
        $sourceUrl = zmf::val('url', 1);
        if (!$sourceUrl) {
            $this->message(0, '请输入网址');
        }
        $ch = curl_init();
        // 设置浏览器的特定header
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Host: mp.weixin.qq.com",
            "Connection: keep-alive",
            "Accept: image/webp,image/apng,image/*,*/*;q=0.8",
            "Upgrade-Insecure-Requests: 1",
            "DNT:1",
            "Accept-Language: zh-CN,zh;q=0.9,en;q=0.8",
            'Cookie:pgv_pvi=5030221824; pgv_si=s2662455296; RK=aSeeRxtLdZ; LW_sid=U1G4F8k746D87116p8O932B300; LW_uid=l1v4q837d6R8d1g67889e2R3V1; qv_swfrfh=www.87g.com; qv_swfrfc=v20; qv_swfrfu=http://www.87g.com/wzry/9503.html; account=chuxcw; cert=eCxJOyvJTzkoCRPQ1OzZoeCt0fCezmUL; _qpsvr_localtk=0.15933102426382706; eas_sid=k1x4B9B5Z7G2u3e0T6d141u012; pgv_info=ssid=s308612767&pgvReferrer=; pgv_pvid=2366253344; ts_uid=8646473693; ptcz=abc6776623c227925e9679d97765a6f0885e2c3fa90d7a8c88a70b37394f3c82; pt2gguin=o0419126376; ua_id=r7lXVWVkaqaCuVfKAAAAAOEK9Ntld4yQBiUF4BVyZl8=; mm_lang=zh_CN; noticeLoginFlag=1; ptisp=cnc; uin=o0419126376; rv2=806780E72C1456FA9746AE14223009FA6B20C313A60F50A152; property20=1F887FE9D6D2DD8DA675B609A6A0F0CFC2A01A26EE9CCA8F3ED6CBD537F462A712D7051819C01B05; sig=h0112b7d12e5eb825547aa2f2f6bf88ec098a929f0e949b36b796ceb96d65631da2b30de6c0ad01abcf; ptui_loginuin=419126376; skey=@LVIJLxA3X; uuid=652795ad2203922d64c6efbef17fa21a; slave_user=gh_8836ef3cb75c; bizuin=3508492333; ticket=bca8d5725e0d549a41cb0c0144690f689ba4173e; ticket_id=gh_8836ef3cb75c; data_bizuin=3508492333; data_ticket=gcsMSjS1Azl261LQw2Pi5CX+mgXBgV/+XpxxgIpFt0D6QDV/353dtkdXOaCEPQH2; slave_sid=aldZRmFKa1dJWl9BNVBhRHBONXVPcjZRSmowRHpmcFlWZ1VJRGJOSmlIWVdXcm1Ed0NLSktUQnFQajBmV0xKczVZU1V3aG12T29hclNCMXBDRTRiV3hXdXNOdTNKY0sybVVZUGREQzBLYlpxYktNdHpjdDRFc3M1ZE9Ja1dzSzI3SlV5M1FURllTYXBiUjlR; xid=8a9864bb6b9d4b87815ad5e30b241210; openid2ticket_oLVgf0a-5efBhztQkFWj9zqNib4E=ZVU0DjoipfZWW9Qr4ybBJup5BfbGdsC8Wk9IKgZbYek=; rewardsn=',
        ));
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0');
        // 在HTTP请求头中"Referer: "的内容。
        curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate, br");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $sourceUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //302redirect
        //如果不是微博的图片，暂且认为是微信图片        
        //针对微信
        curl_setopt($ch, CURLOPT_REFERER, "http://weixin.sogou.com/");
        // 针对https的设置
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        if (!$data) {
            $this->message(0, '抓取失败，请重试', Yii::app()->createUrl('admin/articles/index'));
        }
        preg_match('/\<title\>(.+?)<\/title\>/is', $data, $titleMatch);
        preg_match('/<div class="rich_media_content " id="js_content">(.*?)<\/div>/si', $data, $conMatch);
        //处理标题
        $_title = strip_tags($titleMatch[1]);
        $replace = array(
            '　',
            "...",
            "..",
            "&hellip;",
            "&ldquo;",
            "&rdquo;",
        );
        $_title = str_replace($replace, '', $_title);
        $title = trim(zmf::trimText($_title));
        //处理内容
        $content = $conMatch[1];
        //$pattern = '/<img[\s\S].*?data-src="(.*?)".*?[|\/]>/si';
        $pattern = "/<[img|IMG].*?data-src=[\'|\"](.*?)[\'|\"].*?[\/]?>/si";
        preg_match_all($pattern, $content, $matches);
        foreach ($matches[1] as $k => $v) {
            $content = str_replace($matches[0][$k], '[wximg]' . $v . '[/wximg]', $content);
        }
        $content = strip_tags($content, '<b><strong><p><img><br><br/><h1><h2><h3>');
        $replace = array(
            "/style=\"[^\"]*?\"/i",
            "/<p><span>\&nbsp\;<\/span><\/p>/i",
            "/<p>\&nbsp\;<\/p>/i",
            "/<p><\/p>/i",
            "/　/i",
            "/   /i",
        );
        $to = array(
            ''
        );
        $content = trim(preg_replace($replace, $to, $content));
        $now = zmf::now();
        $attr = array(
            'uid' => 1,
            'title' => $title,
            'content' => $content,
            'status' => Posts::STATUS_STAYCHECK,
            'cTime' => $now,
            'updateTime' => $now,
        );
        $_model2 = new Articles();
        $_model2->attributes = $attr;
        if ($_model2->save(false)) {
            $this->redirect(array('update', 'id' => $_model2->id));
        } else {
            zmf::test($_model2->getErrors());
        }
    }

    public function actionSearch(){
        if (Yii::app()->request->isAjaxRequest && isset($_GET['q'])) {
            $name = trim(zmf::val('q', 1));
            $name = '%' . strtr($name, array('%' => '\%', '_' => '\_', '\\' => '\\\\')) . '%';
            $sql = "SELECT id,title FROM {{articles}} WHERE (title LIKE '$name') AND status=1 LIMIT 10";
            $items = Yii::app()->db->createCommand($sql)->queryAll();
            $returnVal = '';
            foreach ($items as $val) {
                $returnVal .= $val['title'] . '|' . $val['id'] .  "\n";
            }
            echo $returnVal;
        }
    }

    public function actionLinkTags() {
        $_page = zmf::val('page', 2);
        $page = $_page < 1 ? 1 : $_page;
        $limit = 100;
        $start = ($page - 1) * $limit;
        $sql = "select id,title,`desc`,content from {{articles}} ORDER BY id ASC LIMIT $start,$limit";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($items)) {
            $this->redirect(array('index'));
        }
        $tags = Tags::model()->findAll(array(
            'select'=>'id,title,nickname'
        ));
        $_tagArr=[];
        foreach ($tags as $tag) {
            $_tagArrTemp = array_filter(explode(',', $tag['nickname']));
            $_tagArrTemp[] = $tag['title'];
            $_tagArrTemp=array_unique($_tagArrTemp);
            foreach ($_tagArrTemp as $_title){
                $_tagArr[]=array(
                    'id'=>$tag['id'],
                    'title'=>$_title
                );
            }
        }
        foreach ($items as $item) {
            $_content=$item['title'].$item['desc'].$item['content'];
            $_tags = [];
            foreach ($_tagArr as $_tag) {
                if (strpos($_content, $_tag['title']) !== false) {
                    $_tags[] = $_tag;
                }
            }
            if(!empty($_tags)){
                foreach($_tags as $_tag){
                    $_attr = array(
                        'logid' => $item['id'],
                        'classify' => Column::CLASSIFY_POST,
                        'tagid' => $_tag['id'],
                    );
                    $_info = TagRelation::model()->findByAttributes($_attr);
                    if (!$_info) {
                        $_model = new TagRelation;
                        $_model->attributes = $_attr;
                        $_model->save();
                    }
                }
            }
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/articles/linkTags',array('page'=>$page+1)), 0);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Articles('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Articles']))
            $model->attributes = $_GET['Articles'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionTokd($id){
        if($this->uid!=1){
            $this->redirect(['view','id'=>$id]);
        }
        $info=Articles::getOne($id);
        if(!$info){
            $this->jsonOutPut(0, 'not exist');
        }elseif($info['toTime']>0){
            $this->jsonOutPut(0, 'had pushed');
        }
        $token=$this->_getQQToken();
        if(!$token){
            $this->jsonOutPut(0, 'get token failed');
        }
        $url=zmf::config('kd_sync_url').$token;
        $now=zmf::now();
        $content=Posts::kdText($info['content'],'');
        $tags = Tags::getAllByType(Column::CLASSIFY_POST, $info['id']);
        $toTags=array_slice($tags,0,5);
        if(empty($toTags)){
            $this->jsonOutPut(0, '缺少标签');
        }
        $postArr=[
            'appid'=>zmf::config('kd_appid'),
            'timestamp'=>$now,
            'data'=>[
                'puin'=>zmf::config('kd_puin'),
                'title'=>$info['title'],
                'cover'=>zmf::getThumbnailUrl($info['faceImg'],''),
                'content'=>$content,
                'author'=>zmf::config('kd_doc_author'),
                'doc_id'=>zmf::config('kd_doc_pre').$info['id'],
                'doc_class'=>zmf::config('kd_doc_class'),
                'tag'=>join(',',CHtml::listData($toTags,'id','title'))
            ]
        ];
        $json=CJSON::encode($postArr);
        Yii::import('application.vendors.Curl.*');
        require_once 'Curl.php';
        $res = new Curl();
        $result = $res->post($url,$json);
        $arr=CJSON::decode($result,true);
        if($arr['errcode']==0){
            Articles::model()->updateByPk($id,[
                'rowkey'=>$arr['data']['rowkey'],
                'toTime'=>$now,
            ]);
            $this->jsonOutPut(1, '已推送');
        }else{
            zmf::fp($postArr,1);
            zmf::fp($arr,1);
            $this->jsonOutPut(0, $arr['errmsg']);
        }
    }

    private function _getQQToken(){
        $key="some-other-token";
        $token=zmf::getFCache($key);
        if($token){
            return $token;
        }
        $url=zmf::config('kd_token_url');
        $info=zmf::rolling_curl([$url],30,'https://api.mp.qq.com');
        $html=$info[$url]['results']['data'];
        $arr=CJSON::decode($html,true);
        $token='';
        if($arr['errcode']==0){
            $token=$arr['access_token'];
            zmf::setFCache($key,$token,7000);
        }else{
            zmf::test($arr['errmsg']);
            exit();
        }
        return $token;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Articles the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Articles::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Articles $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'articles-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
