<?php

/**
 * @filename _nav.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2015 阿年飞少 
 * @datetime 2016-1-4  15:38:01 
 */
$c = Yii::app()->getController()->id;
$a = Yii::app()->getController()->getAction()->id;
$this->breadcrumbs=array(
    '管理中心',
    '用户'=>array($c.'/index')
);
if($a=='create'){
    $this->breadcrumbs[]='新增';
}elseif($a=='update'){
    $this->breadcrumbs[]='更新';
}