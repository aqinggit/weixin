<?php $res = new assets(); ?>
<!DOCTYPE HTML>
<html lang="zh-CN">
    <head>
        <meta name="renderer" content="webkit"/>
        <meta name="Vary" content="User-Agent" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no,user-scalable=0"/>
        <meta name="viewport" content="initial-scale=1.0,user-scalable=no,maximum-scale=1,user-scalable=0"/>
        <meta content="yes" name="apple-mobile-web-app-capable"/>
        <meta content="black" name="apple-mobile-web-app-status-bar-style"/>
        <meta name="apple-touch-fullscreen" content="yes"/>
        <meta name="full-screen" content="yes"/>
        <meta name="format-detection" content="telephone=no"/>
        <meta name="format-detection" content="address=no"/>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta name="keywords" content="<?php if (!empty($this->keywords)) {echo $this->keywords;}?>" />
        <meta name="description" content="<?php if (!empty($this->pageDescription)) {echo $this->pageDescription;}?>" />        
        <meta name="baidu-site-verification" content="<?php echo zmf::config('baiduSiteVer');?>"/>
        <meta name="google-site-verification" content="<?php echo zmf::config('googleSiteVer');?>" />
        <meta name="sogou_site_verification" content="<?php echo zmf::config('sogouSiteVer');?>"/>
        <meta name="360-site-verification" content="<?php echo zmf::config('360SiteVer');?>" />
        <meta name="shenma-site-verification" content="<?php echo zmf::config('shenmaSiteVer');?>"/>
        <base href="<?php echo zmf::config('baseurl'); ?>"/>        
        <link rel="shortcut icon" href="<?php echo zmf::config('baseurl'); ?>favicon.ico" type="image/x-icon"/>
        <?php echo $this->seoMetaContent;echo $this->baiduJsonLD;$res->loadCssJs('web', $this->currentModule);?>
        <?php if(!YII_DEBUG){?>
            <script>
                document.oncontextmenu=new Function("event.returnValue=false");
                document.onselectstart=new Function("event.returnValue=false");
                document.onkeydown = function () {if (window.event && window.event.keyCode == 123) {event.keyCode = 0;event.returnValue = false;return false;}};
            </script>
        <?php }?>
    </head>
    <body><?php echo $content;$res->jsConfig('web', $this->currentModule); ?></body>
</html>