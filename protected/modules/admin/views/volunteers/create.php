<?php
/**
 * @filename VolunteersController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2019 阿年飞少 
 * @datetime 2019-08-01 22:51:23 */
$this->renderPartial('_nav'); 
if(Yii::app()->user->hasFlash('addVolunteersSuccess')){
    echo '<div class="alert alert-danger">'.Yii::app()->user->getFlash('addVolunteersSuccess').'</div>';
}
$this->renderPartial('_form', array('model'=>$model)); ?>