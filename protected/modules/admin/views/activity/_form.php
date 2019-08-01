<?php
/**
 * @filename ActivityController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2019 阿年飞少 
 * @datetime 2019-08-01 22:50:41 */
 ?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'activity-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($model); ?>
    <div class="form-group">
        <?php echo $form->labelEx($model,'title'); ?>
        
        <?php echo $form->textField($model,'title',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>
        <div class="form-group">
            <?php echo $form->labelEx($model,'content'); ?>
            <?php $this->renderPartial('//common/editor_um', array('model' => $model,'content' => $model->content,'editorWidth'=>688,'uptype'=>'articles','imgsize'=>'c640')); ?>
            <p><a class="btn btn-default" href="javascript:;" onclick="selectAttaches(false,'article',{})"><i class="fa fa-image"></i> 从素材库添加</a></p>
            <p class="help-block">请勿手动缩进</p>
            <?php echo $form->error($model,'content'); ?>
        </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'activityTime'); ?>
        
        <?php echo $form->dateField($model,'activityTime',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'activityTime'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'place'); ?>
        
        <?php echo $form->textField($model,'place',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'place'); ?>
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