<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active hidden"><a href="#tags-holder-collect" id="tags-tab-collect" role="tab" data-toggle="tab" aria-controls="tags-holder-collect" aria-expanded="true">我的收藏</a></li>
    <?php foreach($tags as $typeTag){?>
    <li role="presentation" ><a href="#tags-holder-<?php echo $typeTag['type'];?>" id="tags-tab-<?php echo $typeTag['type'];?>" role="tab" data-toggle="tab" aria-controls="tags-holder-<?php echo $typeTag['type'];?>" aria-expanded="true"><?php echo $typeTag['title'];?></a></li>
    <?php }?>
    <li class="pull-right">
        <div class="selectedTags">
            已选标签：
            <span id="selectedTags-holder"></span>
        </div>
    </li>
</ul>
<div id="myTabContent" class="tab-content">
    <div role="tabpanel" class="tab-pane fade hidden" id="tags-holder-collect" aria-labelledby="tags-tab-collect">
        <div class="conditions-holder">            
            <div class="holder-body albums-holder">
                <?php foreach ($albums as $album){?>
                <span class="_item-coll album-item" data-id="<?php echo $album['id'];?>"><?php echo $album['title'];?></span>
                <?php }?>
            </div>
        </div>
    </div>
    <?php foreach($tags as $typeTag){?>
    <div role="tabpanel" class="tab-pane fade" id="tags-holder-<?php echo $typeTag['type'];?>" aria-labelledby="tags-tab-<?php echo $typeTag['type'];?>">
        <div class="conditions-holder">            
            <div class="holder-body">
                <?php foreach($typeTag['items'] as $item){?>            
                <span class="_item<?php echo in_array($item['id'],$selectedTags) ? ' active' : '';?>"><label class="checkbox-inline"><?php echo CHtml::checkBox('tagid[]', in_array($item['id'],$selectedTags), array('value'=>$item['id'],'id'=>'tagid-'.$item['id'],'data-title'=>$item['title'])).$item['title'];?></label></span>
                <?php }?>          
            </div>
        </div>
    </div>
    <?php }?>
</div>