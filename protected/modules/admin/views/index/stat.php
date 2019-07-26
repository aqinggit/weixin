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
    <div class="stat-item" data-href='<?php echo Yii::app()->createUrl('admin/articles/index');?>'>
        <p><i class="fa fa-th-list" style="color:#<?php echo $colors[4];?>"></i></p>
        <p><?php echo $articles;?></p>
        <p class="help-block">文章</p>
    </div>
    <div class="stat-item" data-href='<?php echo Yii::app()->createUrl('admin/questions/index');?>'>
        <p><i class="fa fa-question" style="color:#<?php echo $colors[3];?>"></i></p>
        <p><?php echo $questions;?></p>
        <p class="help-block">问答</p>
    </div>
    <div class="stat-item" data-href='<?php echo Yii::app()->createUrl('admin/comments/index');?>'>
        <p><i class="fa fa-comments" style="color:#<?php echo $colors[8];?>"></i></p>
        <p><?php echo $comments;?></p>
        <p class="help-block">评论数</p>
    </div>
    
</div>
<div class="simple-stat">    
    <div class="stat-item" data-href='<?php echo Yii::app()->createUrl('admin/attachments/index');?>'>
        <p><i class="fa fa-envelope" style="color:#<?php echo $colors[0];?>"></i></p>
        <p><?php echo $attachments;?></p>
        <p class="help-block">图片数</p>
    </div>
    <div class="stat-item" data-href='<?php echo Yii::app()->createUrl('admin/users/index');?>'>
        <p><i class="fa fa-users" style="color:#<?php echo $colors[7];?>"></i></p>
        <p><?php echo $users;?></p>
        <p class="help-block">用户</p>
    </div>
    <div class="stat-item" data-href=''>
        <p><i class="fa fa-heart" style="color:#<?php echo $colors[9];?>"></i></p>
        <p><?php echo $favorites;?></p>
        <p class="help-block">收藏数</p>
    </div>
    <div class="stat-item" data-href='<?php echo Yii::app()->createUrl('admin/feedback/index');?>'>
        <p><i class="fa fa-envelope" style="color:#<?php echo $colors[10];?>"></i></p>
        <p><?php echo $feedbacks;?></p>
        <p class="help-block">意见反馈</p>
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