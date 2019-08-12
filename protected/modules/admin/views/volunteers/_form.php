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
        <?php echo $form->labelEx($model, 'name'); ?>

        <?php echo $form->textField($model, 'name', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'name'); ?>
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
        <?php echo $form->labelEx($model, 'company'); ?>

        <?php echo $form->textField($model, 'company', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'company'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'cardIdType'); ?>

        <?php echo $form->dropDownList($model, 'cardIdType', Users::CertType(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'cardIdType'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'cardId'); ?>

        <?php echo $form->textField($model, 'cardId', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'cardId'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'sex'); ?>

        <?php echo $form->dropDownList($model, 'sex', Users::Sex(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'sex'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'age'); ?>

        <?php echo $form->textField($model, 'age', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'age'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'phone'); ?>

        <?php echo $form->textField($model, 'phone', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'phone'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'politics'); ?>

        <?php echo $form->dropDownList($model, 'politics', Users::Political(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'politics'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'nation'); ?>

        <?php echo $form->dropDownList($model, 'nation', Users::Ethnicity(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'nation'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'address'); ?>

        <?php echo $form->textField($model, 'address', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'address'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'education'); ?>

        <?php echo $form->dropDownList($model, 'education', Users::EdeGree(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'education'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'volunteerType'); ?>

        <?php echo $form->dropDownList($model, 'volunteerType', Users::volunteerType(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'volunteerType'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'work'); ?>

        <?php echo $form->dropDownList($model, 'work', Users::Employment(), array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'work'); ?>
    </div>

    <div class="form-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '更新', array('class' => 'btn btn-primary')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->