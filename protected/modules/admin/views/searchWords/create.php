<?php
/**
 * @filename SearchWordsController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2018 阿年飞少 
 * @datetime 2018-02-08 06:26:51 */
$this->renderPartial('_nav'); 
if(Yii::app()->user->hasFlash('addSearchWordsSuccess')){
    echo '<div class="alert alert-danger">'.Yii::app()->user->getFlash('addSearchWordsSuccess').'</div>';
}
$this->renderPartial('_form', array('model'=>$model)); ?>