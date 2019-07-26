<?php
/**
 * @filename AnswersController.php
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2017 阿年飞少
 * @datetime 2017-09-27 08:15:35 */
$this->renderPartial('_nav');
echo CHtml::link('新增', array('create','qid'=> zmf::val('qid',2)), array('class' => 'btn btn-danger addBtn'));
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'search-form',
    'htmlOptions' => array(
        'class' => 'search-form'
    ),
    'action' => Yii::app()->createUrl('/admin/answers/index'),
    'enableAjaxValidation' => false,
    'method' => 'GET'
        ));
?>
<div class="fixed-width-group">
    <div class="form-group">
        <?php echo CHtml::textField("content", $_GET["content"], array("class" => "form-control", "placeholder" => $model->getAttributeLabel("content"))); ?>
    </div>    
    <div class="form-group">
        <?php echo CHtml::textField("qid", $_GET["qid"], array("class" => "form-control", "placeholder" => $model->getAttributeLabel("qid"))); ?>
    </div>    
    <div class="form-group">
        <?php echo CHtml::dropDownList("isBest", $_GET["isBest"],zmf::yesOrNo('admin'), array("class" => "form-control", "empty" => $model->getAttributeLabel("isBest"))); ?>        
    </div>
    <div class="form-group">
        <?php echo CHtml::dropDownList("status", $_GET["status"],array('1'=>'正常','2'=>'未通过'), array("class" => "form-control", "empty" => $model->getAttributeLabel("status"))); ?>
    </div>
    <div class="form-group"><button class="btn btn-default" type="submit">搜索</button></div>
</div>
<?php $this->endWidget(); ?>

<table class="table table-hover">
    <tr>        
        <th style="width:80px">ID</th>
        <th><?php echo $model->getAttributeLabel("qid"); ?></th>
        <th style="width:120px"><?php echo $model->getAttributeLabel("uid"); ?></th>
        <th style="width:120px"><?php echo $model->getAttributeLabel("cTime"); ?></th>
        <th style="width:80px"><?php echo $model->getAttributeLabel("isBest"); ?></th>
        <th style="width:100px">问题状态</th>        
        <th style="width:80px">回答状态</th>        
        <th style="width: 160px">操作</th>
    </tr>

<?php foreach ($posts as $data){$_questionInfo=$data->questionInfo;?>
    <tr>        
        <td><?php echo $data->id; ?></td>
        <td><?php echo CHtml::link($_questionInfo->title,array('index','qid'=>$data->qid)); ?></td>        
        <td><?php echo CHtml::link($data->userInfo->truename,array('index','uid'=>$data->uid)); ?></td>
        <td><?php echo zmf::time($data->cTime,'m/d H:i'); ?></td>        
        <td>
            <?php if($data->isBest){?>
            <span class="color-grey">最佳</span><br/>
            <?php echo CHtml::link('取消', array('setBest', 'id' => $data->id,'type'=>'cancel'),array('class'=>'ajax-submitLink')); ?>
            <?php }else{?>
            <span class="color-grey">非最佳</span><br/>
            <?php echo CHtml::link('设为最佳', array('setBest', 'id' => $data->id,'type'=>'do'),array('class'=>'ajax-submitLink')); ?>
            <?php }?>
        </td>
        <td>
            <?php if($_questionInfo['status']== Posts::STATUS_PASSED){?>
            <span class="color-grey">显示中</span><br/>
            <?php echo CHtml::link('下架', array('questions/delete', 'id' => $_questionInfo['id'],'type'=>'del'),array('class'=>'ajax-submitLink')); ?>
            <?php }elseif($_questionInfo['status']== Posts::STATUS_DELED){?>
            <span class="color-grey">已经下架</span><br/>
            <?php echo CHtml::link('上架', array('questions/delete', 'id' => $_questionInfo['id'],'type'=>'pass'),array('class'=>'ajax-submitLink')); ?>
            <?php }else{?>
            <span class="color-grey">待审核</span><br/>
            <?php echo CHtml::link('通过', array('questions/delete', 'id' => $_questionInfo['id'],'type'=>'pass')); ?> | <?php echo CHtml::link('下架', array('questions/delete', 'id' => $_questionInfo['id'],'type'=>'del'),array('class'=>'ajax-submitLink')); ?>
            <?php }?>
        </td>
        <td>
            <?php if($data->status== Posts::STATUS_PASSED){?>
            <span class="color-grey">显示中</span><br/>
            <?php echo CHtml::link('下架', array('delete', 'id' => $data->id,'type'=>'del'),array('class'=>'ajax-submitLink')); ?>
            <?php }elseif($data->status== Posts::STATUS_DELED){?>
            <span class="color-grey">已经下架</span><br/>
            <?php echo CHtml::link('上架', array('delete', 'id' => $data->id,'type'=>'pass'),array('class'=>'ajax-submitLink')); ?>
            <?php }else{?>
            <span class="color-grey">待审核</span><br/>
            <?php echo CHtml::link('通过', array('delete', 'id' => $data->id,'type'=>'pass')); ?> | <?php echo CHtml::link('下架', array('delete', 'id' => $data->id,'type'=>'del'),array('class'=>'ajax-submitLink')); ?>
            <?php }?>
        </td>
        <td>
            <?php echo $_questionInfo['status']== Posts::STATUS_PASSED ? CHtml::link('预览', array('/questions/view', 'id' => $_questionInfo['id'],'urlPrefix'=>$_questionInfo['urlPrefix']),array('target'=>'_blank')) : ''; ?>
            <?php echo CHtml::link('编辑', array('update', 'id' => $data->id)); ?>
            <?php echo CHtml::link('+回答', array('create', 'qid' => $data->qid)); ?>
        </td>
    </tr>
<?php }?>
</table>
<?php $this->renderPartial('/common/pager', array('pages' => $pages)); ?>
