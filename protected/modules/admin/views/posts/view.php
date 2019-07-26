<?php

/**
 * @filename PostsController.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2016 阿年飞少 
 * @datetime 2016-11-04 10:52:11 
 */
$this->breadcrumbs=array(
    '管理中心',
    '素材包'=>array('posts/all')
);
?>
<h1><?php echo $info->title;?></h1>
<div class="content">
    <?php echo $info->content;?>
</div>