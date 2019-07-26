<?php
/**
 * @filename PostsController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2016 阿年飞少 
 * @datetime 2016-11-04 10:52:11 */
$this->renderPartial('_nav');
echo CHtml::link('新增',array('create'),array('class'=>'btn btn-danger addBtn'));
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'search-form',
    'htmlOptions' => array('class'=>'search-form'),
    'action' => Yii::app()->createUrl('/zmf/posts/index'),
    'enableAjaxValidation' => false,
    'method' => 'GET'
    ));
?>
<div class="fixed-width-group">    
    <div class="form-group">   
        <?php echo CHtml::textField("title", $_GET["title"], array("class" => "form-control", "placeholder" => $model->getAttributeLabel("title"))); ?>
    </div>
    <div class="form-group" style="width: 250px">
        <button class="btn btn-default" type="submit">搜索</button>
    </div>
</div>
<?php $this->endWidget(); ?>

<table class="table table-hover">
    <tr>    
        <th style="width: 80px"><?php echo $model->getAttributeLabel("id"); ?></th>
        <th style="width: 120px"><?php echo $model->getAttributeLabel("uid"); ?></th>
        <th style="width: 120px"><?php echo $model->getAttributeLabel("areaId"); ?></th>
        <th><?php echo $model->getAttributeLabel("title"); ?></th>
        <th style="width: 60px"><?php echo $model->getAttributeLabel("hits"); ?></th>
        <th style="width: 140px"><?php echo $model->getAttributeLabel("cTime"); ?></th>
        <th style="width: 180px">操作</th>
    </tr>

    <?php foreach ($posts as $data): ?> 
        <tr>
            <td><?php echo $data->id; ?></td>
            <td><?php echo CHtml::link($data->userInfo->truename,array('index','uid'=>$data->uid)); ?></td>
            <td><?php echo Area::fullPathText($data->areaInfo->sitepath); ?></td>
            <td><?php echo $data->title.($data->top>0 ? '<span class="text-danger">[置顶]</span>' : '').($data->digestTime>0 ? '<span class="red">[精品]</span>' : ''); ?></td>
            <td><?php echo $data->hits; ?></td>
            <td><?php echo zmf::formatTime($data->cTime); ?></td>
            <td>
                <?php echo CHtml::link('预览', array('/posts/view', 'id' => $data->id,'urlPrefix'=>$data->urlPrefix),['target'=>'_blank']); ?>
                <?php echo CHtml::link('置顶', array('setStatus', 'id' => $data->id,'type'=>'top')); ?>
                <?php echo CHtml::link('编辑', array('update', 'id' => $data->id)); ?>
                <?php echo CHtml::link('删除', array('delete', 'id' => $data->id), array('class' => 'delete')); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php $this->renderPartial('/common/pager', array('pages' => $pages)); ?>
