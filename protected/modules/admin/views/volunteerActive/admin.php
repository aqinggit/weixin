<?php
/**
 * @filename VolunteerActiveController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2019 阿年飞少 
 * @datetime 2019-08-07 09:24:37 */
$this->renderPartial('_nav'); 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'volunteer-active-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'vid',
		'aid',
		'score',
		'cTime',
		'status',
            array(
                    'class'=>'CButtonColumn',
            ),
	),
)); 