<style>
    .index_banner {
        background: url('<?php echo zmf::config('baseurl') . 'jsCssSrc/images/web_index2.jpg' ?>') no-repeat;
        position: relative;
        overflow: hidden;
        height: 750px;
        padding: 0;
        /*width: 90%;*/
        margin-top: 0;
        margin-bottom: 0;
        background-position: center center;
        /*background-repeat: no-repeat;*/
        background-size: cover;
    }

    .container {
        width: 100%;
        height: 100%;
    }


    .index_banner {
        position: relative;
        overflow: hidden;
        height: 720px;
        padding: 0;
        margin-top: -25px;
        margin-bottom: 0;
        color: #FCFCFC;
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .index_banner .container {
        position: relative;
        height: 100%;
        z-index: 2;
    }

    .index_banner-video {
        overflow: hidden
    }

    .index_banner-video video {
        min-width: 100%;
        min-height: 100%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        height: auto;
        width: 1270px;
    }

    .index_banner .banner-mask {
        position: absolute;
        background: black;
        opacity: 0.2;
        width: 100%;
        height: 100%;
        z-index: 1;
        top: 0;
    }

    .fadeIn {
        -webkit-animation-name: fadeIn;
        animation-name: fadeIn;
    }

    .animated {
        -webkit-animation-duration: 1s;
        animation-duration: 1s;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
    }

    .index_banner .fixed-tip {
        position: absolute;
        left: 50%;
        top: 50%;
        margin-left: -125px;
        margin-top: -125px;
        text-align: center;
        height: 250px;
        font-size: 20px;
        line-height: 45px
    }

    .index_banner .fixed-tip ._tip {
        font-size: 32px;
    }

    .index_banner .fixed-tip .sub-title {
        margin-top: 30px;
        font-size: 18px;
    }

    .index_banner .index-btn {
        height: 48px;
        font-size: 16px;
        line-height: 48px;
        margin: 100px auto 0
    }

    .index-header {
        -webkit-box-shadow: 0 0 10px rgba(0, 0, 0, .3);
        -moz-box-shadow: 0 0 10px rgba(0, 0, 0, .3);
        box-shadow: 0 0 10px rgba(0, 0, 0, .3);
        position: relative;
        padding: 0
    }

    .index-showcases {
        width: 1200px;
        height: 400px;
        overflow: hidden;
    }

    .index-showcases .item a img {
        width: 100%;
        height: 400px;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
    }

    .index-showcases .carousel-inner {
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
    }

    .index-steps-holder {
        width: 100%;
        height: 165px;
        background: #fff;
        display: block;
        margin-bottom: 0;
        border-bottom: none;
        border-top: none;
        border-radius: 0;
        padding: 0
    }

    .index-steps-holder .index-label {
        line-height: 165px;
        font-size: 24px;
        width: 200px;
        text-align: center;
        float: left;
        border-right: 1px solid #E4E4E4;
    }

    .index-steps-holder .steps-holder ._step {
        height: 165px;
        width: 121px \0
    }

    .index-big-slogan {
        margin-top: 60px;
        position: relative
    }

    .index-big-slogan img {
        width: 1200px;
        height: 600px;
    }

    .index-big-slogan .pk-btn {
        position: absolute;
        width: 180px;
        height: 60px;
        font-size: 0;
        color: transparent;
        display: block;
        bottom: 50px;
        background: url(../images/pk-btn.png) no-repeat center;
        background-size: contain;
        left: 50%;
        margin-left: -90px;
    }

    /**/
    .section .section-header {
        color: #333;
        font-size: 20px;
        padding: 50px 0;
        text-align: center;
    }

    .section-digests .section-body {
        margin-left: -20px;
        margin-right: -20px;
        margin-bottom: -40px;
    }

    .section-digests .section-body a {
        width: 360px;
        height: 240px;
        display: inline-block;
        margin: 0 25px 40px;
        box-shadow: 3px 3px 3px rgba(0, 0, 0, .2);
        position: relative
    }

    .section-digests .section-body a img {
        width: 360px;
        height: 240px;
    }

    .section-digests .section-body .fixed-title {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        text-align: center;
        font-size: 16px;
        background: rgba(0, 0, 0, .5);
        color: #fff;
        padding-top: 100px;
        display: none;
        transition: background 1s;
    }

    .section-digests .section-body a:hover .fixed-title {
        display: block
    }

    .section-awards-holder {
        background: #F2F2F2;
        padding-bottom: 40px
    }

    .section-awards .section-body {
        margin-left: -10px;
        margin-right: -10px;
    }

    .section-awards ._item {
        width: 280px;
        height: 400px;
        margin: 0 10px 0;
        display: block;
        padding: 30px;
        background: #fff;
        border-radius: 3px;
        float: left
    }

    .section-awards ._item img {
        width: 80px;
        height: 80px;
        margin: 20px auto;
        border-radius: 200px;
        display: block
    }

    .section-awards ._item .title, .section-awards ._item .name {
        text-align: center;
        font-size: 16px;
        font-weight: 400;
    }

    .section-awards ._item .name {
        margin-bottom: 30px
    }

    .section-awards ._item .content {
        line-height: 2.25;
        font-weight: 400;
        font-size: 14px;
        color: #666;
    }

    .section-posts {
        padding-top: 50px;
    }

    .section-posts .grid {
        width: 400px;
        height: 400px;
        display: inline-block;
        padding: 28px;
        float: left
    }

    .section-posts .grid-grey {
        background: #F2F2F2
    }

    .section-posts .grid .grid-title, .section-posts .grid .grid-en, .section-posts .grid .grid-title a {
        font-size: 20px;
        color: #FF3366;
        text-align: center;
    }

    .section-posts .grid .grid-en {
        margin-bottom: 30px
    }

    .section-posts .grid .media {
        max-width: 100%
    }

    .section-posts .grid .media img {
        width: 65px;
        height: 65px;
    }

    .section-posts .grid .media .title, .section-posts .grid .media .content {
        width: 268px;
    }

    .section-posts .grid .media .title a {
        font-size: 16px;
        color: #333
    }

    .section-posts .grid .media .content {
        color: #999;
        height: 36px;
        overflow: hidden
    }
</style>
<div class="container">
    <div class="index_banner">
        <div class="index_banner-video" id="index_banner-video"></div>
        <div class="container">
            <div class="fixed-tip">
                <h1 class="_tip">
                    綦江区志愿者管理系统
            </div>
        </div>
        <div class="banner-mask"></div>

    </div>
</div>

