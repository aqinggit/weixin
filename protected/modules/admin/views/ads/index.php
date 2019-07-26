<?php

/**
 * @filename content.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2015 阿年飞少 
 * @datetime 2016-3-30  20:57:16 
 */
$this->renderPartial('_nav');
echo CHtml::link('新增',array('create'),array('class'=>'btn btn-danger addBtn'));
?>

<table class="table table-hover">
    <tr>
        <th style="width: 60px"><?php echo $model->getAttributeLabel('id');?></th>
        <th style="width: 100px"><?php echo $model->getAttributeLabel('position');?></th>
        <th style="width: 160px"><?php echo $model->getAttributeLabel('title');?></th>
        <th><?php echo $model->getAttributeLabel('url');?></th>
        <th style="width: 160px"><?php echo $model->getAttributeLabel('startTime');?></th>
        <th style="width: 160px"><?php echo $model->getAttributeLabel('expiredTime');?></th>
        <th style="width: 80px"><?php echo $model->getAttributeLabel('platform');?></th>
        <th style="width: 80px">操作</th>
    </tr>
    <?php foreach($posts as $data){?>
    <tr>
        <td><?php echo $data->id; ?></td>
        <td><?php echo Ads::colPositions($data->position); ?></td>
        <td><?php echo $data->title; ?></td>
        <td><?php echo $data->url!='' ? CHtml::link(zmf::subStr($data->url),$data->url,array('target'=>'_blank')) : ''; ?></td>
        <td><?php echo $data->startTime>0 ? zmf::time($data->startTime) : '不限'; ?></td>
        <td><?php echo $data->expiredTime>0 ? zmf::time($data->expiredTime) : '不限'; ?></td>
        <td><?php echo Ads::exPlatform($data->platform); ?></td>
        <td>
            <?php echo CHtml::link('编辑', array('update', 'id' => $data->id),array('target'=>'_blank')); ?>        
            <?php echo CHtml::link('删除', array('delete', 'id' => $data->id),array('class'=>'delete','data-id'=>$data['id'])); ?>     
        </td>
    </tr>
    <?php }?>
</table>
<?php if(!empty($posts)){$this->renderPartial('/common/pager',array('pages'=>$pages));}?>        