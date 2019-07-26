<?php

/**
 * @filename about.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2015 阿年飞少 
 * @datetime 2016-1-5  15:04:55 
 */
?>
<div class="container">
    <div class="main-part card">
        <div class="module">
            <div class="module-header"><?php echo $info['title'];?></div>
            <div class="module-body padding-body">
                <?php echo $info['content']; ?>
            </div>
        </div>
    </div>
    <?php if(!empty($allInfos)){?>
    <div class="aside-part card">
        <div class="module">
            <div class="module-header">更多文档</div>
            <div class="module-body">
                <?php foreach ($allInfos as $val){?>
                <p><?php echo zmf::link($val['title'],array('site/info','id'=>$val['id']));?></p>
                <?php }?>
            </div>
        </div>
        <?php }?>
    </div>
</div>
