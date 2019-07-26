<?php
/**
 * @filename SiteinfoColumnsController.php
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2018 阿年飞少
 * @datetime 2018-03-02 01:58:28 */
 $this->renderPartial('_nav');
  echo CHtml::link('新增',array('create'),array('class'=>'btn btn-danger addBtn')); $form=$this->beginWidget('CActiveForm', array(
	'id'=>'search-form',
        'htmlOptions' => array(
            'class'=>'search-form'
        ),
        'action'=>Yii::app()->createUrl('/zmf/siteinfocolumns/index'),
	'enableAjaxValidation'=>false,
        'method'=>'GET'
)); ?>
<div class="fixed-width-group">
     <div class="form-group">
    <?php echo CHtml::textField("title",$_GET["title"],array("class"=>"form-control","placeholder"=>$model->getAttributeLabel("title")));?></div>
    <div class="form-group"><button class="btn btn-default" type="submit">搜索</button></div>
</div>
<?php $this->endWidget(); ?>
 <table class="table table-hover table-striped">
    <tr>
        <th ><?php echo $model->getAttributeLabel("title");?></th>
        <th style="width: 160px">操作</th>
    </tr>
    <?php foreach ($posts as $data): ?>
    <tr>
        <td><?php echo $data->title;?></td>
        <td>
            <?php echo CHtml::link('编辑',array('update','id'=> $data->id));?>
            <?php echo CHtml::link('删除',array('delete','id'=> $data->id));?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php $this->renderPartial('/common/pager',array('pages'=>$pages));?>
