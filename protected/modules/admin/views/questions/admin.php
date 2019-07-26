<?php

/**
 * @filename QuestionsController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-09-27 08:15:52 */
$this->renderPartial('_nav');
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'questions-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        'uid',
        'typeId',
        'areaId',
        'title',
        'faceUrl',
        'seotitle',
        'description',
        'keywords',
        'bestAid',
        'cTime',
        'updateTime',
        'status',
        'hits',
        'tagids',
        'content',
        'urlPrefix',
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));
