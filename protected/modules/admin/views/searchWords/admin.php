<?php
/**
 * @filename SearchWordsController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2018 阿年飞少 
 * @datetime 2018-02-08 06:26:51 */
$this->renderPartial('_nav'); 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'search-words-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'url',
		'order',
		'cTime',
		'updateTime',
		'status',
		'color',
            array(
                    'class'=>'CButtonColumn',
            ),
	),
)); 