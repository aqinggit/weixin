<?php

/**
 * @filename _html.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2015 阿年飞少 
 * @datetime 2017-3-24  11:52:17 
 */
?>
<div class="media fixed-img" id="attach-<?php echo $data['id'];?>">
    <div class="media-left">
        <p class="img"><img src="<?php echo $data['thumbnail'];?>"/></p>
        <p class="text-center"><a href="<?php echo $data['imgUrl'];?>" class="color-grey" target="_blank">查看原图</a></p>
        <p>
            <a href="javascript:;" onclick="_preImg(<?php echo $data['id'];?>)" class="btn btn-default">上一张</a>
            <a href="javascript:;" onclick="_nextImg(<?php echo $data['id'];?>)" class="btn btn-default pull-right">下一张</a>
        </p>
    </div>
    <div class="media-body">
        <p><b>基本信息</b></p>
        <p>文件大小：<?php echo zmf::formatBytes($data['size']);?></p>
        <p>图像尺寸：<?php echo $data['width'].'*'.$data['height'];?></p>
        <p>上传时间：<?php echo zmf::time($data['cTime'],'Y-m-d');?></p>
        <p>上传用户：<?php echo $data['username'];?></p>        
        <p><b>图片描述</b></p>
        <div class="form-group">
            <textarea class="form-control imgAlt" data-id="<?php echo $data['id'];?>" rows="3"><?php echo $data['fileDesc'];?></textarea>
        </div>
        <p><b>图片标签</b></p>        
        <div id="selected-tags-<?php echo $data['id'];?>">
            <?php foreach ($data['tags'] as $tag){?>
            <span class="tag_item" id="tag_item-<?php echo $tag['logid'];?>">
                <?php echo $tag['title'];?>
                <a href="javascript:;" onclick="removeImgTag(<?php echo $tag['logid'];?>)" class="color-grey"><i class="fa fa-remove"></i></a>
            </span>
            <?php }?>
        </div>
        <a href="javascript:;" class="btn btn-xs btn-primary" onclick="$('#_fixed_tags_holder-<?php echo $data['id'];?>').toggle()"><i class="fa fa-plus"></i> 添加标签</a>        
        <a href="javascript:;" class="btn btn-xs btn-default pull-right" onclick="delImgTags(<?php echo $data['id'];?>)"><i class="fa fa-remove"></i> 删除所有标签</a>        
        <div class="_fixed_tags_holder" id="_fixed_tags_holder-<?php echo $data['id'];?>">
            <?php foreach ($data['allTags'] as $all){$_divId=zmf::randMykeys(6);?>
            <p>
                <a href="javascript:;" class="_header" onclick="$('#tags_all-<?php echo $_divId;?>').toggle()">
                    <?php echo $all['title'];?><span class="pull-right color-grey">展开</span>
                </a>
            </p>
            <div class="displayNone" id="tags_all-<?php echo $_divId;?>">
                <?php foreach($all['items'] as $item){?>
                <a class="tag_item" href="javascript:;" onclick="addThisTag(<?php echo $data['id'];?>,<?php echo $item['id'];?>)"><?php echo $item['title'];?></a></span>
                <?php }?>      
            </div>
            <?php }?>
        </div>
    </div>
</div>