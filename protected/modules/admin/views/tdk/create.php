<?php
/**
 * @filename TdkController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-07-18 07:08:03 */
$this->renderPartial('_nav'); 
if(Yii::app()->user->hasFlash('addTdkSuccess')){
    echo '<div class="alert alert-danger">'.Yii::app()->user->getFlash('addTdkSuccess').'</div>';
}
$this->renderPartial('_form', array('model'=>$model)); ?>