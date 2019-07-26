var tipsImgOrder = 0;
var beforeModal;
var ajaxReturn = true;
var url = window.location.href;
function rebind() {
    $("img.lazy").lazyload({
        threshold: 600,
        failure_limit : 50
    });    
    $('.imgAlt').unbind('change').change(function(){
        var dom=$(this);
        var id=dom.attr('data-id');
        if(!id){
            return false;
        }
        var c = $(this).val();
        $.post(zmf.setImgAltUrl, {id: id, content: c, YII_CSRF_TOKEN: zmf.csrfToken}, function (result) {
            result = $.parseJSON(result);
            if (result.status !== 1) {
                simpleDialog({content:result.msg});
            }
        });
    });
    
    $(".tag-item").unbind('click').click(function () {
        var dom = $(this);
        if (dom.hasClass('active')) {
            dom.removeClass('active');
            dom.children('input').removeAttr('checked');
        } else {
            dom.addClass('active');
            dom.children('input').attr('checked', 'checked');
        }
    });
    $("a[action=scroll]").unbind('click').click(function () {
        var dom = $(this);
        var to = dom.attr("action-target");
        if (!to) {
            return false;
        }
        $("body,html").animate({
            scrollTop: $('#' + to).offset().top
        }, 200);
    });
    $('#add-post-btn').unbind('click').click(function () {
        $(window).unbind('beforeunload');
    });    
    //ajax请求
    $("a[action=ajax]").unbind('click').click(function () {
        var dom = $(this);
        var data = dom.attr('action-data');
        var input = dom.attr('action-input');
        if (!data) {
            alert('缺少参数');
            return false;
        }
        var passData = {
            YII_CSRF_TOKEN: zmf.csrfToken,
            action: 'ajax',
            data: data
        };
        if (input) {
            var inputDom = $('#' + input);
            var inputVal = inputDom.val();
            if (!inputVal || parseInt(inputVal) < 1) {
                simpleDialog({content: '请完善输入'});
                inputDom.focus();
                return false;
            } else {
                passData.extra = inputVal;
            }
        }
        $.post(zmf.ajaxUrl, passData, function (result) {
            result = eval('(' + result + ')');
            if (result['status'] === 1) {
                simpleDialog({content: result['msg']});
            } else {
                simpleDialog({content: result['msg']});
            }
        });
    });
    $('a.toggle').unbind('click').click(function(){
        var dom=$(this);
        var tar=dom.attr('data-id');
        if(!tar){
            return false;
        }
        var cdom=$('#content-'+tar);
        var sdom=$('#substr-'+tar);
        if(cdom.css('display')==='none'){
            cdom.show();
            sdom.hide();
        }else{
            cdom.hide();
            sdom.show();
        }
    });
    $(".tags-item").unbind('click').click(function () {
        function checkNum() {
            var num = 0;
            $(".tags-item").each(function () {
                if ($(this).hasClass('active')) {
                    ++num;
                }
            });
            if (num >= 10) {
                return false;
            }
            return true;
        }
        var dom = $(this);
        if (dom.hasClass('active')) {
            dom.removeClass('active');
            dom.children('input').removeAttr('checked');
        } else {
            if (!checkNum()) {
                simpleDialog({content: '最多只能选择10个标签'});
                return false;
            }
            dom.addClass('active');
            dom.children('input').attr('checked', 'checked');
        }
    });
    $('#tags-holder .pointer').unbind('click').click(function(){
        var dom=$(this);
        if(dom.hasClass('active')){
            dom.parent('._tags_items').children('.hide-item').each(function(){
                $(this).addClass('displayNone');
            });
            dom.removeClass('active').html('︾');
        }else{
            dom.parent('._tags_items').children('.hide-item').each(function(){
                $(this).removeClass('displayNone');
            });
            dom.addClass('active').html('︽');
        }
    });
    //调用复制
    var clipboard = new Clipboard('.btn-copy');
    clipboard.on('success', function (e) {
        simpleDialog({content: '复制成功'});
    });
    clipboard.on('error', function (e) {
        simpleDialog({content: '复制失败，请手动复制浏览器链接'});
    });
}
function loadBaiduJScript() {
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = "http://api.map.baidu.com/api?v=2.0&ak=6dpa3CAjuZwAEbx1viy4jtGGIdbIZv59&callback=initBaiduMap";
    document.body.appendChild(script);
}
function initBaiduMap() {
    var map = new BMap.Map("map-holder", {enableMapClick:false}); 
    var point = new BMap.Point(long,lat);
    var marker = new BMap.Marker(point);  // 创建标注
    map.addOverlay(marker);        
    map.centerAndZoom(point,18);                 
    map.enableScrollWheelZoom();  
    var opts = {
      width : 200,     // 信息窗口宽度
      height: 100,     // 信息窗口高度
      title : title, // 信息窗口标题
      enableMessage:true,//设置允许信息窗发送短息          
    }
    var infoWindow = new BMap.InfoWindow(address, opts);  // 创建信息窗口对象 
    marker.addEventListener("click", function(){          
            map.openInfoWindow(infoWindow,point); //开启信息窗口
    });
}
// 使用message对象封装消息  
var flashTitle = {
    time: 0,
    title: document.title,
    timer: null,
    // 显示新消息提示  
    show: function () {
        var title = flashTitle.title.replace("【　　　】", "").replace("【新消息】", "");
        // 定时器，设置消息切换频率闪烁效果就此产生  
        flashTitle.timer = setTimeout(function () {
            flashTitle.time++;
            flashTitle.show();
            if (flashTitle.time % 2 == 0) {
                document.title = "【新消息】" + title
            } else {
                document.title = "【　　　】" + title
            }
            ;
        }, 600);
        return [flashTitle.timer, flashTitle.title];
    },
    // 取消新消息提示  
    clear: function () {
        clearTimeout(flashTitle.timer);
        document.title = flashTitle.title;
    }
};
var notice_interval = null;
function getNotice() {
    doGetNotice();
    window.onblur = function () {
        clearInterval(notice_interval);
    };
    window.onfocus = function () {
        clearInterval(notice_interval);
        notice_interval = window.setInterval("doGetNotice()", 10000);
    }
}
function doGetNotice() {
    if (!checkLogin()) {
        return false;
    }
    $.post(zmf.ajaxUrl, {action: 'getNotice', YII_CSRF_TOKEN: zmf.csrfToken}, function (result) {
        result = $.parseJSON(result);
        if (result.status === 1) {
            var notices = parseInt(result.notices);
            if (notices > 0) {
                $('#top-nav-count').html(notices).css('display', 'inline-block');
                if (flashTitle.timer === null) {
                    flashTitle.show();
                }
            } else {
                $('#top-nav-count').hide();
                flashTitle.clear();
            }
            var tasks = parseInt(result.tasks);
            if (tasks > 0) {
                $('#top-task-count').html(tasks).css('display', 'inline-block');
            }else{
                $('#top-task-count').hide();
            }
        }
    })
}
function playVideo(company, videoid, targetHolder, dom) {
    if (!company || !videoid || !targetHolder) {
        return false;
    }
    var w = $('#' + targetHolder).width();
    var h = w * 9 / 16;
    var html = '';
    if (company === 'youku') {
        html = '<iframe src="http://player.youku.com/embed/' + videoid + '" height="' + h + '" width="' + w + '" allowtransparency="true" allowfullscreen="true" allowfullscreenInteractive="true" scrolling="no" border="0" frameborder="0"  height="' + h + '" width="' + w + '"></iframe>';
    } else if (company === 'tudou') {
        html = '<iframe src="http://www.tudou.com/programs/view/html5embed.action?type=2&' + videoid + '" allowtransparency="true" allowfullscreen="true" allowfullscreenInteractive="true" scrolling="no" border="0" frameborder="0"  height="' + h + '" width="' + w + '"></iframe>';
    } else if (company === 'qq') {
        html = '<iframe src="http://v.qq.com/iframe/player.html?vid=' + videoid + '&tiny=0&auto=1" allowtransparency="true" allowfullscreen="true" allowfullscreenInteractive="true" scrolling="no" border="0" frameborder="0"  height="' + h + '" width="' + w + '"></iframe>';
    }
    $('#' + targetHolder).html(html);
    $(dom).remove();
}
function myUploadify() {
    $("#uploadfile").uploadify({
        height: 34,
        width: 120,
        swf: zmf.baseUrl + '/common/uploadify/uploadify.swf',
        queueID: 'fileQueue',
        auto: true,
        multi: true,
        fileObjName: 'filedata',
        uploadLimit: zmf.perAddImgNum,
        fileSizeLimit: zmf.allowImgPerSize,
        fileTypeExts: zmf.allowImgTypes,
        fileTypeDesc: 'Image Files',
        uploader: tipImgUploadUrl,
        buttonText: '请选择',
        buttonClass: 'btn btn-success',
        debug: false,
        formData: {'PHPSESSID': zmf.currentSessionId, 'YII_CSRF_TOKEN': zmf.csrfToken},
        onUploadSuccess: function (file, data, response) {
            data = eval("(" + data + ")");
            if (data['status'] == 1) {
                var img = "<p><img src='" + data['thumbnail'] + "' data='" + data['attachid'] + "' class='img-responsive'/></p>";
                myeditor.execCommand("inserthtml", img);
                if($('#waitForAlt').length>0){
                    var html='<div class="media"><div class="media-left"><img src="'+ data['thumbnail'] + '"/></div><div class="media-body"><div class="form-group"><textarea class="form-control imgAlt" data-id="'+data['attachid']+'" rows="4" placeholder="输入图片alt"></textarea></div></div></div>';
                    $('#waitForAlt').append(html);
                    rebind();
                }
            } else {
                simpleDialog({content: data.msg});
            }
            tipsImgOrder++;
        }
    });
}
function uploadByLimit(params) {
    if (typeof params !== "object") {
        return false;
    }
    var multi = true;
    if (typeof params.multi === 'undefined') {
        multi = true;
    } else {
        multi = params.multi;
    }
    $("#" + params.placeHolder).uploadify({
        height: params.height ? params.height : 100,
        width: params.width ? params.width : 300,
        swf: zmf.baseUrl + '/common/uploadify/uploadify.swf',
        queueID: params.queueID ? params.queueID : 'singleFileQueue',
        auto: true,
        multi: multi,
        queueSizeLimit: zmf.perAddImgNum,
        fileObjName: params.filedata ? params.filedata : 'filedata',
        fileTypeExts: zmf.allowImgTypes,
        fileSizeLimit: zmf.allowImgPerSize,
        fileTypeDesc: 'Image Files',
        uploader: params.uploadUrl,
        buttonText: params.buttonText ? params.buttonText : (params.buttonText === null ? '' : '添加图片'),
        buttonClass: params.buttonClass ? params.buttonClass : 'btn btn-default',
        debug: false,
        formData: {'PHPSESSID': zmf.currentSessionId, 'YII_CSRF_TOKEN': zmf.csrfToken},
        onSelect: function (fileObj) {
//            console.log(fileObj);
//            alert(
//                  "文件名：" + fileObj.name + "\r\n" +
//                  "文件大小：" + fileObj.size + "\r\n" +
//                  "创建时间：" + fileObj.creationDate + "\r\n" +
//                  "最后修改时间：" + fileObj.modificationDate + "\r\n" +
//                  "文件类型：" + fileObj.type
//            );
//            $("#"+params.placeHolder).uploadify('cancel');
        },
        onUploadSuccess: function (file, data, response) {
            data = $.parseJSON(data);
            if (data['status'] == 1) {
                if (params.inputId) {
                    $('#' + params.inputId).val(data.imgsrc);
                }
                if (params.targetHolder) {
                    $('#' + params.targetHolder).attr('src', data.thumbnail);
                }
            } else {
                simpleDialog({content: data.msg});
            }
        }
    });
}
/**
 * placeHolder, inputId, limit,multi
 * @returns {undefined}
 */
function singleUploadify(params) {
    if (typeof params !== "object") {
        return false;
    }
    var multi = true;
    if (typeof params.multi === 'undefined') {
        multi = true;
    } else {
        multi = params.multi;
    }
    $("#" + params.placeHolder).uploadify({
        height: params.height ? params.height : 100,
        width: params.width ? params.width : 300,
        swf: zmf.baseUrl + '/common/uploadify/uploadify.swf',
        queueID: 'singleFileQueue',
        auto: true,
        multi: multi,
        queueSizeLimit: zmf.perAddImgNum,
        fileObjName: params.filedata ? params.filedata : 'filedata',
        fileTypeExts: zmf.allowImgTypes,
        fileSizeLimit: zmf.allowImgPerSize,
        fileTypeDesc: 'Image Files',
        uploader: params.uploadUrl,
        buttonText: params.buttonText ? params.buttonText : (params.buttonText === null ? '' : '添加图片'),
        buttonClass: params.buttonClass ? params.buttonClass : 'btn btn-default',
        debug: false,
        formData: {'PHPSESSID': zmf.currentSessionId, 'YII_CSRF_TOKEN': zmf.csrfToken},
        onUploadStart: function (file) {
            if (params.saveItems) {
                var _params = {};
                var myDate = new Date();
                var _type = file.type;
                var _name = params.type + '/' + myDate.getFullYear() + '/' + (myDate.getMonth() + 1) + '/' + myDate.getDate() + '/' + uuid() + _type;
                _params.key = _name;
                _params.token = params.token;
                $("#" + params.placeHolder).uploadify('settings', 'formData', _params);
            }
        },
        onUploadSuccess: function (file, data, response) {
            data = $.parseJSON(data);
            if (params.saveItems) {
                if (!data.error) {
                    var passData = {
                        YII_CSRF_TOKEN: zmf.csrfToken,
                        filePath: data.key,
                        fileSize: file.size,
                        type: params.type,
                        logid: params.logid,
                        action: 'saveUploadImg'
                    };
                    $.post(zmf.ajaxUrl, passData, function (reJson) {
                        reJson = $.parseJSON(reJson);
                        if (reJson.status === 1) {
                            $("#fileSuccess").append(reJson.html);
                            if (params.inputId) {
                                $('#' + params.inputId).val(reJson.attachid);
                            }
                            rebind();
                        } else {
                            alert(reJson.msg);
                            return false;
                        }
                    });
                } else {
                    alert(data.error);
                    return false;
                }
            } else {
                if (data.status === 1) {
                    $("#fileSuccess").html(data.html);
                    if (params.inputId) {
                        $('#' + params.inputId).val(data.attachid);
                    }
                    rebind();
                } else {
                    alert(data.msg);
                    return false;
                }
            }
        }
    });
}

/*
 * a:对话框id
 * t:提示
 * c:对话框内容
 * ac:下一步的操作名
 * time:自动关闭
 */
function dialog(diaObj) {
    if (typeof diaObj !== "object") {
        return false;
    }
    var c = diaObj.msg;
    var a = diaObj.id;
    var t = diaObj.title;
    var ac = diaObj.action;
    var acn = diaObj.actionName;
    var time = diaObj.time;
    var size = diaObj.modalSize;
    $('#' + beforeModal).modal('hide');
    if (typeof t === 'undefined' || t === '') {
        t = '提示';
    }
    if (typeof a === 'undefined' || a === '') {
        a = 'myDialog';
    }
    if (typeof ac === 'undefined') {
        ac = '';
    }
    if (typeof size === 'undefined') {
        size = '';
    }
    $('#' + a).remove();
    var longstr = '<div class="modal fade mymodal" id="' + a + '" tabindex="-1" role="dialog" aria-labelledby="' + a + 'Label" aria-hidden="true"><div class="modal-dialog ' + size + '"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title" id="' + a + 'Label">' + t + '</h4></div><div class="modal-body">' + c + '</div><div class="modal-footer">';
    longstr += '<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>';
    if (ac !== '' && typeof ac !== 'undefined') {
        var _t;
        if (acn !== '' && typeof acn !== 'undefined') {
            _t = acn;
        } else {
            _t = '确定';
        }
        longstr += '<button type="button" class="btn btn-primary" action="' + ac + '" data-loading-text="Loading...">' + _t + '</button>';
    }
    longstr += '</div></div></div></div>';
    $("body").append(longstr);
    $('#' + a).modal({
        backdrop: false,
        keyboard: false
    });
    beforeModal = a;
    if (time > 0 && typeof time !== 'undefined') {
        setTimeout("closeDialog('" + a + "')", time * 1000);
    }
}
function closeDialog(a) {
    if (!a) {
        a = 'myDialog';
    }
    $('#' + a).modal('hide');
    $('#' + a).remove();
    $("body").eq(0).removeClass('modal-open');
}
function simpleDialog(diaObj) {
    if (typeof diaObj !== "object") {
        return false;
    }
    var c = diaObj.content || diaObj.msg;
    var longstr = '<div class="simpleDialog '+(diaObj.status===1 ? 'succDialog' : 'errDialog')+'">' + c + '</div>';
    $("body").append(longstr);
    var dom = $('.simpleDialog');
    var w = dom.width();
    var h = dom.height();
    dom.css({
        'margin-left': -w / 2,
        'margin-top': -h / 2
    });
    dom.fadeIn(300);
    setTimeout("closeSimpleDialog()", 2700);
}
function closeSimpleDialog() {
    $('.simpleDialog').fadeOut(100).remove();
}
function simpleLoading(diaObj) {
    if (typeof diaObj !== "object") {
        return false;
    }
    var c = diaObj.title;
    var longstr = '<div class="simple-loading-box"><div class="loading-holder"><i class="fa fa-spinner"></i></div><div class="loading-title"><p>' + c + '</p></div></div>';
    $("body").append(longstr);
    var dom = $('.simple-loading-box');
    var w = dom.width();
    var h = dom.height();
    dom.css({
        'margin-left': -w / 2,
        'margin-top': -h / 2
    });
    dom.fadeIn(300);
    setTimeout("closeSimpleLoading()", 2700);
}
function closeSimpleLoading() {
    $('.simple-loading-box').fadeOut(100).remove();
}
function checkAjax() {
    if (!ajaxReturn) {
        simpleDialog({content: '请求正在发送中，请稍后'});
        return false;
    }
    ajaxReturn = false;
    return true;
}
function checkLogin() {
    if (typeof zmf.hasLogin === 'undefined') {
        return false;
    } else if (zmf.hasLogin === 'true') {
        return true;
    } else {
        return false;
    }
}
function uuid(len, radix) {
    var chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.split('');
    var uuid = [], i;
    radix = radix || chars.length;

    if (len) {
        for (i = 0; i < len; i++)
            uuid[i] = chars[0 | Math.random() * radix];
    } else {
        var r;
        // rfc4122 requires these characters
        uuid[8] = uuid[13] = uuid[18] = uuid[23] = '-';
        uuid[14] = '4';
        // Fill in random data.  At i==19 set the high bits of clock sequence as
        // per rfc4122, sec. 4.1.5
        for (i = 0; i < 36; i++) {
            if (!uuid[i]) {
                r = 0 | Math.random() * 16;
                uuid[i] = chars[(i === 19) ? (r & 0x3) | 0x8 : r];
            }
        }
    }
    return uuid.join('');
}
function stopDefault(e) {
    //阻止默认浏览器动作(W3C)
    if (e && e.preventDefault)
        e.preventDefault();
    //IE中阻止函数器默认动作的方式
    else
        window.event.returnValue = false;
    return false;
}
/*! Lazy Load 1.9.7 - MIT license - Copyright 2010-2015 Mika Tuupola */
!function (a, b, c, d) {
    var e = a(b);
    a.fn.lazyload = function (f) {
        function g() {
            var b = 0;
            i.each(function () {
                var c = a(this);
                if (!j.skip_invisible || c.is(":visible"))
                    if (a.abovethetop(this, j) || a.leftofbegin(this, j))
                        ;
                    else if (a.belowthefold(this, j) || a.rightoffold(this, j)) {
                        if (++b > j.failure_limit)
                            return!1
                    } else
                        c.trigger("appear"), b = 0
            })
        }
        var h, i = this, j = {threshold: 0, failure_limit: 0, event: "scroll", effect: "show", container: b, data_attribute: "original", skip_invisible: !1, appear: null, load: null, placeholder: "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"};
        return f && (d !== f.failurelimit && (f.failure_limit = f.failurelimit, delete f.failurelimit), d !== f.effectspeed && (f.effect_speed = f.effectspeed, delete f.effectspeed), a.extend(j, f)), h = j.container === d || j.container === b ? e : a(j.container), 0 === j.event.indexOf("scroll") && h.bind(j.event, function () {
            return g()
        }), this.each(function () {
            var b = this, c = a(b);
            b.loaded = !1, (c.attr("src") === d || c.attr("src") === !1) && c.is("img") && c.attr("src", j.placeholder), c.one("appear", function () {
                if (!this.loaded) {
                    if (j.appear) {
                        var d = i.length;
                        j.appear.call(b, d, j)
                    }
                    a("<img />").bind("load", function () {
                        var d = c.attr("data-" + j.data_attribute);
                        c.hide(), c.is("img") ? c.attr("src", d) : c.css("background-image", "url('" + d + "')"), c[j.effect](j.effect_speed), b.loaded = !0;
                        var e = a.grep(i, function (a) {
                            return!a.loaded
                        });
                        if (i = a(e), j.load) {
                            var f = i.length;
                            j.load.call(b, f, j)
                        }
                    }).attr("src", c.attr("data-" + j.data_attribute))
                }
            }), 0 !== j.event.indexOf("scroll") && c.bind(j.event, function () {
                b.loaded || c.trigger("appear")
            })
        }), e.bind("resize", function () {
            g()
        }), /(?:iphone|ipod|ipad).*os 5/gi.test(navigator.appVersion) && e.bind("pageshow", function (b) {
            b.originalEvent && b.originalEvent.persisted && i.each(function () {
                a(this).trigger("appear")
            })
        }), a(c).ready(function () {
            g()
        }), this
    }, a.belowthefold = function (c, f) {
        var g;
        return g = f.container === d || f.container === b ? (b.innerHeight ? b.innerHeight : e.height()) + e.scrollTop() : a(f.container).offset().top + a(f.container).height(), g <= a(c).offset().top - f.threshold
    }, a.rightoffold = function (c, f) {
        var g;
        return g = f.container === d || f.container === b ? e.width() + e.scrollLeft() : a(f.container).offset().left + a(f.container).width(), g <= a(c).offset().left - f.threshold
    }, a.abovethetop = function (c, f) {
        var g;
        return g = f.container === d || f.container === b ? e.scrollTop() : a(f.container).offset().top, g >= a(c).offset().top + f.threshold + a(c).height()
    }, a.leftofbegin = function (c, f) {
        var g;
        return g = f.container === d || f.container === b ? e.scrollLeft() : a(f.container).offset().left, g >= a(c).offset().left + f.threshold + a(c).width()
    }, a.inviewport = function (b, c) {
        return!(a.rightoffold(b, c) || a.leftofbegin(b, c) || a.belowthefold(b, c) || a.abovethetop(b, c))
    }, a.extend(a.expr[":"], {"below-the-fold": function (b) {
            return a.belowthefold(b, {threshold: 0})
        }, "above-the-top": function (b) {
            return!a.belowthefold(b, {threshold: 0})
        }, "right-of-screen": function (b) {
            return a.rightoffold(b, {threshold: 0})
        }, "left-of-screen": function (b) {
            return!a.rightoffold(b, {threshold: 0})
        }, "in-viewport": function (b) {
            return a.inviewport(b, {threshold: 0})
        }, "above-the-fold": function (b) {
            return!a.belowthefold(b, {threshold: 0})
        }, "right-of-fold": function (b) {
            return a.rightoffold(b, {threshold: 0})
        }, "left-of-fold": function (b) {
            return!a.rightoffold(b, {threshold: 0})
        }})
}(jQuery, window, document);
/*!
 * clipboard.js v1.5.5
 * https://zenorocha.github.io/clipboard.js
 *
 * Licensed MIT © Zeno Rocha
 */
!function (t) {
    if ("object" == typeof exports && "undefined" != typeof module)
        module.exports = t();
    else if ("function" == typeof define && define.amd)
        define([], t);
    else {
        var e;
        e = "undefined" != typeof window ? window : "undefined" != typeof global ? global : "undefined" != typeof self ? self : this, e.Clipboard = t()
    }
}(function () {
    var t, e, n;
    return function t(e, n, r) {
        function o(a, c) {
            if (!n[a]) {
                if (!e[a]) {
                    var s = "function" == typeof require && require;
                    if (!c && s)
                        return s(a, !0);
                    if (i)
                        return i(a, !0);
                    var u = new Error("Cannot find module '" + a + "'");
                    throw u.code = "MODULE_NOT_FOUND", u
                }
                var l = n[a] = {exports: {}};
                e[a][0].call(l.exports, function (t) {
                    var n = e[a][1][t];
                    return o(n ? n : t)
                }, l, l.exports, t, e, n, r)
            }
            return n[a].exports
        }
        for (var i = "function" == typeof require && require, a = 0; a < r.length; a++)
            o(r[a]);
        return o
    }({1: [function (t, e, n) {
                var r = t("matches-selector");
                e.exports = function (t, e, n) {
                    for (var o = n ? t : t.parentNode; o && o !== document; ) {
                        if (r(o, e))
                            return o;
                        o = o.parentNode
                    }
                }
            }, {"matches-selector": 2}], 2: [function (t, e, n) {
                function r(t, e) {
                    if (i)
                        return i.call(t, e);
                    for (var n = t.parentNode.querySelectorAll(e), r = 0; r < n.length; ++r)
                        if (n[r] == t)
                            return!0;
                    return!1
                }
                var o = Element.prototype, i = o.matchesSelector || o.webkitMatchesSelector || o.mozMatchesSelector || o.msMatchesSelector || o.oMatchesSelector;
                e.exports = r
            }, {}], 3: [function (t, e, n) {
                function r(t, e, n, r) {
                    var i = o.apply(this, arguments);
                    return t.addEventListener(n, i), {destroy: function () {
                            t.removeEventListener(n, i)
                        }}
                }
                function o(t, e, n, r) {
                    return function (n) {
                        n.delegateTarget = i(n.target, e, !0), n.delegateTarget && r.call(t, n)
                    }
                }
                var i = t("closest");
                e.exports = r
            }, {closest: 1}], 4: [function (t, e, n) {
                n.node = function (t) {
                    return void 0 !== t && t instanceof HTMLElement && 1 === t.nodeType
                }, n.nodeList = function (t) {
                    var e = Object.prototype.toString.call(t);
                    return void 0 !== t && ("[object NodeList]" === e || "[object HTMLCollection]" === e) && "length"in t && (0 === t.length || n.node(t[0]))
                }, n.string = function (t) {
                    return"string" == typeof t || t instanceof String
                }, n.function = function (t) {
                    var e = Object.prototype.toString.call(t);
                    return"[object Function]" === e
                }
            }, {}], 5: [function (t, e, n) {
                function r(t, e, n) {
                    if (!t && !e && !n)
                        throw new Error("Missing required arguments");
                    if (!c.string(e))
                        throw new TypeError("Second argument must be a String");
                    if (!c.function(n))
                        throw new TypeError("Third argument must be a Function");
                    if (c.node(t))
                        return o(t, e, n);
                    if (c.nodeList(t))
                        return i(t, e, n);
                    if (c.string(t))
                        return a(t, e, n);
                    throw new TypeError("First argument must be a String, HTMLElement, HTMLCollection, or NodeList")
                }
                function o(t, e, n) {
                    return t.addEventListener(e, n), {destroy: function () {
                            t.removeEventListener(e, n)
                        }}
                }
                function i(t, e, n) {
                    return Array.prototype.forEach.call(t, function (t) {
                        t.addEventListener(e, n)
                    }), {destroy: function () {
                            Array.prototype.forEach.call(t, function (t) {
                                t.removeEventListener(e, n)
                            })
                        }}
                }
                function a(t, e, n) {
                    return s(document.body, t, e, n)
                }
                var c = t("./is"), s = t("delegate");
                e.exports = r
            }, {"./is": 4, delegate: 3}], 6: [function (t, e, n) {
                function r(t) {
                    var e;
                    if ("INPUT" === t.nodeName || "TEXTAREA" === t.nodeName)
                        t.focus(), t.setSelectionRange(0, t.value.length), e = t.value;
                    else {
                        t.hasAttribute("contenteditable") && t.focus();
                        var n = window.getSelection(), r = document.createRange();
                        r.selectNodeContents(t), n.removeAllRanges(), n.addRange(r), e = n.toString()
                    }
                    return e
                }
                e.exports = r
            }, {}], 7: [function (t, e, n) {
                function r() {
                }
                r.prototype = {on: function (t, e, n) {
                        var r = this.e || (this.e = {});
                        return(r[t] || (r[t] = [])).push({fn: e, ctx: n}), this
                    }, once: function (t, e, n) {
                        function r() {
                            o.off(t, r), e.apply(n, arguments)
                        }
                        var o = this;
                        return r._ = e, this.on(t, r, n)
                    }, emit: function (t) {
                        var e = [].slice.call(arguments, 1), n = ((this.e || (this.e = {}))[t] || []).slice(), r = 0, o = n.length;
                        for (r; o > r; r++)
                            n[r].fn.apply(n[r].ctx, e);
                        return this
                    }, off: function (t, e) {
                        var n = this.e || (this.e = {}), r = n[t], o = [];
                        if (r && e)
                            for (var i = 0, a = r.length; a > i; i++)
                                r[i].fn !== e && r[i].fn._ !== e && o.push(r[i]);
                        return o.length ? n[t] = o : delete n[t], this
                    }}, e.exports = r
            }, {}], 8: [function (t, e, n) {
                "use strict";
                function r(t) {
                    return t && t.__esModule ? t : {"default": t}
                }
                function o(t, e) {
                    if (!(t instanceof e))
                        throw new TypeError("Cannot call a class as a function")
                }
                n.__esModule = !0;
                var i = function () {
                    function t(t, e) {
                        for (var n = 0; n < e.length; n++) {
                            var r = e[n];
                            r.enumerable = r.enumerable || !1, r.configurable = !0, "value"in r && (r.writable = !0), Object.defineProperty(t, r.key, r)
                        }
                    }
                    return function (e, n, r) {
                        return n && t(e.prototype, n), r && t(e, r), e
                    }
                }(), a = t("select"), c = r(a), s = function () {
                    function t(e) {
                        o(this, t), this.resolveOptions(e), this.initSelection()
                    }
                    return t.prototype.resolveOptions = function t() {
                        var e = arguments.length <= 0 || void 0 === arguments[0] ? {} : arguments[0];
                        this.action = e.action, this.emitter = e.emitter, this.target = e.target, this.text = e.text, this.trigger = e.trigger, this.selectedText = ""
                    }, t.prototype.initSelection = function t() {
                        if (this.text && this.target)
                            throw new Error('Multiple attributes declared, use either "target" or "text"');
                        if (this.text)
                            this.selectFake();
                        else {
                            if (!this.target)
                                throw new Error('Missing required attributes, use either "target" or "text"');
                            this.selectTarget()
                        }
                    }, t.prototype.selectFake = function t() {
                        var e = this;
                        this.removeFake(), this.fakeHandler = document.body.addEventListener("click", function () {
                            return e.removeFake()
                        }), this.fakeElem = document.createElement("textarea"), this.fakeElem.style.position = "absolute", this.fakeElem.style.left = "-9999px", this.fakeElem.style.top = (window.pageYOffset || document.documentElement.scrollTop) + "px", this.fakeElem.setAttribute("readonly", ""), this.fakeElem.value = this.text, document.body.appendChild(this.fakeElem), this.selectedText = c.default(this.fakeElem), this.copyText()
                    }, t.prototype.removeFake = function t() {
                        this.fakeHandler && (document.body.removeEventListener("click"), this.fakeHandler = null), this.fakeElem && (document.body.removeChild(this.fakeElem), this.fakeElem = null)
                    }, t.prototype.selectTarget = function t() {
                        this.selectedText = c.default(this.target), this.copyText()
                    }, t.prototype.copyText = function t() {
                        var e = void 0;
                        try {
                            e = document.execCommand(this.action)
                        } catch (n) {
                            e = !1
                        }
                        this.handleResult(e)
                    }, t.prototype.handleResult = function t(e) {
                        e ? this.emitter.emit("success", {action: this.action, text: this.selectedText, trigger: this.trigger, clearSelection: this.clearSelection.bind(this)}) : this.emitter.emit("error", {action: this.action, trigger: this.trigger, clearSelection: this.clearSelection.bind(this)})
                    }, t.prototype.clearSelection = function t() {
                        this.target && this.target.blur(), window.getSelection().removeAllRanges()
                    }, t.prototype.destroy = function t() {
                        this.removeFake()
                    }, i(t, [{key: "action", set: function t() {
                                var e = arguments.length <= 0 || void 0 === arguments[0] ? "copy" : arguments[0];
                                if (this._action = e, "copy" !== this._action && "cut" !== this._action)
                                    throw new Error('Invalid "action" value, use either "copy" or "cut"')
                            }, get: function t() {
                                return this._action
                            }}, {key: "target", set: function t(e) {
                                if (void 0 !== e) {
                                    if (!e || "object" != typeof e || 1 !== e.nodeType)
                                        throw new Error('Invalid "target" value, use a valid Element');
                                    this._target = e
                                }
                            }, get: function t() {
                                return this._target
                            }}]), t
                }();
                n.default = s, e.exports = n.default
            }, {select: 6}], 9: [function (t, e, n) {
                "use strict";
                function r(t) {
                    return t && t.__esModule ? t : {"default": t}
                }
                function o(t, e) {
                    if (!(t instanceof e))
                        throw new TypeError("Cannot call a class as a function")
                }
                function i(t, e) {
                    if ("function" != typeof e && null !== e)
                        throw new TypeError("Super expression must either be null or a function, not " + typeof e);
                    t.prototype = Object.create(e && e.prototype, {constructor: {value: t, enumerable: !1, writable: !0, configurable: !0}}), e && (Object.setPrototypeOf ? Object.setPrototypeOf(t, e) : t.__proto__ = e)
                }
                function a(t, e) {
                    var n = "data-clipboard-" + t;
                    if (e.hasAttribute(n))
                        return e.getAttribute(n)
                }
                n.__esModule = !0;
                var c = t("./clipboard-action"), s = r(c), u = t("tiny-emitter"), l = r(u), f = t("good-listener"), d = r(f), h = function (t) {
                    function e(n, r) {
                        o(this, e), t.call(this), this.resolveOptions(r), this.listenClick(n)
                    }
                    return i(e, t), e.prototype.resolveOptions = function t() {
                        var e = arguments.length <= 0 || void 0 === arguments[0] ? {} : arguments[0];
                        this.action = "function" == typeof e.action ? e.action : this.defaultAction, this.target = "function" == typeof e.target ? e.target : this.defaultTarget, this.text = "function" == typeof e.text ? e.text : this.defaultText
                    }, e.prototype.listenClick = function t(e) {
                        var n = this;
                        this.listener = d.default(e, "click", function (t) {
                            return n.onClick(t)
                        })
                    }, e.prototype.onClick = function t(e) {
                        var n = e.delegateTarget || e.currentTarget;
                        this.clipboardAction && (this.clipboardAction = null), this.clipboardAction = new s.default({action: this.action(n), target: this.target(n), text: this.text(n), trigger: n, emitter: this})
                    }, e.prototype.defaultAction = function t(e) {
                        return a("action", e)
                    }, e.prototype.defaultTarget = function t(e) {
                        var n = a("target", e);
                        return n ? document.querySelector(n) : void 0
                    }, e.prototype.defaultText = function t(e) {
                        return a("text", e)
                    }, e.prototype.destroy = function t() {
                        this.listener.destroy(), this.clipboardAction && (this.clipboardAction.destroy(), this.clipboardAction = null)
                    }, e
                }(l.default);
                n.default = h, e.exports = n.default
            }, {"./clipboard-action": 8, "good-listener": 5, "tiny-emitter": 7}]}, {}, [9])(9)
});
rebind();