
<?php
/** 
 * @filename NotificationController.php  
 * @Description 
 * @author 阿年飞少 <ph7pal@qq.com>  
 * @link http://www.newsoul.cn  
 * @copyright Copyright©2017 阿年飞少  
 * @datetime 2017-08-09 09:49:11 
 */ 
$this->renderPartial('_nav');
?>
<div class="form"> 
<?php $form=$this->beginWidget('CActiveForm', array( 
    'id'=>'notification-form', 
    'enableAjaxValidation'=>false, 
)); ?>
<?php echo $form->errorSummary($model); ?>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon">搜索</span>
            <?php $this->widget('CAutoComplete', array(
            'name'=>'username',
            'url'=>array('users/search'),
            'multiple'=>false,
            'htmlOptions'=>array('class'=>"form-control",'placeholder'=>'用户昵称/手机号/邮箱'),
            'methodChain'=>".result(function(event,item){var uid=item[1];var name=item[0];var phone=item[2];$('#".(CHtml::activeId($model, 'authorid'))."').val(uid);})",
            )); ?>
            <?php echo $form->hiddenField($model,'authorid',array('class'=>'form-control')); ?>                    
        </div>
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