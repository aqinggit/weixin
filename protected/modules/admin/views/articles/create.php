<?php

/**
 * @filename ArticlesController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-10-14 08:37:28 
 */
$this->renderPartial('_nav');
if (Yii::app()->user->hasFlash('addArticlesSuccess')) {
    echo '<div class="alert alert-danger">' . Yii::app()->user->getFlash('addArticlesSuccess') . '</div>';
}
$this->renderPartial('_form', array(
    'model' => $model, 
    'tags' => $tags,
    'contentImgs'=>$contentImgs,
    'weixinImgs'=>$weixinImgs    
        ));
