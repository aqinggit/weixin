<?php
/**
 * @filename AnswersController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-09-27 08:15:35 */
$this->renderPartial('_nav'); 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'answers-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'uid',
		'qid',
		'content',
		'favors',
		'platform',
		'status',
		'isBest',
		'hits',
		'comments',
		'cTime',
		'updateTime',
            array(
                    'class'=>'CButtonColumn',
            ),
	),
)); 