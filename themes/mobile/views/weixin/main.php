<style>
    .personal {
        background: url("http://pics.sc.chinaz.com/files/pic/pic9/201905/zzpic18272.jpg") no-repeat;
        width: 100%;
        padding: 20px 0;

    }

    .head_photo {
        width: 100px;
        border-radius: 50%;
        display: block;
        margin: 0 auto;
        padding-bottom: 8px;
    }

    .weui-tab {
        position: relative;
        height: 100%;
    }

    .weui-panel:after, .weui-panel:before {
        content: " ";
        position: absolute;
        left: 0;
        right: 0;
        height: 1px;
        color: #e5e5e5;
    }

    .weui-media-box_appmsg .weui-media-box__thumb {
        width: 50%;
        height: 50%;
        vertical-align: middle;
    }

    .status {
        display: inline-block;
        font-size: 12px;
        padding: 1px 3px;
        margin-right: 5px;
        border: 1px solid #eee;
        border-radius: 3px;
    }

    .weui-media-box__title {
        font-weight: 400;
        font-size: 17px;
        width: auto;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        word-wrap: break-word;
        word-break: break-all;
    }

    .weui-media-box {
        padding: 5px 15px;
    }

    .r {
        float: right;
    }

    .quit {

        position: absolute;
        width: 30%;
        /*margin: 50px auto;*/
        bottom: 20%;
        left: 35%;
        border-radius: 25%;
    }
</style>
<div class="personal">
    <img class="head_photo"
         src="https://ss0.bdstatic.com/70cFvHSh_Q1YnxGkpoWK1HF6hhy/it/u=1440019312,3309809430&fm=26&gp=0.jpg" alt="">
    <div style="text-align: center;font-size: 15px"><?php echo $this->userInfo['truename'] ;?></div>
</div>

<?php ?>
<div class="weui-tab">
    <div class="weui-panel weui-panel_access">
        <div id="list_on">
            <div class="weui-panel_bd">
                <a href="http://z.qiiing.com/weixin/activity/detail" class="weui-media-box weui-media-box_appmsg">
                    <div class="weui-media-box__hd">
                        <img class="weui-media-box__thumb" src="http://css.zhiyuanyun.com/default/images/noimg_opp.jpg"
                             onerror="this.src='http://css.zhiyuanyun.com/default/images/noimg_opp.jpg'">
                    </div>
                    <div class="weui-media-box__bd">
                        <h4 class="weui-media-box__title">
                            <span class="status" style="color:green;">招募中</span>
                            首届“周末文艺荟”优秀节目集中展演及第二届周未文艺荟
                        </h4>
                        <p class="weui-media-box__desc" style="margin-top:5px;height:16px;overflow:hidden;">
                            志愿团体 :
                            荣昌区新时代文明实践文化体育志愿服务分队
                        </p>
                        <p class="weui-media-box__desc" style="margin-top:5px;">
                            <span>计划 : 20&nbsp;&nbsp;&nbsp;招募 : 19</span>
                            <span class="r">5,394.23公里</span>
                        </p>
                    </div>
                </a>
                <a href="http://z.qiiing.com/weixin/activity/detail" class="weui-media-box weui-media-box_appmsg">
                    <div class="weui-media-box__hd">
                        <img class="weui-media-box__thumb" src="http://css.zhiyuanyun.com/default/images/noimg_opp.jpg"
                             onerror="this.src='http://css.zhiyuanyun.com/default/images/noimg_opp.jpg'">
                    </div>
                    <div class="weui-media-box__bd">
                        <h4 class="weui-media-box__title">
                            <span class="status" style="color:green;">招募中</span>
                            首届“周末文艺荟”优秀节目集中展演及第二届周未文艺荟
                        </h4>
                        <p class="weui-media-box__desc" style="margin-top:5px;height:16px;overflow:hidden;">
                            志愿团体 :
                            荣昌区新时代文明实践文化体育志愿服务分队
                        </p>
                        <p class="weui-media-box__desc" style="margin-top:5px;">
                            <span>计划 : 20&nbsp;&nbsp;&nbsp;招募 : 19</span>
                            <span class="r">5,394.23公里</span>
                        </p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="quit">
    <a href="<?php echo zmf::createUrl('/weixin/logout') ?>" class="weui-btn weui-btn_plain-primary" style="border-radius: 30px">退出</a>
</div>

