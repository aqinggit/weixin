<?php
/**
 * @filename ArticlesWeixinController.php
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2019 阿年飞少
 * @datetime 2019-07-26 20:54:56 */
 $this->renderPartial('_nav');
  echo CHtml::link('新增',array('create'),array('class'=>'btn btn-danger addBtn')); $form=$this->beginWidget('CActiveForm', array(
	'id'=>'search-form',
        'htmlOptions' => array(
            'class'=>'search-form'
        ),
        'action'=>Yii::app()->createUrl('/zmf/articlesweixin/index'),
	'enableAjaxValidation'=>false,
        'method'=>'GET'
)); ?>
<div class="fixed-width-group">
     <div class="form-group">
    <?php echo CHtml::textField("user_id",$_GET["user_id"],array("class"=>"form-control","placeholder"=>$model->getAttributeLabel("user_id")));?></div>
    <div class="form-group">
    <?php echo CHtml::textField("title",$_GET["title"],array("class"=>"form-control","placeholder"=>$model->getAttributeLabel("title")));?></div>
    <div class="form-group">
    <?php echo CHtml::textField("content",$_GET["content"],array("class"=>"form-control","placeholder"=>$model->getAttributeLabel("content")));?></div>
    <div class="form-group">
    <?php echo CHtml::textField("status",$_GET["status"],array("class"=>"form-control","placeholder"=>$model->getAttributeLabel("status")));?></div>
    <div class="form-group">
    <?php echo CHtml::textField("score",$_GET["score"],array("class"=>"form-control","placeholder"=>$model->getAttributeLabel("score")));?></div>
    <div class="form-group"><button class="btn btn-default" type="submit">搜索</button></div>
</div>
<?php $this->endWidget(); ?>

 <table class="table table-hover table-striped">
    <tr>
                <th ><?php echo $model->getAttributeLabel("user_id");?></th>
                <th ><?php echo $model->getAttributeLabel("title");?></th>
                <th ><?php echo $model->getAttributeLabel("status");?></th>
                <th ><?php echo $model->getAttributeLabel("score");?></th>
                <th ><?php echo $model->getAttributeLabel("cTime");?></th>
                <th style="width: 160px">操作</th>
    </tr>

    <?php foreach ($posts as $data): ?>
    <tr>
                <td><?php echo $data->userInfo->truename;?></td>
                <td><?php echo $data->title;?></td>
                <td><?php echo $data->status==1?"通过":"未通过";?></td>
                <td><?php echo $data->score;?></td>
                <td><?php echo zmf::time($data->cTime);?></td>
                <td>
            <?php echo CHtml::link('编辑',array('update','id'=> $data->id));?>
            <?php echo CHtml::link('预览',array('/articleweixin/index','id'=> $data->id));?>
            <?php echo CHtml::link('删除',array('delete','id'=> $data->id));?>
            <?php echo CHtml::link('通过',array('pass','id'=> $data->id));?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php $this->renderPartial('/common/pager',array('pages'=>$pages));?>
