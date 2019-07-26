<?php
$this->breadcrumbs = array(
    '首页'=>array('index/index'),
    '小工具'=>array('tools/index'),
    '本站链接'
);
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'search-form',
    'htmlOptions' => array('class' => 'search-form'),
    'action' => Yii::app()->createUrl('/admin/site/urls'),
    'enableAjaxValidation' => false,
    'method' => 'GET'
    ));
$arr=array(
    'all'=>'全部',
    'articles'=>'文章',
    'questions'=>'问答',
    'attachments'=>'图片',
    'search'=>'搜索记录',
    'columns'=>'内容分类',
    'tags'=>'标签',
);
?>
<div class="fixed-width-group">
    <div class="form-group">
        <?php echo CHtml::dropDownList("table", $_GET["table"],$arr, array("class" => "form-control",'empty'=>'--分类--')); ?> 
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
    </div>
</div>
<?php $this->endWidget(); ?>
<div class="form-group">
    <textarea class="form-control" rows="30"><?php echo $urls;?></textarea>
</div>