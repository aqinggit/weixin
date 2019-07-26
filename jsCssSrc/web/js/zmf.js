var tipsImgOrder = 0;
var beforeModal;
var ajaxReturn = true;
var _topNavTimer;
var navTimeout, navTimeover;//导航卡片
var areaTimeout,areaTimeover;//地区卡片
var letterTimeout;//字母
/*搜索框*/
var curr_suggitem = 0, lastv = '', search_keyup_t;
var url = window.location.href;
$(window).scroll(function () {
    $(window).scrollTop() > 100 ? $(".back-to-top").css({display:'block'}) : $(".back-to-top").fadeOut();
    var ndom=$('#navigation');
    var nh=ndom.height();
    $(window).scrollTop() > nh ? ndom.addClass('navbar-shadow') : ndom.removeClass('navbar-shadow');
}), $(".back-to-top").click(function () {
    return $("body,html").animate({
        scrollTop: 0
    }, 200), !1;
}), $(window).resize(function () {
    backToTop();
}), backToTop();
function rebind() {
    $('#site-info-holder').html($('#site-info-html').html());
    $('#area-letternav a.area-letter').click(function() {
        stopDefault();
        var target=$(this).attr('data-offset');
        clearTimeout(letterTimeout);
        $("#area-body").animate({
            scrollTop: target-165
        }, 200);
    });
    $('#area-letternav a.area-letter').mouseover(function() {
        var target=$(this).attr('data-offset');
        clearTimeout(letterTimeout);
        letterTimeout = setTimeout(function() {
            $("#area-body").animate({
                scrollTop: target-165
            }, 200);
        }, 150);
    });
    $('#area-letternav a.area-letter').mouseout(function() {
        clearTimeout(letterTimeout);
    });
    $("#site-info-toggle,#site-info-holder").mouseover(function() {
        clearTimeout(areaTimeout);
        areaTimeover = setTimeout(function() {
            $('#site-info-holder').show();
            $('#area-letternav a.area-letter').each(function() {
                var dom=$(this);
                if(!dom.attr('data-offset')){
                    var target=dom.attr('href');
                    var bodyTop=$('#navigation').offset().top;
                    dom.attr('data-offset',$(target).offset().top-bodyTop);
                }
            });
        }, 100);
    });
    $("#site-info-toggle,#site-info-holder").mouseout(function() {
        clearTimeout(areaTimeover);
        areaTimeout = setTimeout(function() {
            $('#site-info-holder').hide();
        }, 300);
    });
    $("img.lazy").lazyload({
        threshold: 600,
        failure_limit : 50,
        skip_invisible : false
    });
    $('#add-post-btn').unbind('click').click(function () {
        $(window).unbind('beforeunload');
    });
    $('.sendSms-btn').unbind('click').click(function () {
        var dom = $(this);
        var _target = dom.attr('data-target');
        var phone = $('#' + _target).val();
        var type = dom.attr('data-type');
        if (!_target) {
            simpleDialog({msg: '请输入手机号'});
            return false;
        }
        if (!phone && type!=='expasswd') {
            $('#' + _target).focus();
            simpleDialog({msg: '请输入手机号'});
            return false;
        }
        if (!type) {
            simpleDialog({msg: '缺少类型参数'});
            return false;
        }
        if (!checkAjax()) {
            return false;
        }
        $.post(zmf.ajaxUrl, {action: 'sendSms', type: type, phone: phone ? phone : '', YII_CSRF_TOKEN: zmf.csrfToken}, function (result) {
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
            } else {
                simpleDialog({msg: result.msg});
            }
        });
    });
    if(zmf.remaindSendSmsTime>0){
        $('.sendSms-btn').each(function(){
            var dom=$(this);
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
        })
    }
    $('#login-btn').unbind('click').click(function () {
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
                simpleDialog({msg: '请输入验证码'});
                return false;
            }
        }
        if (!value) {
            simpleDialog({msg: '缺少参数'});
            return false;
        }
        if (!checkAjax()) {
            return false;
        }
        $.post(zmf.ajaxUrl, {action: 'login', type: type, phone: phone, value: value,_valiCode:valicode, YII_CSRF_TOKEN: zmf.csrfToken}, function (result) {
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
    $('#login-phone,#reg-phone').keyup(function(){
        var dom=$(this);
        if(dom.val()){
            $('.sendSms-btn').removeClass('disabled').removeAttr('disabled');
        }else{
            $('.sendSms-btn').addClass('disabled').attr('disabled','disabled');
        }
    });
    $('#reg-btn').unbind('click').click(function () {
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
            //validom.focus();
            //simpleDialog({msg: '请输入校验码'});
            //return false;
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
            YII_CSRF_TOKEN: zmf.csrfToken
        };
        $.post(zmf.ajaxUrl, passData, function (result) {
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
    $('#fixed-contact-us ._item').unbind('click').click(function(){
        var dom=$(this);
        var cdom=dom.children('span');
        var tar=dom.attr('data-target');
        $('#fixed-contact-us ._item').each(function(){
            var _dom=$(this);
            var _cdom=_dom.children('span');
            var _tar=_dom.attr('data-target');

            if(_tar!==tar){
                if($('#'+_tar).css('display')!=='none'){
                    $('#'+_tar).fadeOut();
                    _cdom.removeClass('remove');
                }
            }
        });
        if($('#'+tar).css('display')!=='none'){
            $('#'+tar).fadeOut();
            cdom.removeClass('remove');
        }else{
            $('#'+tar).fadeIn();
            cdom.addClass('remove')
        }
    });
}
function searchKeyup(e, type) {
    searchTimeOut(e, type);
    var event = e || window.event;
    var etarget = event.target || event.srcElement;
    if (event.keyCode == 13) {
        if (navigator.userAgent.toUpperCase().indexOf("MSIE") != -1 && lastv != etarget.value) {
            lastv = etarget.value;
            return false;
        }
        $(etarget).siblings("#search-btn").click();
    } else if (event.keyCode == 38 || event.keyCode == 40) {
        if ($("#JS_search_autocomplete").css("display") == "block") {
            var itemlist = $("._search_item");
            itemlist.removeClass('active');
            itemlist.eq(curr_suggitem).addClass('active');
            $(event.target).val(itemlist.eq(curr_suggitem).text());
            if (curr_suggitem < itemlist.length) {
                curr_suggitem++;
            } else {
                curr_suggitem = 0;
            }
        }
    }
    lastv = etarget.value;
}
function hideSearch() {
    clearTimeout(search_keyup_t);
    search_keyup_t = setTimeout(function() {
        $("#JS_search_autocomplete").html('').hide();
    }, 500);
}
function showSearchPlaceholder(){
    $('#JS_search_autocomplete').html($('#JS_search_placeholder').html()).show();
}
function searchTimeOut(e, type) {
    var event = e || window.event;
    clearTimeout(search_keyup_t);
    if (event.keyCode != 38 && event.keyCode != 40) {
        search_keyup_t = setTimeout(function() {
            var c = $('#JS_search_keyword').val();
            if (!c) {
                showSearchPlaceholder();
                return false;
            }else{
                $('#JS_search_autocomplete').html('');
            }
            var passData={
                action: 'search',
                keyword: c,
                YII_CSRF_TOKEN: zmf.csrfToken
            };
            $.post(zmf.ajaxUrl,passData , function (res) {
                res = $.parseJSON(res);
                ajaxReturn = true;
                if(res.status===1 ){
                    $('#JS_search_autocomplete').html(res.msg).show();
                }else{
                    hideSearch();
                }
            });
        }, 500);
    }
    showSearchPlaceholder();
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
function backToTop() {
    var x = $(window).width();
    var x2 = $("#back-to-top").width();
    var x3 = parseInt((x + 16) / 2);
    $("#back-to-top").css('left', x3 + 'px');
    //让body至少为窗口高度
    var wh = $(window).height();
    var dh = $(document.body).height();
    if (wh > dh) {
        $("body").css('height', wh);
    }
    $('#footer-bg').fadeIn(3000);
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
function showLogin(){
    var regAndLogin=zmf.regAndLogin;
    if(regAndLogin!=1){
        return false;
    }
    $.post(zmf.ajaxUrl, {action:'checkLoginHtml',YII_CSRF_TOKEN: zmf.csrfToken}, function (result) {
        ajaxReturn = true;
        result = $.parseJSON(result);
        if (result.status === 1) {
            $('#JS_navbar_login').html(result.msg).show();
        }else{
            $('#JS_navbar_login').show();
        }
        return false;
    });
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
rebind();
showLogin();