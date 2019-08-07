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



    .apply {
        position: absolute;
        width: 100%;
        bottom: 10%;
        margin: 0 auto;
    }
</style>
<div class="personal">
    <img class="head_photo"
         src="https://ss0.bdstatic.com/70cFvHSh_Q1YnxGkpoWK1HF6hhy/it/u=1440019312,3309809430&fm=26&gp=0.jpg" alt="">
    <div style="text-align: center;font-size: 15px"><?php echo $this->userInfo['truename']; ?></div>
</div>

<?php ?>
<div class="weui-tab">
    <div class="weui-panel weui-panel_access">
        <div id="list_on">
            <div class="weui-panel_bd">
                <?php foreach ($activity as $item) { ?>
                    <a class="weui-media-box weui-media-box_appmsg" href="<?php echo zmf::createUrl('activity/detail',['id'=>$item['id']])?>" >
                        <div class="weui-media-box__hd">
                            <img class="weui-media-box__thumb"
                                 src="http://css.zhiyuanyun.com/default/images/noimg_opp.jpg"
                                 onerror="this.src='http://css.zhiyuanyun.com/default/images/noimg_opp.jpg'">
                        </div>
                        <div class="weui-media-box__bd">
                            <h4 class="weui-media-box__title">
                                <span class="status" style="color:green;"><?php echo $item['status'] !=1 ? '待审核' : '已通过' ?></span>
                                <?php echo $item['title'];?>
                            </h4>
                            <p class="weui-media-box__desc" style="margin-top:5px;height:16px;overflow:hidden;">
                                地址: <?php echo $item['place']; ?>
                            </p>
                            <p class="weui-media-box__desc" style="margin-top:5px;">
                                <span>计划 : <?php echo $item['count']; ?>&nbsp;&nbsp;&nbsp;招募 : 19</span>
                            </p>
                        </div>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<div class="apply">
    <div class="weui-btn-area">
        <a href="<?php echo zmf::createUrl('/weixin/logout') ?>" class="weui-btn weui-btn_primary">退出</a>
    </div>
</div>


