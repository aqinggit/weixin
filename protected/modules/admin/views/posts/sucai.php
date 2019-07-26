<?php

/**
 * @filename sucai.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2015 阿年飞少 
 * @datetime 2017-3-23  16:01:25 
 */
$this->breadcrumbs=array(
    '管理中心',
    '素材包'=>array('posts/all')
);
?>
<style>
    .caption p{
        word-break: break-all
    }
    .selectedTags{
        line-height: 35px;        
    }
    .selectedTags a{
        margin-left: 10px
    }
</style>
<ul class="nav nav-tabs" role="tablist" style="margin-bottom:20px">
    <li role="presentation"><?php echo CHtml::link('素材',array('attachments/index'));?></li>
    <li role="presentation" class="active"><?php echo CHtml::link('素材包',array('posts/all'));?></li>
    <li role="presentation"><?php echo CHtml::link('我的收藏',array('users/favorites'));?></li>
    <li class="pull-right">
        <div class="selectedTags">
            已选标签：
            <?php foreach($selectedTagsArr as $val){?>
            <a href="javascript:;" class="label label-info" onclick="$('#tagid-<?php echo $val['id'];?>').click()">
                <?php echo $val['title'];?>
                <i class="fa fa-remove"></i>
            </a>
            <?php }?>
        </div>
    </li>
</ul>
<div id="tags-holder">
    <?php foreach($tags as $tag){?>
    <div class="conditions-holder">
        <div class="holder-title"><?php echo $tag['typeName'];?>：</div>
        <div class="holder-body">
            <?php foreach($tag['items'] as $item){?>
            <span class="_item<?php echo in_array($item['id'],$selectedTags) ? ' active' : '';?>"><label><?php echo CHtml::checkBox('tagid[]', in_array($item['id'],$selectedTags), array('value'=>$item['id'],'id'=>'tagid-'.$item['id'])).$item['title'];?></label></span>
            <?php }?>          
        </div>
    </div>
    <?php }?>
</div>
<?php echo CHtml::link('新增',array('create','from'=>'sucai'),array('class'=>'btn btn-primary addBtn'));?>
<div class="sucai-holder">
    <?php foreach ($posts as $post){?>
    <div class="thumbnail">
        <a href="<?php echo Yii::app()->createUrl('zmf/posts/view',array('id'=>$post['id']));?>" target="_blank">
            <img src="<?php echo zmf::lazyImg();?>" class="lazy" data-original="<?php echo zmf::getThumbnailUrl($post['faceUrl'],'a280');?>"/>
        </a>
        <div class="caption">
            <p><?php echo CHtml::link($post['title'],array('view','id'=>$post['id']),array('target'=>'_blank')).($post['imgs']>0 ? '（'.$post['imgs'].'图）' : '').'<span class="color-grey">'.zmf::time($post['cTime'],'Y/m/d').'</span>'.CHtml::link('编辑',array('update','id'=>$post['id']));?></p>            
        </div>
    </div>
    <?php } ?>
</div>
<?php $this->renderPartial('/common/pager', array('pages' => $pages)); ?>
<script>
    $(document).ready(function(){
        $("#tags-holder input").change(function(){
            var idsStr='';
            $("#tags-holder input[name='tagid[]']:checkbox:checked").each(function(){
                idsStr+=$(this).val()+',';
            });
            window.location.href = '<?php echo Yii::app()->createUrl('zmf/posts/all',array('tagid'=>''));?>'+idsStr;
        });
    })
</script>