<style>
    .personal {
        background: url("<?php echo zmf::config('baseurl') . 'jsCssSrc/images/user_bac.jpg' ?>") no-repeat;
        width: 100%;
        padding: 20px 0;
        display: flex;
        height: 110px;
        justify-content: space-between;
        position: relative;


    }
    .activity-num{
        position: absolute;
        height: 30px;
        bottom: 0;
        width: 100%;
        background-color: #505050 !important;
        opacity: 0.6;
        color: #fff;
        line-height: 30px;
        padding-left: 10px;
    }
    .integral{
        font-size: 15px;
        flex: 1;
        padding-left: 5px;
}
    .head_photo {
        width: 70px;
        display: block;
        margin: 0 auto;
        padding-bottom: 8px;
        flex: 1;
        padding-left: 50px;
    }
    .head_photo img{
        width: 80px;
        border-radius: 50%;
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

    .v-type{
      font-size: 15px;
      margin-top: 8px;
      flex: 1;
      font-weight: bold;
  }


    .apply {
        position: relative;
        width: 100%;
        bottom: 30px;
        padding-top: 20px;
        margin: 0 auto;

    }
    @font-face {
        font-family: 'iconfont';  /* project id 1357462 */
        src: url('//at.alicdn.com/t/font_1357462_fjlajg5qd2u.eot');
        src: url('//at.alicdn.com/t/font_1357462_fjlajg5qd2u.eot?#iefix') format('embedded-opentype'),
        url('//at.alicdn.com/t/font_1357462_fjlajg5qd2u.woff2') format('woff2'),
        url('//at.alicdn.com/t/font_1357462_fjlajg5qd2u.woff') format('woff'),
        url('//at.alicdn.com/t/font_1357462_fjlajg5qd2u.ttf') format('truetype'),
        url('//at.alicdn.com/t/font_1357462_fjlajg5qd2u.svg#iconfont') format('svg');
    }
    .iconfont{
        font-family:"iconfont" !important;
        font-size:16px;font-style:normal;
        -webkit-font-smoothing: antialiased;
        -webkit-text-stroke-width: 0.2px;
        -moz-osx-font-smoothing: grayscale;}
</style>
<div class="personal">
    <div class="head_photo">
        <img src="<?php echo zmf::config('baseurl') . 'jsCssSrc/images/user-photo.jpg'?>" alt="头像">
    </div>

    <div style="padding: 10px 40px 0 0">
        <div>
            <i class="iconfont">&#xe613;</i><?php echo $this->userInfo['truename']; ?>
            <span class="integral">130积分</span> <i style="color: #d58512" class="iconfont">&#xe6a4;</i>
        </div>
        <div class="v-type"><?php echo Users::VolunteerType($this->userInfo['volunteerType']); ?></div>
    </div>
    <div class="activity-num">
        今年参与志愿活动：6场
    </div>
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
                                 src="<?php echo zmf::config('baseurl') . 'jsCssSrc/images/activity_img.jpg'?>"
                                 onerror="this.src='<?php echo zmf::config('baseurl') . 'jsCssSrc/images/activity_img.jpg'?>'">
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
                                <span>计划 : <?php echo $item['count']; ?>&nbsp;&nbsp;&nbsp;招募 : <?php echo VolunteerActive::getActiveCount($item['id'])?></span>
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


