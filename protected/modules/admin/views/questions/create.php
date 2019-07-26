<?php

/**
 * @filename QuestionsController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-09-27 08:15:52 */
$this->renderPartial('_nav');
if (Yii::app()->user->hasFlash('addQuestionsSuccess')) {
    echo '<div class="alert alert-danger">' . Yii::app()->user->getFlash('addQuestionsSuccess') . '</div>';
}
$this->renderPartial('_form', array('model' => $model,'tags'=>$tags,'contentImgs'=>$contentImgs));