<?php
/**
 * @filename NotificationController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-03-17 21:57:43 */
$this->renderPartial('_nav');
?>
<table class="table table-hover">
    <tr>
        <th><?php echo $model->getAttributeLabel("id"); ?></th>
        <th><?php echo $model->getAttributeLabel("uid"); ?></th>
        <th><?php echo $model->getAttributeLabel("type"); ?></th>
        <th><?php echo $model->getAttributeLabel("content"); ?></th>
        <th><?php echo $model->getAttributeLabel("cTime"); ?></th>
        <th>操作</th>
    </tr>

    <?php foreach ($posts as $data): ?> 
        <tr>
            <td><?php echo $data->id; ?></td>
            <td><?php echo $data->userInfo->truename; ?></td>
            <td><?php echo $data->type; ?></td>
            <td><?php echo $data->content; ?></td>
            <td><?php echo zmf::time($data->cTime); ?></td>
            <td>
                <?php echo CHtml::link('编辑', array('update', 'id' => $data->id)); ?>        
                <?php echo CHtml::link('删除', array('delete', 'id' => $data->id)); ?>
            </td>
        </tr>    
    <?php endforeach; ?>
</table>
<?php $this->renderPartial('/common/pager', array('pages' => $pages)); ?>
