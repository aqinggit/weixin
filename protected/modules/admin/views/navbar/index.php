<?php
/**
 * @filename NavbarController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2018 阿年飞少 
 * @datetime 2018-02-06 13:05:46 
 */
$this->renderPartial('_nav');
echo CHtml::link('新增', array('create'), array('class' => 'btn btn-danger addBtn'));
?>
<table class="table table-hover table-striped">
    <tr>   
        <th style="width: 60px"><?php echo $model->getAttributeLabel("id"); ?></th>
        <th style="width: 120px"><?php echo $model->getAttributeLabel("title"); ?></th>
        <th><?php echo $model->getAttributeLabel("url"); ?></th>
        <th style="width: 60px"><?php echo $model->getAttributeLabel("order"); ?></th>
        <th style="width: 60px"><?php echo $model->getAttributeLabel("status"); ?></th>
        <th style="width: 60px"><?php echo $model->getAttributeLabel("target"); ?></th>
        <th style="width: 60px"><?php echo $model->getAttributeLabel("nofollow"); ?></th>
        <th style="width: 60px"><?php echo $model->getAttributeLabel("isHot"); ?></th>
        <th style="width: 60px"><?php echo $model->getAttributeLabel("isNew"); ?></th>
        <th style="width: 80px"><?php echo $model->getAttributeLabel("position"); ?></th>
        <th style="width: 120px">操作</th>
    </tr>

    <?php foreach ($posts as $data): ?> 
        <tr>        
            <td><?php echo $data->id; ?></td>
            <td><?php echo $data->title; ?></td>
            <td><?php echo $data->url; ?></td>
            <td><?php echo $data->order; ?></td>
            <td><?php echo zmf::yesOrNo($data->status); ?></td>
            <td><?php echo zmf::yesOrNo($data->target); ?></td>
            <td><?php echo zmf::yesOrNo($data->nofollow); ?></td>
            <td><?php echo zmf::yesOrNo($data->isHot); ?></td>
            <td><?php echo zmf::yesOrNo($data->isNew); ?></td>
            <td><?php echo Navbar::exPoi($data->position); ?></td>
            <td>
                <?php echo CHtml::link('编辑', array('update', 'id' => $data->id)); ?>        
                <?php echo CHtml::link('删除', array('delete', 'id' => $data->id)); ?>
            </td>
        </tr>    
    <?php endforeach; ?>
</table>
<?php $this->renderPartial('/common/pager', array('pages' => $pages)); ?>
