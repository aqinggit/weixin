<?php
/**
 * @filename ColumnController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2016 阿年飞少 
 * @datetime 2016-05-10 16:32:06 */
$this->renderPartial('_nav');
 ?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'column-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($model); ?>
    <div class="form-group">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'title'); ?>
    </div> 
    <div class="form-group">
        <?php echo $form->labelEx($model,'h2'); ?>
        <?php echo $form->textField($model,'h2',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'h2'); ?>
    </div> 
    <div class="form-group">
        <?php echo $form->labelEx($model,'h3'); ?>
        <?php echo $form->textField($model,'h3',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'h3'); ?>
    </div> 
    <div class="form-group">
        <?php echo $form->labelEx($model,'nickname'); ?>
        <?php echo $form->textArea($model,'nickname',array('rows'=>4,'class'=>'form-control')); ?>
        <p class="help-block">英文“,”隔开</p>
        <?php echo $form->error($model,'nickname'); ?>
    </div> 
    <div class="form-group">
        <?php echo $form->labelEx($model,'seoTitle'); ?>
        <?php echo $form->textArea($model,'seoTitle',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'seoTitle'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'seoDesc'); ?>
        <?php echo $form->textArea($model,'seoDesc',array('class'=>'form-control','rows'=>5)); ?>
        <?php echo $form->error($model,'seoDesc'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'seoKeywords'); ?>
        <?php echo $form->textArea($model,'seoKeywords',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'seoKeywords'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'belongId'); ?>
        <?php echo $form->dropDownlist($model,'belongId',  Column::listFirst(),array('class'=>'form-control','empty'=>'--选择所属--')); ?>
        <?php echo $form->error($model,'belongId'); ?>
    </div>    
    <div class="form-group">
        <?php echo $form->labelEx($model,'classify'); ?>
        <?php echo $form->dropDownlist($model,'classify',  Column::classify('admin'),array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'classify'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'name'); ?>
        <?php echo $form->textField($model,'name',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>    
    <div class="form-group">
        <?php echo $form->labelEx($model,'bgImgUrl'); ?>     
        <p><img src="<?php echo Attachments::faceImg($model->bgImgId, 'a120');?>" alt="修改头像" id="user-avatar" style="width: 120px;height: 120px;"></p>
        <?php $this->renderPartial('/common/_singleUpload',array('model'=>$model,'fieldName'=>'bgImgId','type'=>'faceImg','fileholder'=>'filedata','targetHolder'=>'user-avatar','imgsize'=>'a120','progress'=>true));?>
        <?php echo $form->hiddenField($model,'bgImgId',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'bgImgUrl'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'showNews'); ?>        
        <?php echo $form->dropDownlist($model,'showNews', zmf::yesOrNo('admin'),array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'showNews'); ?>
    </div> 
    <div class="form-group">
        <?php echo $form->labelEx($model,'order'); ?>
        <?php echo $form->textField($model,'order',array('class'=>'form-control')); ?>
        <p class="help-block">越大越靠后</p>
        <?php echo $form->error($model,'order'); ?>
    </div>
    <div class="form-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '更新',array('class'=>'btn btn-primary')); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->