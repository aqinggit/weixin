<?php
/**
 * @filename SearchRecordsController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-08-04 08:16:05 */
 ?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'search-records-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($model); ?>
    <div class="form-group">
        <?php echo $form->labelEx($model,'title'); ?>        
        <?php echo $form->textField($model,'title',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'times'); ?>        
        <?php echo $form->textField($model,'times',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'times'); ?>
    </div>    
    <div class="form-group">
        <?php echo $form->labelEx($model,'results'); ?>        
        <?php echo $form->textField($model,'results',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'results'); ?>
    </div>
    <div class="form-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '更新',array('class'=>'btn btn-primary')); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->