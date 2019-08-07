<style>
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
</style>
<div class="weui-tab">
    <div class="weui-panel weui-panel_access">
        <div id="list_on">
            <div class="weui-panel_bd">
                <?php foreach ($items as $item) { ?>
                    <a class="weui-media-box weui-media-box_appmsg" href="detail.html?id=<?php echo $item['id']?>" >
                        <div class="weui-media-box__hd">
                            <img class="weui-media-box__thumb"
                                 src="http://css.zhiyuanyun.com/default/images/noimg_opp.jpg"
                                 onerror="this.src='http://css.zhiyuanyun.com/default/images/noimg_opp.jpg'">
                        </div>
                        <div class="weui-media-box__bd">
                            <h4 class="weui-media-box__title">
                                <span class="status" style="color:green;">招募中</span>
                                <?php echo $item['title'];?>
                            </h4>
                            <p class="weui-media-box__desc" style="margin-top:5px;height:16px;overflow:hidden;">
                                地址: <?php echo $item['place']; ?>
                            </p>
                            <p class="weui-media-box__desc" style="margin-top:5px;">
                                <span>计划 : <?php echo $item['count']; ?>&nbsp;&nbsp;&nbsp;招募 : <?php echo VolunteerActive::getActiveCount($item['id'])?></span>
                            </p>
                        </div>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>