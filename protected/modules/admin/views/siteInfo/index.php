<?php
$this->renderPartial('_nav');
echo CHtml::link('新增', array('create'), array('class' => 'btn btn-danger addBtn'));
?>

<table class="table table-hover">
    <tr>
        <th style="width: 120px">分类</th>
        <th>标题</th>
        <th style="width: 160px">主旨</th>
        <th style="width: 160px">操作</th>
    </tr>
    <?php foreach($posts as $data):?> 
    <tr>
        <td><?php echo CHtml::link($data->colInfo->title,array('index','colid'=>$data->colid)); ?></td>	
        <td><?php echo CHtml::link($data->title,array('/site/info','id'=>$data->id),array('target'=>'_blank')); ?></td>	
        <td><?php echo SiteInfo::exTypes($data->code); ?></td>	
        <td>
            <?php echo CHtml::link('编辑',array('update','id'=>$data->id));?>
            <?php echo CHtml::link('删除',array('delete','id'=>$data->id),array('confirm'=>'确定？'));?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<?php $this->renderPartial('/common/pager',array('pages'=>$pages));?>