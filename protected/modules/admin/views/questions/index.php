<?php
/**
 * @filename QuestionsController.php
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2017 阿年飞少
 * @datetime 2017-09-27 08:15:52 */
$this->renderPartial('_nav');
echo CHtml::link('新增', array('create'), array('class' => 'btn btn-danger addBtn'));
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'search-form',
    'htmlOptions' => array(
        'class' => 'search-form'
    ),
    'action' => Yii::app()->createUrl('/admin/questions/index'),
    'enableAjaxValidation' => false,
    'method' => 'GET'
        ));
?>
<div class="fixed-width-group">
    <div class="form-group">
        <?php echo CHtml::textField("title", $_GET["title"], array("class" => "form-control", "placeholder" => $model->getAttributeLabel("title"))); ?>
    </div>
    <div class="form-group">
        <?php echo CHtml::dropDownList("typeId", $_GET["typeId"], Column::listClassifyFirst(Column::CLASSIFY_QUESTION), array("class" => "form-control", "empty" => $model->getAttributeLabel("typeId"))); ?> 
    </div>
    <div class="form-group">
        <?php echo CHtml::dropDownList("createUid", $_GET["createUid"], $users, array("class" => "form-control", "empty" => $model->getAttributeLabel("createUid"))); ?>
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
        <?php echo CHtml::dropDownList("status", $_GET["status"],array('1'=>'正常','2'=>'未通过'), array("class" => "form-control", "empty" => $model->getAttributeLabel("status"))); ?>
    </div>
    <div class="form-group">
        <button class="btn btn-default" type="submit">搜索</button>
        <?php echo CHtml::link('关键词替换',array('words/index'));?>
    </div>
</div>
<?php $this->endWidget(); ?>

<table class="table table-hover">
    <tr>
        <th style="width: 60px">ID</th>        
        <th style="width: 80px"><?php echo $model->getAttributeLabel("areaId"); ?></th>
        <th style="width: 120px"><?php echo $model->getAttributeLabel("typeId"); ?></th>
        <th style="width: 100px"><?php echo $model->getAttributeLabel("uid"); ?></th>
        <th style="width: 80px"><?php echo $model->getAttributeLabel("answers"); ?></th>
        <th><?php echo $model->getAttributeLabel("title"); ?></th>
        <th style="width: 80px"><?php echo $model->getAttributeLabel("bestAid"); ?></th>
        <th style="width: 160px">时间</th>
        <th style="width: 100px">状态</th>
        <th style="width: 280px">操作</th>
    </tr>

<?php foreach ($posts as $data): ?>
    <tr id="item-<?php echo $data->id; ?>">
        <td><?php echo $data->id; ?></td>        
        <td><?php echo $data->areaId>0 ? CHtml::link($data->areaInfo->title,array('index','areaId'=>$data->areaId)) : '<span class="color-grey">未设置</span>'; ?></td>
        <td><?php echo $data->typeId>0 ? CHtml::link($data->typeInfo->title,array('index','typeId'=>$data->typeId)) : '<span class="color-grey">未设置</span>'; ?></td>
        <td><?php echo CHtml::link($data->userInfo->truename,array('index','uid'=>$data->uid)); ?></td>
        <td><?php echo CHtml::link($data->answers, array('answers/index', 'qid' => $data->id),array('target'=>'_blank')); ?></td>
        <td><?php echo $data->title; ?></td>
        <td><?php echo $data->bestAid>0 ? '有' : '<span class="color-grey">无</span>'; ?></td>
        <td>
            发布：<?php echo $data->cTime>0 ? zmf::time($data->cTime,'m/d H:i') : ''; ?>
        </td>
        <td>
            <?php if($data->status== Posts::STATUS_PASSED){?>
            <span class="color-grey">显示中</span>
            <?php echo CHtml::link('下架', array('delete', 'id' => $data->id,'type'=>'del'),array('class'=>'ajax-submitLink')); ?>
            <?php }elseif($data->status== Posts::STATUS_DELED){?>
            <span class="color-grey">已经下架</span>
            <?php echo CHtml::link('上架', array('delete', 'id' => $data->id,'type'=>'pass'),array('class'=>'ajax-submitLink')); ?>
            <?php }else{?>
            <span class="color-grey">待审核</span>
            <?php echo CHtml::link('通过', array('delete', 'id' => $data->id,'type'=>'pass')); ?> | <?php echo CHtml::link('下架', array('delete', 'id' => $data->id,'type'=>'del'),array('class'=>'ajax-submitLink')); ?>
            <?php }?>
        </td>
        <td>
            <?php echo CHtml::link('编辑', array('update', 'id' => $data->id),array('target'=>'_blank')); ?>
            <?php echo CHtml::link('+回答', array('answers/create', 'qid' => $data->id),array('target'=>'_blank')); ?>
            <?php echo CHtml::link('采集', array('byTitle', 'id' => $data->id),array('target'=>'_blank')); ?>
            <?php echo CHtml::link('删除', array('realDel', 'id' => $data->id),array('class'=>'delete','data-id'=>$data->id)); ?>
            <?php if($data->status==Posts::STATUS_PASSED){?>
            &nbsp;|&nbsp;
            <?php echo CHtml::link('预览',array('/questions/view','id'=>$data->id,'urlPrefix'=>$data['urlPrefix']),array('target'=>'_blank')); ?>
            <?php echo CHtml::link('推送',array('tools/submitUrl','url'=> zmf::config('domain').Yii::app()->createUrl('/questions/view',array('id'=>$data->id,'urlPrefix'=>$data['urlPrefix']))),array('class'=>'ajax-submitLink')); ?>
            <?php }?>
        </td>
    </tr>
<?php endforeach; ?>
</table>
<?php $this->renderPartial('/common/pager', array('pages' => $pages)); ?>
