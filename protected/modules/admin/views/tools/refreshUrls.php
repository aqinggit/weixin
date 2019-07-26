<?php
$this->breadcrumbs=array(
    '管理中心',
    '刷新缓存'
);
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'search-form',
    'htmlOptions' => array('class'=>'search-form'),
    'action' => Yii::app()->createUrl('/zmf/site/refreshCache'),
    'enableAjaxValidation' => false,
    ));
?>
<div class="form-group">
    <?php echo CHtml::textArea("urls", '', array("class" => "form-control",'rows'=>8)); ?>
    <p class="help-block">一行一个连接</p>
</div>
<div class="form-group">
    <button class="btn btn-default" type="submit">提交</button>        
</div>
<?php $this->endWidget(); ?>