<?php
/**
 * @filename ArticlesController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-10-14 08:37:28 */
$this->renderPartial('_nav');
echo CHtml::link('新增', array('create'), array('class' => 'btn btn-danger addBtn'));
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'search-form',
    'htmlOptions' => array('class' => 'search-form'),
    'action' => Yii::app()->createUrl('/admin/articles/index'),
    'enableAjaxValidation' => false,
    'method' => 'GET'
    ));
?>
<div class="fixed-width-group">
    <div class="form-group">
        <?php echo CHtml::textField("title", $_GET["title"], array("class" => "form-control", "placeholder" => $model->getAttributeLabel("title"))); ?> 
    </div>
    <div class="form-group">
        <?php echo CHtml::dropDownList("typeId", $_GET["typeId"], Column::listClassifyFirst(Column::CLASSIFY_POST), array("class" => "form-control", "empty" => $model->getAttributeLabel("typeId"))); ?> 
    </div>
    <div class="form-group">
        <?php echo CHtml::dropDownList("uid", $_GET["uid"], $users, array("class" => "form-control", "empty" => $model->getAttributeLabel("uid"))); ?>
    </div>
    <div class="form-group">
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name'=>'startTime',
            'language'=>'zh-cn',
            'value'=>($startTime>0 ? date('Y/m/d',$startTime) :''),
            'options'=>array(
                'showAnim'=>'fadeIn',
            ),
            'htmlOptions'=>array(
                'readonly'=>'readonly',
                'class'=>'form-control',
                'placeholder'=>'起始时间',
                'value'=>($startTime>0 ? date('Y/m/d',$startTime) :'')
            ),
        ));
        ?>
    </div>
    <div class="form-group">
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name'=>'endTime',
            'language'=>'zh-cn',
            'value'=>($endTime>0 ? date('Y/m/d',$endTime) :''),
            'options'=>array(
                'showAnim'=>'fadeIn',
            ),
            'htmlOptions'=>array(
                'readonly'=>'readonly',
                'class'=>'form-control',
                'placeholder'=>'终止时间',
                'value'=>($endTime>0 ? date('Y/m/d',$endTime) :'')
            ),
        ));
        ?>
    </div>
    <div class="form-group">
        <?php echo CHtml::dropDownList("status", $_GET["status"], Posts::exStatus('admin'), array("class" => "form-control", "empty" => $model->getAttributeLabel("status"))); ?> 
    </div>
    <div class="form-group">
        <button class="btn btn-default" type="submit">搜索</button>
        <?php echo CHtml::link('关键词替换',array('words/index'));?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php 
$form = $this->beginWidget('CActiveForm', array(
'id' => 'search-form',
'htmlOptions' => array('class' => 'search-form','target' => '_blank'),
'action' => Yii::app()->createUrl('/admin/articles/caiji'),
'enableAjaxValidation' => false,
));
?>
<div class="fixed-width-group"> 
    <div class="form-group" style="width: 338px">
        <?php echo CHtml::textField("url", '', array("class" => "form-control", "placeholder" => '文章页面，目前支持微信')); ?>
    </div>
    <div class="form-group">
        <button class="btn btn-default" type="submit">获取</button>        
    </div>
</div> 
<?php $this->endWidget(); ?>
<table class="table table-hover">
    <tr>    
        <th style="width: 80px"><?php echo $model->getAttributeLabel("id"); ?></th>
        <th style="width: 80px"><?php echo $model->getAttributeLabel("areaId"); ?></th>
        <th style="width: 120px"><?php echo $model->getAttributeLabel("typeId"); ?></th>
        <th style="width: 100px"><?php echo $model->getAttributeLabel("uid"); ?></th>
        <th style="min-width: 120px"><?php echo $model->getAttributeLabel("title"); ?></th>
        <th style="width: 60px"><?php echo $model->getAttributeLabel("status"); ?></th>
        <th style="width: 140px"><?php echo $model->getAttributeLabel("cTime"); ?></th>
        <th style="width: 300px">操作</th>
    </tr>

    <?php foreach ($posts as $data): ?> 
        <tr id="item-<?php echo $data['id'];?>">
            <td><?php echo CHtml::link(($data->toTime>0 ? '# ' : '#').$data->id,['tokd','id'=>$data['id']],['target'=>'_blank']); ?></td>
            <td><?php echo $data->areaId>0 ? CHtml::link($data->areaInfo->title,array('index','areaId'=>$data->areaId)) : '<span class="color-grey">未设置</span>'; ?></td>
            <td><?php echo $data->typeId>0 ? CHtml::link($data->typeInfo->title,array('index','typeId'=>$data->typeId)) : '<span class="color-grey">未设置</span>'; ?></td>
            <td><?php echo CHtml::link($data->userInfo->truename,array('index','uid'=>$data->uid)); ?></td>
            <td><?php echo $data->title; ?></td>
            <td class="<?php echo $data->status!=Posts::STATUS_PASSED ? 'text-danger' : ''; ?>"><?php echo CHtml::link(Posts::exStatus($data->status), array('setStatus', 'id' => $data->id,'type'=>'passed'),array('class'=>$data->status!=Posts::STATUS_PASSED ? 'text-danger' : '')); ?></td>
            <td>
                <?php echo $data['cTime']>0 ? zmf::time($data['cTime']) : '';?>
            </td>
            <td>                
                <?php echo CHtml::link('导入问答', array('questions/createFromArticle', 'aid' => $data->id),array('target'=>'_blank')); ?>                
                <?php echo CHtml::link('编辑', array('update', 'id' => $data->id),array('target'=>'_blank')); ?>        
                <?php echo CHtml::link('删除', array('delete', 'id' => $data->id),array('class'=>'delete','data-id'=>$data['id'])); ?>                
                &nbsp;|&nbsp;
                <?php echo CHtml::link('百度','https://www.baidu.com/s?ie=UTF-8&wd='.$data->title,array('target'=>'_blank')); ?>
                <?php if($data->status==Posts::STATUS_PASSED){?>
                <?php echo CHtml::link('预览',array('/article/view','id'=>$data->id,'urlPrefix'=>$data['urlPrefix']),array('target'=>'_blank')); ?>
                <?php echo CHtml::link('推送',array('tools/submitUrl','url'=> zmf::config('domain').Yii::app()->createUrl('/article/view',array('id'=>$data->id,'urlPrefix'=>$data['urlPrefix']))),array('class'=>'ajax-submitLink')); ?>
                <?php }?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php $this->renderPartial('/common/pager', array('pages' => $pages)); ?>
