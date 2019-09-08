<?php
/**
 * @filename _nav.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2019 阿年飞少 
 * @datetime 2019-09-09 00:00:30 */
$c = Yii::app()->getController()->id;
$a = Yii::app()->getController()->getAction()->id;
$this->menu = array(
    '列表' => array(
        'link' => array('index'),
        'active' => in_array($a, array('index'))
    ),
    '新增' => array(
        'link' => array('create'),
        'active' => in_array($a, array('create'))
    ),
);
$this->breadcrumbs=array(
    '管理中心',
    '答题记录'=>array($c.'/index')
);
if($a=='create'){
    $this->breadcrumbs[]='新增';
}elseif($a=='update'){
    $this->breadcrumbs[]='更新';
}