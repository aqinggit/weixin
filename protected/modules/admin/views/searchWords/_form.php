<?php
/**
 * @filename SearchWordsController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2018 阿年飞少 
 * @datetime 2018-02-08 06:26:51 */
 ?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'search-words-form',
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
        <?php echo $form->labelEx($model,'order'); ?>        
        <?php echo $form->textField($model,'order',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'order'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'position'); ?>
        <?php echo $form->dropDownlist($model,'position', SearchWords::exPoi('admin'),array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'position'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'status'); ?>
        <?php echo $form->dropDownlist($model,'status', zmf::yesOrNo('admin'),array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'status'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'color'); ?>        
        <?php echo $form->textField($model,'color',array('class'=>'form-control')); ?>
        <p class="help-block">带#号的颜色值，如“#333333”</p>
        <?php echo $form->error($model,'color'); ?>
    </div>
    <div class="form-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '更新',array('class'=>'btn btn-primary')); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->