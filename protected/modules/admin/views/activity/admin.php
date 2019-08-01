<?php
/**
 * @filename ActivityController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2019 阿年飞少 
 * @datetime 2019-08-01 21:51:07 */
$this->renderPartial('_nav'); 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'activity-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'content',
		'cTime',
		'status',
		'activityTime',
		'place',
		'uid',
		'score',
		'faceImg',
            array(
                    'class'=>'CButtonColumn',
            ),
	),
)); 