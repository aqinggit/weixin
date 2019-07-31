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

    .pd-t-b-0{
        padding-top: 0;
        padding-bottom: 0;
    }


</style>

<div class="weui-search-bar clearfix  col-fff">
    <span class="nav-menu"><&nbsp;返回</span>
    <span class="nav-menu">登录</span>
    <span class="nav-menu">注册</span>
</div>

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
            <?php echo $form->textField($model, 'truename', ['class' => 'weui-input', 'placeholder' => '只允许数字字母下划线']); ?>

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

    <!--todo-->
    <div class="weui-cell pd-t-b-0">
        <div class="weui-cell__hd"><label class="weui-label">国家</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->dropDownList($model, 'country', Users::Country(), ['class' => 'weui-select']); ?>
        </div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">真实姓名</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->textField($model, 'actualName', ['class' => 'weui-input', 'placeholder' => '请输入真实姓名']); ?>
        </div>
    </div>
    <div class="weui-cell pd-t-b-0">
        <div class="weui-cell__hd"><label class="weui-label">证件类型</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->dropDownList($model, 'certType', Users::CertType(), ['class' => 'weui-select']); ?>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">证件号码</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->textField($model, 'certNumber', ['class' => 'weui-input', 'placeholder' => '请输入证件号码']); ?>
        </div>
    </div>

    <div class="weui-cell pd-t-b-0">
        <div class="weui-cell__hd"><label class="weui-label">性别</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->dropDownList($model, 'sex', Users::Sex(), ['class' => 'weui-select']); ?>
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
            <?php echo $form->dropDownList($model, 'politicalStatus', Users::Political(), ['class' => 'weui-select']); ?>
        </div>
    </div>

    <div class="weui-cell pd-t-b-0">
        <div class="weui-cell__hd"><label class="weui-label">民族</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->dropDownList($model, 'nation', Users::Ethnicity(), ['class' => 'weui-select']); ?>
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
            <?php echo $form->dateField($model, 'birthday', ['class' => 'weui-input']); ?>
        </div>
    </div>
    <div class="weui-cell pd-t-b-0">
        <div class="weui-cell__hd"><label class="weui-label">最高学历</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->dropDownList($model, 'highestEdu', Users::EdeGree(), ['class' => 'weui-select']); ?>
        </div>
    </div>
    <div class="weui-cell pd-t-b-0">
        <div class="weui-cell__hd"><label class="weui-label">从业状况</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->dropDownList($model, 'employmentStatus', Users::Employment(), ['class' => 'weui-select']); ?>
        </div>
    </div>

    <div class="weui-cell pd-t-b-0">
        <div class="weui-cell__hd"><label class="weui-label">服务类别</label></div>
        <div class="weui-cell__bd weui-cell_primary">
            <input class="weui-input" type="text" id="Users_serviceType" name="Users[serviceType]" value=""
                   placeholder="请选择服务类别">
        </div>
    </div>
    <script>
        $("#Users_serviceType").select({
            title: "服务类别", multi: true, min: 1, max: 4,
            items: [{"title": "社区服务", "value": "社区服务"}, {"title": "生态环保", "value": "生态环保"}, {
                "title": "医疗卫生",
                "value": "医疗卫生"
            }, {"title": "应急平安", "value": "应急平安"}, {"title": "助老助残", "value": "助老助残"}, {
                "title": "关爱儿童",
                "value": "关爱儿童"
            }, {"title": "赛会服务", "value": "赛会服务"}, {"title": "法律咨询", "value": "法律咨询"}, {
                "title": "教育培训",
                "value": "教育培训"
            }, {"title": "文化艺术", "value": "文化艺术"}, {"title": "心理咨询", "value": "心理咨询"}, {
                "title": "信息宣传",
                "value": "信息宣传"
            }, {"title": "网络维护", "value": "网络维护"}, {"title": "行政支持", "value": "行政支持"}, {
                "title": "活动策划",
                "value": "活动策划"
            }, {"title": "礼仪接待", "value": "礼仪接待"}, {"title": "外语翻译", "value": "外语翻译"}, {
                "title": "摄影摄像",
                "value": "摄影摄像"
            }]
        });

    </script>

    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">受邀加入项目</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->dropDownList($model, 'joinProject', [1 => '是', 0 => '否'], ['class' => 'weui-select']); ?>
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