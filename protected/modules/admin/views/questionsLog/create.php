<?php
/**
 * @filename QuestionsLogController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2019 阿年飞少 
 * @datetime 2019-09-09 00:00:30 */
$this->renderPartial('_nav'); 
if(Yii::app()->user->hasFlash('addQuestionsLogSuccess')){
    echo '<div class="alert alert-danger">'.Yii::app()->user->getFlash('addQuestionsLogSuccess').'</div>';
}
$this->renderPartial('_form', array('model'=>$model)); ?>