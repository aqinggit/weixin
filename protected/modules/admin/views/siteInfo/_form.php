<?php $uploadurl=Yii::app()->createUrl('attachments/upload',array('type'=>'siteinfo','imgsize'=>600));?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'site-info-form',
	'enableAjaxValidation'=>false,
)); ?>
	<?php echo $form->errorSummary($model); ?>	
	<div class="form-group">
            <?php echo $form->labelEx($model,'colid'); ?>
            <?php echo $form->dropDownList($model,'colid', SiteinfoColumns::listAll(),array('class'=>'form-control')); ?>
            <?php echo $form->error($model,'colid'); ?>
	</div>
	<div class="form-group">
            <?php echo $form->labelEx($model,'title'); ?>
            <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
            <?php echo $form->error($model,'title'); ?>
	</div>
        <div class="form-group">
            <?php echo $form->labelEx($model,'code'); ?>
            <div class="input-group">
                <?php echo $form->textField($model,'code',array('class'=>'form-control','placeholder'=>$model->getAttributeLabel('code'))); ?>
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">下拉选择 <span class="caret"></span></button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <?php $codesArr=SiteInfo::exTypes('admin'); foreach ($codesArr as $key => $value) {?>
                        <li><a href="javascript:;" onclick="$('#<?php echo CHtml::activeId($model, 'code');?>').val('<?php echo $key;?>');"><?php echo $value;?></a></li>
                        <?php }?>
                    </ul>
                </div><!-- /btn-group -->
            </div><!-- /input-group -->
            <?php echo $form->error($model,'code'); ?>
            <p class="help-block">用于指定查询，每个路径只能存在一篇文章</p>
	</div>
	<div class="form-group">
            <?php echo $form->labelEx($model,'content'); ?>
            <?php $this->renderPartial('//common/editor_um', array('model' => $model,'content' => $model->content,'uploadurl'=>$uploadurl)); ?>
            <?php echo $form->error($model,'content'); ?>
	</div>
	<div class="form-group">
            <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '更新',array('class'=>'btn btn-success','id'=>'add-post-btn')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->