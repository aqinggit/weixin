<?php

/**
 * @filename login-carousel.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2015 阿年飞少 
 * @datetime 2016-5-26  14:57:36 
 */
$posts=  Ads::getAllByPo('reg','img',false,5,'c900505.jpg');
?>
<?php if(!empty($posts)){?>
<div id="login-reg-generic" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner" role="listbox">
        <?php foreach ($posts as $k=>$val){?>
        <div class="item<?php if($k==0){?> active<?php }?>">
            <img alt="<?php echo $val['title'];?>" src="<?php echo $val['faceUrl'];?>" data-holder-rendered="true">
        </div>
        <?php }?>
    </div>
</div>
<?php }