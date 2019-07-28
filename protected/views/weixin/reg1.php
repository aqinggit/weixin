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

</style>

<div class="weui-search-bar clearfix  col-fff">
    <span class="nav-menu"><&nbsp;返回</span>
    <span class="nav-menu">登录</span>
    <span class="nav-menu">注册</span>
</div>

<div class="form weui-cells weui-cells_form reg-tab">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'users-reg1-form',
        'enableAjaxValidation' => false,
    )); ?>
    <div class="weui-cell col-bac">
        <div class="weui-cell__hd "><label class="weui-label">志愿者注册</label></div>
    </div>




    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">用户名</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->textField($model, 'truename', ['class' => 'weui-input', 'placeholder' => '只允许数字字母下划线']); ?>

        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">密码</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->passwordField($model, 'password', ['class' => 'weui-input']); ?>
        </div>
    </div>


    <div class="row">
        <?php echo $form->labelEx($model, 'cTime'); ?>
        <?php echo $form->dateField($model, 'cTime'); ?>
        <?php echo $form->error($model, 'cTime'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->textField($model, 'status'); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'platform'); ?>
        <?php echo $form->textField($model, 'platform'); ?>
        <?php echo $form->error($model, 'platform'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'ip'); ?>
        <?php echo $form->textField($model, 'ip'); ?>
        <?php echo $form->error($model, 'ip'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'hits'); ?>
        <?php echo $form->textField($model, 'hits'); ?>
        <?php echo $form->error($model, 'hits'); ?>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">性别</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->dropDownList($model, 'sex', [0 => '男', 1 => '女'], ['class' => 'weui-select']); ?>
        </div>
    </div>


    <div class="row">
        <?php echo $form->labelEx($model, 'isAdmin'); ?>
        <?php echo $form->textField($model, 'isAdmin'); ?>
        <?php echo $form->error($model, 'isAdmin'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'phoneChecked'); ?>
        <?php echo $form->textField($model, 'phoneChecked'); ?>
        <?php echo $form->error($model, 'phoneChecked'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'gold'); ?>
        <?php echo $form->textField($model, 'gold'); ?>
        <?php echo $form->error($model, 'gold'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'levelTitle'); ?>
        <?php echo $form->textField($model, 'levelTitle'); ?>
        <?php echo $form->error($model, 'levelTitle'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'authorId'); ?>
        <?php echo $form->textField($model, 'authorId'); ?>
        <?php echo $form->error($model, 'authorId'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'favors'); ?>
        <?php echo $form->textField($model, 'favors'); ?>
        <?php echo $form->error($model, 'favors'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'favord'); ?>
        <?php echo $form->textField($model, 'favord'); ?>
        <?php echo $form->error($model, 'favord'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'favorAuthors'); ?>
        <?php echo $form->textField($model, 'favorAuthors'); ?>
        <?php echo $form->error($model, 'favorAuthors'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'exp'); ?>
        <?php echo $form->textField($model, 'exp'); ?>
        <?php echo $form->error($model, 'exp'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'level'); ?>
        <?php echo $form->textField($model, 'level'); ?>
        <?php echo $form->error($model, 'level'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'groupid'); ?>
        <?php echo $form->textField($model, 'groupid'); ?>
        <?php echo $form->error($model, 'groupid'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'powerGroupId'); ?>
        <?php echo $form->textField($model, 'powerGroupId'); ?>
        <?php echo $form->error($model, 'powerGroupId'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'score'); ?>
        <?php echo $form->textField($model, 'score'); ?>
        <?php echo $form->error($model, 'score'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'phone'); ?>
        <?php echo $form->textField($model, 'phone'); ?>
        <?php echo $form->error($model, 'phone'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'contact'); ?>
        <?php echo $form->textField($model, 'contact'); ?>
        <?php echo $form->error($model, 'contact'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'avatar'); ?>
        <?php echo $form->textField($model, 'avatar'); ?>
        <?php echo $form->error($model, 'avatar'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email'); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'levelIcon'); ?>
        <?php echo $form->textField($model, 'levelIcon'); ?>
        <?php echo $form->error($model, 'levelIcon'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'content'); ?>
        <?php echo $form->textField($model, 'content'); ?>
        <?php echo $form->error($model, 'content'); ?>
    </div>



    <div class="weui-btn-area col-red">
        <?php echo $form->errorSummary($model); ?>
    </div>


    <div class="weui-btn-area">
        <?php echo CHtml::submitButton('确定', array('class' => 'weui-btn weui-btn_primary btn-color')); ?>
    </div>


    <?php $this->endWidget(); ?>

</div><!-- form -->