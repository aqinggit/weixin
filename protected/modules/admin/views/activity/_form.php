<?php
/**
 * @filename ActivityController.php
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2019 阿年飞少
 * @datetime 2019-08-01 22:50:41
 */
?>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'activity-form',
        'enableAjaxValidation' => false,
    )); ?>
    <?php echo $form->errorSummary($model); ?>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'title'); ?>

        <?php echo $form->textField($model, 'title', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'place'); ?>

        <?php echo $form->textField($model, 'place', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'place'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'content'); ?>
        <?php $this->renderPartial('//common/editor_um', array('model' => $model, 'content' => $model->content, 'editorWidth' => 800, 'uptype' => 'articles', 'imgsize' => 'c640')); ?>
        <?php echo $form->error($model, 'content'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'count'); ?>
        <?php echo $form->textField($model, 'count', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'count'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'responsible'); ?>
        <?php echo $form->textField($model, 'responsible', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'responsible'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'phone'); ?>
        <?php echo $form->textField($model, 'phone', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'phone'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'startTime'); ?>

        <?php echo $form->dateField($model, 'startTime', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'startTime'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'endTime'); ?>

        <?php echo $form->dateField($model, 'endTime', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'endTime'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'volunteerType'); ?>

        <?php echo $form->dropDownList($model, 'volunteerType', Users::VolunteerType() , array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'volunteerType'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'score'); ?>

        <?php echo $form->textField($model, 'score', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'score'); ?>
    </div>

    <div class="form-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '更新', array('class' => 'btn btn-primary')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->