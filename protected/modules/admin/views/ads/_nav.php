<?php
/**
 * @filename _nav.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2016 阿年飞少 
 * @datetime 2016-11-14 09:08:36 */
//$c = Yii::app()->getController()->id;
$a = Yii::app()->getController()->getAction()->id;
$this->breadcrumbs = array(
    '管理中心',
    '展示图' => array('index')
);
if ($a == 'create') {
    $this->breadcrumbs[] = '新增';
} elseif ($a == 'update') {
    $this->breadcrumbs[] = '更新';
}