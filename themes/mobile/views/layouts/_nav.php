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
    <a href="<?php echo zmf::createUrl('index/posts');?>" class="weui-tabbar__item<?php echo $this->selectNav == 'posts'  ? ' weui-bar__item_on' : '';?>">
        <i class="fa fa-file-text-o"></i>      
        <p class="weui-tabbar__label">案例</p>
    </a>
    <a href="<?php echo zmf::createUrl('index/gallery');?>" class="weui-tabbar__item<?php echo $this->selectNav == 'gallery'  ? ' weui-bar__item_on' : '';?>">
        <i class="fa fa-image"></i>
        <p class="weui-tabbar__label">图册</p>
    </a>    
    <a href="javascript:;" class="showContact weui-tabbar__item<?php echo $this->selectNav=='user' ? ' weui-bar__item_on' : '';?>">
        <p><i class="fa fa-user"></i></p>
        <p class="weui-tabbar__label">联系我们</p>
    </a>
</div>
<div class="contact-holder" id="JS_contact_holder">
    <div class="contact-body">
        <div class="qrcode-holder">
            <div class="_left">
                <img src="<?php echo zmf::config('siteWeixinUrl');?>">
            </div>
            <div class="_right">
                <p class="_t1">请在微信中<br/>请长按识别</p>
                <p class="color-grey _t2">或搜索添加</p>
                <p class="_t3"><?php echo zmf::config('siteWeixin');?></p>
            </div>
        </div>
        <div class="more-contact-holder">
            <p>
                <span class="color-999">QQ客服号</span>
                <span class="pull-right color-333"><a href="<?php echo zmf::createUrl('site/to',['type'=>'qq']);?>" target="_blank" rel="nofollow"><?php echo zmf::config('siteQQ');?></a></span>
            </p>
            <p>
                <span class="color-999">全国热线</span>
                <span class="pull-right color-333"><a href="tel:<?php echo zmf::config('site400Phone');?>" rel="nofollow"><?php echo zmf::config('site400Phone');?></a></span>
            </p>
            <p>
                <span class="color-999">值班热线</span>
                <span class="pull-right color-333"><a href="tel:<?php echo zmf::config('sitePhone');?>" rel="nofollow"><?php echo zmf::config('sitePhone');?></a></span>
            </p>
        </div>
        <a class="_btn" href="javascript:;" id="JS_contact_close">关闭</a>
    </div>
</div>