<?php
/**
 * @filename QuestionsController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2019 阿年飞少 
 * @datetime 2019-08-04 09:58:00 */
$this->renderPartial('_nav'); 
if(Yii::app()->user->hasFlash('addQuestionsSuccess')){
    echo '<div class="alert alert-danger">'.Yii::app()->user->getFlash('addQuestionsSuccess').'</div>';
}
$this->renderPartial('_form', array('model'=>$model)); ?>