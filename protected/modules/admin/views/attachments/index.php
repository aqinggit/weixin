<?php

/**
 * @filename index.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2015 阿年飞少 
 * @datetime 2016-1-4  12:58:04 
 */
$this->renderPartial('_nav');
?>
<style>
    .images-holder{
        float: left;
    }
    .images-holder .img-item{
        float: left;
        margin-right: 5px;
        margin-bottom: 5px;
        width: 120px;
        height: 120px;
        position: relative
    }
    .images-holder .img-item img{
        width: 120px;
        height: 120px;
    }
    .img-item ._check{
        position: absolute;
        right: 0;
        bottom: 0;
    }
    .img-item ._check input{
        width: 20px;
        height: 20px;
    }
    .fixed-img .media-left{
        background: #f2f2f2;              
        padding-right: 0
    }
    .fixed-img .media-left .img{
        width: 600px;    
        display: block
    }
    .fixed-img .media-left img{
        max-width: 100%;      
        margin: 0 auto;
        display: block
    }
    .fixed-img .media-body{
        padding-left: 10px
    }
    .tag_item,.pet_item{
        padding: 5px 10px;
        border: 1px solid #f2f2f2;
        margin-right: 5px;
        margin-bottom: 5px;
        display: inline-block;
        color: #0099CC
    }
    ._fixed_tags_holder{
        height: 300px;
        overflow-y: auto;
        display: none;
        margin-top: 10px;
        
    }
    ._fixed_tags_holder ._header{
        background: #f2f2f2;
        padding: 5px 10px;
        display: block;
        width: 100%
    }
    .displayNone{
        display: none
    }
    .right-btns{
        width: 120px;
        position: fixed;
        right: 0;
        top: 40%;
        border: 1px solid #ccc;
        border-radius: 3px;
        padding: 10px 5px;
        background: #fff
    }
</style>
<ul class="nav nav-tabs" role="tablist" style="margin-bottom:20px">
    <li role="presentation" class="active"><?php echo CHtml::link('素材',array('attachments/index'));?></li>
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
        <div class="holder-title"><?php echo $tag['title'];?>：</div>
        <div class="holder-body">
            <?php foreach($tag['items'] as $item){?>            
            <span class="_item<?php echo in_array($item['id'],$selectedTags) ? ' active' : '';?>"><label class="checkbox-inline"><?php echo CHtml::checkBox('tagid[]', in_array($item['id'],$selectedTags), array('value'=>$item['id'],'id'=>'tagid-'.$item['id'])).$item['title'];?></label></span>
            <?php }?>          
        </div>
    </div>
    <?php }?>
</div>

<div class="images-holder" id="attachments">
    <?php foreach($posts as $k=>$img){?>
    <div class="img-item" id="img-list-<?php echo $img['id'];?>" data-id="<?php echo $img['id'];?>">
        <img src="<?php echo zmf::lazyImg();?>" data-original="<?php echo $img['filePath'];?>" class="img-responsive lazy" onclick="showImg(<?php echo $img['id'];?>)"/>   
        <span class="_check">
            <?php echo CHtml::checkBox('ids[]', false,array('value'=>$img['id'],'id'=>'_check_'.$img['id'],'class'=>'_check_item'));?>
        </span>
    </div>
    <?php }?>
</div>

<div class="right-btns">
    <label><?php echo CHtml::checkBox('all');?> 全选/取消全选</label>
    <p><a href="javascript:;" class="btn btn-default btn-block" onclick="multiMask()">添加标签</a></p>
    <p><a href="javascript:;" class="btn btn-danger btn-block" onclick="multiDel()">删除</a></p>
</div>  
<?php if(!empty($posts)){$this->renderPartial('/common/pager',array('pages'=>$pages));}?> 
<div class="modal fade" id="multi-dialog" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel2">批量添加标签</h4>
            </div>
            <div class="modal-body">
                <p><b>已选标签</b></p>
                <div id="selected-multi-tags" style="min-height:50px"></div>
                <p><b>选择标签</b></p>
                <div class="_fixed_tags_holder" style="display:block">
                    <?php foreach ($tags as $all){$_divId=zmf::randMykeys(6);?>
                    <p>
                        <a href="javascript:;" class="_header" onclick="$('#tags_all-<?php echo $_divId;?>').toggle()">
                            <?php echo $all['title'];?><span class="pull-right color-grey">展开</span>
                        </a>
                    </p>
                    <div class="displayNone" id="tags_all-<?php echo $_divId;?>">
                        <?php foreach($all['items'] as $item){?>
                        <a class="tag_item" href="javascript:;" onclick="_selectThisTag(<?php echo $item['id'];?>,'<?php echo $item['title'];?>')"><?php echo $item['title'];?></a></span>
                        <?php }?>      
                    </div>
                    <?php }?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" action="saveMultiTags">保存</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#all").click(function(){
            if(this.checked){   
                $("#attachments :checkbox").prop("checked", true);  
            }else{   
                $("#attachments :checkbox").prop("checked", false);
            }   
        });
        $("#tags-holder input").change(function(){
            var idsStr='';
            $("#tags-holder input[name='tagid[]']:checkbox:checked").each(function(){
                idsStr+=$(this).val()+',';
            });
            window.location.href = '<?php echo Yii::app()->createUrl('admin/attachments/index',array('tagid'=>''));?>'+idsStr;
        });
    });
function multiMask() {
    var idsStr = '';
    $("#attachments input[name='ids[]']:checkbox:checked").each(function () {
        idsStr += $(this).val() + ',';
    });
    if (!idsStr || idsStr === '' || idsStr === ',') {
        simpleDialog({content: '请先选择图片'});
        return false;
    }
    $('#multi-dialog').modal({
        backdrop: false,
        keyboard: false
    });
    $("button[action=saveMultiTags]").unbind('click').click(function () {
        var tagStr = '';
        $('#selected-multi-tags .tag_item').each(function () {
            tagStr += $(this).attr('data-id') + ',';
        });
        if (!tagStr || tagStr === '' || tagStr === ',') {
            simpleDialog({content: '请先选择标签'});
            return false;
        }
        var passData = {
            YII_CSRF_TOKEN: zmf.csrfToken,
            imgIds: idsStr,
            tagids: tagStr
        };
        simpleDialog({content: '添加中...'});
        $.post(zmf.attachAddMultiTagUrl, passData, function (data) {
            closeSimpleDialog();
            data = $.parseJSON(data);
            ajaxReturn = true;
            if (data.status === 1) {
                simpleDialog({content: '已添加'});
                $("#all").click();
                $("#all").click();
            } else {
                simpleDialog({content: data.msg});
            }
        });
    });
}       
function multiDel() {
    var idsStr = '';
    $("#attachments input[name='ids[]']:checkbox:checked").each(function () {
        idsStr += $(this).val() + ',';
    });
    if (!idsStr || idsStr === '' || idsStr === ',') {
        simpleDialog({content: '请先选择图片'});
        return false;
    }
    if(!confirm('确定？')){
        return false;
    }    
    var passData = {
        YII_CSRF_TOKEN: zmf.csrfToken,
        imgIds: idsStr,        
    };
    simpleDialog({content: '删除中...'});
    $.post(zmf.attachMultiDelUrl, passData, function (data) {        
        data = $.parseJSON(data);
        ajaxReturn = true;
        if (data.status === 1) {
            simpleDialog({content: data.msg});
            $("#all").click();
            $("#all").click();
        } else {
            simpleDialog({content: data.msg});
        }
    });    
}    
function _preImg(id) {
    if (!id) {
        simpleDialog({content: '缺少参数'});
        return false;
    }
    var _id = $('#img-list-' + id).prev('.img-item').attr('data-id');
    if (!_id) {
        simpleDialog({content: '已是第一张'});
        return false;
    }
    showImg(_id);
}
function _nextImg(id) {
    if (!id) {
        simpleDialog({content: '缺少参数'});
        return false;
    }
    var _id = $('#img-list-' + id).next('.img-item').attr('data-id');
    if (!_id) {
        simpleDialog({content: '已是最后一张'});
        return false;
    }
    showImg(_id);
}
function showImg(id) {
    var passData = {
        YII_CSRF_TOKEN: zmf.csrfToken,
        id: id
    };
    simpleDialog({content: '正在加载中...'});
    $.post(zmf.attachDetailUrl, passData, function (data) {
        closeSimpleDialog();
        data = $.parseJSON(data);
        ajaxReturn = true;
        if (data.status === 1) {
            dialog({
                title: '素材详情',
                msg: data.msg,
                modalSize: 'modal-lg',
            });
            rebind();
        } else {
            simpleDialog({msg: data.msg});
        }
    })
}
function removeImgTag(id) {
    var passData = {
        YII_CSRF_TOKEN: zmf.csrfToken,
        id: id
    };
    if (!confirm('确定删除？')) {
        return false;
    }
    simpleDialog({content: '正在加载中...'});
    $.post(zmf.attachDelTagUrl, passData, function (data) {
        closeSimpleDialog();
        data = $.parseJSON(data);
        ajaxReturn = true;
        if (data.status === 1) {
            simpleDialog({msg: data.msg});
            $('#tag_item-' + id).remove();
        } else {
            simpleDialog({msg: data.msg});
        }
    });
}
function delImgTags(id) {
    var passData = {
        YII_CSRF_TOKEN: zmf.csrfToken,
        id: id
    };
    if (!confirm('确定删除？')) {
        return false;
    }
    simpleDialog({content: '正在加载中...'});
    $.post(zmf.attachDelTagsUrl, passData, function (data) {
        closeSimpleDialog();
        data = $.parseJSON(data);
        ajaxReturn = true;
        if (data.status === 1) {
            simpleDialog({msg: data.msg});
            $('#selected-tags-' + id).html('');
        } else {
            simpleDialog({msg: data.msg});
        }
    });
}
function addThisTag(imgId, tagid) {
    if (!imgId || !tagid) {
        alert('缺少参数');
        return false;
    }
    var passData = {
        YII_CSRF_TOKEN: zmf.csrfToken,
        imgId: imgId,
        tagid: tagid
    };
    simpleDialog({content: '添加中...'});
    $.post(zmf.attachAddTagUrl, passData, function (data) {
        closeSimpleDialog();
        data = $.parseJSON(data);
        ajaxReturn = true;
        if (data.status === 1) {
            $('#selected-tags-' + imgId).append(data.msg);
        } else {
            simpleDialog({msg: data.msg});
        }
    });
}
function _selectThisTag(tagid, title) {
    var dom = $('#selected-multi-tags');
    if ($('#_tag_item_' + tagid).length > 0) {
        simpleDialog({msg: '已添加'});
        return false;
    } else if (dom.children('.tag_item').length >= 10) {
        simpleDialog({msg: '一次只能添加最多20个标签'});
        return false;
    }
    dom.append('<span class="tag_item" id="_tag_item_' + tagid + '" data-id="' + tagid + '">' + title + ' <a href="javascript:;" onclick="$(\'#_tag_item_' + tagid + '\').remove()"><i class="fa fa-remove"></i></a></span>');
}
</script>