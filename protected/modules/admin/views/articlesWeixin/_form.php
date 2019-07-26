<?php
/**
 * @filename ArticlesWeixinController.php
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2019 阿年飞少
 * @datetime 2019-07-26 20:54:56
 */
?>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'articles-weixin-form',
        'enableAjaxValidation' => false,
    )); ?>
    <?php echo $form->errorSummary($model); ?>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'title'); ?>

        <?php echo $form->textField($model, 'title', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>


    <div class="form-group">
        <?php echo $form->labelEx($model, 'score'); ?>

        <?php echo $form->textField($model, 'score', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'score'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'content'); ?>
        <?php $this->renderPartial('//common/editor_um', array('model' => $model, 'content' => $model->content, 'uploadurl' => $uploadurl)); ?>
        <div id="waitForAlt" class="waitForAlt">
            <?php foreach ($contentImgs as $img) { ?>
                <div class="media">
                    <div class="media-left"><img src="<?php echo $img['remote']; ?>"/></div>
                    <div class="media-body">
                        <div class="form-group"><textarea class="form-control imgAlt"
                                                          data-id="<?php echo $img['id']; ?>" rows="4"
                                                          placeholder="输入图片alt"><?php echo $img['fileDesc']; ?></textarea>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php echo $form->error($model, 'content'); ?>
    </div>
    <div class="form-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '更新', array('class' => 'btn btn-primary')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->