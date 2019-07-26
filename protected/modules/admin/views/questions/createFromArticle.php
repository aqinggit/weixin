<?php
/**
 * @filename QuestionsController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-09-27 08:15:52 */
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
                <?php echo $form->labelEx($model,'typeId'); ?>        
                <?php echo $form->dropDownlist($model,'typeId', Column::listAll(),array('class'=>'form-control','empty'=>'--选择分类--')); ?>
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
        <?php echo $form->textField($model,'title',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'faceUrl'); ?>     
        <p><img src="<?php echo zmf::getThumbnailUrl($model->faceUrl, 'a120', 'faceUrl');?>" alt="修改头像" id="user-avatar" style="width: 120px;height: 120px;"></p>
        <?php $this->renderPartial('/common/_singleUpload',array('model'=>$model,'fieldName'=>'faceUrl','type'=>'faceImg','fileholder'=>'filedata','targetHolder'=>'user-avatar','imgsize'=>'a120','progress'=>true));?>
        <?php echo $form->hiddenField($model,'faceUrl',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'faceUrl'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'content'); ?>
        <?php echo $form->textArea($model,'content',array('class'=>'form-control','rows'=>8)); ?>
        <?php echo $form->error($model,'content'); ?>
    </div>
    <?php $selectedTags=$model->tagids!='' ? explode(',',$model->tagids) : array();if(!empty($tags)){?>
    <div class="form-group">
        <label>标签</label>
        <div class="add-tags-box" id="add-tags-box">
            <?php foreach($tags as $tagArr){$items=$tagArr['items'];?>
            <div class="tags-holder">
                <div class="tags-label"><?php echo $tagArr['title'];?>标签：</div>
                <div class="tags-items">
                    <?php foreach($items as $_tag){?>                
                    <span class="tags-item<?php echo in_array($_tag['id'],$selectedTags) ? ' active':'';?>">
                        <?php echo CHtml::checkBox('tags[]', in_array($_tag['id'],$selectedTags) ? true:false,array('value'=>$_tag['id'],'id'=>uniqid()));?>
                        <?php echo $_tag['title'];?>
                    </span>
                    <?php }?>
                </div>
            </div>
            <?php }?>
        </div>
    </div>
    <?php }?>
    <div class="row">
        <div class="col-xs-6 col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'cTime'); ?>        
                <?php echo $form->textField($model,'cTime',array('class'=>'form-control','value'=>($model->cTime>0 ? zmf::time($model->cTime) : ''))); ?>
                <?php echo $form->error($model,'cTime'); ?>
            </div>
        </div>
        <div class="col-xs-6 col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'hits'); ?>        
                <?php echo $form->textField($model,'hits',array('class'=>'form-control')); ?>
                <?php echo $form->error($model,'hits'); ?>
            </div>
        </div>
    </div>
    <hr/>    
    <div class="form-group">
        <?php echo $form->labelEx($modelAnswer,'content'); ?>
        <?php $this->renderPartial('//common/editor_um', array('model' => $modelAnswer,'content' => $modelAnswer->content,'editorWidth'=>688,'uptype'=>'articles','imgsize'=>'tc800wm','from'=>'article')); ?>        
        <p class="help-block">请勿手动缩进</p>
        <div id="waitForAlt" class="waitForAlt">
            <?php foreach($contentImgs as $img){?>
            <div class="media"><div class="media-left"><img src="<?php echo $img['remote'];?>"/></div><div class="media-body"><div class="form-group"><textarea class="form-control imgAlt" data-id="<?php echo $img['id'];?>" rows="4" placeholder="输入图片alt"><?php echo $img['fileAlt'];?></textarea></div></div></div>
            <?php }?>
        </div>
        <?php echo $form->error($modelAnswer,'content'); ?>
    </div>
    <div class="row">
        <div class="col-xs-4 col-sm-4">
            <div class="form-group">
                <?php echo $form->labelEx($modelAnswer,'status'); ?>        
                <?php echo $form->dropDownlist($modelAnswer,'status', Posts::exStatus('admin'),array('class'=>'form-control')); ?>
                <?php echo $form->error($modelAnswer,'status'); ?>
            </div> 
        </div>
        <div class="col-xs-4 col-sm-4">
            <div class="form-group">
                <?php echo $form->labelEx($modelAnswer,'cTime'); ?>        
                <?php echo $form->textField($modelAnswer,'cTime',array('class'=>'form-control')); ?>
                <?php echo $form->error($modelAnswer,'cTime'); ?>
            </div> 
        </div>
        <div class="col-xs-4 col-sm-4">
            <div class="form-group">
                <?php echo $form->labelEx($modelAnswer,'hits'); ?>        
                <?php echo $form->textField($modelAnswer,'hits',array('class'=>'form-control')); ?>
                <?php echo $form->error($modelAnswer,'hits'); ?>
            </div> 
        </div>
    </div>
    <div class="form-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '更新',array('class'=>'btn btn-primary','id'=>'add-post-btn')); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->