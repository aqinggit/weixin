<?php
/**
 * @filename VolunteersController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2019 阿年飞少 
 * @datetime 2019-08-01 22:51:23 */
$this->renderPartial('_nav'); 
$this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
		'id',
		'name',
		'password',
		'truename',
		'cTime',
		'score',
		'status',
		'email',
		'cardIdType',
		'cardId',
		'sex',
		'birthday',
		'phone',
		'politics',
		'nation',
		'address',
		'education',
		'work',
    ),
)); 