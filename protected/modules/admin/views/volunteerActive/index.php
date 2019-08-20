<?php
/**
 * @filename VolunteerActiveController.php
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2019 阿年飞少
 * @datetime 2019-08-07 09:24:37
 */
$this->renderPartial('_nav');
echo CHtml::link('新增', array('create'), array('class' => 'btn btn-danger addBtn'));
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'search-form',
    'htmlOptions' => array(
        'class' => 'search-form'
    ),
    'action' => Yii::app()->createUrl('/admin/volunteeractive/index'),
    'enableAjaxValidation' => false,
    'method' => 'GET'
)); ?>
<div class="fixed-width-group">
    <div class="form-group">
        <?php echo CHtml::dropDownList("status", $_GET["status"],[0=>'待审核',1=>'已通过'], array("class" => "form-control", "placeholder" => $model->getAttributeLabel("status"))); ?></div>
    <div class="form-group">
        <button class="btn btn-default" type="submit">搜索</button>
    </div>
</div>
<?php $this->endWidget(); ?>

<table class="table table-hover table-striped">
    <tr>
        <th><?php echo $model->getAttributeLabel("vid"); ?></th>
        <th><?php echo $model->getAttributeLabel("aid"); ?></th>
        <th><?php echo $model->getAttributeLabel("cTime"); ?></th>
        <th><?php echo $model->getAttributeLabel("status"); ?></th>
        <th><?php echo $model->getAttributeLabel("score"); ?></th>
        <th style="width: 160px">操作</th>
    </tr>

    <?php foreach ($posts as $data): ?>
        <tr>
            <td><?php echo zmf::link($data->UsersInfo->truename, ['admin/Volunteers/update', 'id' => $data->vid]) ?></td>
            <td><?php echo zmf::link($data->ActivityInfo->title, ['/Activity/detail', 'id' => $data->aid]) ?></td>
            <td><?php echo zmf::time($data->cTime); ?></td>
            <td><?php echo Users::Status($data->status); ?></td>
            <td><?php echo $data->score; ?></td>
            <td>
                <?php echo CHtml::link('编辑', array('update', 'id' => $data->id)); ?>
                <?php echo CHtml::link('删除', array('delete', 'id' => $data->id),array('class'=>'delete')); ?>
                <?php echo CHtml::link('通过', array('pass', 'id' => $data->id),array('class'=>'delete')); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php $this->renderPartial('/common/pager', array('pages' => $pages)); ?>
