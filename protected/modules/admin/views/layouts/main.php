<?php
$this->beginContent('/layouts/common');
$title= zmf::config('houtaiTitle');
$color= zmf::config('houtaiColor');
$color2= zmf::config('houtaiColor2');
?>
<style>
    .nav>li>a.noLeft{
        padding-left:5px;
    }
    .nav>li>a.noRight{
        padding-right:5px;
    }
    .settings-main-box{
        min-height: 1000px;
    }
    <?php if($color){?>
    .navbar-default{
        background: <?php echo $color;?> !important;
    }
    .settings-side-box,.settings-side-box .side-toggle,.settings-side-box .panel{
        background: <?php echo $color;?> !important;
    }
    .settings-side-box .panel .panel-body{
        background: <?php echo $color2;?> !important;
        opacity:.8
    }
    .settings-side-box .list-group-item{
        color:<?php echo $color;?> !important;
    }
    .settings-side-box .panel .fa{
        color:<?php echo $color2;?> !important;
    }
    <?php }?>
</style>
<div class="top-header">                
    <nav class="navbar navbar-default">
        <div class="container-fluid">        
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <?php echo CHtml::link($title ? $title : '管理中心',array('index/index'),array('class'=>'navbar-brand'));?>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">                    
                    <li><?php echo CHtml::link('文章',array('articles/index'),array('class'=>'noRight','title'=>'文章列表'));?></li>
                    <li><?php echo CHtml::link('<i class="fa fa-plus"></i>',array('articles/create'),array('class'=>'noLeft','title'=>'新增文章'));?></li>
                    <li><?php echo CHtml::link('问答',array('questions/index'),array('class'=>'noRight','title'=>'问答列表'));?></li>
                    <li><?php echo CHtml::link('<i class="fa fa-plus"></i>',array('questions/create'),array('class'=>'noLeft','title'=>'新增问答'));?></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $this->userInfo['truename'];?> <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><?php echo CHtml::link('站点首页',  zmf::config('baseurl'),array('role'=>'menuitem','target'=>'_blank'));?></li>
                            <li class="divider"></li>
                            <li><?php echo CHtml::link('退出',array('/site/logout'),array('role'=>'menuitem'));?></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<div class="settings-side-box" id="settings-side-box">        
    <?php echo CHtml::link('<h1 class="side-header">管理中心</h1>',array('index/index'));?>
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <?php $navs=  AdminCommon::navbar();?>
        <?php foreach($navs as $nav){if(!$nav['seconds']){?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">                    
                <?php echo CHtml::link('<h4 class="panel-title">'.$nav['title'].'<span class="pull-right"><i class="fa fa-angle-right"></i></span></h4>',$nav['url'],array('class'=>'collapsed'));?>
            </div>
        </div>
        <?php }else{$_id= zmf::randMykeys(6, 2);$_active=false;foreach($nav['seconds'] as $v){if($v['active']){$_active=true;break;}}?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $_id;?>" aria-expanded="false" aria-controls="<?php echo $_id;?>" class="collapsed" target="main">
                    <h4 class="panel-title">
                        <?php echo $nav['title'];?>
                        <span class="pull-right"><i class="fa fa-angle-down"></i></span>
                    </h4>
                </a>
            </div>
            <div id="<?php echo $_id;?>" class="panel-collapse collapse <?php echo $_active ? 'in' : '';?>" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false">
                <div class="panel-body">
                    <div class="list-group">
                        <?php foreach($nav['seconds'] as $v){?>
                        <?php echo CHtml::link($v['title'],$v['url'],array('class'=>'list-group-item'.($v['active'] ? ' active' : '')));?>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>            
        <?php }}?>
    </div>
    <a href="javascript:;" class="side-toggle" id="side-toggle"></a>
</div>
<div class="settings-main-box" id="settings-main-box">
    <?php if(!empty($this->breadcrumbs)){?>
    <ol class="breadcrumb">
        <?php foreach($this->breadcrumbs as $k=>$v){?>
        <li><?php echo is_array($v) ? CHtml::link($k,$v):$v;?></li>
        <?php }?>
    </ol>
    <?php }?>     
    <?php echo $content; ?>
</div>
<script>    
    $(document).ready(function() {
        $('#side-toggle').unbind('click').click(function(){
            var dom=$('#settings-side-box');  
            var domm=$('#settings-main-box');  
            if(parseInt(dom.css('left'))<0){
                dom.animate({
                    left:0
                },300);
                domm.animate({
                    'padding-left':150
                },300);
            }else{
                dom.animate({
                    left:"-140px"
                },300);
                domm.animate({
                    'padding-left':10
                },300);
            }
        });
    });
    function setSideHeight(){
        var dom=$('#settings-side-box');  
        dom.animate({
            left:"-120px"
        },300);
    }
</script>   
<?php $this->endContent(); ?>