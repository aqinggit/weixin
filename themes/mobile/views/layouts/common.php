<?php $res = new assets(); ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no,user-scalable=0"/>
    <meta name="viewport" content="initial-scale=1.0,user-scalable=no,maximum-scale=1,user-scalable=0"/>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <meta name="keywords" content="<?php if (!empty($this->keywords)) {
        echo $this->keywords;
    } else {
        echo zmf::config('siteKeywords');
    } ?>"/>
    <meta name="description" content="<?php if (!empty($this->pageDescription)) {
        echo $this->pageDescription;
    } else {
        echo zmf::config('siteDesc');
    } ?>"/>
    <meta content="yes" name="apple-mobile-web-app-capable"/>
    <meta content="black" name="apple-mobile-web-app-status-bar-style"/>
    <meta name="apple-touch-fullscreen" content="yes"/>
    <meta name="full-screen" content="yes"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta name="format-detection" content="address=no"/>
    <meta name="Vary" content="User-Agent"/>
    <meta name="applicable-device" content="mobile"/>
    <?php echo $this->seoMetaContent; ?>
    <link rel="shortcut icon" href="<?php echo zmf::config('baseurl'); ?>favicon.ico" type="image/x-icon"/>
    <link rel="canonical" href="<?php echo zmf::config('staticDomain') . Yii::app()->request->url; ?>"/>
    <?php echo $res->loadCssJs('mobile', $this->currentModule);
    echo $this->baiduJsonLD; ?>
</head>
<body>
<?php echo $content;
$res->jsConfig('mobile', $this->currentModule); ?>
<div class="weui-tabbar">
    <a href="<?php echo zmf::createUrl('/index/index') ?>" class="weui-tabbar__item weui-bar__item_on">
        <img src="https://css.zhiyuanyun.com/default/wx/images/tab.home.press.png" alt="" class="weui-tabbar__icon">
        <p class="weui-tabbar__label">首页</p>
    </a>
    <a href="<?php echo zmf::createUrl('/activity/index') ?>" class="weui-tabbar__item ">
        <img src="https://css.zhiyuanyun.com/default/wx/images/gird_xj.png" alt="" class="weui-tabbar__icon">
        <p class="weui-tabbar__label">志愿活动</p>
    </a>
    <a href="<?php echo zmf::createUrl('/weixin/main') ?>" class="weui-tabbar__item ">
        <img src="https://css.zhiyuanyun.com/default/wx/images/tab.user.normal.png" alt="" class="weui-tabbar__icon">
        <p class="weui-tabbar__label">我的</p>
    </a>
</div>
</div>
</body>
</html>