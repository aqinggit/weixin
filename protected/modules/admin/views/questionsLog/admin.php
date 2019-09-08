<?php
/**
 * @filename QuestionsLogController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2019 阿年飞少 
 * @datetime 2019-09-09 00:00:30 */
$this->renderPartial('_nav'); 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'questions-log-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'cTime',
		'status',
		'phone',
		'questions',
		'answers',
		'ip',
		'socre',
            array(
                    'class'=>'CButtonColumn',
            ),
	),
)); 