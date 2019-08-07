<?php
/**
 * @filename VolunteerActiveController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2019 阿年飞少 
 * @datetime 2019-08-07 09:24:37 */
 ?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'volunteer-active-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($model); ?>
    <div class="form-group">
        <?php echo $form->labelEx($model,'vid'); ?>
        
        <?php echo $form->textField($model,'vid',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'vid'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'aid'); ?>
        
        <?php echo $form->textField($model,'aid',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'aid'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'score'); ?>
        
        <?php echo $form->textField($model,'score',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'score'); ?>
    </div>
    <div class="form-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '更新',array('class'=>'btn btn-primary')); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->