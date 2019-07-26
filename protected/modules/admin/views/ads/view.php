<?php
/**
 * @filename AdsController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2016 阿年飞少 
 * @datetime 2016-07-25 04:22:45 */
 
$this->breadcrumbs=array(
	'Ads'=>array('index'),
	$model->title,
);

$this->menu=array(
    array('label'=>'List Ads', 'url'=>array('index')),
    array('label'=>'Create Ads', 'url'=>array('create')),
    array('label'=>'Update Ads', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Delete Ads', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
    array('label'=>'Manage Ads', 'url'=>array('admin')),
);
?>
<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
		'id',
		'uid',
		'title',
		'description',
		'url',
		'faceimg',
		'faceUrl',
		'startTime',
		'expiredTime',
		'position',
		'classify',
		'hits',
		'order',
		'status',
		'cTime',
    ),
)); ?>