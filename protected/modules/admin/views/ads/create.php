<?php

/**
 * @filename AdsController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2016 阿年飞少 
 * @datetime 2016-07-25 04:22:45 
 */
$this->renderPartial('_nav');
if (Yii::app()->user->hasFlash('addAdsSuccess')) {
    echo '<div class="alert alert-danger">' . Yii::app()->user->getFlash('addAdsSuccess') . '</div>';
}
$this->renderPartial('_form', array('model' => $model));
