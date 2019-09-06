<?php
/**
 * @filename QuestionsController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2019 阿年飞少 
 * @datetime 2019-09-05 09:44:29 */
 ?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'questions-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($model); ?>
    <div class="form-group">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'content'); ?>
        <?php $this->renderPartial('//common/editor_um', array('model' => $model, 'content' => $model->content, 'editorWidth' => 800, 'uptype' => 'articles', 'imgsize' => 'c640')); ?>
        <?php echo $form->error($model, 'content'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'answers'); ?>
        <?php echo $form->textField($model,'answers',array('class'=>'form-control')); ?>
        <?php echo $form->error($model, 'answers'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'analysis'); ?>
        
        <?php echo $form->textField($model,'analysis',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'analysis'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'score'); ?>
        
        <?php echo $form->textField($model,'score',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'score'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'type'); ?>
        <?php echo $form->dropDownList($model, 'type', Questions::Type() , array('class' => 'form-control')); ?>
        <?php echo $form->error($model,'type'); ?>
    </div>
    <div class="form-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '更新',array('class'=>'btn btn-primary')); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->