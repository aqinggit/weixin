var floatParams = {};
$(document).ready(function(){
    $('.delete').unbind('click').click(function(){
        stopDefault();
        if(!confirm('确定？')){
            return false;
        }
        var dom=$(this);
        var url = dom.attr('href');
        var id = dom.attr('data-id');
        var target = dom.attr('data-target');
        var reload = dom.attr('data-reload');
        if (!url) {
            return false;
        }
        $.post(url, {YII_CSRF_TOKEN: zmf.csrfToken}, function (result) {
            ajaxReturn = true;                
            result = $.parseJSON(result);
            if (result.status === 1) {
                simpleDialog({content: result.msg});
                if(parseInt(reload)===1){
                    function refreshPage() {
                        window.location.reload();
                        window.setTimeout("refreshPage()", 1500);
                    }
                    refreshPage();
                }else if(target){
                    $('#'+target).remove();
                }else if(id){
                    $('#item-'+id).remove();
                }
            } else {
                simpleDialog({content: result.msg});
            }
        });
    });
    $('.ajax-submitLink').unbind('click').click(function(){
        stopDefault();
        if(!confirm('确定？')){
            return false;
        }
        var dom=$(this);
        var url = dom.attr('href');        
        if (!url) {
            return false;
        }
        $.post(url, {YII_CSRF_TOKEN: zmf.csrfToken}, function (result) {
            ajaxReturn = true;                
            result = $.parseJSON(result);
            if (result.status === 1) {
                simpleDialog({content: result.msg});                
            } else {
                simpleDialog({content: result.msg});
            }
        });
    });
});
function stopDefault(e) {
    //阻止默认浏览器动作(W3C)
    if (e && e.preventDefault)
        e.preventDefault();
    //IE中阻止函数器默认动作的方式
    else
        window.event.returnValue = false;
    return false;
}
function refreshPage() {
    window.location.reload();
    window.setTimeout("refreshPage()", 1500);
}
function selectAttaches(url, from, params) {
    var html = '<div id="imgsDialogHolder"><div id="imgsTagsHolder"></div><div id="imgsHolder" class="imgsHolder"></div></div>';
    if (!$('#imgsHolder').length) {
        dialog({msg: html, title: '选择图片', modalSize: 'modal-lg'});
        ajaxTags(from, 'site');
    } else if ($('#myDialog').css('display') === 'none') {
        $('#myDialog').modal('show');
    }
    if (params) {
        floatParams = params;
    } else {
        params = floatParams;
    }
    var tagids = '';
    $('#imgsTagsHolder input[type=checkbox]:checked').each(function () {
        tagids += $(this).val() + ','
    });
    var album=$('.albums-holder .active').attr('data-id');
    var passData = {
        YII_CSRF_TOKEN: zmf.csrfToken,
        from: from ? from : '',
        tagids: tagids,
        album: album ? album : 0
    };
    if (!url) {
        url = zmf.ajaxAttachesUrl;
    }
    $.post(url, passData, function (data) {
        data = $.parseJSON(data);
        ajaxReturn = true;
        if (data.status === 1) {
            $('#imgsHolder').html(data.html);
            $('#imgsHolder a').unbind('click').click(function () {
                var _dom = $(this);
                var _id = _dom.attr('data-id');
                if (!_id) {
                    return false;
                }
                var _big = _dom.attr('data-original');
                var _thumb = _dom.children('img').attr('src');
                if (from === 'avatar') {
                    $('#' + params.inputId).val(_id);
                    $('#' + params.targetHolder).attr('src', _thumb);
                } else if (from === 'posts') {
                    var html = '<div class="thumbnail col-xs-4 col-sm-4 attach-item" id="uploadAttach' + _id + '"><span class="right-bar"><a title="删除图片" class="del-btn" href="javascript:;" onclick="$(\'#uploadAttach' + _id + '\').remove()"><i class="fa fa-remove"></i></a><a title="设置为封面图" onclick="setPostFaceimg(\'' + _id + '\',this,\'' + _thumb + '\',\'' + _big + '\')" class="face-btn" href="javascript:;"><i class="fa fa-bookmark-o"></i></a></span><img src="' + _thumb + '" class="img-responsive"><input type="hidden" name="attaches[img' + _id + '][type]" value="img"><textarea class="form-control" placeholder="点击添加图片描述" name="attaches[img' + _id + '][desc]"></textarea></div>';
                    $('#' + params.targetHolder).append(html);
                } else if (from === 'article') {
                    var img = "<p><img src='" + _big + "/c650.jpg' data='" + _id + "' class='img-responsive'/><br/></p>";
                    myeditor.execCommand("inserthtml", img);
                }
            });
        } else {
            simpleDialog({msg: data.msg});
        }
    });
}

function ajaxTags(from, action) {
    var passData = {
        YII_CSRF_TOKEN: zmf.csrfToken,
    };
    $.post(zmf.ajaxTagsUrl, passData, function (data) {
        data = $.parseJSON(data);
        if (data.status === 1) {
            $('#imgsTagsHolder').html(data.html);
            $('#imgsTagsHolder input[type=checkbox]').on('change', function () {
                var _dom = $(this);
                var _id = _dom.val();
                var _title = _dom.attr('data-title');
                var _html = '<a href="javascript:;" id="selected_tags_a_' + _id + '" class="label label-info" onclick="$(\'#tagid-' + _id + '\').click()">' + _title + '<i class="fa fa-remove"></i></a>';
                if (_dom.hasClass('selected')) {
                    _dom.removeClass('selected');
                    $('#selected_tags_a_' + _id).remove();
                } else {
                    _dom.addClass('selected');
                    $('#selectedTags-holder').append(_html);
                }
                if (action === 'site') {
                    selectAttaches(false, from, false);
                } else {
                    selectZoneImgs(false, from, false);
                }
            });
            $('.albums-holder .album-item').unbind('click').click(function(){
                $(this).siblings().removeClass('active');
                $(this).toggleClass('active');
                if (action === 'site') {
                    selectAttaches(false, from, false);
                } else {
                    selectZoneImgs(false, from, false);
                }
            });
        }
    });
}
function _searchThisTag(item){
    var html='<span class="tags-item" id="select-this-tag-'+item[1]+'" onclick="_removeThisTag('+item[1]+')"><input value="'+item[1]+'" type="checkbox" name="tags[]" checked="checked">'+item[0]+'</span>';
    if($('#select-this-tag-'+item[1]).length>0){
        simpleDialog({
            msg:'已添加'
        });
    }else{
        $('#add-tags-box').append(html);
    }
}
function _removeThisTag(id){
    $('#select-this-tag-'+id).remove();
}
function autoMatchTags(){
    var content='';
    $('.autoLinkTagContent').each(function(){
        content+=$(this).val()+',';
    });
    content+=myeditor.getContentTxt();            
    $.post(zmf.autoMatchTagUrl, {content:content,YII_CSRF_TOKEN: zmf.csrfToken}, function (result) {
        ajaxReturn = true;                
        result = $.parseJSON(result);
        if (result.status === 1) {
            $('#add-tags-box').append(result.msg.html);
            simpleDialog({content: '已匹配'});
        } else {
            simpleDialog({content: result.msg});
        }
    });
}
function setProductFaceimg(id, dom, imgurl, imgsrc) {
    var _cd = $(dom).children('i');
    var has = false;
    if (_cd.hasClass('fa-bookmark')) {
        has = true;
    }
    $('.right-bar').each(function () {
        $(this).find('.fa-bookmark').removeClass('fa-bookmark').addClass('fa-bookmark-o');
    })
    if (has) {
        id = '';
    } else if (_cd.hasClass('fa-bookmark-o')) {
        _cd.removeClass('fa-bookmark-o').addClass('fa-bookmark');
    } else {
        _cd.removeClass('fa-bookmark').addClass('fa-bookmark-o');
        id = '';
    }
    $('#Products_faceImg').val(id);
    $('#product-avatar').attr('src', imgurl);
}