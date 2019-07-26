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
<article class="weui-article">
    <h1><?php echo $info['title'];?></h1>
    <section><?php echo zmf::text(array(), $info['content']); ?></section>
</article>
<?php if(!empty($allInfos)){?>
<div class="weui-cells">
    <?php foreach ($allInfos as $val){?>                
        <?php echo zmf::link('<div class="weui-cell__bd ui-nowrap">'.$val['title'].'</div><div class="weui-cell__ft"></div>',array('site/info','code'=>$val['code']),array('class'=>'weui-cell weui-cell_access','data-type'=>'mip'));?>
    <?php }?>            
</div>
<?php }