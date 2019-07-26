<?php
/**
 * @filename _nav.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2018 阿年飞少 
 * @datetime 2018-02-06 13:05:46 */
$c = Yii::app()->getController()->id;
$a = Yii::app()->getController()->getAction()->id;
$this->breadcrumbs=array(
    '管理中心',
    '导航'=>array($c.'/index')
);
if($a=='create'){
    $this->breadcrumbs[]='新增';
}elseif($a=='update'){
    $this->breadcrumbs[]='更新';
}