<?php
/**
 * @filename NavbarController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2018 阿年飞少 
 * @datetime 2018-02-06 13:05:46 */
 ?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'navbar-form',
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
        <?php echo $form->labelEx($model,'status'); ?>        
        <?php echo $form->dropDownlist($model,'status', zmf::yesOrNo('admin'),array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'status'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'target'); ?>        
        <?php echo $form->dropDownlist($model,'target',zmf::yesOrNo('admin'),array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'target'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'nofollow'); ?>        
        <?php echo $form->dropDownlist($model,'nofollow',zmf::yesOrNo('admin'),array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'nofollow'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'isHot'); ?>        
        <?php echo $form->dropDownlist($model,'isHot',zmf::yesOrNo('admin'),array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'isHot'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'isNew'); ?>        
        <?php echo $form->dropDownlist($model,'isNew',zmf::yesOrNo('admin'),array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'isNew'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'position'); ?>        
        <?php echo $form->dropDownlist($model,'position', Navbar::exPoi('admin'),array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'position'); ?>
    </div>
    <div class="form-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '更新',array('class'=>'btn btn-primary')); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->