<?php
/**
 * @filename QuestionsLogController.php
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2019 阿年飞少
 * @datetime 2019-09-09 00:00:30
 */
$this->renderPartial('_nav');
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'search-form',
    'htmlOptions' => array(
        'class' => 'search-form'
    ),
    'enableAjaxValidation' => false,
    'method' => 'GET'
)); ?>
<div class="fixed-width-group">
    <div class="form-group">
        <?php echo CHtml::textField("phone", $_GET["phone"], array("class" => "form-control", "placeholder" => $model->getAttributeLabel("phone"))); ?></div>
    <div class="form-group">
        <?php echo CHtml::textField("socre", $_GET["socre"], array("class" => "form-control", "placeholder" => $model->getAttributeLabel("socre"))); ?></div>
    <div class="form-group">
        <button class="btn btn-default" type="submit">搜索</button>
    </div>
</div>
<?php $this->endWidget(); ?>

<table class="table table-hover table-striped">
    <tr>
        <th><?php echo $model->getAttributeLabel("phone"); ?></th>
        <th><?php echo $model->getAttributeLabel("ip"); ?></th>
        <th><?php echo $model->getAttributeLabel("cTime"); ?></th>
        <th><?php echo $model->getAttributeLabel("socre"); ?></th>
    </tr>

    <?php foreach ($posts as $data): ?>
        <tr>
            <td><?php echo $data->phone; ?></td>
            <td><?php echo long2ip($data->ip); ?></td>
            <td><?php echo zmf::time($data->cTime); ?></td>
            <td><?php echo $data->socre; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php $this->renderPartial('/common/pager', array('pages' => $pages)); ?>
