<?php
/**
 * @filename NotificationController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-03-17 21:57:43 */
$this->renderPartial('_nav'); 
if(Yii::app()->user->hasFlash('addNotificationSuccess')){
    echo '<div class="alert alert-danger">'.Yii::app()->user->getFlash('addNotificationSuccess').'</div>';
}
$this->renderPartial('_form', array('model'=>$model)); ?>