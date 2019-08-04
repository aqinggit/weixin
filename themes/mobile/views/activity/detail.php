<style>
    body, html {
        height: 100%;
        -webkit-tap-highlight-color: transparent
    }

    body {
        font-family: -apple-system-font, Helvetica Neue, Helvetica, sans-serif
    }

    ul {
        list-style: none
    }

    .page, body {
        background-color: #f8f8f8
    }

    .link {
        color: #1aad19
    }

    .container {
        overflow: hidden
    }

    .container, .page {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0
    }

    .page {
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
        opacity: 0;
        z-index: 1
    }

    .page.js_show {
        opacity: 1
    }

    .page__hd {
        padding: 40px
    }

    .page__bd_spacing {
        padding: 0 15px
    }

    .page__ft {
        padding-top: 40px;
        padding-bottom: 10px;
        text-align: center
    }

    .page__ft img {
        height: 19px
    }

    .page__ft.j_bottom {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0
    }

    .page__title {
        text-align: left;
        font-size: 20px;
        font-weight: 400
    }

    .page__desc {
        margin-top: 5px;
        color: #888;
        text-align: left;
        font-size: 14px
    }

    .page.home .page__intro-icon {
        margin-top: -.2em;
        margin-left: 5px;
        width: 16px;
        height: 16px;
        vertical-align: middle
    }

    .page.home .page__title {
        font-size: 0;
        margin-bottom: 15px
    }

    .page.home .page__bd img {
        width: 30px;
        height: 30px
    }

    .page.home .page__bd li {
        margin: 10px 0;
        background-color: #fff;
        overflow: hidden;
        border-radius: 2px;
        cursor: pointer
    }

    .page.home .page__bd li.js_show .weui-flex {
        opacity: .4
    }

    .page.home .page__bd li.js_show .page__category {
        height: auto
    }

    .page.home .page__bd li.js_show .page__category-content {
        opacity: 1;
        -webkit-transform: translateY(0);
        transform: translateY(0)
    }

    .page.home .page__bd li:first-child {
        margin-top: 0
    }

    .page.home .page__category {
        height: 0;
        overflow: hidden
    }

    .page.home .page__category-content {
        opacity: 0;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
        -webkit-transition: .3s;
        transition: .3s
    }

    .page.home .weui-flex {
        padding: 20px;
        -webkit-box-align: center;
        -webkit-align-items: center;
        align-items: center;
        -webkit-transition: .3s;
        transition: .3s
    }

    .page.home .weui-cells {
        margin-top: 0
    }

    .page.home .weui-cells:after, .page.home .weui-cells:before {
        display: none
    }

    .page.home .weui-cell {
        padding-left: 20px;
        padding-right: 20px
    }

    .page.home .weui-cell:before {
        left: 20px;
        right: 20px
    }

    .page.button .page__bd {
        padding: 0 15px
    }

    .page.button .button-sp-area {
        margin: 0 auto;
        padding: 15px 0;
        width: 60%
    }

    .page.cell .page__bd, .page.form .page__bd {
        padding-bottom: 30px
    }

    .page.actionsheet, .page.dialog {
        background-color: #fff
    }

    .page.dialog .page__bd {
        padding: 0 15px
    }

    .page.msg, .page.msg_success, .page.msg_warn, .page.toast {
        background-color: #fff
    }

    .page.panel .page__bd {
        padding-bottom: 20px
    }

    .page.article {
        background-color: #fff
    }

    .page.icons {
        text-align: center
    }

    .page.icons .page__bd {
        padding: 0 40px;
        text-align: left
    }

    .page.icons .icon-box {
        margin-bottom: 25px;
        display: -webkit-box;
        display: -webkit-flex;
        display: flex;
        -webkit-box-align: center;
        -webkit-align-items: center;
        align-items: center
    }

    .page.icons .icon-box i {
        margin-right: 18px
    }

    .page.icons .icon-box__ctn {
        -webkit-flex-shrink: 100;
        flex-shrink: 100
    }

    .page.icons .icon-box__title {
        font-weight: 400
    }

    .page.icons .icon-box__desc {
        margin-top: 6px;
        font-size: 12px;
        color: #888
    }

    .page.icons .icon_sp_area {
        margin-top: 10px;
        text-align: left
    }

    .page.icons .icon_sp_area i:before {
        margin-bottom: 5px
    }

    .page.flex .placeholder {
        margin: 5px;
        padding: 0 10px;
        background-color: #ebebeb;
        height: 2.3em;
        line-height: 2.3em;
        text-align: center;
        color: #cfcfcf
    }

    .page.loadmore {
        background-color: #fff
    }

    .page.layers {
        overflow-x: hidden;
        -webkit-perspective: 1000px;
        perspective: 1000px
    }

    @media only screen and (max-width: 320px) {
        .page.layers .page__hd {
            padding-left: 20px;
            padding-right: 20px
        }
    }

    .page.layers .page__bd {
        position: relative
    }

    .page.layers .page__desc {
        min-height: 4.8em
    }

    .page.layers .layers__layer {
        position: absolute;
        left: 50%;
        width: 150px;
        height: 266px;
        margin-left: -75px;
        box-sizing: border-box;
        -webkit-transition: .5s;
        transition: .5s;
        background: url(images/layers/transparent.gif) no-repeat 50%;
        background-size: contain;
        font-size: 14px;
        color: #fff
    }

    .page.layers .layers__layer span {
        position: absolute;
        bottom: 5px;
        left: 0;
        right: 0;
        text-align: center;
        -webkit-transition: .5s;
        transition: .5s
    }

    .page.layers .layers__layer:last-child span {
        color: #aaa
    }

    .page.layers .layers__layer.j_hide {
        opacity: 0
    }

    .page.layers .layers__layer.j_pic span {
        color: transparent
    }

    @media only screen and (min-width: 375px) and (min-height: 603px) {
        .page.layers .layers__layer {
            width: 180px;
            height: 320px;
            margin-left: -90px
        }
    }

    @media only screen and (min-width: 414px) and (min-height: 640px) {
        .page.layers .layers__layer {
            width: 200px;
            height: 355px;
            margin-left: -100px
        }
    }

    .page.layers .layers__layer_popout {
        border: 1px solid hsla(0, 0%, 80%, .5);
        z-index: 4
    }

    .page.layers .layers__layer_popout.j_transform {
        -webkit-transform: translateX(15px) rotateX(45deg) rotate(10deg) skew(-15deg) translateZ(120px);
        transform: translateX(15px) rotateX(45deg) rotate(10deg) skew(-15deg) translateZ(120px)
    }

    @media only screen and (max-width: 320px) {
        .page.layers .layers__layer_popout.j_transform {
            -webkit-transform: translateX(15px) rotateX(45deg) rotate(10deg) skew(-15deg) translateZ(140px);
            transform: translateX(15px) rotateX(45deg) rotate(10deg) skew(-15deg) translateZ(140px)
        }
    }

    .page.layers .layers__layer_popout.j_pic {
        border-color: transparent;
        background-image: url(images/layers/popout.png)
    }

    .page.layers .layers__layer_mask {
        background-color: rgba(0, 0, 0, .5);
        z-index: 3
    }

    .page.layers .layers__layer_mask.j_transform {
        -webkit-transform: translateX(15px) rotateX(45deg) rotate(10deg) skew(-15deg) translateZ(40px);
        transform: translateX(15px) rotateX(45deg) rotate(10deg) skew(-15deg) translateZ(40px)
    }

    @media only screen and (max-width: 320px) {
        .page.layers .layers__layer_mask.j_transform {
            -webkit-transform: translateX(15px) rotateX(45deg) rotate(10deg) skew(-15deg) translateZ(80px);
            transform: translateX(15px) rotateX(45deg) rotate(10deg) skew(-15deg) translateZ(80px)
        }
    }

    .page.layers .layers__layer_navigation {
        background-color: rgba(40, 187, 102, .5);
        z-index: 2
    }

    .page.layers .layers__layer_navigation.j_transform {
        -webkit-transform: translateX(15px) rotateX(45deg) rotate(10deg) skew(-15deg) translateZ(-40px);
        transform: translateX(15px) rotateX(45deg) rotate(10deg) skew(-15deg) translateZ(-40px)
    }

    @media only screen and (max-width: 320px) {
        .page.layers .layers__layer_navigation.j_transform {
            -webkit-transform: translateX(15px) rotateX(45deg) rotate(10deg) skew(-15deg) translateZ(20px);
            transform: translateX(15px) rotateX(45deg) rotate(10deg) skew(-15deg) translateZ(20px)
        }
    }

    .page.layers .layers__layer_navigation.j_pic {
        background-color: transparent;
        background-image: url(images/layers/navigation.png)
    }

    .page.layers .layers__layer_content {
        background-color: #fff;
        z-index: 1
    }

    .page.layers .layers__layer_content.j_transform {
        -webkit-transform: translateX(15px) rotateX(45deg) rotate(10deg) skew(-15deg) translateZ(-120px);
        transform: translateX(15px) rotateX(45deg) rotate(10deg) skew(-15deg) translateZ(-120px)
    }

    @media only screen and (max-width: 320px) {
        .page.layers .layers__layer_content.j_transform {
            -webkit-transform: translateX(15px) rotateX(45deg) rotate(10deg) skew(-15deg) translateZ(-40px);
            transform: translateX(15px) rotateX(45deg) rotate(10deg) skew(-15deg) translateZ(-40px)
        }
    }

    .page.layers .layers__layer_content.j_pic {
        background-image: url(images/layers/content.png)
    }

    .page.searchbar .searchbar-result {
        display: none;
        margin-top: 0;
        font-size: 14px
    }

    .page.searchbar .searchbar-result .weui-cell__bd {
        padding: 2px 0 2px 20px;
        color: #666
    }

    .page.actionsheet, .page.picker {
        overflow: hidden
    }

    .page.picker {
        background-color: #fff
    }

    .page.gallery {
        overflow: hidden
    }

    @-webkit-keyframes a {
        0% {
            -webkit-transform: translate3d(100%, 0, 0);
            transform: translate3d(100%, 0, 0);
            opacity: 0
        }
        to {
            -webkit-transform: translateZ(0);
            transform: translateZ(0);
            opacity: 1
        }
    }

    @keyframes a {
        0% {
            -webkit-transform: translate3d(100%, 0, 0);
            transform: translate3d(100%, 0, 0);
            opacity: 0
        }
        to {
            -webkit-transform: translateZ(0);
            transform: translateZ(0);
            opacity: 1
        }
    }

    @-webkit-keyframes b {
        0% {
            -webkit-transform: translateZ(0);
            transform: translateZ(0);
            opacity: 1
        }
        to {
            -webkit-transform: translate3d(100%, 0, 0);
            transform: translate3d(100%, 0, 0);
            opacity: 0
        }
    }

    @keyframes b {
        0% {
            -webkit-transform: translateZ(0);
            transform: translateZ(0);
            opacity: 1
        }
        to {
            -webkit-transform: translate3d(100%, 0, 0);
            transform: translate3d(100%, 0, 0);
            opacity: 0
        }
    }

    .page.slideIn {
        -webkit-animation: a .2s forwards;
        animation: a .2s forwards
    }

    .page.slideOut {
        -webkit-animation: b .2s forwards;
        animation: b .2s forwards
    }

    body, input, select, textarea {
        font-family: Helvetica-Light, Helvetica;
    }

    .clearfix {
        zoom: 1;
    }

    .clearfix:after {
        content: ".";
        display: block;
        clear: both;
        height: 0;
        overflow: hidden;
        visibility: hidden;
    }

    .l {
        float: left;
    }

    .r {
        float: right;
    }

    .weui-cells {
        font-size: 14px;
        margin-top: 10px;
    }

    .weui-tabbar {
        position: fixed;
    }

    .weui-media-box_appmsg .weui-media-box__thumb {
        width: 50%;
        height: 50%;
        vertical-align: middle;
    }

    .weui-media-box {
        padding: 5px 15px;
    }

    a {
        color: #09bb07;
    }

    .weui-cell__ft a {
        color: #09bb07;
    }

    .pagebar {
        padding: 8px;
    }

    .pagebar span, .pagebar a {
        display: inline-block;
        padding: 1px 8px;
        border: 1px solid #09bb07;
        margin-right: 5px;
        font-size: 14px;
        color: #09bb07;
    }

    .pagebar span.now_class {
        background: #09bb07;
        color: #fff;
    }

    .near {
        background: url(images/storelogo.png) left center no-repeat;
        width: 32px;
        height: 30px;
        background-size: auto 24px;
        display: inline-block;
    }

    .cat {
        background: url(images/cat.png) left center no-repeat;
        padding: 5px 0 0 30px;
        color: #999;
        width: 36px;
        height: 30px;
        background-size: auto 24px;
        display: inline-block;
    }

    .px {
        background: url(images/px.png) left center no-repeat;
        padding: 5px 0 0 30px;
        color: #999;
        width: 32px;
        height: 30px;
        background-size: auto 24px;
        display: inline-block;
    }

    .bookli {
        width: 50%;
        float: left;
    }

    .weui-actionsheet .weui-actionsheet__title {
        height: 30px;
    }

    .weui-cell_access .weui-cell__ft_no {
        padding-right: 0px;
    }

    /*a  upload */
    .a-upload {
        padding: 10px;
        height: 20px;
        line-height: 20px;
        position: relative;
        cursor: pointer;
        color: #888;
        background: #fafafa;
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
        display: inline-block;
        *display: inline;
        *zoom: 1;
        width: 90%;
        text-align: center;
        font-size: 16px;
    }

    .a-upload input {
        position: absolute;
        font-size: 100px;
        right: 0;
        top: 0;
        opacity: 0;
        filter: alpha(opacity=0);
        cursor: pointer
    }

    .a-upload:hover {
        color: #444;
        background: #eee;
        border-color: #ccc;
        text-decoration: none
    }

    .contop {
        margin-top: 10px;
    }

    .contop .l {
        width: 30%;
    }

    .contop .r {
        width: 70%;
        font-weight: bold;
        font-size: 16px;
    }

    .conlist p {
        margin-top: 10px;
    }

    .conlist p span {
        font-weight: bold;
    }

    .conlist p img {
        width: 100%;
    }

    .c1 {
        border-top: 1px solid #eee;
        margin-top: 10px;
    }

    .job .con p span, .my {
        color: #fff;
    }

    .status {
        display: inline-block;
        font-size: 12px;
        padding: 1px 3px;
        margin-right: 5px;
        border: 1px solid #eee;
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
        border-radius: 3px;
    }

</style>

<div class="weui-tab">
    <div class="weui-cells__title">项目信息
        <?php if ($item['status'] == 1) { ?>
            <a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_primary r">招募中</a>
        <?php } ?>
    </div>
    <div class="weui-panel weui-panel_access page__bd">
        <article class="weui-article">
            <h1><?php echo $item['title']; ?></h1>
            <section>
                <h3>志愿者类型：<?php echo Volunteers::VolunteerType($item['volunteerType']); ?></h3>
                <h3>项目日期：<a href="javascript:;"><?php echo zmf::time($item['startTime'],'Y-m-d'); ?></a> 至 <a href="javascript:;"><?php echo zmf::time($item['endTime'],'Y-m-d'); ?></a></h3>
                <h3>项目地址：<?php echo $item['place']; ?>
                <h3>项目联系人：<?php echo $item['responsible']; ?></h3>

                <h3>手机：<a href="tel:<?php echo $item['phone']; ?>"><?php echo $item['phone']; ?></a></h3>
            </section>
        </article>
    </div>

    <div class="weui-cells__title">项目简介</div>
    <div class="weui-panel weui-panel_access page__bd">
        <article class="weui-article">
            <?php echo $item['content']; ?>
        </article>
    </div>


    <div class="clearfix" style="height:65px;"></div>
    <div class="weui-tabbar">
        <a href="javascript:;" onclick="join_opp2(2762710);" class="weui-tabbar__item weui-btn weui-btn_primary"
           style="border-radius:0">
            <p class="weui-tabbar__label" style="color:#fff;">我要报名</p>
        </a>

    </div>

</div>