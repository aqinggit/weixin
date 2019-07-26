<?php
/**
 * @filename TdkController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-07-18 07:08:03 */
$this->renderPartial('_nav'); 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tdk-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'uid',
		'title',
		'desc',
		'keywords',
		'position',
		'cTime',
            array(
                    'class'=>'CButtonColumn',
            ),
	),
)); 