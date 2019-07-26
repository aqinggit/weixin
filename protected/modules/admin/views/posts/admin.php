<?php
/**
 * @filename PostsController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2016 阿年飞少 
 * @datetime 2016-11-04 10:52:11 */
$this->renderPartial('_nav'); 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'posts-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'colid',
		'uid',
		'title',
		'keywords',
		'content',
		'faceImg',
		'faceUrl',
		'classify',
		'comments',
		'favorites',
		'top',
		'hits',
		'tagids',
		'status',
		'cTime',
		'updateTime',
            array(
                    'class'=>'CButtonColumn',
            ),
	),
)); 