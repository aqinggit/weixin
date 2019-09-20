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
    .index_photo{
        width: 100%;
        /*height: 450px;*/
    }
</style>
<div class="weui-tab">
    <div><img class="index_photo" src="<?php echo zmf::config('baseurl') . 'jsCssSrc/images/index.jpg' ?>" alt="封面图"></div>
    <div class="img_title">通知:系统测试中...</div>

    <div class="weui-grids">
        <a href="<?php echo zmf::createUrl('/weixin/reg')?>" class="weui-grid js_grid">
            <div class="weui-grid__icon"><img src="<?php echo zmf::config('baseurl') . 'jsCssSrc/images/index_icon1.png' ?>" alt="志愿者图标"></div>
            <p class="weui-grid__label">成为志愿者</p>
        </a>
        <a href="<?php echo zmf::createUrl('/activity/index')?>" class="weui-grid js_grid">
            <div class="weui-grid__icon"><img src="<?php echo zmf::config('baseurl') . 'jsCssSrc/images/index_icon2.png' ?>" alt="活动图标"></div>
            <p class="weui-grid__label">志愿活动</p>
        </a>
        <a href="<?php echo zmf::createUrl('/Competition/index')?>" class="weui-grid js_grid">
            <div class="weui-grid__icon"><img src="<?php echo zmf::config('baseurl') . 'jsCssSrc/images/index_icon3.png' ?>" alt="竞赛图标"></div>
            <p class="weui-grid__label">知识竞赛</p>
        </a>
    </div>
</div>
<div class="clearfix" style="height:65px;"></div>
<?php
    zmf::test($this->nav);
if ($this->nav){$this->renderPartial('/layouts/_nav');}?>
