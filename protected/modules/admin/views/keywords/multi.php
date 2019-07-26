<?php
/* @var $this TagsController */
/* @var $model Tags */
/* @var $form CActiveForm */
if(Yii::app()->user->hasFlash('addKeywordsSuccess')){
    echo '<div class="alert alert-danger">'.Yii::app()->user->getFlash('addKeywordsSuccess').'</div>';
}
?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'tags-form',
    'enableAjaxValidation'=>false,
)); ?>
    <div class="form-group">
        <label>批量导入关键词</label>
        <?php echo CHtml::textArea('items','',array('rows'=>10,'class'=>'form-control')); ?>
        <p class="help-block">一行一条记录，“关键词#绝对链接”</p>
    </div>
    <div class="form-group">
        <?php echo CHtml::submitButton('新增',array('class'=>'btn btn-primary')); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->