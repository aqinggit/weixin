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
            <?php echo $form->passwordField($model, 'password', ['class' => 'weui-input', 'placeholder' => '8-20位密码']); ?>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">确认密码</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->passwordField($model, 'password', ['class' => 'weui-input', 'placeholder' => '请再次输入密码']); ?>
        </div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">邮箱</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->emailField($model, 'email', ['class' => 'weui-input', 'placeholder' => '请输入邮箱']); ?>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">真实姓名</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->textField($model, 'actualName', ['class' => 'weui-input', 'placeholder' => '请输入真实姓名']); ?>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">证件类型</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->dropDownList($model, 'sex', [0 => '请选择', 1 => '内地居民身份证', 2 => '香港居民身份证', 3 => '澳门居民身份证', 4 => '台湾居民身份证', 5 => '护照'], ['class' => 'weui-select']); ?>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">证件号码</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->textField($model, 'certNumber', ['class' => 'weui-input', 'placeholder' => '请输入证件号码']); ?>

        </div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">性别</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->dropDownList($model, 'sex', [0 => '男', 1 => '女'], ['class' => 'weui-select']); ?>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">手机</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->telField($model, 'phone', ['class' => 'weui-input', 'placeholder' => '请输入手机号码']); ?>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">政治面貌</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->dropDownList($model, 'politicalStatus', [0 => '请选择', 1 => '中国共产党党员', 2 => '中国共产党预备党员', 3 => '中国共产党党员（保留团籍）', 4 => '中国共产主义青年团团员', 5 => '中国国民党革命委员会会员', 6 => '中国民主同盟盟员', 7 => '中国民主建国会会员', 8 => '中国民主促进会会员', 9 => '中国农工民主党党员', 10 => '中国致公党党员', 11 => '九三学社社员', 12 => '台湾民主自治同盟盟员', 13 => '无党派民主人士', 14 => '中国少年先锋队队员', 15 => '群众',], ['class' => 'weui-select']); ?>
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
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">最高学历</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->dropDownList($model, 'highestEdu', [0 => '请选择', 1 => '博士研究生', 2 => '硕士研究生', 3 => '大学本科', 4 => '大学专科', 5 => '中等专科', 6 => '职业高中', 7 => '技工学校', 8 => '高中', 9 => '初中', 10 => '小学', 11 => '其他'], ['class' => 'weui-select']); ?>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">从业状况</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->dropDownList($model, 'employmentStatus', [0 => '请选择', 1 => '国家公务员（含参照、依照公务员管理）', 2 => '专业技术人员', 3 => '职员', 4 => '企业管理人员', 5 => '工人', 6 => '农民', 7 => '学生', 8 => '教师', 9 => '现役军人', 10 => '自由职业者', 11 => '个体经营者',12=>'无业人员',13=>'退（离）休人员',14=>'其他'], ['class' => 'weui-select']); ?>
        </div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">服务类别</label></div>
        <div class="weui-cell__bd weui-cell_primary">
            <input class="weui-input" type="text" id="Users_serviceType" name="Users[serviceType]" value="" placeholder="请选择服务类别">
        </div>
    </div>
    <script>
        $("#Users_serviceType").select({
            title: "服务类别",multi: true,min: 1,max: 4,
            items: [{"title":"社区服务","value":"社区服务"},{"title":"生态环保","value":"生态环保"},{"title":"医疗卫生","value":"医疗卫生"},{"title":"应急平安","value":"应急平安"},{"title":"助老助残","value":"助老助残"},{"title":"关爱儿童","value":"关爱儿童"},{"title":"赛会服务","value":"赛会服务"},{"title":"法律咨询","value":"法律咨询"},{"title":"教育培训","value":"教育培训"},{"title":"文化艺术","value":"文化艺术"},{"title":"心理咨询","value":"心理咨询"},{"title":"信息宣传","value":"信息宣传"},{"title":"网络维护","value":"网络维护"},{"title":"行政支持","value":"行政支持"},{"title":"活动策划","value":"活动策划"},{"title":"礼仪接待","value":"礼仪接待"},{"title":"外语翻译","value":"外语翻译"},{"title":"摄影摄像","value":"摄影摄像"}]            });

    </script>

    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">受邀加入项目</label></div>
        <div class="weui-cell__bd">
            <?php echo $form->dropDownList($model, 'joinProject', [0 => '是', 1 => '否'], ['class' => 'weui-select']); ?>
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