<?php
$this->breadcrumbs = array(
    '首页'=>array('index/index'),
    '小工具'=>array('tools/index'),
    '操作日志'=>array('site/logs'),
);
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'search-form',
    'htmlOptions' => array('class' => 'search-form'),
    'action' => Yii::app()->createUrl('/admin/site/logs'),
    'enableAjaxValidation' => false,
    'method' => 'GET'
    ));
$arr=array(
   'article'=>'文章',
   'question'=>'问题',
   'answer'=>'回答',
);
?>
<div class="fixed-width-group">
    <div class="form-group">
        <?php echo CHtml::textField("uid", $_GET["uid"], array("class" => "form-control",'placeholder'=>'用户ID')); ?> 
    </div>
    <div class="form-group">
        <?php echo CHtml::dropDownList("table", $_GET["table"],$arr, array("class" => "form-control",'empty'=>'--分类--')); ?> 
    </div>
    <div class="form-group">
        <?php echo CHtml::textField("logid", $_GET["logid"], array("class" => "form-control",'placeholder'=>'对象ID')); ?> 
    </div>
    <div class="form-group">
        <?php 
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'startTime',
            'language' => 'zh-cn',
            'options' => array('showAnim' => 'fadeIn'),
            'value'=>  $startTime ? zmf::time($startTime,'Y/m/d') : '',    
            'htmlOptions' => array(
                'class' => 'form-control',
                'placeholder'=>'起始时间'
                )
            )); 
        ?>
    </div>    
    <div class="form-group">
        <?php 
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'endTime',
            'language' => 'zh-cn',
            'options' => array('showAnim' => 'fadeIn'),
            'value'=>  $endTime ? zmf::time($endTime,'Y/m/d') : '',    
            'htmlOptions' => array(
                'class' => 'form-control',
                'placeholder'=>'截止时间'
                )
            ));
        ?>
    </div>
    <div class="form-group">
        <button class="btn btn-default" type="submit">搜索</button>
        <?php echo CHtml::link('统计',array('statLogs','uid'=>$_GET["uid"],'startTime'=>$startTime ? zmf::time($startTime,'Y/m/d') : '','endTime'=>$endTime ? zmf::time($endTime,'Y/m/d') : ''),array('class'=>'btn btn-default'));?>
    </div>
</div>
<?php $this->endWidget(); ?>
<table class="table table-hover">
    <tr>            
        <th style="width: 120px"><?php echo $model->getAttributeLabel("uid"); ?></th>
        <th><?php echo $model->getAttributeLabel("content"); ?></th>
        <th style="width: 140px"><?php echo $model->getAttributeLabel("cTime"); ?></th>
    </tr>
    <?php foreach ($posts as $data): ?> 
        <tr id="item-<?php echo $data['id'];?>">
            <td><?php echo CHtml::link($data->userInfo->truename,array('logs','uid'=>$data->uid)); ?></td>
            <td><?php echo $data->content.'#'.$data->logid; ?></td>
            <td><?php echo zmf::time($data['cTime']);?></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php $this->renderPartial('/common/pager', array('pages' => $pages)); ?>