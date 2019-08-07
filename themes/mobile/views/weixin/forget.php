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
<?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'users-forget-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => false
    )); ?>
    <div class="weui-tab">
        <div class="weui-cells__title">忘记密码</div>
        <div class="weui-panel weui-panel_access">
            <div class="weui-cells weui-cells_form" id="ulogin" style="margin-top:0;font-size: 14px">
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label">身份证号</label></div>
                    <div class="weui-cell__bd">
                        <?php echo CHtml::textField('cardId', '', array('class' => 'weui-input', 'placeholder' => '请输入身份证')); ?>
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label">手机号</label></div>
                    <div class="weui-cell__bd">
                        <?php echo CHtml::textField('phone', '', array('class' => 'weui-input', 'placeholder' => '请输入手机')); ?>
                    </div>
                </div>

                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label">密码</label></div>
                    <div class="weui-cell__bd">
                        <div class="weui-cell__bd">
                            <?php echo CHtml::passwordField('password', '', array('class' => 'weui-input', 'placeholder' => '请输入新密码')); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="weui-btn-area">
             <?php echo CHtml::submitButton('找回密码',['class'=>'weui-btn weui-btn_primary']); ?>
        </div>

        <div class="weui-btn-area fs16">
            <a href="<?php echo zmf::createUrl('weixin/login') ?>">立即登陆</a>&nbsp;&nbsp;
        </div>
    </div>
    <?php $this->endWidget();?>

