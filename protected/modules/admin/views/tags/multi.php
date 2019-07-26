<?php
/* @var $this TagsController */
/* @var $model Tags */
/* @var $form CActiveForm */
if(Yii::app()->user->hasFlash('addTagsSuccess')){
    echo '<div class="alert alert-danger">'.Yii::app()->user->getFlash('addTagsSuccess').'</div>';
}
?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'tags-form',
    'enableAjaxValidation'=>false,
)); ?>
    <?php echo $form->errorSummary($model); ?>
    <div class="form-group">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textArea($model,'title',array('rows'=>10,'class'=>'form-control')); ?>
        <p class="help-block">批量导入同样类型的标签</p>
        <?php echo $form->error($model,'title'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'classify'); ?>
        <?php echo $form->dropDownList($model,'classify', Column::classify('admin'),array('class'=>'form-control','empty'=>'--请选择--')); ?>
        <?php echo $form->error($model,'classify'); ?>
    </div>
    <div class="form-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '保存',array('class'=>'btn btn-primary')); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->