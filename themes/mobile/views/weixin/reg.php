<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>
<style>
    .reg-tab {
        font-size: 14px;
        margin: 0;
    }

    .btn-color:hover {
        background-color: #007500;
    }

    .nav-menu {
        float: left;
        padding-right: 10px;
        font-size: 16px;
        color: #09bb07;
        padding-left: 5px;
    }

    .col-bac {
        background: #f7f7fa;
    }

    .col-fff {
        background-color: #fff;
    }

    .col-red {
        color: red;
    }

    .pd-t-b-0 {
        padding-top: 0;
        padding-bottom: 0;
    }

    .pd-l-0{
        padding-left: 0;
    }

</style>

<!--<div class="weui-search-bar clearfix  col-fff">-->
<!--    <span class="nav-menu"><&nbsp;返回</span>-->
<!--    <span class="nav-menu">登录</span>-->
<!--    <span class="nav-menu">注册</span>-->
<!--</div>-->

<div class="form weui-cells weui-cells_form reg-tab">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'users-reg-form',
        'enableAjaxValidation' => false,
    )); ?>
    <div class="weui-cell col-bac">
        <div class="weui-cell__hd "><label class="weui-label">志愿者注册</label></div>
    </div>


    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">用户名</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->textField($model, 'name', ['class' => 'weui-input', 'placeholder' => '只允许数字字母下划线']); ?>

        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">密码</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->passwordField($model, 'password', ['class' => 'weui-input', 'placeholder' => '8-20位密码']); ?>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">确认密码</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->passwordField($model, 'password2', ['class' => 'weui-input', 'placeholder' => '请再次输入密码']); ?>
        </div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">邮箱</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->emailField($model, 'email', ['class' => 'weui-input', 'placeholder' => '请输入邮箱']); ?>
        </div>
    </div>

    <div class="weui-cell pd-t-b-0">
        <div class="weui-cell__hd"><label class="weui-label">志愿者类型</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->dropDownList($model, 'volunteerType', Users::volunteerType(), ['class' => 'weui-select pd-l-0']); ?>
        </div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">真实姓名</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->textField($model, 'truename', ['class' => 'weui-input', 'placeholder' => '请输入真实姓名']); ?>
        </div>
    </div>
    <div class="weui-cell pd-t-b-0">
        <div class="weui-cell__hd"><label class="weui-label">证件类型</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->dropDownList($model, 'cardIdType', Users::CertType(), ['class' => 'weui-select pd-l-0']); ?>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">证件号码</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->textField($model, 'cardId', ['class' => 'weui-input', 'placeholder' => '请输入证件号码']); ?>
        </div>
    </div>

    <div class="weui-cell pd-t-b-0">
        <div class="weui-cell__hd"><label class="weui-label">性别</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->dropDownList($model, 'sex', Users::Sex(), ['class' => 'weui-select pd-l-0']); ?>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">手机</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->telField($model, 'phone', ['class' => 'weui-input', 'placeholder' => '请输入手机号码']); ?>
        </div>
    </div>
    <div class="weui-cell pd-t-b-0">
        <div class="weui-cell__hd"><label class="weui-label">政治面貌</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->dropDownList($model, 'politics', Users::Political(), ['class' => 'weui-select pd-l-0']); ?>
        </div>
    </div>

    <div class="weui-cell pd-t-b-0">
        <div class="weui-cell__hd"><label class="weui-label">民族</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->dropDownList($model, 'nation', Users::Ethnicity(), ['class' => 'weui-select pd-l-0']); ?>
        </div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">详细地址</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->textField($model, 'address', ['class' => 'weui-input', 'placeholder' => '请输入详细地址']); ?>
        </div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">出生日期</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->dateField($model, 'birthday', ['class' => 'weui-input pd-l-0']); ?>
        </div>
    </div>
    <div class="weui-cell pd-t-b-0">
        <div class="weui-cell__hd"><label class="weui-label">最高学历</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->dropDownList($model, 'education', Users::EdeGree(), ['class' => 'weui-select pd-l-0']); ?>
        </div>
    </div>
    <div class="weui-cell pd-t-b-0">
        <div class="weui-cell__hd"><label class="weui-label">从业状况</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->dropDownList($model, 'work', Users::Employment(), ['class' => 'weui-select pd-l-0']); ?>
        </div>
    </div>
    <div class="weui-btn-area col-red">
        <?php echo $form->errorSummary($model); ?>
    </div>


    <div class="weui-btn-area">
        <?php echo CHtml::submitButton('确定', array('class' => 'weui-btn weui-btn_primary btn-color')); ?>
    </div>


    <?php $this->endWidget(); ?>

</div><!-- form -->