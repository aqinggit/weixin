<div class="login-form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'reg-form',
        'enableAjaxValidation'=>false,
        'enableClientValidation'=>false
    )); ?>
    <h1 class="logo"><?php echo zmf::config('sitename');?></h1>
    <div class="form-body">
        <div class="weui-cells weui-cells_form">
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">手机号</label></div>
                <div class="weui-cell__bd">
                    <?php echo CHtml::numberField('reg-phone','', array('class'=>'weui-input','placeholder'=>'请输入手机号'));?>
                </div>
            </div>
            <div class="weui-cell weui-cell_vcode"  id="use-sms-code">
                <div class="weui-cell__hd">
                    <label class="weui-label">验证码</label>
                </div>
                <div class="weui-cell__bd">
                    <?php echo CHtml::numberField('reg-code','', array('class'=>'weui-input','placeholder'=>'验证码')); ?>
                </div>
                <div class="weui-cell__ft">
                    <button type="button" class="weui-vcode-btn" id="sendSms-btn" data-target="reg-phone" data-type="reg">获取验证码</button>
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">昵　称</label></div>
                <div class="weui-cell__bd">
                    <?php echo CHtml::textField('reg-username','', array('class'=>'weui-input','placeholder'=>'怎么称呼您'));?>
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">密　码</label></div>
                <div class="weui-cell__bd">
                    <?php echo CHtml::passwordField('reg-password','', array('class'=>'weui-input','placeholder'=>'不短于6位'));?>
                </div>
            </div>
        </div>
        <div class="submit-holder btn-holder">
            <?php echo CHtml::hiddenField('reg-type','passwd'); ?>
            <?php echo CHtml::hiddenField('reg-bind',$bind); ?>
            <?php echo CHtml::hiddenField('reg-ucode',$ucode); ?>
            <div class="form-group">
                <a href="javascript:;" class="btn btn-success" id="reg-btn"><?php echo ($bind=='weixin' && $this->fromWeixin) ? '绑定微信' : '完成注册';?></a>
            </div>
            <div class="form-group">
                <?php echo ($bind=='weixin' && $this->fromWeixin) ? CHtml::link('绑定账号',array('site/login','bind'=>'weixin'),array('class'=>'btn btn-default')) :CHtml::link('登　录',array('site/login'),array('class'=>'btn btn-default'));?>
            </div>
        </div>
    </div>
    <?php $this->endWidget();?>
</div>