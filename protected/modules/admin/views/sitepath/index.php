<?php
/**
 * @filename SitepathController.php
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2018 阿年飞少
 * @datetime 2018-06-07 14:10:00
 */
$this->renderPartial('_nav');
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'search-form',
    'htmlOptions' => array(
        'class' => 'search-form'
    ),
    'action' => Yii::app()->createUrl('/admin/sitepath/index'),
    'enableAjaxValidation' => false,
    'method' => 'GET'
));
?>
<div class="fixed-width-group">
    <div class="form-group">
        <?php echo CHtml::textField("logid", $_GET["logid"], array("class" => "form-control", "placeholder" => $model->getAttributeLabel("logid"))); ?>
    </div>
    <div class="form-group">
        <?php echo CHtml::textField("classify", $_GET["classify"], array("class" => "form-control", "placeholder" => $model->getAttributeLabel("classify"))); ?>
    </div>
    <div class="form-group">
        <?php echo CHtml::textField("name", $_GET["name"], array("class" => "form-control", "placeholder" => $model->getAttributeLabel("name"))); ?>
    </div>
    <div class="form-group"><button class="btn btn-default" type="submit">搜索</button></div>
    <div class="form-group" style="width: 200px">
        <?php echo CHtml::link('地区',array('intoArea'));?>
        <?php echo CHtml::link('分类',array('intoColumn'));?>
        <?php echo CHtml::link('标签',array('intoTags'));?>
    </div>
</div>
<?php $this->endWidget(); ?>

<table class="table table-hover table-striped">
    <tr>
        <th style="width: 80px"><?php echo $model->getAttributeLabel("id"); ?></th>
        <th style="width: 80px"><?php echo $model->getAttributeLabel("name"); ?></th>
        <th style="width: 80px"><?php echo $model->getAttributeLabel("logid"); ?></th>
        <th><?php echo $model->getAttributeLabel("classify"); ?></th>
        <th style="width: 80px">操作</th>
    </tr>

    <?php foreach ($posts as $data): ?>
        <tr>
            <td><?php echo $data->id; ?></td>
            <td><?php echo $data->name; ?></td>
            <td><?php echo $data->logid; ?></td>
            <td><?php echo $data->classify; ?></td>
            <td>
                <?php echo CHtml::link('删除', array('delete', 'id' => $data->id)); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php $this->renderPartial('/common/pager', array('pages' => $pages)); ?>
