<?php
/**
 * @filename AreaController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-11-16 13:49:15 */
$this->renderPartial('_nav');
echo CHtml::link('新增', array('create'), array('class' => 'btn btn-danger addBtn'));
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'search-form',
    'htmlOptions' => array(
        'class' => 'search-form'
    ),
    'action' => Yii::app()->createUrl('/admin/area/index',array('type'=>'all')),
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
    <div class="form-group"><button class="btn btn-default" type="submit">搜索</button></div>
    <div class="form-group"><?php echo CHtml::link('已开通',array('index','type'=>'opened'));?></div>
</div>
<?php $this->endWidget(); ?>

<table class="table table-hover">
    <tr>     
        <th style="width: 80px"><?php echo $model->getAttributeLabel("id"); ?></th>
        <th><?php echo $model->getAttributeLabel("title"); ?></th>
        <th style="width: 120px"><?php echo $model->getAttributeLabel("name"); ?></th>
        <th style="width: 120px"><?php echo $model->getAttributeLabel("belongId"); ?></th>
        <th style="width: 80px"><?php echo $model->getAttributeLabel("opened"); ?></th>        
        <th style="width: 160px">操作</th>
    </tr>
    <?php foreach ($posts as $data): ?> 
        <tr>
            <td><?php echo $data->id; ?></td>
            <td><?php echo $data->title; ?></td>
            <td><?php echo $data->name; ?></td>
            <td><?php $beinfo=$data->belongInfo;echo $beinfo->title.($beinfo['belongId']>0 ? '['.$beinfo->belongInfo->title.']' : ''); ?></td>
            <td><?php echo CHtml::link($data->opened ? '<span class="text-danger">已开通</span>' : '开通',array('setStatus','id'=>$data->id,'type'=>'opened'),array('confirm'=>'已确定？'));?></td>    
            <td>
                <?php echo $data->opened ? CHtml::link('TDK',array('tdk/jump', 'url' => zmf::createUrl('/index/index',array('colName'=>$data['name']))),array('target'=>'_blank')) : '';?>
                <?php echo CHtml::link('包含',array('index','belongId'=>$data->id));?>
                <?php echo CHtml::link('编辑', array('update', 'id' => $data->id)); ?>
            </td>
        </tr>    
    <?php endforeach; ?>
</table>
<?php $this->renderPartial('/common/pager', array('pages' => $pages)); ?>
