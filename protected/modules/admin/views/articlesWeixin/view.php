<?php
/**
 * @filename ArticlesWeixinController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2019 阿年飞少 
 * @datetime 2019-07-26 20:54:56 */
$this->renderPartial('_nav'); 
$this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
		'id',
		'user_id',
		'title',
		'content',
		'cTime',
		'status',
		'score',
    ),
)); 