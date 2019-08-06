<script type='text/javascript' src='/js/swiper.js' charset='utf-8'></script>
<style>

    .weui-tab .img_title {
        position: absolute;
        top: 0px;
        height: 30px;
        line-height: 28px;
        overflow: hidden;
        color: #fff;
        background: #000;
        padding-left: 5px;
        width: 100%;
        opacity: 0.6;
        font-size: 16px;
    }
</style>
<div class="weui-tab">
    <div class="swiper-slide"><img src="http://s.zhiyuanyun.com/www.chinavolunteer.cn/cms/201807/09/5b4320e279547.JPG"
                                   style="width: 400px" alt=""></div>
    <div class="img_title">通知:系统测试中...</div>

    <div class="weui-grids">
        <a href="<?php echo zmf::createUrl('/weixin/reg')?>" class="weui-grid js_grid">
            <div class="weui-grid__icon"><img src="https://css.zhiyuanyun.com/default/wx/images/gird_zyz.png"></div>
            <p class="weui-grid__label">成为志愿者</p>
        </a>
        <a href="<?php echo zmf::createUrl('/activity/index')?>" class="weui-grid js_grid">
            <div class="weui-grid__icon"><img src="https://css.zhiyuanyun.com/default/wx/images/gird_tt.png"></div>
            <p class="weui-grid__label">志愿活动</p>
        </a>
        <a href="<?php echo zmf::createUrl('/Competition/index')?>" class="weui-grid js_grid">
            <div class="weui-grid__icon"><img src="https://css.zhiyuanyun.com/default/wx/images/gird_xm.png"></div>
            <p class="weui-grid__label">知识竞赛</p>
        </a>
    </div>
</div>
<div class="clearfix" style="height:65px;"></div>
<div class="weui-tabbar">
    <a href="<?php echo zmf::createUrl('/index/index')?>" class="weui-tabbar__item weui-bar__item_on">
        <img src="https://css.zhiyuanyun.com/default/wx/images/tab.home.press.png" alt="" class="weui-tabbar__icon">
        <p class="weui-tabbar__label">首页</p>
    </a>
    <a href="<?php echo zmf::createUrl('/Competition/index')?>" class="weui-tabbar__item ">
        <img src="https://css.zhiyuanyun.com/default/wx/images/gird_xj.png" alt=""
             class="weui-tabbar__icon">
        <p class="weui-tabbar__label">志愿活动</p>
    </a>

    <a href="<?php echo zmf::createUrl('/weixin/index')?>" class="weui-tabbar__item ">
        <img src="https://css.zhiyuanyun.com/default/wx/images/tab.user.normal.png" alt=""
             class="weui-tabbar__icon">
        <p class="weui-tabbar__label">我的</p>
    </a>

</div>