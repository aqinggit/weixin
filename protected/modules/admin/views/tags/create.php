<?php 
$this->renderPartial('/tags/_nav');
if(Yii::app()->user->hasFlash('addTagsSuccess')){
    echo '<div class="alert alert-danger">'.Yii::app()->user->getFlash('addTagsSuccess').'</div>';
}
$this->renderPartial('_form', array('model'=>$model)); 