<?php
/**
 * @filename QuestionsController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-09-27 08:15:52 
 */
$tags= Tags::getAllByType(Column::CLASSIFY_QUESTION, $model->id);
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'questions-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($model); ?>
    <div class="row">
        <div class="col-xs-4 col-sm-4">
            <div class="form-group">
                <?php echo $form->labelEx($model,'areaId'); ?>        
                <div class="input-group">
                    <span class="input-group-addon">搜索</span>
                    <?php $this->widget('CAutoComplete', array(
                    'name'=>'areaname',
                    'url'=>array('area/search'),
                    'multiple'=>false,
                    'htmlOptions'=>array('class'=>"form-control",'placeholder'=>'地区名称'.($model->areaId>0 ? ',所属：'.$model->areaInfo->title : '')),
                    'methodChain'=>".result(function(event,item){var uid=item[1];var name=item[0];var phone=item[2];$('#".(CHtml::activeId($model, 'areaId'))."').val(uid);})",
                    )); ?>
                    <?php echo $form->hiddenField($model,'areaId',array('class'=>'form-control')); ?>                    
                </div>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4">
            <div class="form-group">
                <?php echo $form->labelEx($model,'typeId'); ?>        
                <?php echo $form->dropDownlist($model,'typeId', Column::listClassifyFirst(Column::CLASSIFY_QUESTION),array('class'=>'form-control','empty'=>'--选择分类--')); ?>
                <?php echo $form->error($model,'typeId'); ?>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4">
            <div class="form-group">
                <?php echo $form->labelEx($model,'uid'); ?>        
                <div class="input-group">
                    <span class="input-group-addon">搜索</span>
                    <?php $this->widget('CAutoComplete', array(
                    'name'=>'username',
                    'url'=>array('users/search'),
                    'multiple'=>false,
                    'htmlOptions'=>array('class'=>"form-control",'placeholder'=>'用户昵称'.($model->uid>0 ? ',所属：'.$model->userInfo->truename : '')),
                    'methodChain'=>".result(function(event,item){var uid=item[1];var name=item[0];var phone=item[2];$('#".(CHtml::activeId($model, 'uid'))."').val(uid);})",
                    )); ?>
                    <?php echo $form->hiddenField($model,'uid',array('class'=>'form-control')); ?>                    
                </div>
            </div>
        </div>
    </div> 
    <div class="form-group">
        <?php echo $form->labelEx($model,'title'); ?>        
        <?php echo $form->textField($model,'title',array('class'=>'form-control autoLinkTagContent')); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'faceUrl'); ?>     
        <p><img src="<?php echo Attachments::faceImg($model->faceId, 'a120');?>" alt="修改头像" id="user-avatar" style="width: 120px;height: 120px;"></p>
        <?php $this->renderPartial('/common/_singleUpload',array('model'=>$model,'fieldName'=>'faceUrl','type'=>'faceImg','fileholder'=>'filedata','targetHolder'=>'user-avatar','imgsize'=>'a120','progress'=>true));?>
        <?php echo $form->hiddenField($model,'faceId',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'faceUrl'); ?>
    </div>
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
    <?php $this->renderPartial('/tags/_forForm',array('tags'=>$tags));?>
    <div class="form-group">
        <?php echo $form->labelEx($model,'hits'); ?>        
        <?php echo $form->textField($model,'hits',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'hits'); ?>
    </div>
    <div class="form-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '更新',array('class'=>'btn btn-primary','id'=>'add-post-btn')); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->