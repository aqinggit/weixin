<?php
/**
 * @filename ActivityController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2019 阿年飞少 
 * @datetime 2019-08-01 21:51:07 */
$this->renderPartial('_nav'); 
if(Yii::app()->user->hasFlash('addActivitySuccess')){
    echo '<div class="alert alert-danger">'.Yii::app()->user->getFlash('addActivitySuccess').'</div>';
}
$this->renderPartial('_form', array('model'=>$model)); ?>