<?php
/**
 * @filename VolunteersController.php
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2019 阿年飞少
 * @datetime 2019-08-01 22:51:23
 */
?>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'volunteers-form',
        'enableAjaxValidation' => false,
    )); ?>
    <?php echo $form->errorSummary($model); ?>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'username'); ?>

        <?php echo $form->textField($model, 'username', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'username'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'password'); ?>

        <?php echo $form->passwordField($model, 'password', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'password2'); ?>

        <?php echo $form->passwordField($model, 'password2', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'password2'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'truename'); ?>

        <?php echo $form->textField($model, 'truename', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'truename'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'email'); ?>

        <?php echo $form->textField($model, 'email', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'cardIdType'); ?>

        <?php echo $form->dropDownList($model, 'cardIdType', Volunteers::CertType(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'cardIdType'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'cardId'); ?>

        <?php echo $form->textField($model, 'cardId', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'cardId'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'sex'); ?>

        <?php echo $form->dropDownList($model, 'sex', Volunteers::Sex(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'sex'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'birthday'); ?>

        <?php echo $form->dateField($model, 'birthday', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'birthday'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'phone'); ?>

        <?php echo $form->textField($model, 'phone', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'phone'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'politics'); ?>

        <?php echo $form->dropDownList($model, 'politics', Volunteers::Political(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'politics'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'nation'); ?>

        <?php echo $form->dropDownList($model, 'nation', Volunteers::Ethnicity(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'nation'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'address'); ?>

        <?php echo $form->textField($model, 'address', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'address'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'education'); ?>

        <?php echo $form->dropDownList($model, 'education', Volunteers::EdeGree(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'education'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'volunteerType'); ?>

        <?php echo $form->dropDownList($model, 'volunteerType', Volunteers::volunteerType(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'volunteerType'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'work'); ?>

        <?php echo $form->dropDownList($model, 'work', Volunteers::Employment(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'work'); ?>
    </div>

    <div class="form-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '更新', array('class' => 'btn btn-primary')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->