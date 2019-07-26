<?php
/**
 * @filename LinksController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2016 阿年飞少 
 * @datetime 2016-12-06 15:32:40 */
$this->renderPartial('_nav');
?>
<?php echo CHtml::link('新增', array('create'), array('class' => 'btn btn-danger addBtn')); ?>

<table class="table table-hover">
    <tr>    
        <th style="width: 80px"><?php echo $model->getAttributeLabel("id"); ?></th>
        <th ><?php echo $model->getAttributeLabel("title"); ?></th>
        <th ><?php echo $model->getAttributeLabel("url"); ?></th>
        <th ><?php echo $model->getAttributeLabel("position"); ?></th>
        <th ><?php echo $model->getAttributeLabel("cTime"); ?></th>
        <th style="width: 160px">操作</th>
    </tr>
    <?php foreach ($posts as $data): ?> 
    <tr>
        <td><?php echo $data->id; ?></td>
        <td><?php echo $data->title; ?></td>
        <td><?php echo CHtml::link(zmf::subStr($data->url),$data->url,array('target'=>'_blank')); ?></td>
        <td><?php echo CHtml::link(zmf::subStr($data->position),$data->position,array('target'=>'_blank')); ?></td>
        <td><?php echo zmf::formatTime($data->cTime); ?></td>                 
        <td>
            <?php echo CHtml::link('编辑', array('update', 'id' => $data->id)); ?>        
            <?php echo CHtml::link('删除', array('delete', 'id' => $data->id)); ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php $this->renderPartial('/common/pager', array('pages' => $pages)); ?>
