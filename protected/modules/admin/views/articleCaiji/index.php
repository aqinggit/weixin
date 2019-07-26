<?php
/**
 * @filename ArticleCaijiController.php
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com>
 * @link http://www.newsoul.cn
 * @copyright Copyright©2017 阿年飞少
 * @datetime 2017-12-05 07:28:35 */
 $this->renderPartial('_nav');
 $form=$this->beginWidget('CActiveForm', array(
	'id'=>'search-form',
        'htmlOptions' => array(
            'class'=>'search-form'
        ),
        'action'=>Yii::app()->createUrl('/admin/articleCaiji/index'),
	'enableAjaxValidation'=>false,
        'method'=>'GET'
)); ?>
<div class="fixed-width-group">
     <div class="form-group">
        <?php echo CHtml::textField("title",$_GET["title"],array("class"=>"form-control","placeholder"=>$model->getAttributeLabel("title")));?>
     </div>
    <div class="form-group"><button class="btn btn-default" type="submit">搜索</button></div>
</div>
<?php $this->endWidget(); ?>
 <table class="table table-hover">
    <tr>
        <th ><?php echo $model->getAttributeLabel("title");?></th>
        <th style="width: 60px"><?php echo $model->getAttributeLabel("weight");?></th>
        <th style="width: 60px"><?php echo $model->getAttributeLabel("type");?></th>
        <th style="width: 160px"><?php echo $model->getAttributeLabel("cTime");?></th>
        <th style="width: 120px">操作</th>
    </tr>
    <?php foreach ($posts as $data): ?>
    <tr>
        <td><?php echo CHtml::link($data->title,$data->url,array('target'=>'_blank'));?></td>
        <td><?php echo $data->weight;?></td>
        <td><?php echo ArticleCaiji::exType($data->type);?></td>
        <td><?php echo zmf::time($data->cTime);?></td>
        <td>
            <?php echo CHtml::link('删除',array('delete','id'=> $data->id));?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php $this->renderPartial('/common/pager',array('pages'=>$pages));?>
