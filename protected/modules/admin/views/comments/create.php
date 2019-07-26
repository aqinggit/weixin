<?php

/**
 * @filename create.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2015 阿年飞少 
 * @datetime 2017-2-16  14:09:15 
 */
$this->renderPartial('_nav');
?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comments-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($model); ?>
    <div class="form-group">
        <?php echo $form->labelEx($model,'uid'); ?>        
        <div class="input-group">
            <span class="input-group-addon">搜索</span>
            <?php $this->widget('CAutoComplete', array(
            'name'=>'username',
            'url'=>array('users/search'),
            'multiple'=>false,
            'htmlOptions'=>array('class'=>"form-control",'placeholder'=>'用户昵称'.($model->uid>0 ? ',所属：'.$model->authorInfo->truename : '')),
            'methodChain'=>".result(function(event,item){var uid=item[1];var name=item[0];var phone=item[2];$('#".(CHtml::activeId($model, 'uid'))."').val(uid);})",
            )); ?>
            <?php echo $form->hiddenField($model,'uid',array('class'=>'form-control')); ?>                    
        </div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'content'); ?> 
        <?php echo $form->textArea($model,'content',array('class'=>'form-control','rows'=>4)); ?>
        <?php echo $form->error($model,'content'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'status'); ?>        
        <?php echo $form->dropDownlist($model,'status',  Posts::exStatus('admin'),array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'status'); ?>
    </div>
    <div class="form-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '更新',array('class'=>'btn btn-primary','id'=>'add-post-btn')); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->