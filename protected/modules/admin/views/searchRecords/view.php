<?php

/**
 * @filename SearchRecordsController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-08-04 08:16:05 */
$this->renderPartial('_nav');
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'title',
        'hash',
        'times',
        'cTime',
        'updateTime',
        'expiredTime',
        'results',
    ),
));
