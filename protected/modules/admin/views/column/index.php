
<?php
/**
 * @filename ColumnController.php  
 * @Description 
 * @author 阿年飞少 <ph7pal@qq.com>  
 * @link http://www.newsoul.cn  
 * @copyright Copyright©2017 阿年飞少  
 * @datetime 2017-08-06 12:16:48 */
$this->renderPartial('_nav');
echo CHtml::link('新增', array('create'), array('class' => 'btn btn-danger addBtn'));
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'search-form',
    'htmlOptions' => array(
        'class' => 'search-form'
    ),
    'action' => Yii::app()->createUrl('/admin/column/index'),
    'enableAjaxValidation' => false,
    'method' => 'GET'
        ));
?>
<div class="fixed-width-group">
    <div class="form-group">
        <?php echo CHtml::textField("title", $_GET["title"], array("class" => "form-control", "placeholder" => $model->getAttributeLabel("title"))); ?>
    </div>    
    <div class="form-group">
        <?php echo CHtml::textField("name", $_GET["name"], array("class" => "form-control", "placeholder" => $model->getAttributeLabel("name"))); ?>
    </div>    
    <div class="form-group">
        <?php echo CHtml::dropDownlist("classify", $_GET["classify"], Column::classify('admin'), array("class" => "form-control", "empty" => $model->getAttributeLabel("classify"))); ?>
    </div>    
    <div class="form-group"><button class="btn btn-default" type="submit">搜索</button></div>
</div>
<?php $this->endWidget(); ?>
<table class="table table-hover"> 
    <tr> 
        <th style="width: 50px"><?php echo $model->getAttributeLabel("id"); ?></th> 
        <th style="width: 80px"><?php echo $model->getAttributeLabel("classify"); ?></th> 
        <th><?php echo $model->getAttributeLabel("title"); ?></th> 
        <th style="width: 120px"><?php echo $model->getAttributeLabel("belongId"); ?></th>
        <th style="width: 120px"><?php echo $model->getAttributeLabel("name"); ?></th> 
        <th style="width: 200px">操作</th> 
    </tr>
    <?php foreach ($posts as $data): ?>  
        <tr> 
            <td><?php echo $data->id; ?></td> 
            <td><?php echo CHtml::link(Column::classify($data->classify),array('index','classify'=>$data->classify)); ?></td> 
            <td><?php echo $data->title; ?></td> 
            <td><?php echo $data->belongInfo->title; ?></td> 
            <td><?php echo $data->name; ?></td> 
            <td> 
                <?php echo CHtml::link('预览', array('/index/index', 'colName' => $data->name),array('target'=>'_blank')); ?> 
                <?php echo CHtml::link('TDK', array('tdk/jump', 'url' => zmf::createUrl('/index/index',array('colName'=>$data['name']))),array('target'=>'_blank')); ?>
                <?php echo CHtml::link('编辑', array('update', 'id' => $data->id)); ?>         
                <?php echo CHtml::link('删除', array('delete', 'id' => $data->id)); ?> 
            </td> 
        </tr>     
    <?php endforeach; ?> 
</table> 
<?php $this->renderPartial('/common/pager', array('pages' => $pages)); ?> 