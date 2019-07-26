<?php
/**
 * @filename AnswersController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-09-27 08:15:35 
 */
$_qinfo=$model->questionInfo;
$this->breadcrumbs = array(
    '管理中心',
    '问题' => array('questions/index'),
    '回答' => array('index'),
    $_qinfo->title => array('index','qid'=>$_qinfo->id),
    '添加回答'
);
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'answers-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($model); ?>
    <div class="well well-sm">
        <h2><b><?php echo $_qinfo->title;?></b></h2>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'uid'); ?>   
        <div class="input-group">
            <span class="input-group-addon">搜索</span>
            <?php $this->widget('CAutoComplete', array(
            'name'=>'username',
            'url'=>array('users/search'),
            'multiple'=>false,
            'htmlOptions'=>array('class'=>"form-control",'placeholder'=>'用户昵称/手机号/QQ/微信'.($model->uid>0 ? '（目前所属【'.$model->userInfo->truename.'】）' : '')),
            'methodChain'=>".result(function(event,item){var uid=item[1];var name=item[0];var phone=item[2];$('#".(CHtml::activeId($model, 'uid'))."').val(uid);})",
            )); ?>
            <?php echo $form->hiddenField($model,'uid',array('class'=>'form-control')); ?>
        </div>
        <?php echo $form->error($model,'uid'); ?>
    </div> 
    <style>
        .waitForAlt .media img{
            width: 120px;
            height: 90px;
        }
    </style>
    <div class="form-group">
        <?php echo $form->labelEx($model,'content'); ?>
        <?php $this->renderPartial('//common/editor_um', array('model' => $model,'content' => $model->content,'editorWidth'=>688,'uptype'=>'articles','imgsize'=>'tc800wm','from'=>'article')); ?>
        <p class="help-block">请勿手动缩进</p>
        <div id="waitForAlt" class="waitForAlt">
            <?php foreach($contentImgs as $img){?>
            <div class="media"><div class="media-left"><img src="<?php echo $img['remote'];?>"/></div><div class="media-body"><div class="form-group"><textarea class="form-control imgAlt" data-id="<?php echo $img['id'];?>" rows="4" placeholder="输入图片alt"><?php echo $img['fileAlt'];?></textarea></div></div></div>
            <?php }?>
        </div>
        <?php echo $form->error($model,'content'); ?>
    </div>
    <div class="row">
        <div class="col-xs-4 col-sm-4">
            <div class="form-group">
                <?php echo $form->labelEx($model,'status'); ?>        
                <?php echo $form->dropDownlist($model,'status', Posts::exStatus('admin'),array('class'=>'form-control')); ?>
                <?php echo $form->error($model,'status'); ?>
            </div> 
        </div>
        <div class="col-xs-4 col-sm-4">
            <div class="form-group">
                <?php echo $form->labelEx($model,'cTime'); ?>        
                <?php echo $form->textField($model,'cTime',array('class'=>'form-control')); ?>
                <?php echo $form->error($model,'cTime'); ?>
            </div> 
        </div>
        <div class="col-xs-4 col-sm-4">
            <div class="form-group">
                <?php echo $form->labelEx($model,'hits'); ?>        
                <?php echo $form->textField($model,'hits',array('class'=>'form-control')); ?>
                <?php echo $form->error($model,'hits'); ?>
            </div> 
        </div>
    </div>
    <div class="form-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '更新',array('class'=>'btn btn-primary','id'=>'add-post-btn')); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->