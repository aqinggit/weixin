<?php
/**
 * @filename NotificationController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-03-17 21:57:43 */
 ?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'notification-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($model); ?>
    <div class="form-group">
        <?php echo $form->labelEx($model,'uid'); ?>        
        <?php echo $form->textField($model,'uid',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'uid'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'type'); ?>        
        <?php echo $form->dropDownlist($model,'type',Notification::exTypes('admin'),array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'type'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'content'); ?>        
        <?php echo $form->textArea($model,'content',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'content'); ?>
    </div>
    <div class="form-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '更新',array('class'=>'btn btn-primary')); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->