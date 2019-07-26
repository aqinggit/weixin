<?php
$this->breadcrumbs=array(
    '管理中心',
    '链接提交'
);
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'search-form',
    'htmlOptions' => array('class'=>'search-form'),
    'action' => Yii::app()->createUrl('/admin/tools/submitUrls'),
    'enableAjaxValidation' => false,
    ));
?>
<div class="form-group">
    <?php echo CHtml::dropDownList("type", '',array('1'=>'普通链接','2'=>'Mip链接','3'=>'熊掌号','4'=>'熊掌号历史','5'=>'原创'), array("class" => "form-control")); ?>
</div>
<div class="form-group">
    <?php echo CHtml::textArea("urls", '', array("class" => "form-control",'rows'=>8)); ?>
    <p class="help-block">一行一个连接</p>
</div>
<div class="form-group">
    <button class="btn btn-default" type="submit">提交</button>        
</div>
<?php $this->endWidget(); ?>