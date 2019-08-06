<style>
    a {
        color: #09bb07;
    }
    a {
        text-decoration: none;
        -webkit-tap-highlight-color: rgba(0,0,0,0);
    }
    .fs16{
        font-size: 16px;
    }
</style>
<div class="weui-tab">
    <div class="weui-cells__title">志愿者/志愿团体登录</div>
    <div class="weui-panel weui-panel_access">
        <div class="weui-cells weui-cells_form" id="ulogin" style="margin-top:0;font-size: 14px">
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">帐号</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" id="uname" value="" placeholder="请输入用户名/身份证号码"
                           style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;">
                </div>
            </div>

            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">密码</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="password" id="upass" value="" placeholder="请输入密码"
                           style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;">
                </div>
            </div>
        </div>
    </div>

    <div class="weui-btn-area">
        <a class="weui-btn weui-btn_primary" href="javascript:" onclick="login(this)">登录</a>
    </div>

    <div class="weui-btn-area fs16" >
        <a href="/app/user/getpwd.php">忘记密码</a>&nbsp;&nbsp;
        <a href="/app/user/getpwd.php?type=login">找回用户名</a>&nbsp;&nbsp;
    </div>

    <div class="clearfix" style="height:65px;"></div>
    <div class="weui-tabbar">
        <a href="/app/weixin/index.php" class="weui-tabbar__item ">
            <img src="https://css.zhiyuanyun.com/default/wx/images/tab.home.normal.png" alt=""
                 class="weui-tabbar__icon">
            <p class="weui-tabbar__label">首页</p>
        </a>
        <a href="/app/weixin/qrscan.php" class="weui-tabbar__item ">
            <img src="https://css.zhiyuanyun.com/default/wx/images/gird_xj.png" alt=""
                 class="weui-tabbar__icon">
            <p class="weui-tabbar__label">志愿活动</p>
        </a>

        <a href="/app/weixin/my.php" class="weui-tabbar__item ">
            <img src="https://css.zhiyuanyun.com/default/wx/images/tab.user.normal.png" alt=""
                 class="weui-tabbar__icon">
            <p class="weui-tabbar__label">我的</p>
        </a>

    </div>
</div>
