<?php
/**
 * @filename LinksController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2016 阿年飞少 
 * @datetime 2016-12-06 15:32:40 */
 ?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'links-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($model); ?>
    <div class="form-group">
        <?php echo $form->labelEx($model,'title'); ?>        
        <?php echo $form->textField($model,'title',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'url'); ?>        
        <?php echo $form->textField($model,'url',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'url'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'position'); ?>
        <?php echo $form->textField($model,'position', array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'position'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'logo'); ?>
        <p><img src="<?php echo Attachments::faceImg($model->faceId, 'a120');?>" alt="修改头像" id="user-avatar" style="width: 120px;height: 120px;"></p>
        <?php $this->renderPartial('/common/_singleUpload',array('model'=>$model,'fieldName'=>'faceId','type'=>'faceImg','fileholder'=>'filedata','targetHolder'=>'user-avatar','imgsize'=>'a120','progress'=>true));?>
        <?php echo $form->hiddenField($model,'faceId',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'logo'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'platform'); ?>        
        <?php echo $form->dropDownlist($model,'platform',  Links::exPlatform('admin'),array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'platform'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'status'); ?>        
        <?php echo $form->dropDownlist($model,'status', zmf::yesOrNo('admin'),array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'status'); ?>
    </div>
    <div class="form-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '更新',array('class'=>'btn btn-primary')); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->