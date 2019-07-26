<?php
/**
 * @filename TdkController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-07-18 07:08:03 
 */
$uploadurl=Yii::app()->createUrl('/attachments/upload',array('type'=>'posts','imgsize'=>'c650.jpg'));
 ?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tdk-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($model); ?>
    <div class="form-group">
        <?php echo $form->labelEx($model,'url'); ?>        
        <?php echo $form->textField($model,'url',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'url'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'title'); ?>        
        <?php echo $form->textField($model,'title',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'desc'); ?>        
        <?php echo $form->textArea($model,'desc',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'desc'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'keywords'); ?>        
        <?php echo $form->textField($model,'keywords',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'keywords'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'navContent'); ?>        
        <?php echo $form->textArea($model,'navContent',array('class'=>'form-control','rows'=>6)); ?>
        <?php echo $form->error($model,'navContent'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'content'); ?>    
        <?php $this->renderPartial('//common/editor_um', array('model' => $model,'content' => $model->content,'uploadurl'=>$uploadurl)); ?>
        <?php echo $form->error($model,'content'); ?>
    </div>    
    <div class="form-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '更新',array('class'=>'btn btn-primary','id'=>'add-post-btn')); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->