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
    <a href="<?php echo zmf::config('baseurl');?>" class="weui-tabbar__item<?php echo $this->selectNav=='index' ? ' weui-bar__item_on' : '';?>">
        <i class="fa fa-home"></i>
        <p class="weui-tabbar__label">首页</p>
    </a>
</div>
