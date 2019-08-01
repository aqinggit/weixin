<?php
/**
 * @filename VolunteersController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2019 阿年飞少 
 * @datetime 2019-08-01 22:51:23 */
 ?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'volunteers-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($model); ?>
    <div class="form-group">
        <?php echo $form->labelEx($model,'username'); ?>
        
        <?php echo $form->textField($model,'username',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'username'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'password'); ?>
        
        <?php echo $form->textField($model,'password',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'password'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'truename'); ?>
        
        <?php echo $form->textField($model,'truename',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'truename'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'cTime'); ?>
        
        <?php echo $form->textField($model,'cTime',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'cTime'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'score'); ?>
        
        <?php echo $form->textField($model,'score',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'score'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'status'); ?>
        
        <?php echo $form->textField($model,'status',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'status'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'email'); ?>
        
        <?php echo $form->textField($model,'email',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'email'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'cardIdType'); ?>
        
        <?php echo $form->textField($model,'cardIdType',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'cardIdType'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'cardId'); ?>
        
        <?php echo $form->textField($model,'cardId',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'cardId'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'sex'); ?>
        
        <?php echo $form->textField($model,'sex',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'sex'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'birthday'); ?>
        
        <?php echo $form->textField($model,'birthday',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'birthday'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'phone'); ?>
        
        <?php echo $form->textField($model,'phone',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'phone'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'politics'); ?>
        
        <?php echo $form->textField($model,'politics',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'politics'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'nation'); ?>
        
        <?php echo $form->textField($model,'nation',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'nation'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'address'); ?>
        
        <?php echo $form->textField($model,'address',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'address'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'education'); ?>
        
        <?php echo $form->textField($model,'education',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'education'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'work'); ?>
        
        <?php echo $form->textField($model,'work',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'work'); ?>
    </div>
    <div class="form-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '更新',array('class'=>'btn btn-primary')); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->