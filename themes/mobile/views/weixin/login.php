<style>
    a {
        color: #09bb07;
    }

    a {
        text-decoration: none;
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
    }

    .fs16 {
        font-size: 16px;
    }
</style>
<?php if ($canLogin) {
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => false
    )); ?>
    <div class="weui-tab">
        <div class="weui-cells__title">志愿者登录</div>
        <div class="weui-panel weui-panel_access">
            <div class="weui-cells weui-cells_form" id="ulogin" style="margin-top:0;font-size: 14px">
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label">帐号</label></div>
                    <div class="weui-cell__bd">
                        <?php echo CHtml::textField('login-username', '', array('class' => 'weui-input', 'placeholder' => '手机/身份证/用户名')); ?>
                    </div>
                </div>

                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label">密码</label></div>
                    <div class="weui-cell__bd">
                        <div class="weui-cell__bd">
                            <?php echo CHtml::passwordField('login-password', '', array('class' => 'weui-input', 'placeholder' => '请输入密码')); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="weui-btn-area">
            <a href="javascript:;" class="weui-btn weui-btn_primary" id="login-btn">登录</a>
        </div>

        <div class="weui-btn-area fs16">
            <a href="<?php echo zmf::createUrl('weixin/reset') ?>">忘记密码</a>&nbsp;&nbsp;
            <a href="<?php echo zmf::createUrl('weixin/reg') ?>">成为志愿者</a>&nbsp;&nbsp;
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
    <?php $this->endWidget();
} else { ?>
    <div class="alert alert-danger">
        <p>错误操作太频繁，请稍后再试！</p>
        <p>
            <?php echo CHtml::link('返回首页', zmf::config('baseurl'), array('class' => 'alert-link')); ?>
            <?php echo CHtml::link('前去注册', array('site/reg'), array('class' => 'alert-link')); ?>
        </p>
    </div>
<?php } ?>