<style>
    body{
        background: #333;
    }
    .form{
        width: 320px;
        padding: 15px;
        background: #fff;
        position: absolute;
        left: 50%;
        margin-left: -160px;
        top: 50%;
        margin-top: -90px;
        height: 180px;
        overflow: hidden;
        border-radius: 5px;
        box-shadow: 0 0 20px rgba(255,255,255,0.8);
    }
    .form .title{
        font-size: 18px;
        text-align: center;
        color: #333;
        margin-bottom: 10px;
    }
</style>
<div class="form">
    <p class="title"><?php $t=zmf::config('houtaiTitle');echo $t ? $t : '管理中心';?></p>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'column-form',
        'enableAjaxValidation'=>false,
    )); ?>
    <div class="form-group">
        <?php echo CHtml::passwordField('code','',array('class'=>'form-control','placeholder'=>'验证码'));?>
    </div>
    <div class="form-group">
        <?php echo CHtml::submitButton('验证',array('class'=>'btn btn-primary btn-block')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>