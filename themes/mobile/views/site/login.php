<div class="login-form">
    <h1 class="logo"><?php echo zmf::config('sitename');?></h1>
    <?php if($canLogin){$form=$this->beginWidget('CActiveForm', array(
        'id'=>'login-form',
        'enableAjaxValidation'=>false,
        'enableClientValidation'=>false
    )); ?>
        <div class="form-body">
            <div class="weui-cells weui-cells_form">
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label">手机号</label></div>
                    <div class="weui-cell__bd">
                        <?php echo CHtml::numberField('login-phone','', array('class'=>'weui-input','placeholder'=>'请输入手机号'));?>
                    </div>
                </div>
                <div class="weui-cell displayNone" id="use-passwd">
                    <div class="weui-cell__hd"><label class="weui-label">密　码</label></div>
                    <div class="weui-cell__bd">
                        <?php echo CHtml::passwordField('login-password','', array('class'=>'weui-input','placeholder'=>'请输入密码')); ?>
                    </div>
                </div>
                <div class="weui-cell weui-cell_vcode"  id="use-sms-code">
                    <div class="weui-cell__hd">
                        <label class="weui-label">验证码</label>
                    </div>
                    <div class="weui-cell__bd">
                        <?php echo CHtml::numberField('login-code','', array('class'=>'weui-input','placeholder'=>'验证码')); ?>
                    </div>
                    <div class="weui-cell__ft">
                        <button type="button" class="weui-vcode-btn" id="sendSms-btn" data-target="login-phone" data-type="login">获取验证码</button>
                    </div>
                </div>
                <div class="weui-cell weui-cell_switch">
                    <div class="weui-cell__bd">使用账户密码登录</div>
                    <div class="weui-cell__ft">
                        <label for="switchCP" class="weui-switch-cp">
                            <input id="switchCP" class="weui-switch-cp__input" type="checkbox">
                            <div class="weui-switch-cp__box"></div>
                        </label>
                    </div>
                </div>
            </div>
            <div class="submit-holder btn-holder">
                <?php echo CHtml::hiddenField('login-type','sms'); ?>
                <?php echo CHtml::hiddenField('login-bind',$bind); ?>
                <div class="form-group">
                    <a href="javascript:;" class="btn btn-success" id="login-btn"><?php echo ($bind=='weixin' && $this->fromWeixin) ? '绑定微信' : '登　录';?></a>
                </div>
                <div class="form-group">
                    <?php echo ($bind=='weixin' && $this->fromWeixin) ? CHtml::link('注　册',array('site/reg','bind'=>'weixin'),array('class'=>'btn btn-default')) : CHtml::link('注　册',array('site/reg'),array('class'=>'btn btn-default'));?>
                </div>
            </div>
        </div>
        <?php $this->endWidget();}else{ ?>
        <div class="alert alert-danger">
            <p>错误操作太频繁，请稍后再试！</p>
            <p>
                <?php echo CHtml::link('返回首页',  zmf::config('baseurl'),array('class'=>'alert-link'));?>
                <?php echo CHtml::link('前去注册',  array('site/reg'),array('class'=>'alert-link'));?>
            </p>
        </div>
    <?php }?>
</div>
<script>
    $(document).ready(function(){
        $('#switchCP').unbind('change').change(function(){
            var dom=$('#use-passwd');
            var dom1=$('#use-sms-validate');
            var dom2=$('#use-sms-code');
            if(dom.css('display')==='none'){
                dom.removeClass('displayNone');
                dom1.addClass('displayNone');
                dom2.addClass('displayNone');
                $('#login-type').val('passwd');
            }else{
                dom.addClass('displayNone');
                dom1.removeClass('displayNone');
                dom2.removeClass('displayNone');
                $('#login-type').val('sms');
            }
        })
    })
</script>