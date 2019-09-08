<?php
/**
 * @filename QuestionsLogController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2019 阿年飞少 
 * @datetime 2019-09-09 00:00:30 */
 ?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'questions-log-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($model); ?>
    <div class="form-group">
        <?php echo $form->labelEx($model,'id'); ?>
        
        <?php echo $form->textField($model,'id',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'id'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'cTime'); ?>
        
        <?php echo $form->textField($model,'cTime',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'cTime'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'status'); ?>
        
        <?php echo $form->textField($model,'status',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'status'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'phone'); ?>
        
        <?php echo $form->textField($model,'phone',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'phone'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'questions'); ?>
        
        <?php echo $form->textField($model,'questions',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'questions'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'answers'); ?>
        
        <?php echo $form->textField($model,'answers',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'answers'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'ip'); ?>
        
        <?php echo $form->textField($model,'ip',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'ip'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'socre'); ?>
        
        <?php echo $form->textField($model,'socre',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'socre'); ?>
    </div>
    <div class="form-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '更新',array('class'=>'btn btn-primary')); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->