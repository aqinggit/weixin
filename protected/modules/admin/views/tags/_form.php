<?php
/* @var $this TagsController */
/* @var $model Tags */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'tags-form',
    'enableAjaxValidation'=>false,
)); ?>
    <?php echo $form->errorSummary($model); ?>
    <div class="form-group">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'name'); ?>
        <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'classify'); ?>
        <?php echo $form->dropDownList($model,'classify',  Column::classify('admin'),array('class'=>'form-control','empty'=>'--请选择--')); ?>
        <?php echo $form->error($model,'classify'); ?>
    </div>    
    <div class="form-group">
        <?php echo $form->labelEx($model,'nickname'); ?>
        <?php echo $form->textArea($model,'nickname',array('rows'=>6, 'cols'=>50,'class'=>'form-control')); ?>
        <p class="help-block">英文逗号隔开</p>
        <?php echo $form->error($model,'nickname'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'isDisplay'); ?>
        <?php echo $form->dropDownList($model,'isDisplay',  zmf::yesOrNo('admin'),array('class'=>'form-control','empty'=>'--请选择--')); ?>
        <?php echo $form->error($model,'isDisplay'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'toped'); ?>
        <?php echo $form->dropDownList($model,'toped',  zmf::yesOrNo('admin'),array('class'=>'form-control','empty'=>'--请选择--')); ?>
        <?php echo $form->error($model,'toped'); ?>
    </div>
    <div class="form-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '保存',array('class'=>'btn btn-primary')); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->