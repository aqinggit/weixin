<?php
/**
 * @filename SearchRecordsController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-08-04 08:16:05 */
$this->renderPartial('_nav'); 
if(Yii::app()->user->hasFlash('addSearchRecordsSuccess')){
    echo '<div class="alert alert-danger">'.Yii::app()->user->getFlash('addSearchRecordsSuccess').'</div>';
}
$this->renderPartial('_form', array('model'=>$model)); ?>