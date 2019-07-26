<?php
/**
 * @filename NotificationController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-03-17 21:57:43 */
$this->renderPartial('_nav'); 
$this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
		'id',
		'uid',
		'type',
		'new',
		'authorid',
		'author',
		'content',
		'cTime',
		'from_id',
		'from_idtype',
		'from_num',
    ),
)); 