<?php
/**
 * @filename PostThreadsController.php
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2016 阿年飞少
 * @datetime 2016-09-04 22:17:36
 */
$uploadurl=Yii::app()->createUrl('/attachments/upload',array('type'=>'posts','imgsize'=>'c650.jpg'));
$tags= Tags::getAllByType(Column::CLASSIFY_CASE, $model->id);
?>
    <div class="form">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'post-threads-form',
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
                    <?php echo $form->dropDownlist($model,'typeId', Column::listClassifyFirst(Column::CLASSIFY_CASE),array('class'=>'form-control','empty'=>'--选择分类--')); ?>
                    <?php echo $form->error($model,'typeId'); ?>
                </div>
            </div>
            <div class="col-xs-4 col-sm-4">
                <div class="form-group">
                    <?php echo $form->labelEx($model,'classify'); ?>
                    <?php echo $form->dropDownlist($model,'classify', Posts::exClassify('admin'),array('class'=>'form-control','empty'=>'--选择分类--')); ?>
                    <?php echo $form->error($model,'classify'); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model,'title'); ?>
            <div class="input-group">
                <?php echo $form->textField($model,'title',array('class'=>'form-control autoLinkTagContent')); ?>
                <span class="input-group-btn">
                <button class="btn btn-default" type="button" onclick="gotoBaidu()">百度一下</button>
            </span>
            </div>
            <?php echo $form->error($model,'title'); ?>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model,'desc'); ?>
            <?php echo $form->textArea($model,'desc',array('class'=>'form-control autoLinkTagContent','rows'=>4)); ?>
            <?php echo $form->error($model,'desc'); ?>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model,'faceUrl'); ?>
            <p><img src="<?php echo Attachments::faceImg($model->faceImg, 'a120');?>" alt="修改头像" id="user-avatar" style="width: 120px;height: 120px;"></p>
            <?php $this->renderPartial('/common/_singleUpload',array('model'=>$model,'fieldName'=>'faceImg','type'=>'faceImg','fileholder'=>'filedata','targetHolder'=>'user-avatar','imgsize'=>'a120','progress'=>true));?>
            <?php echo $form->hiddenField($model,'faceImg',array('class'=>'form-control')); ?>
            <?php echo $form->error($model,'faceUrl'); ?>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model,'content'); ?>
            <?php $this->renderPartial('//common/editor_um', array('model' => $model,'content' => $model->content,'uploadurl'=>$uploadurl)); ?>
            <div id="waitForAlt" class="waitForAlt">
                <?php foreach($contentImgs as $img){?>
                    <div class="media"><div class="media-left"><img src="<?php echo $img['remote'];?>"/></div><div class="media-body"><div class="form-group"><textarea class="form-control imgAlt" data-id="<?php echo $img['id'];?>" rows="4" placeholder="输入图片alt"><?php echo $img['fileDesc'];?></textarea></div></div></div>
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
            <?php echo $form->labelEx($model,'order'); ?>
            <?php echo $form->textField($model,'order',array('class'=>'form-control')); ?>
            <?php echo $form->error($model,'order'); ?>
        </div>
        <div class="checkbox">
            <label><?php echo CHtml::activeCheckBox($model, 'top',array('checked'=>$model->top>0 ? 1 : 0));?> 首页置顶</label>
        </div>
        <div class="form-group">
            <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '更新',array('class'=>'btn btn-primary','id'=>'add-post-btn')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- form -->
    <script>
        function gotoBaidu(){
            var title=$('#Articles_title').val();
            if(!title){
                simpleDialog({msg:'请输入标题'})
                return false;
            }
            window.open('https://www.baidu.com/s?ie=UTF-8&wd='+title,'_blank');
        }
    </script>
<?php $this->renderPartial('/common/weixinImg',array('weixinImgs'=>$weixinImgs));?>