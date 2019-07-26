<?php
/**
 * @filename WordsController.php 
 * @Description 
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-08-11 09:53:46 */
$this->renderPartial('_nav');
echo CHtml::link('新增', array('create'), array('class' => 'btn btn-danger addBtn'));
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'search-form',
    'htmlOptions' => array(
        'class' => 'search-form'
    ),
    'action' => Yii::app()->createUrl('/admin/words/index'),
    'enableAjaxValidation' => false,
    'method' => 'GET'
        ));
?>
<div class="fixed-width-group"> 
    <div class="form-group"> 
        <?php echo CHtml::textField("word", $_GET["word"], array("class" => "form-control", "placeholder" => $model->getAttributeLabel("word"))); ?>
    </div> 
    <div class="form-group"> 
        <?php echo CHtml::dropDownList("type", $_GET["type"], Words::exTypes('admin'),array("class" => "form-control", "empty" => '--请选择--')); ?>
    </div>     
    <div class="form-group">
        <button class="btn btn-default" type="submit">搜索</button>
        <div class="dropdown pull-right">
            <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-default">
                替换<span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dLabel">
               <li><?php echo CHtml::link('评论', array('replaceAll','type'=>'tips'),array('target'=>'_blank'))?></li>
                <li><?php echo CHtml::link('回答', array('replaceAll','type'=>'answers'),array('target'=>'_blank'))?></li>
                <li><?php echo CHtml::link('文章', array('replaceAll','type'=>'articles'),array('target'=>'_blank'))?></li>
            </ul>
        </div>
    </div> 
</div> 
<?php $this->endWidget(); ?>

<table class="table table-hover"> 
    <tr> 
        <th style="width: 120px"><?php echo $model->getAttributeLabel("uid"); ?></th>     
        <th style="width: 80px"><?php echo $model->getAttributeLabel("type"); ?></th>            
        <th style="width: 80px"><?php echo $model->getAttributeLabel("action"); ?></th>            
        <th ><?php echo $model->getAttributeLabel("word"); ?></th>      
        <th style="width: 200px">操作</th> 
    </tr> 

    <?php foreach ($posts as $data): ?> 
    <tr class="item-<?php echo $data->id;?>"> 
        <td><?php echo CHtml::link($data->userInfo->truename,array('index','uid'=>$data->uid)); ?></td> 
        <td><?php echo Words::exTypes($data->type); ?></td>   
        <td><?php echo Words::exActions($data->action); ?></td>            
        <td><?php echo $data->word.($data->action== Words::ACTION_REPLACE ? '=>'.$data->replaceTo : ''); ?></td> 
        <td>
            <?php 
            if($data->action== Words::ACTION_REPLACE){?>
            <span class="dropdown" >
                <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    替换<span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><?php echo CHtml::link('评论', array('replace','type'=>'tips', 'id' => $data->id),array('target'=>'_blank'))?></li>
                    <li><?php echo CHtml::link('回答', array('replace','type'=>'answers', 'id' => $data->id),array('target'=>'_blank'))?></li>
                    <li><?php echo CHtml::link('文章', array('replace','type'=>'articles', 'id' => $data->id),array('target'=>'_blank'))?></li>
                </ul>
            </span>
            <?php }?>
            <?php echo CHtml::link('编辑', array('update', 'id' => $data->id)); ?> 
            <?php echo CHtml::link('删除', array('delete', 'id' => $data->id),array('class'=>'delete','data-id'=>$data->id)); ?> 
        </td>
    </tr> 
    <?php endforeach; ?> 
</table> 
<?php $this->renderPartial('/common/pager', array('pages' => $pages)); ?> 