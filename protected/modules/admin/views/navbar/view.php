<?php
/**
 * @filename NavbarController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2018 阿年飞少 
 * @datetime 2018-02-06 13:05:46 */
$this->renderPartial('_nav'); 
$this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
		'id',
		'title',
		'url',
		'order',
		'cTime',
		'updateTime',
		'status',
		'target',
		'nofollow',
		'isHot',
		'isNew',
    ),
)); 