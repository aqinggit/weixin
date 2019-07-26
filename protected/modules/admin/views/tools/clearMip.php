<?php
$this->breadcrumbs=array(
    '管理中心',
    '链接提交'
);
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'search-form',
    'htmlOptions' => array('class'=>'search-form'),
    'action' => Yii::app()->createUrl('/admin/tools/clearMip'),
    'enableAjaxValidation' => false,
    ));
?>
<div class="form-group">
    <?php echo CHtml::textField("urls", '', array("class" => "form-control")); ?>
    <p class="help-block">一行一个连接</p>
</div>
<div class="form-group">
    <button class="btn btn-default" type="submit">提交</button>        
</div>
<?php $this->endWidget(); ?>