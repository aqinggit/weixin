<?php
/**
 * @filename ActivityController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2019 阿年飞少 
 * @datetime 2019-08-01 21:51:07 */
 ?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'activity-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($model); ?>
    <div class="form-group">
        <?php echo $form->labelEx($model,'id'); ?>
        
        <?php echo $form->textField($model,'id',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'id'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'title'); ?>
        
        <?php echo $form->textField($model,'title',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'content'); ?>
        
        <?php echo $form->textField($model,'content',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'content'); ?>
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
        <?php echo $form->labelEx($model,'activityTime'); ?>
        
        <?php echo $form->textField($model,'activityTime',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'activityTime'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'place'); ?>
        
        <?php echo $form->textField($model,'place',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'place'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'uid'); ?>
        
        <?php echo $form->textField($model,'uid',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'uid'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'score'); ?>
        
        <?php echo $form->textField($model,'score',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'score'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'faceImg'); ?>
        
        <?php echo $form->textField($model,'faceImg',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'faceImg'); ?>
    </div>
    <div class="form-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '更新',array('class'=>'btn btn-primary')); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->