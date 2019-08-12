
<style>
    .charts{
        min-height:900px; 
    }
</style>
<div id="chart-canvas" class="charts well">
    <?php

$this->renderPartial('_nav');
$colors=array(
    '985DB4',
    '89E88F',
    'EA5B46',
    'E4DB24',
    '8BBAFE',
    'FE6634',
    '00CC65',
    'FF9997',
    '33CBCC',
    'BE7435',
    'FF6634',
    'F23055',
    '00AB56',
    'FFCA32',
    '32BDBD',
    'DF3051',
    '5C5D78',
    'E68B79',
    '616280',
    'A0D1CE',
);
?>
<style>
    .simple-stat{
        display: flex;
    }
    .simple-stat .stat-item{
        -webkit-box-flex: 1;
        -webkit-flex: 1;
        flex: 1;
        text-align: center;
        padding: 30px 0;
        border-bottom: 1px solid #E4E4E4;
        border-right: 1px solid #E4E4E4;
        cursor: pointer
    }
    .simple-stat i{
        font-size: 48px;
    }
</style>
<div class="simple-stat">
    <div class="stat-item" data-href='<?php echo Yii::app()->createUrl('zmf/articles/index');?>'>
        <p><i class="fa fa-pencil" style="color:#<?php echo $colors[0];?>"></i></p>
        <p><?php echo $articles;?></p>
        <p class="help-block">文章</p>
    </div>
    <div class="stat-item" data-href='<?php echo Yii::app()->createUrl('zmf/posts/index');?>'>
        <p><i class="fa fa-thumbs-up" style="color:#<?php echo $colors[1];?>"></i></p>
        <p><?php echo $posts;?></p>
        <p class="help-block">案例</p>
    </div>
    <div class="stat-item" data-href='<?php echo Yii::app()->createUrl('zmf/plans/index');?>'>
        <p><i class="fa fa-rmb" style="color:#<?php echo $colors[2];?>"></i></p>
        <p><?php echo $plans;?></p>
        <p class="help-block">订单</p>
    </div>
    <div class="stat-item" data-href='<?php echo Yii::app()->createUrl('zmf/goods/index');?>'>
        <p><i class="fa fa-credit-card" style="color:#<?php echo $colors[3];?>"></i></p>
        <p><?php echo $goods;?></p>
        <p class="help-block">套餐</p>
    </div>
</div>
<div class="simple-stat">
    <div class="stat-item" data-href='<?php echo Yii::app()->createUrl('zmf/users/index');?>'>
        <p><i class="fa fa-users" style="color:#<?php echo $colors[4];?>"></i></p>
        <p><?php echo $users;?></p>
        <p class="help-block">用户</p>
    </div>
    <div class="stat-item" data-href='<?php echo Yii::app()->createUrl('zmf/tips/index');?>'>
        <p><i class="fa fa-star" style="color:#<?php echo $colors[5];?>"></i></p>
        <p><?php echo $tips;?></p>
        <p class="help-block">评价</p>
    </div>
    <div class="stat-item" data-href='<?php echo Yii::app()->createUrl('zmf/feedback/index');?>'>
        <p><i class="fa fa-comments" style="color:#<?php echo $colors[6];?>"></i></p>
        <p><?php echo $feedbackNum;?></p>
        <p class="help-block">反馈</p>
    </div>
    <div class="stat-item" data-href='<?php echo Yii::app()->createUrl('zmf/attachments/index');?>'>
        <p><i class="fa fa-file" style="color:#<?php echo $colors[7];?>"></i></p>
        <p><?php echo $attachsNum;?></p>
        <p class="help-block">附件</p>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.stat-item').click(function(){
            var url=$(this).attr('data-href');
            if(url){
                window.location.href=url;
            }
        })
    })
</script>
</div>