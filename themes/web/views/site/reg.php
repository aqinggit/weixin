<div class="login-reg-module row">
    <div class="hidden-xs col-sm-8 col-lg-8">
        <?php $this->renderPartial('/site/login-carousel');?>
    </div>
    <div class="col-xs-12 col-sm-4 col-lg-4">
        <div class="login-form reg-form">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'reg-form',
                'enableAjaxValidation'=>false,
                'enableClientValidation'=>false
            )); ?>
            <h1>新用户注册</h1>
            <div class="form-body">
                <div class="form-group">
                    <label>手机号：</label>
                    <?php echo CHtml::textField('reg-phone','', array('class'=>'form-control','placeholder'=>'请输入常用手机号'));?>
                </div>
                <div class="form-group inline-btns">
                    <label>验证码：</label>
                    <?php echo CHtml::textField('reg-code','', array('class'=>'form-control','placeholder'=>'验证码')); ?>
                    <button type="button" class="msgBtn disabled sendSms-btn" data-target="reg-phone" data-type="reg" disabled="disabled">发送验证码</button>
                </div>
                <div class="form-group">
                    <label>姓　名：</label>
                    <?php echo CHtml::textField('reg-username','', array('class'=>'form-control','placeholder'=>'怎么称呼您')); ?>
                </div>
                <div class="form-group" id="use-passwd">
                    <label>密　码：</label>
                    <?php echo CHtml::passwordField('reg-password','', array('class'=>'form-control','placeholder'=>'长度不短于6位')); ?>
                </div>
                <div class="form-group">
                    <?php echo CHtml::hiddenField('reg-type','passwd'); ?>
                    <?php echo CHtml::hiddenField('reg-ucode',$ucode); ?>
                    <a href="javascript:;" class="submitBtn" id="reg-btn">完成注册</a>
                </div>
            </div>
            <?php $this->endWidget();?>
        </div>
    </div>
</div>