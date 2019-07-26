<?php

/**
 * @filename ArticlesController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-10-14 08:37:28 */
$this->renderPartial('_nav');
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'typeId',
        'areaId',
        'fid',
        'uid',
        'title',
        'desc',
        'faceImg',
        'hits',
        'comments',
        'favorites',
        'digest',
        'top',
        'cTime',
        'status',
        'props',
        'urlPrefix',
        'seoTitle',
        'seoDesc',
        'seoKeywords',
        'tagids',
        'content',
    ),
));
