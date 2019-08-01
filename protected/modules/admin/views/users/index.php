<?php

/**
 * @filename index.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2015 阿年飞少 
 * @datetime 2016-1-4  12:57:20 
 */
$this->renderPartial('_nav');
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'search-form',
    'htmlOptions' => array('class' => 'search-form'),
    'action' => Yii::app()->createUrl('/admin/users/index'),
    'enableAjaxValidation' => false,
    'method' => 'GET'
        ));
?>
<div class="fixed-width-group">
    <div class="form-group">
        <?php echo CHtml::textField("truename", $_GET["truename"], array("class" => "form-control", "placeholder" => $model->getAttributeLabel("truename"))); ?> 
    </div>
    <div class="form-group">
        <?php echo CHtml::textField("phone", $_GET["phone"], array("class" => "form-control", "placeholder" => $model->getAttributeLabel("phone"))); ?> 
    </div>
    <div class="form-group">
        <?php echo CHtml::textField("email", $_GET["email"], array("class" => "form-control", "placeholder" => $model->getAttributeLabel("email"))); ?> 
    </div>
    <div class="form-group">
        <button class="btn btn-default" type="submit">搜索</button>
    </div>
</div>
<?php $this->endWidget(); ?>
<table class="table table-hover">
    <tr>
        <th style="width: 60px">ID</th>
        <th>用户名</th>
        <th style="width: 160px">用户组</th>
        <th style="width: 80px">手机号</th>
        <th style="width: 160px">邮箱</th>
        <th style="width: 160px">注册时间</th>
        <th style="width: 100px">来源</th>
        <th style="width: 120px">操作</th>
    </tr>
<?php foreach($posts as $data):?> 
    <tr>
        <td><?php echo CHtml::encode($data->id);?></td>
	<td><?php echo CHtml::link(CHtml::encode($data->truename),array('view','id'=>$data->id));?></td>
	<td><?php echo CHtml::encode($data->groupInfo->title);?></td>
	<td><?php echo CHtml::encode($data->phone);?></td>
	<td><?php echo CHtml::encode($data->email);?></td>
        <td><?php echo zmf::formatTime($data->cTime);?></td>
        <td><?php echo Users::exPlatform($data->platform);?></td>
	<td>
            <?php echo CHtml::link('发消息',array('notice','id'=>$data->id));?>
            <?php echo CHtml::link('编辑',array('update','id'=>$data->id));?>
	</td>
    </tr>
 <?php endforeach;?>
</table>
<?php $this->renderPartial('/common/pager',array('pages'=>$pages));?>