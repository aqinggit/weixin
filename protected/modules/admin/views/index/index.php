
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
    <div class="stat-item" data-href='<?php echo Yii::app()->createUrl('admin/activity/index');?>'>
        <p><i class="fa fa-star" style="color:#<?php echo $colors[0];?>"></i></p>
        <p><?php echo $activity;?></p>
        <p class="help-block">活动</p>
    </div>
    <div class="stat-item" data-href='<?php echo Yii::app()->createUrl('admin/volunteers/index');?>'>
        <p><i class="fa fa-users" style="color:#<?php echo $colors[1];?>"></i></p>
        <p><?php echo $volunteers;?></p>
        <p class="help-block">志愿者</p>
    </div>
    <div class="stat-item" data-href='<?php echo Yii::app()->createUrl('admin/volunteers/index',['type'=>'index']);?>'>
        <p><i class="fa fa-users" style="color:#<?php echo $colors[2];?>"></i></p>
        <p><?php echo $volunteersNoPass;?></p>
        <p class="help-block">待审核志愿者</p>
    </div>
    <div class="stat-item" data-href='<?php echo Yii::app()->createUrl('admin/volunteerActive/index');?>'>
        <p><i class="fa fa-comments" style="color:#<?php echo $colors[3];?>"></i></p>
        <p><?php echo $volunteerActive;?></p>
        <p class="help-block">活动申请管理</p>
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