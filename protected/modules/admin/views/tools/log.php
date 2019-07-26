<?php

/**
 * @filename log.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2015 阿年飞少 
 * @datetime 2015-7-9  18:05:15 
 */
$this->breadcrumbs = array(
    '首页'=>array('index/index'),    
    '小工具'=>array('tools/index')
);
if($_GET['type']=='app'){
    $delAction='delApp';
}elseif($_GET['type']=='apptimes'){
    $delAction='delApptimes';
}elseif($_GET['type']=='log'){
    $delAction='delLog';
}elseif($_GET['type']=='crashLog'){
    $delAction='delCrashLog';
}elseif($_GET['type']=='appLog'){
    $delAction='delAppLog';
}
?>
<div class="row">
    <div class="col-xs-10 col-sm-10">
        <?php zmf::test($content);?>
    </div>
    <div class="col-xs-2 col-sm-2">
        <?php echo CHtml::link('清空日志',array('checkLog','type'=>$delAction,'file'=>$_GET['file']),array('class'=>'btn btn-primary'));?>
    </div>
</div>
