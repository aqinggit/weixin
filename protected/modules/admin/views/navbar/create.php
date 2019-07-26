<?php
/**
 * @filename NavbarController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2018 阿年飞少 
 * @datetime 2018-02-06 13:05:46 */
$this->renderPartial('_nav'); 
if(Yii::app()->user->hasFlash('addNavbarSuccess')){
    echo '<div class="alert alert-danger">'.Yii::app()->user->getFlash('addNavbarSuccess').'</div>';
}
$this->renderPartial('_form', array('model'=>$model)); ?>