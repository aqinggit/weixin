<?php
/**
 * @filename AnswersController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-09-27 08:15:35 
 */
if(Yii::app()->user->hasFlash('addAnswersSuccess')){
    echo '<div class="alert alert-danger">'.Yii::app()->user->getFlash('addAnswersSuccess').'</div>';
}
$this->renderPartial('_form', array('model'=>$model)); ?>