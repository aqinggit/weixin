<?php
/**
 * @filename AdsController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2016 阿年飞少 
 * @datetime 2016-07-25 04:22:45 */
 ?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ads-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($model); ?>
    <div class="form-group">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textArea($model,'description',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'description'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'url'); ?>
        <?php echo $form->textField($model,'url',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'url'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'faceUrl'); ?>     
        <p><img src="<?php echo Attachments::faceImg($model->faceimg, 'a120');?>" alt="修改头像" id="user-avatar" style="width: 120px;height: 120px;"></p>
        <?php $this->renderPartial('/common/_singleUpload',array('model'=>$model,'fieldName'=>'faceimg','type'=>'faceImg','fileholder'=>'filedata','targetHolder'=>'user-avatar','imgsize'=>'a120','progress'=>true));?>
        <?php echo $form->hiddenField($model,'faceimg',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'faceUrl'); ?>
    </div>
    <div class="row">
        <div class="col-xs-6 col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'startTime'); ?>
                <?php 
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model,
                'attribute'=>'startTime',
                'language'=>'zh-cn',
                'value'=>date('Y/m/d',$model->startTime),			    
                            'options'=>array(
                                'showAnim'=>'fadeIn',
                            ),	
                            'htmlOptions'=>array(
                                'readonly'=>'readonly',
                                'class'=>'form-control',
                                'value'=>date('Y/m/d',($model->startTime) ? $model->startTime :'')
                        ),		    
                        ));
                ?>
                <?php echo $form->error($model,'startTime'); ?>
            </div>
        </div>
        <div class="col-xs-6 col-sm-6">
            <div class="form-group">
                <?php echo $form->labelEx($model,'expiredTime'); ?>
                <?php 
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model,
                'attribute'=>'expiredTime',
                'language'=>'zh-cn',
                'value'=>date('Y/m/d',$model->expiredTime),			    
                            'options'=>array(
                                'showAnim'=>'fadeIn',
                            ),	
                            'htmlOptions'=>array(
                                'readonly'=>'readonly',
                                'class'=>'form-control',
                                'value'=>date('Y/m/d',($model->expiredTime) ? $model->expiredTime :'')
                        ),		    
                        ));
                ?>
                <?php echo $form->error($model,'expiredTime'); ?>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-3 col-sm-3">
            <div class="form-group">
                <?php echo $form->labelEx($model,'position'); ?>
                <?php echo $form->dropDownlist($model,'position',Ads::colPositions('admin'),array('class'=>'form-control')); ?>
                <?php echo $form->error($model,'position'); ?>
            </div>
        </div>
        <div class="col-xs-3 col-sm-3">
            <div class="form-group">
                <?php echo $form->labelEx($model,'classify'); ?>
                <?php echo $form->dropDownlist($model,'classify',Ads::adsStyles('admin'),array('class'=>'form-control')); ?>
                <?php echo $form->error($model,'classify'); ?>
            </div>
        </div>
        <div class="col-xs-3 col-sm-3">
            <div class="form-group">
                <?php echo $form->labelEx($model,'platform'); ?>
                <?php echo $form->dropDownlist($model,'platform',Ads::exPlatform('admin'),array('class'=>'form-control')); ?>
                <?php echo $form->error($model,'platform'); ?>
            </div>
        </div>
        <div class="col-xs-3 col-sm-3">
            <div class="form-group">
                <?php echo $form->labelEx($model,'order'); ?>
                <?php echo $form->textField($model,'order',array('class'=>'form-control')); ?>
                <p class="help-block">越大越靠前</p>
                <?php echo $form->error($model,'order'); ?>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-3 col-sm-3">
            <div class="form-group">
                <?php echo $form->labelEx($model,'bgColor'); ?>
                <?php echo $form->textField($model,'bgColor',array('class'=>'form-control')); ?>
                <p class="help-block">带“#”，例如：“#000000”</p>
                <?php echo $form->error($model,'bgColor'); ?>
            </div>
        </div>
        <div class="col-xs-3 col-sm-3">
            <div class="form-group">
                <?php echo $form->labelEx($model,'color'); ?>
                <?php echo $form->textField($model,'color',array('class'=>'form-control')); ?>
                <p class="help-block">带“#”，例如：“#000000”</p>
                <?php echo $form->error($model,'color'); ?>
            </div>
        </div>        
    </div>     
    <div class="form-group">
        <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '更新',array('class'=>'btn btn-primary')); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->