<?php
/**
 * @filename AreaController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-11-16 13:49:15 */
$this->renderPartial('_nav'); 
if(Yii::app()->user->hasFlash('addAreaSuccess')){
    echo '<div class="alert alert-danger">'.Yii::app()->user->getFlash('addAreaSuccess').'</div>';
}
$this->renderPartial('_form', array('model'=>$model)); ?>