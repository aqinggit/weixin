<?php

/**
 * @filename TagsController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2015 阿年飞少 
 * @datetime 2016-1-4  12:54:36 
 */
class AttachmentsController extends Admin {

    public function init() {
        parent::init();
        $this->checkPower('attachments');
    }

    public function actionIndex() {
        $criteria = new CDbCriteria();
        $criteria->order = 't.cTime DESC';
        $criteria->condition = 't.status!=' . Posts::STATUS_DELED;
        $criteria->select = 't.id,t.uid,t.remote';
        $tagids = zmf::val('tagid', 1);
        $tagids = array_unique(array_filter(explode(',', $tagids)));
        $_limitIdsArr = $selectedTags = array();
        if (!empty($tagids)) {
            foreach ($tagids as $k => $_tagid) {
                if ($k > 0 && empty($_limitIdsArr)) {
                    break;
                }
                if ($k == 0) {
                    $_sql = 'SELECT a.id,a.uid FROM {{attachments}} a,{{tag_relation}} tr WHERE tr.tagid="' . $_tagid . '" AND tr.classify="img" AND a.status!=3 AND tr.logid=a.id';
                    $_items = Yii::app()->db->createCommand($_sql)->queryAll();
                    $_limitIdsArr = array_keys(CHtml::listData($_items, 'id', 'uid'));
                } else {
                    $_limitIds = join(',', $_limitIdsArr);
                    if (!$_limitIds) {
                        $_limitIdsArr = array();
                        break;
                    }
                    $_sql = 'SELECT a.id,a.uid FROM {{attachments}} a,{{tag_relation}} tr WHERE tr.tagid="' . $_tagid . '" AND tr.classify="img" AND a.status!=3 AND tr.logid IN(' . $_limitIds . ') AND tr.logid=a.id';
                    $_items = Yii::app()->db->createCommand($_sql)->queryAll();
                    $_limitIdsArr = array_keys(CHtml::listData($_items, 'id', 'uid'));
                }
            }
            $idsStr = join(',', $_limitIdsArr);
            if ($idsStr != '') {
                $criteria->condition = 't.id IN(' . $idsStr . ')';
            } else {
                $criteria->condition = 't.id=0';
            }
            $_sql2 = 'SELECT id,title FROM {{tags}} WHERE id IN(' . (join(',', $tagids)) . ')';
            $selectedTags = Yii::app()->db->createCommand($_sql2)->queryAll();
        }
        $criteria->order='cTime DESC';
        $count = Attachments::model()->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 80;
        $pager->applyLimit($criteria);
        $posts = Attachments::model()->findAll($criteria);
        foreach ($posts as $k => $val) {
            $posts[$k]['filePath'] = zmf::getThumbnailUrl($val['remote'], 'a120');
        }
        //所有标签
        //$tags=Tags::getAllTags();
        $this->render('index', array(
            'pages' => $pager,
            'posts' => $posts,
            'tags' => $tags,
            'selectedTags' => $tagids,
            'selectedTagsArr' => $selectedTags,
        ));
    }

    public function actionSetImgAlt() {
        if (!$this->isAjax) {
            $this->jsonOutPut(0, '不被允许的操作');
        }
        $id = zmf::val('id', 2);
        $alt = zmf::val('content', 1);
        if (!$id) {
            $this->jsonOutPut(0, '缺少参数');
        }
        if (Attachments::model()->updateByPk($id, array('fileDesc' => $alt))) {
            $this->jsonOutPut(1, '已更新');
        } else {
            $this->jsonOutPut(0, '更新失败，可能是未做修改');
        }
    }

    public function actionAjaxSelect() {
        if (!Yii::app()->request->isAjaxRequest) {
            $this->jsonOutPut(0, '不被允许的操作');
        }
        $from = zmf::val('from', 1);
        $_page = zmf::val('page', 2);
        $page = $_page < 1 ? 1 : $_page;
        $limit = 35;
        $start = ($page - 1) * $limit;
        $tagids = zmf::val('tagids', 1);
        $album = zmf::val('album', 2);
        $tagids = array_unique(array_filter(explode(',', $tagids)));
        $_limitIdsArr = $selectedTags = array();
        $idsStr = $tagIdstr = '';
        if (!empty($tagids)) {
            $tagIdstr = join(',', $tagids);
            foreach ($tagids as $k => $_tagid) {
                if ($k > 0 && empty($_limitIdsArr)) {
                    break;
                }
                if ($k == 0) {
                    $_sql = 'SELECT a.id,a.uid FROM {{attachments}} a,{{tag_relation}} tr WHERE tr.tagid="' . $_tagid . '" AND tr.classify="img" AND a.status!=3 AND tr.logid=a.id';
                    $_items = Yii::app()->db->createCommand($_sql)->queryAll();
                    $_limitIdsArr = array_keys(CHtml::listData($_items, 'id', 'uid'));
                } else {
                    $_limitIds = join(',', $_limitIdsArr);
                    if (!$_limitIds) {
                        $_limitIdsArr = array();
                        break;
                    }
                    $_sql = 'SELECT a.id,a.uid FROM {{attachments}} a,{{tag_relation}} tr WHERE tr.tagid="' . $_tagid . '" AND tr.classify="img" AND a.status!=3 AND tr.logid IN(' . $_limitIds . ') AND tr.logid=a.id';
                    $_items = Yii::app()->db->createCommand($_sql)->queryAll();
                    $_limitIdsArr = array_keys(CHtml::listData($_items, 'id', 'uid'));
                }
            }
            $idsStr = join(',', $_limitIdsArr);
        }
        if (!empty($tagids) && !$idsStr) {
            $items = array();
        } elseif ($idsStr != '') {
            if ($album) {
                $sql = 'SELECT a.id,f.id AS logid,a.remote FROM {{attachments}} a,{{favorites}} f WHERE f.album=' . $album . ' AND f.classify="img" AND f.logid=a.id AND a.id IN(' . $idsStr . ') ' .  ' ORDER BY f.cTime ASC';
            } else {
                $sql = "SELECT id,remote FROM {{attachments}} WHERE id IN({$idsStr})" . " AND classify!='poi' AND `status`=1 ORDER BY cTime DESC LIMIT $start,$limit";
            }
            $items = Yii::app()->db->createCommand($sql)->queryAll();
        } else {
            if ($album) {
                $sql = 'SELECT a.id,f.id AS logid,a.remote FROM {{attachments}} a,{{favorites}} f WHERE f.album=' . $album . ' AND f.classify="img" AND f.logid=a.id' . ' ORDER BY f.cTime ASC';
            } else {
                $sql = "SELECT id,remote FROM {{attachments}} WHERE classify!='poi'" . " AND `status`=1 ORDER BY cTime DESC LIMIT $start,$limit";
            }
            $items = Yii::app()->db->createCommand($sql)->queryAll();
        }
        if (empty($items)) {
            $this->jsonOutPut(0, '没有更多了');
        }
        foreach ($items as $k => $val) {
            $items[$k]['thumbnail'] = zmf::getThumbnailUrl($val['remote'], 'a120');
        }
        $pages = [];
        if ($page > 1) {
            $pages[] = array(
                'title' => '上一页',
                'url' => Yii::app()->createUrl('admin/attachments/ajaxSelect', array('page' => ($page - 1), 'tagids' => $tagIdstr))
            );
        }
        for ($i = $page - 5; $i < $page; ++$i) {
            if ($i < 1) {
                continue;
            }
            $pages[] = array(
                'title' => $i,
                'url' => Yii::app()->createUrl('admin/attachments/ajaxSelect', array('page' => $i, 'tagids' => $tagIdstr)),
                'active' => $i == $page
            );
        }
        $yu = 10 - count($pages);
        if (count($items) == $limit) {
            for ($i = $page; $i < $page + $yu + 1; ++$i) {
                if ($i < 1) {
                    continue;
                }
                $pages[] = array(
                    'title' => $i,
                    'url' => Yii::app()->createUrl('admin/attachments/ajaxSelect', array('page' => $i, 'tagids' => $tagIdstr)),
                    'active' => $i == $page
                );
            }
            $pages[] = array(
                'title' => '下一页',
                'url' => Yii::app()->createUrl('admin/attachments/ajaxSelect', array('page' => ($page + 1), 'tagids' => $tagIdstr))
            );
        }
        $html = $this->renderPartial('ajaxHtml', array(
            'posts' => $items,
            'from' => $from,
            'pages' => $pages,
                ), true);
        $data = array(
            'html' => $html,
            'status' => 1
        );
        echo CJSON::encode($data);
    }

    public function actionAjaxTags() {
        if (!$this->isAjax) {
            $this->jsonOutPut(0, '不被允许的操作');
        }
        //我的收藏夹
        $albums = [];
        $html = $this->renderPartial('_ajaxTags', array(
            'tags' => $tags,
            'albums' => $albums,
                ), true);
        $data = array(
            'html' => $html,
            'status' => 1
        );
        echo CJSON::encode($data);
    }

    public function actionDetail() {
        $id = zmf::val('id', 2);
        if (!$id) {
            $this->jsonOutPut(0, '缺少参数');
        }
        $info = Attachments::model()->findByPk($id);
        if (!$info) {
            $this->jsonOutPut(0, '页面不存在');
        }
        //取标签
        $sql = 'SELECT tr.id AS logid,t.id,t.title FROM {{tags}} t,{{tag_relation}} tr WHERE tr.classify='.Column::CLASSIFY_IMAGE.' AND tr.logid=' . $id . ' AND tr.tagid=t.id';
        $tags = Yii::app()->db->createCommand($sql)->queryAll();
        $arr = array(
            'id' => $id,
            'size' => $info['size'],
            'width' => $info['width'],
            'height' => $info['height'],
            'cTime' => $info['cTime'],
            'fileDesc' => $info['fileDesc'],
            'username' => $info->userInfo->truename,
            'thumbnail' => zmf::getThumbnailUrl($info['remote'], 'c650.jpg'),
            'imgUrl' => zmf::getThumbnailUrl($info['remote'], 'original'),
            'tags' => $tags,
            'allTags' => $allTags
        );
        $html = $this->renderPartial('/attachments/_html', array('data' => $arr), true);
        $this->jsonOutPut(1, $html);
    }

    public function actionDelTag() {
        $logid = zmf::val('id', 2);
        if (!$logid) {
            $this->jsonOutPut(0, '缺少参数');
        }
        if (TagRelation::model()->deleteByPk($logid)) {
            $this->jsonOutPut(1, '已删除');
        }
        $this->jsonOutPut(0, '未知错误，可能是已经删除');
    }

    public function actionDelTags() {
        $logid = zmf::val('id', 2);
        if (!$logid) {
            $this->jsonOutPut(0, '缺少参数');
        }
        if (TagRelation::model()->deleteAll('logid=:logid AND classify="img"', array(':logid' => $logid))) {
            $this->jsonOutPut(1, '已删除');
        }
        $this->jsonOutPut(0, '未知错误，可能是已经删除');
    }

    public function actionAddTag() {
        $imgId = zmf::val('imgId', 2);
        $tagid = zmf::val('tagid', 2);
        if (!$imgId || !$tagid) {
            $this->jsonOutPut(0, '缺少参数');
        }
        $tagInfo = Tags::model()->findByPk($tagid);
        if (!$tagInfo) {
            $this->jsonOutPut(0, '标签不存在');
        }
        $model = new TagRelation();
        $reInfo = $model->find('logid=:logid AND tagid=:tagid AND classify=:classify', array(
            ':logid' => $imgId,
            ':tagid' => $tagid,
            ':classify' => 'img'
        ));
        if ($reInfo) {
            $this->jsonOutPut(0, '已添加过了');
        }
        $model->attributes = array(
            'logid' => $imgId,
            'tagid' => $tagid,
            'classify' => 'img'
        );
        if ($model->save()) {
            $this->jsonOutPut(1, '<span class="tag_item" id="tag_item-' . $model->id . '">' . $tagInfo['title'] . ' <a href="javascript:;" onclick="removeImgTag(' . $model->id . ')" class="color-grey"><i class="fa fa-remove"></i></a></span>');
        }
        $this->jsonOutPut(0, '未知错误，添加失败');
    }

    public function actionAddMultiTag() {
        $imgIds = zmf::val('imgIds', 1);
        $tagids = zmf::val('tagids', 1);
        $imgIds = array_unique(array_filter(explode(',', $imgIds)));
        $tagids = array_unique(array_filter(explode(',', $tagids)));
        if (!$imgIds || !$tagids) {
            $this->jsonOutPut(0, '缺少参数');
        }
        foreach ($imgIds as $imgId) {
            foreach ($tagids as $tagid) {
                $_attr = array(
                    'logid' => $imgId,
                    'tagid' => $tagid,
                    'classify' => 'img'
                );
                if (!TagRelation::model()->findByAttributes($_attr)) {
                    $_model = new TagRelation;
                    $_model->attributes = $_attr;
                    $_model->save();
                }
            }
        }
        $this->jsonOutPut(1, '已添加');
    }

    public function actionDelMultiTag() {
        $imgIds = zmf::val('imgIds', 1);
        $imgIds = array_unique(array_filter(explode(',', $imgIds)));
        if (!$imgIds) {
            $this->jsonOutPut(0, '缺少参数');
        }
        $str = join(',', $imgIds);
        if (!$str) {
            $this->jsonOutPut(0, '缺少参数');
        }
        if (Attachments::model()->updateAll(array('status' => Posts::STATUS_DELED), 'id IN(' . $str . ')')) {
            $this->jsonOutPut(1, '已添加');
        }
        $this->jsonOutPut(0, '删除失败');
    }
    
    public function actionMultiDel() {
        $imgIds = zmf::val('imgIds', 1);
        $imgIds = array_unique(array_filter(explode(',', $imgIds)));
        if (!$imgIds) {
            $this->jsonOutPut(0, '缺少参数');
        }
        $str = join(',', $imgIds);
        if (!$str) {
            $this->jsonOutPut(0, '缺少参数');
        }
        if (Attachments::model()->updateAll(array('status' => Posts::STATUS_DELED), 'id IN(' . $str . ') AND isDisplay=0')) {
            $this->jsonOutPut(1, '已删除');
        }
        $this->jsonOutPut(0, '删除失败');
    }

    public function actionUpdateRemote() {
        $_page = zmf::val('page', 2);
        $page = $_page < 1 ? 1 : $_page;
        $limit = 100;
        $start = ($page - 1) * $limit;
        $sql = "select id,filePath,classify,cTime from {{attachments}} WHERE remote='' ORDER BY id ASC LIMIT $start,$limit";
        $items = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($items)) {
            $this->redirect(array('index'));
        }
        foreach ($items as $item) {
            $_remote = zmf::uploadDirs($item['cTime'], 'site', $item['classify']) . $item['filePath'];
            Attachments::model()->updateByPk($item['id'], array(
                'remote' => $_remote
            ));
        }
        $this->message(1, '即将处理第' . ($page + 1) . '页', Yii::app()->createUrl('admin/attachments/updateRemote'), 0);
    }

}
