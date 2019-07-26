<?php
/**
 * @filename SearchRecordsController.php
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2017 阿年飞少
 * @datetime 2017-08-04 08:16:05 */
$this->renderPartial('_nav');
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'search-form',
    'htmlOptions' => array(
        'class' => 'search-form'
    ),
    'action' => Yii::app()->createUrl('/admin/searchRecords/index'),
    'enableAjaxValidation' => false,
    'method' => 'GET'
        ));
?>
<div class="fixed-width-group">
    <div class="form-group">
        <?php echo CHtml::textField("title", $_GET["title"], array("class" => "form-control", "placeholder" => $model->getAttributeLabel("title"))); ?>
    </div>
    <div class="form-group">
        <?php echo CHtml::textField("hash", $_GET["hash"], array("class" => "form-control", "placeholder" => $model->getAttributeLabel("hash"))); ?>
    </div>    
    <div class="form-group"><button class="btn btn-default" type="submit">搜索</button></div>
</div>
<?php $this->endWidget(); ?>

<table class="table table-hover">
    <tr>
        <th ><?php echo $model->getAttributeLabel("title"); ?></th>
        <th style="width: 160px">更新时间</th>
        <th style="width: 60px">次数</th>
        <th style="width: 60px">显示</th>
        <th style="width: 160px">操作</th>
    </tr>
    <?php foreach ($posts as $data): ?>
        <tr>
            <td><?php echo $data->title; ?></td>
            <td><?php echo zmf::formatTime($data->updateTime); ?></td>
            <td><?php echo $data->times; ?></td>
            <td><?php echo CHtml::link(zmf::yesOrNo($data->status), array('setStatus', 'id' => $data->id,'type'=>($data->status ? 'del' : 'pass')),array('class'=>($data->status!=Posts::STATUS_PASSED ? 'text-danger' : ''))); ?></td>
            <td>
                <?php echo CHtml::link('预览', array('/search/do', 'logCode' => $data->hash),array('target'=>'_blank')); ?>
                <?php echo CHtml::link('编辑', array('update', 'id' => $data->id)); ?>
                <?php echo CHtml::link('删除', array('delete', 'id' => $data->id)); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php $this->renderPartial('/common/pager', array('pages' => $pages)); ?>
