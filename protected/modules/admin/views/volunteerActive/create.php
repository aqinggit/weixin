<?php
/**
 * @filename VolunteerActiveController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2019 阿年飞少 
 * @datetime 2019-08-07 09:24:37 */
$this->renderPartial('_nav'); 
if(Yii::app()->user->hasFlash('addVolunteerActiveSuccess')){
    echo '<div class="alert alert-danger">'.Yii::app()->user->getFlash('addVolunteerActiveSuccess').'</div>';
}
$this->renderPartial('_form', array('model'=>$model)); ?>