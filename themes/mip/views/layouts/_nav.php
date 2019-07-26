<?php
/**
 * @filename _cols.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2015 阿年飞少 
 * @datetime 2016-6-6  10:52:18 
 */
//$cols=  Column::allCols();
?>
<div class="weui-tabbar">     
    <a href="<?php echo zmf::config('baseurl');?>" class="weui-tabbar__item<?php echo $this->selectNav=='index' ? ' weui-bar__item_on' : '';?>" data-type="mip">
        <i class="fa fa-home"></i>
        <p class="weui-tabbar__label">首页</p>
    </a>
    <a href="<?php echo zmf::createUrl('index/posts');?>" class="weui-tabbar__item<?php echo $this->selectNav == 'posts'  ? ' weui-bar__item_on' : '';?>" data-type="mip">
        <i class="fa fa-file-text-o"></i>      
        <p class="weui-tabbar__label">案例</p>
    </a>
    <a href="<?php echo zmf::createUrl('index/gallery');?>" class="weui-tabbar__item<?php echo $this->selectNav == 'gallery'  ? ' weui-bar__item_on' : '';?>" data-type="mip">
        <i class="fa fa-image"></i>
        <p class="weui-tabbar__label">图册</p>
    </a>    
    <a href="<?php echo zmf::config('mobileDomain');?>" class="showContact weui-tabbar__item<?php echo $this->selectNav=='user' ? ' weui-bar__item_on' : '';?>">
        <p><i class="fa fa-user"></i></p>
        <p class="weui-tabbar__label">联系我们</p>
    </a>
</div>