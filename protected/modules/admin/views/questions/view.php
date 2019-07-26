<?php

/**
 * @filename QuestionsController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2017 阿年飞少 
 * @datetime 2017-09-27 08:15:52 */
$this->renderPartial('_nav');
?>
<div class="well well-sm">
    <p><b><?php echo $model->title;?></b></p>
    <p><?php echo $model->content;?></p>
    <p>
        <?php echo CHtml::link('添加回答',array('answers/create','qid'=>$model->id),array('class'=>'btn btn-primary'));?>
    </p>
</div>
