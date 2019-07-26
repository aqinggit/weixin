<?php

/**
 * @filename _nav.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-07-18 07:08:03 */
$c = Yii::app()->getController()->id;
$a = Yii::app()->getController()->getAction()->id;
$this->breadcrumbs = array(
    '管理中心',
    '敏感词' => array($c . '/index')
);
if ($a == 'create') {
    $this->breadcrumbs[] = '新增';
} elseif ($a == 'update') {
    $this->breadcrumbs[] = '更新';
}