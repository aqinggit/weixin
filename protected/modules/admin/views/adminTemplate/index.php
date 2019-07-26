<?php
/**
 * @filename AdminTemplateController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-05-25 03:09:04 */
 $this->renderPartial('_nav'); 
 echo CHtml::link('新增',array('create'),array('class'=>'btn btn-danger addBtn'));
 ?>
 <table class="table table-hover">
    <tr>    
        <th style="width: 80px"><?php echo $model->getAttributeLabel("id");?></th>
        <th style=""><?php echo $model->getAttributeLabel("title");?></th>
        <th style="width: 160px">操作</th>
    </tr>
    <?php foreach ($posts as $data): ?> 
    <tr>
        <td><?php echo $data->id;?></td>
        <td><?php echo $data->title;?></td>
        <td>
            <?php echo CHtml::link('编辑',array('update','id'=> $data->id));?>        
            <?php echo CHtml::link('删除',array('delete','id'=> $data->id), array('class' => 'delete'));?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php $this->renderPartial('/common/pager',array('pages'=>$pages));?>
