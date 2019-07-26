<?php
/**
 * @filename AreaController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-11-16 13:49:15 
 */
$_beinfo=$model->belongInfo;
$_beinfo2=$_beinfo->belongInfo;
if($_beinfo2){
    $_title=$_beinfo['title'].'('.$_beinfo2['title'].')';
}elseif($_beinfo){
    $_title=$_beinfo['title'];
}
?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'area-form',
	'enableAjaxValidation'=>false,
)); ?>
    <?php echo $form->errorSummary($model); ?>
    <div class="form-group">
        <?php echo $form->labelEx($model,'title'); ?>        
        <?php echo $form->textField($model,'title',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'belongId'); ?>
        <?php
        $this->widget('CAutoComplete', array(
            'name' => 'suggest_area',
            'url' => array('area/search'),
            'max' => 10, //specifies the max number of items to display
            'minChars' => 2,
            'delay' => 500, //number of milliseconds before lookup occurs
            'matchCase' => false, //match case when performing a lookup?
            'value' => $_title,
            'htmlOptions' => array('class' => 'form-control'),
            'methodChain' => ".result(function(event,item){ $('#Area_belongId').val(item[1]);})",
        ));
        ?>
        <?php echo $form->hiddenField($model, 'belongId'); ?>
        <?php echo $form->error($model, 'belongId'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'name'); ?>        
        <?php echo $form->textField($model,'name',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'opened'); ?>        
        <?php echo $form->dropDownlist($model,'opened', zmf::yesOrNo('admin'),array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'opened'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'recommend'); ?>        
        <?php echo $form->dropDownlist($model,'recommend', zmf::yesOrNo('admin'),array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'recommend'); ?>
    </div>
    <div class="form-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '更新',array('class'=>'btn btn-primary')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->