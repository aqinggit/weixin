var ajaxReturn = true;
var beforeModal;
function rebind() {
    $("img.lazy").lazyload({
        threshold:600
    });
    /**
    * 获取内容
    * @param {type} dom
    * @param {type} t 类型
    * @param {type} k keyid
    * @param {type} p 页码
    * @returns {Boolean}
    */
    $("a[action=getContents]").unbind('tap').tap(function () {
        var dom = $(this);
        var acdata = dom.attr("data-id");
        var t = dom.attr("data-type");
        var p = dom.attr("data-page");
        var targetBox = dom.attr('data-target');
        if (!targetBox) {
            return false;
        }
        if(dom.attr('data-loaded')==='1'){
            $('#' + targetBox+'-box').hide();
            dom.attr('data-loaded',0);
            return false;
        }
        if (!p) {
            p = 1;
        }
        var loading = '<div class="loading-holder"><a class="btn btn-default disabled" href="javascript:;">拼命加载中...</a></div>';
        $('#' + targetBox).children('.loading-holder').each(function () {
            $(this).remove();
        });
        $('#' + targetBox).append(loading);
        $('#' + targetBox+'-box').show();
        $.post(zmf.ajaxUrl, {action:'getContents',type: t, page: p, data: acdata, YII_CSRF_TOKEN: zmf.csrfToken}, function (result) {
            ajaxReturn = true;
            dom.attr('data-loaded', 1);
            result = $.parseJSON(result);
            if (result.status === 1) {
                var data = result.msg;
                var pageHtml = '', dataHtml = '';
                if (data.html !== '') {
                    dataHtml += data.html;
                }
                if (data.loadMore === 1) {
                    var _p = parseInt(p) + 1;
                    pageHtml += '<div class="loading-holder"><a class="btn btn-default"  href="javascript:;" action="getContents" data-type="' + t + '" data-id="' + acdata + '" data-page="' + _p + '" data-target="' + targetBox + '">加载更多</a></div>';
                } else {
                    if(data.html==='' && p===1){
                        pageHtml += '';
                    }else{
                        pageHtml += '<div class="loading-holder"><a class="btn btn-default disabled" href="javascript:;">已全部加载</a></div>';
                    }
                }                
                $('#' + targetBox + ' .loading-holder').each(function () {
                    $(this).remove();
                });                
                if (p > 1) {
                    $('#' + targetBox).append(dataHtml);
                } else {
                    if(data.html === ''){
                        dataHtml='<div class="help-block text-center">暂无内容</div>';
                    }
                    $('#' + targetBox).html(dataHtml);
                }
                $('#' + targetBox).append(pageHtml);
                if(p===1){
                    $('#' + targetBox + '-form').html(data.formHtml);
                }
                rebind();
            } else {
                simpleDialog({content: result.msg});
            }
        });
    });
    $("a[action=ajax-contents]").unbind('tap').tap(function () {
        var dom = $(this);
        ajaxContents(dom);
    });
    $("a[action=scroll]").unbind('tap').tap(function () {
        var dom = $(this);
        var to = dom.attr("action-target");
        if (!to) {
            return false;
        }
        $("body,html").animate({
            scrollTop: $('#' + to).offset().top
        }, 200);
    });
    $('.showContact').unbind('tap').tap(function () {
        $('#JS_contact_holder').toggle();
        stopDefault();
    });
    $('#JS_contact_close').unbind('tap').tap(function () {
        $('#JS_contact_holder').hide();
        stopDefault();
    });
    $('#sendSms-btn').unbind('tap').tap(function () {
        var dom = $(this);
        var _target = dom.attr('data-target');
        if (!_target) {
            simpleDialog({msg: '请输入手机号'});
            return false;
        }
        var phone = $('#' + _target).val();
        if (!phone) {
            $('#' + _target).focus();
            simpleDialog({msg: '请输入手机号'});
            return false;
        }
        var type = dom.attr('data-type');
        if (!type) {
            simpleDialog({msg: '缺少类型参数'});
            return false;
        }
        if(type==='login' || type==='reg'){
            var validom = $('#validate-code');
            var valicode = validom.val();
//            if (!valicode) {
//                validom.focus();
//                simpleDialog({msg: '请输入校验码'});
//                return false;
//            }
        }
        if (!checkAjax()) {
            return false;
        }
        $.post(zmf.ajaxUrl, {action: 'sendSms', type: type, phone: phone,valicode:valicode, YII_CSRF_TOKEN: zmf.csrfToken}, function (result) {
            ajaxReturn=true;
            result = eval('(' + result + ')');
            if (result.status === 1) {
                var totalTime = 60, times = 0;
                dom.text('重新发送 ' + totalTime + 's').attr('disabled', 'disabled');
                var interval = setInterval(function () {
                    times += 1;
                    var time = totalTime - times;
                    dom.text('重新发送 ' + time + 's');
                    if (time <= 0) {
                        clearInterval(interval);
                        dom.removeAttr('disabled').text('重新发送');
                    }
                }, 1000);
                //$('.nextStep-btn').removeAttr('disabled');
            } else {
                simpleDialog({msg: result.msg});
            }
        });
    });
    if(zmf.remaindSendSmsTime>0){
        var dom=$('#sendSms-btn');
        var totalTime = zmf.remaindSendSmsTime, times = 0;
        dom.text('重新发送 ' + totalTime + 's').attr('disabled', 'disabled');
        var interval = setInterval(function () {
            times += 1;
            var time = totalTime - times;
            dom.text('重新发送 ' + time + 's');
            if (time <= 0) {
                clearInterval(interval);
                dom.removeAttr('disabled').text('重新发送');
            }
        }, 1000);
    }
    $('#login-btn').unbind('tap').tap(function () {
        var type = $('#login-type').val();
        if (!type || (type !== 'passwd' && type !== 'sms')) {
            simpleDialog({msg: '参数错误'});
            return false;
        }
        var phone = $('#login-phone').val();
        if (!phone) {
            simpleDialog({msg: '请输入手机号'});
            return false;
        }
        var validom = $('#validate-code');
        var value = '';
        if (type === 'passwd') {
            value = $('#login-password').val();
            if (!value) {
                $('#login-password').focus();
                simpleDialog({msg: '请输入密码'});
                return false;
            }
        } else if (type === 'sms') {
            var valicode = validom.val();
            if (!valicode) {
                //validom.focus();
                //simpleDialog({msg: '请输入校验码'});
                //return false;
            }
            value = $('#login-code').val();
            if (!value) {
                $('#login-code').focus();
                simpleDialog({msg: '请输入验证码'});
                return false;
            }
        }
        if (!value) {
            simpleDialog({msg: '缺少参数'});
            return false;
        }
        var bind=$('#login-bind').val();
        if(!bind || typeof bind==='undefined'){
            bind='';
        }
        if (!checkAjax()) {
            return false;
        }
        $.post(zmf.ajaxUrl, {action: 'login', type: type, phone: phone, value: value,_valiCode:valicode,bind:bind, YII_CSRF_TOKEN: zmf.csrfToken}, function (result) {
            ajaxReturn=true;
            result = eval('(' + result + ')');
            if (result.status === 1) {
                window.location.href = result.msg;
            }else if(result.status===-9){
                simpleDialog({msg: result.msg});
                $('#validate-code-img').click();
            } else {
                simpleDialog({msg: result.msg});
            }
        });
    });

    $('#reg-btn').unbind('tap').tap(function () {
        var pdom = $('#reg-phone');
        var codedom = $('#reg-code');
        var unamedom = $('#reg-username');
        var passwddom = $('#reg-password');
        var validom = $('#validate-code');
        var phone = pdom.val();
        if (!phone) {
            pdom.focus();
            simpleDialog({msg: '请输入常用手机号'});
            return false;
        }
        var valicode = validom.val();
        if (!valicode) {
//            validom.focus();
//            simpleDialog({msg: '请输入校验码'});
//            return false;
        }
        var code = codedom.val();
        if (!code) {
            codedom.focus();
            simpleDialog({msg: '请输入验证码'});
            return false;
        }
        var name = unamedom.val();
        if (!name) {
            unamedom.focus();
            simpleDialog({msg: '请输入昵称'});
            return false;
        }
        var passwd = passwddom.val();
        if (!passwd) {
            passwddom.focus();
            simpleDialog({msg: '请输入密码'});
            return false;
        }
        if (passwd.length < 6) {
            passwddom.focus();
            simpleDialog({msg: '密码长度不短于6位'});
            return false;
        }
        var bind=$('#reg-bind').val();
        if(!bind || typeof bind==='undefined'){
            bind='';
        }
        if (!checkAjax()) {
            return false;
        }
        var passData={
            action: 'reg',
            name: name,
            phone: phone,
            code: code,
            passwd: passwd,
            ucode: $('#reg-ucode').val(),
            _valiCode:valicode,
            bind:bind,
            YII_CSRF_TOKEN: zmf.csrfToken
        };
        $.post(zmf.ajaxUrl,passData , function (result) {
            ajaxReturn=true;
            result = eval('(' + result + ')');
            if (result.status === 1) {
                window.location.href = result.msg;
            }else if(result.status===-9){
                simpleDialog({msg: result.msg});
                $('#validate-code-img').click();
            } else {
                simpleDialog({msg: result.msg});
            }
        });
    });
    $('.sendSms-btn').unbind('tap').tap(function () {
        var dom = $(this);
        var _target = dom.attr('data-target');
        if (!_target) {
            simpleDialog({content: '请输入手机号'});
            return false;
        }
        var phone = $('#' + _target).val();
        if (!phone) {
            simpleDialog({content: '请输入手机号'});
            return false;
        }
        var type = dom.attr('data-type');
        if (!type) {
            simpleDialog({content: '缺少类型参数'});
            return false;
        }
        $.post(zmf.ajaxUrl, {action: 'sendSms', type: type, phone: phone, YII_CSRF_TOKEN: zmf.csrfToken}, function (result) {
            result = eval('(' + result + ')');
            if (result['status'] === 1) {
                var totalTime=60,times=0;
                dom.text('重新发送 '+totalTime+'s').attr('disabled','disabled');                
                var interval = setInterval(function(){
                    times+=1;
                    var time = totalTime-times;
                    dom.text('重新发送 '+time+'s');
                    if(time <= 0) {
                        clearInterval(interval);
                        dom.removeAttr('disabled').text('重新发送');
                    }
                }, 1000);
                $('#forgot-hidden').show();
            } else {
                simpleDialog({content: result['msg']});
            }
        });
    });
}
function showNavDia(){
    $('#JS_fixed_nav_holder').show().animate({right:0});
}
function closeNavDia(){
    var $dom=$('#JS_fixed_nav_holder');
    $dom.animate({right:'-1000px'},300,'linear')
}
/**
 * 获取内容
 * @param {type} dom
 * @param {type} t 类型
 * @param {type} k keyid
 * @param {type} p 页码
 * @returns {Boolean}
 */
function getContents(dom) {
    var acdata = dom.attr("action-data");
    var t = dom.attr("action-type");
    var p = dom.attr("action-page");
    var targetBox = dom.attr('action-target');
    if (!checkAjax()) {
        return false;
    }
    if (!targetBox) {
        return false;
    }
    if (!p) {
        p = 1;
    }
    var btnHtml='',loadingCss='';
    if(zmf.module==='magazine'){
        btnHtml='btn btn-default btn-block';
    }else{
        btnHtml='ui-btn-lg';
        loadingCss='ui-btn-wrap';
    }
    var loading = '<div class="loading-holder '+loadingCss+'"><a class="'+btnHtml+' disabled" href="javascript:;">拼命加载中...</a></div>';
    $('#' + targetBox + '-box').children('.loading-holder').each(function () {
        $(this).remove();
    });
    $('#' + targetBox + '-box').append(loading);
    $.post(zmf.contentsUrl, {type: t, page: p, data: acdata, YII_CSRF_TOKEN: zmf.csrfToken}, function (result) {
        ajaxReturn = true;
        dom.attr('loaded', '1');
        result = $.parseJSON(result);
        if (result.status === 1) {
            var data = result.msg;

            var pageHtml = '', dataHtml = '';

            if (data.html !== '') {
                dataHtml += data.html;
            }

            if (data.loadMore === 1) {
                var _p = parseInt(p) + 1;
                pageHtml += '<div class="loading-holder '+loadingCss+'"><a class="'+btnHtml+'"  href="javascript:;" action="get-contents" action-type="' + t + '" action-data="' + acdata + '" action-page="' + _p + '" action-target="' + targetBox + '">加载更多</a></div>';
            } else {
                pageHtml += '<div class="loading-holder '+loadingCss+'"><a class="'+btnHtml+' disabled" href="javascript:;">已全部加载</a></div>';
            }

            if (p === 1) {
                $('#' + targetBox + '-box').append(data.formHtml);
                $('#' + targetBox + '-box .loading-holder').each(function () {
                    $(this).remove();
                });
            } else {
                $('#' + targetBox + '-box .loading-holder').each(function () {
                    $(this).remove();
                });
            }
            if (p > 1) {
                $('#' + targetBox).append(dataHtml);
            } else {
                $('#' + targetBox).html(dataHtml);
            }
            $('#' + targetBox + '-box').append(pageHtml);

            rebind();
        } else {
            simpleDialog({content: result.msg});
        }
    });

}
function ajaxContents(dom) {
    stopDefault();
    var p = dom.attr("action-page");
    var targetBox = dom.attr('action-target');
    var url = dom.attr('href');
    if (!targetBox || !url) {
        return false;
    }
    if (!p) {
        p = 1;
    }
    var loading = '<div class="loading-holder"><a class="btn btn-default" href="javascript:;"><i class="weui-loading"></i> 拼命加载中...</a></div>';
    $('#' + targetBox + '-box').children('.loading-holder').each(function () {
        $(this).remove();
    });
    $('#' + targetBox + '-box').append(loading);
    $.post(url, {page: p, YII_CSRF_TOKEN: zmf.csrfToken}, function (result) {
        ajaxReturn = true;
        dom.attr('loaded', '1');
        result = $.parseJSON(result);
        if (result.status === 1) {
            var data = result.msg;
            var pageHtml = '', dataHtml = '';
            if (data.html !== '') {
                dataHtml += data.html;
            }
            if (data.loadMore === 1) {
                var _p = parseInt(p) + 1;
                pageHtml += '<div class="loading-holder"><a class="btn btn-default"  href="' + data.url + '" action="ajax-contents" action-page="' + _p + '" action-target="' + targetBox + '">加载更多</a></div>';
            } else {
                pageHtml += '<div class="loading-holder"><a class="btn btn-default" href="javascript:;">已全部加载</a></div>';
            }

            if (p === 1) {
                $('#' + targetBox + '-box').append(data.formHtml);
                $('#' + targetBox + '-box .loading-holder').each(function () {
                    $(this).remove();
                });
            } else {
                $('#' + targetBox + '-box .loading-holder').each(function () {
                    $(this).remove();
                });
            }
            if (p > 1) {
                $('#' + targetBox).append(dataHtml);
            } else {
                $('#' + targetBox).html(dataHtml);
            }
            $('#' + targetBox + '-box').append(pageHtml);
            rebind();
        } else {
            simpleDialog({content: result.msg});
        }
    });

}
function closeConfirmDialog(){
    var $iosActionsheet = $('#confirmDialog');        
    $iosActionsheet.fadeOut(200);    
}
function confirmDialog(obj){
    if (typeof obj !== "object") {
        return false;
    }
    closeConfirmDialog();
    var html='<div id="confirmDialog"><div class="weui-mask"></div><div class="weui-dialog"><div class="weui-dialog__hd"><strong class="weui-dialog__title">'+obj.title+'</strong></div><div class="weui-dialog__bd">'+obj.content+'</div><div class="weui-dialog__ft"><a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_default" onClick="closeConfirmDialog()">'+obj.cancelTitle+'</a><a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary" id="_confirm_dialog_confirm">'+obj.confirmTitle+'</a></div></div></div>';
    var $confirmDialog = $('#confirmDialog');
    if($confirmDialog.length>0){
        $confirmDialog.remove();
    }
    $("body").append(html);
    $confirmDialog.fadeIn(200);
    $('#_confirm_dialog_confirm').on('tap', obj.confirmFunc);    
}
function closeActionsSheet(event){
    stopDefault(event);
    var $iosActionsheet = $('#iosActionsheet');
    var $iosMask = $('#iosMask');
    $iosActionsheet.removeClass('weui-actionsheet_toggle');
    $iosMask.fadeOut(200);
}
function showActionsSheet(obj){
    if (typeof obj !== "object") {
        return false;
    }
    stopDefault();
    closeActionsSheet();
    var html='<div class="weui-mask" id="iosMask" style="display: none;"></div><div class="weui-actionsheet" id="iosActionsheet"><div class="weui-actionsheet__title"><p class="weui-actionsheet__title-text">'+obj.title+'</p></div><div class="weui-actionsheet__menu">'+obj.actions+'</div><div class="weui-actionsheet__action"><div class="weui-actionsheet__cell" id="iosActionsheetCancel">取消</div></div></div>';
    var $iosActionsheet = $('#iosActionsheet');
    var $iosMask = $('#iosMask');
    if($iosActionsheet.length>0){
        $iosActionsheet.remove();
        $iosMask.remove();
    }
    $("body").append(html);
    var $iosActionsheet = $('#iosActionsheet');
    var $iosMask = $('#iosMask');
    function hideActionSheet() {
        stopDefault();
        $iosActionsheet.removeClass('weui-actionsheet_toggle');
        $iosMask.fadeOut(200);
    }
    $iosMask.on('tap', hideActionSheet);
    $('#iosActionsheetCancel').on('tap', hideActionSheet);
    $iosActionsheet.addClass('weui-actionsheet_toggle');
    $iosMask.fadeIn(200);
}
function showLoading(){
    var html='<div id="loadingToast" style="display: none;"><div class="weui-mask_transparent"></div><div class="weui-toast"><i class="weui-loading weui-icon_toast"></i><p class="weui-toast__content">数据加载中</p></div></div>';
    var $loadingToast = $('#loadingToast');  
    if($loadingToast.length>0){
        $loadingToast.remove();
    }
    $("body").append(html);
    var $loadingToast = $('#loadingToast');    
    if ($loadingToast.css('display') !== 'none') return;
    $loadingToast.fadeIn(100);
    setTimeout(function () {
        $loadingToast.fadeOut(100);
    }, 2000);    
}
function closeLoading(){
    $('#loadingToast').fadeOut(100);
}
function dialog(diaObj) {
    if (typeof diaObj !== "object") {
        return false;
    }
    closeSimpleDialog();
    var c = diaObj.msg;
    var longstr = '<div class="simpleDialog '+(diaObj.status===1 ? 'succDialog' : 'errDialog')+'" id="simpleDialog">' + c + '</div>';
    $("body").append(longstr);
    var dom = $('#simpleDialog');
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
    $('#simpleDialog').fadeOut(100).remove();
}
function scollToComment(){
    $('.toggle-area').each(function(){
        $(this).fadeIn(500);
    });
    var h=$(window).height();
    var _h=$(".comment-textarea").offset().top;        
    $("body,html").animate({
        scrollTop: _h
    }, 200);    
}
function simpleDialog(diaObj) {
    if (typeof diaObj !== "object") {
        return false;
    }
    closeSimpleDialog();
    var c = diaObj.content || diaObj.msg;
    var longstr = '<div class="simpleDialog errDialog">' + c + '</div>';
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
            };  
        }, 600);  
        return [flashTitle.timer, flashTitle.title];  
    },  
    // 取消新消息提示  
    clear: function () {  
        clearTimeout(flashTitle.timer);  
        document.title = flashTitle.title;  
    }  
};  
function getNotice(){
    doGetNotice();
    window.setInterval("doGetNotice()",10000);
}
function doGetNotice(){
    if(!checkLogin()){
        return false;
    }
    $.post(zmf.ajaxUrl, {action:'getNotice',YII_CSRF_TOKEN: zmf.csrfToken}, function (result) {
        result = $.parseJSON(result);
        if (result.status === 1) {
            var _num=parseInt(result.msg);
            if(_num>0){
                $('#top-nav-count').html(_num).css('display','inline-block');
                if(flashTitle.timer===null){
                    flashTitle.show();
                }                
            }else{
                $('#top-nav-count').hide();
                flashTitle.clear();
            }
        }else{
            
        }
    })
}
function closeSimpleDialog() {
    $('.simpleDialog').fadeOut(100).remove();
}
function checkAjax() {
    if (!ajaxReturn) {
        simpleDialog({content: '请求正在发送中，请稍后'});
        return false;
    }
    ajaxReturn = false;
    return true;
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
/*lazyload*/
!function (a, b, c, d) {
    var e = a(b);
    a.fn.lazyload = function (c) {
        function i() {
            var b = 0;
            f.each(function () {
                var c = a(this);
                if (!h.skip_invisible || "none" !== c.css("display"))
                    if (a.abovethetop(this, h) || a.leftofbegin(this, h))
                        ;
                    else if (a.belowthefold(this, h) || a.rightoffold(this, h)) {
                        if (++b > h.failure_limit)
                            return!1
                    } else
                        c.trigger("appear"), b = 0
            })
        }
        var g, f = this, h = {threshold: 0, failure_limit: 0, event: "scroll", effect: "show", container: b, data_attribute: "original", skip_invisible: !0, appear: null, load: null};
        return c && (d !== c.failurelimit && (c.failure_limit = c.failurelimit, delete c.failurelimit), d !== c.effectspeed && (c.effect_speed = c.effectspeed, delete c.effectspeed), a.extend(h, c)), g = h.container === d || h.container === b ? e : a(h.container), 0 === h.event.indexOf("scroll") && g.on(h.event, function () {
            return i()
        }), this.each(function () {
            var b = this, c = a(b);
            b.loaded = !1, c.one("appear", function () {
                if (!this.loaded) {
                    if (h.appear) {
                        var d = f.length;
                        h.appear.call(b, d, h)
                    }
                    a("<img />").on("load", function () {
                        var d, e;
                        c.hide().attr("src", c.data(h.data_attribute))[h.effect](h.effect_speed), b.loaded = !0, d = a.grep(f, function (a) {
                            return!a.loaded
                        }), f = a(d), h.load && (e = f.length, h.load.call(b, e, h))
                    }).attr("src", c.data(h.data_attribute))
                }
            }), 0 !== h.event.indexOf("scroll") && c.on(h.event, function () {
                b.loaded || c.trigger("appear")
            })
        }), e.on("resize", function () {
            i()
        }), /iphone|ipod|ipad.*os 5/gi.test(navigator.appVersion) && e.on("pageshow", function (b) {
            b = b.originalEvent || b, b.persisted && f.each(function () {
                a(this).trigger("appear")
            })
        }), a(b).on("load", function () {
            i()
        }), this
    }, a.belowthefold = function (c, f) {
        var g;
        return g = f.container === d || f.container === b ? e.height() + e.scrollTop() : a(f.container).offset().top + a(f.container).height(), g <= a(c).offset().top - f.threshold
    }, a.rightoffold = function (c, f) {
        var g;
        return g = f.container === d || f.container === b ? e.width() + e[0].scrollX : a(f.container).offset().left + a(f.container).width(), g <= a(c).offset().left - f.threshold
    }, a.abovethetop = function (c, f) {
        var g;
        return g = f.container === d || f.container === b ? e.scrollTop() : a(f.container).offset().top, g >= a(c).offset().top + f.threshold + a(c).height()
    }, a.leftofbegin = function (c, f) {
        var g;
        return g = f.container === d || f.container === b ? e[0].scrollX : a(f.container).offset().left, g >= a(c).offset().left + f.threshold + a(c).width()
    }, a.inviewport = function (b, c) {
        return!(a.rightoffold(b, c) || a.leftofbegin(b, c) || a.belowthefold(b, c) || a.abovethetop(b, c))
    }, a.extend(a.fn, {"below-the-fold": function (b) {
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
}($, window, document);
/*jquery.pin*/
(function(e){"use strict";e.fn.pin=function(t){var n=0,r=[],i=false,s=e(window);t=t||{};var o=function(){for(var n=0,o=r.length;n<o;n++){var u=r[n];if(t.minWidth&&s.width()<=t.minWidth){if(u.parent().is(".pin-wrapper")){u.unwrap()}u.css({width:"",left:"",top:"",position:""});if(t.activeClass){u.removeClass(t.activeClass)}i=true;continue}else{i=false}var a=t.containerSelector?u.closest(t.containerSelector):e(document.body);var f=u.offset();var l=a.offset();var c=u.offsetParent().offset();if(!u.parent().is(".pin-wrapper")){u.wrap("<div class='pin-wrapper'>")}var h=e.extend({top:0,bottom:0},t.padding||{});u.data("pin",{pad:h,from:(t.containerSelector?l.top:f.top)-h.top,to:l.top+a.height()-u.outerHeight()-h.bottom,end:l.top+a.height(),parentTop:c.top});u.css({width:u.outerWidth()});u.parent().css("height",u.outerHeight())}};var u=function(){if(i){return}n=s.scrollTop();var o=[];for(var u=0,a=r.length;u<a;u++){var f=e(r[u]),l=f.data("pin");if(!l){continue}o.push(f);var c=l.from-l.pad.bottom,h=l.to-l.pad.top;if(c+f.outerHeight()>l.end){f.css("position","");continue}if(c<n&&h>n){!(f.css("position")=="fixed")&&f.css({left:f.offset().left,top:l.pad.top}).css("position","fixed");if(t.activeClass){f.addClass(t.activeClass)}}else if(n>=h){f.css({left:"",top:h-l.parentTop+l.pad.top}).css("position","absolute");if(t.activeClass){f.addClass(t.activeClass)}}else{f.css({position:"",top:"",left:""});if(t.activeClass){f.removeClass(t.activeClass)}}}r=o};var a=function(){o();u()};this.each(function(){var t=e(this),n=e(this).data("pin")||{};if(n&&n.update){return}r.push(t);e("img",this).one("load",o);n.update=a;e(this).data("pin",n)});s.scroll(u);s.resize(function(){o()});o();s.load(a);return this}})(jQuery)
rebind();
//getNotice();