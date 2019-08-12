<div class="login-reg-module row">
    <div class="hidden-xs col-sm-8 col-lg-8">
        <?php $this->renderPartial('/site/login-carousel'); ?>
        <div style="background: url('<?php echo zmf::config('baseurl') . 'jsCssSrc/images/3.jpg' ?>') no-repeat;width: 815px;height: 305px;position: absolute;background-size: cover">
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-lg-4">

        <div class="login-form">
            <?php if ($canLogin) {
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'login-form',
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => false
                )); ?>
                <h1>登录</h1>
                <div class="form-body">
                    <div class="form-group">
                        <label>手机号：</label>
                        <?php echo CHtml::textField('login-phone', '', array('class' => 'form-control', 'placeholder' => '请输入手机号')); ?>
                    </div>
                    <div class="form-group" id="use-passwd">
                        <label>密　码：</label>
                        <?php echo CHtml::passwordField('login-password', '', array('class' => 'form-control', 'placeholder' => '请输入密码')); ?>
                    </div>
                    <div id="use-sms">
                        <div class="form-group">
                            <label>验证码：</label>
                            <?php echo CHtml::textField('login-code', '', array('class' => 'form-control', 'placeholder' => '请输入密码')); ?>
                            <button type="button" class="msgBtn disabled sendSms-btn" data-target="login-phone"
                                    data-type="login" disabled="disabled">发送验证码
                            </button>
                            <div class="clearfix"></div>
                            <p class="ex-tip">
                                <a href="javascript:;" onclick="toggleArea('sms')">用密码登录</a>
                                <?php echo zmf::link('前往注册', array('site/reg'), array('class' => 'pull-right color-grey')); ?>
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo CHtml::hiddenField('login-type', 'passwd'); ?>
                        <a href="javascript:;" class="submitBtn" id="login-btn">登　录</a>
                    </div>
                </div>
                <?php $this->endWidget();
            } else { ?>
                <div class="alert alert-danger">
                    <p>错误操作太频繁，请稍后再试！</p>
                    <p>
                        <?php echo zmf::link('返回首页', zmf::config('baseurl'), array('class' => 'alert-link')); ?>
                        <?php echo zmf::link('前去注册', array('site/reg'), array('class' => 'alert-link')); ?>
                    </p>
                </div>
            <?php } ?>
        </div>
        <script>
            function toggleArea(f) {
                if (f === 'passwd') {
                    $('#use-passwd').hide();
                    $('#use-sms').show();
                    $('#login-type').val('sms');
                } else {
                    $('#use-passwd').show();
                    $('#use-sms').hide();
                    $('#login-type').val('passwd');
                }
            }

            $(document).keyup(function (event) {
                if (event.keyCode == 13) {
                    $('#login-btn').click();
                }
            });
        </script>
    </div>
</div>