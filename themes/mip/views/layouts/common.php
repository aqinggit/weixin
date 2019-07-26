<?php $res = new assets(); ?>
<!DOCTYPE HTML>
<html mip>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
        <meta content="yes" name="apple-mobile-web-app-capable" />
        <meta content="black" name="apple-mobile-web-app-status-bar-style"  />
        <meta name="apple-touch-fullscreen" content="yes">
        <meta name="full-screen" content="yes">
        <meta name="format-detection" content="telephone=no">
        <meta name="format-detection" content="address=no">
        <meta name="Vary" content="User-Agent" />
        <meta name="applicable-device" content="mobile">
        <meta http-equiv="mobile-agent" content="format=html5;url=<?php echo zmf::config('domain').Yii::app()->request->url;?>">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta name="keywords" content="<?php if (!empty($this->keywords)){echo $this->keywords;}else{ echo zmf::config('siteKeywords');}?>" />
        <meta name="description" content="<?php if (!empty($this->pageDescription)){echo $this->pageDescription;}else{ echo zmf::config('siteDesc');}?>" />
        <link rel="stylesheet" type="text/css" href="https://c.mipcdn.com/static/v1/mip.css">
        <link rel="canonical" href="<?php echo zmf::config('mobileDomain').Yii::app()->request->url;?>">
        <?php echo $res->loadCssJs('mip',$this->currentModule);echo $this->baiduJsonLD;?>
        <script async src="https://c.mipcdn.com/static/v1/mip.js"></script>
        <script async src="https://c.mipcdn.com/extensions/platform/v1/mip-cambrian/mip-cambrian.js"></script>
        <script async src="https://c.mipcdn.com/static/v1/mip-stats-baidu/mip-stats-baidu.js"></script>
    </head>
    <body>
        <mip-cambrian site-id="<?php echo zmf::config('xzh_appid');?>"></mip-cambrian>
        <?php echo $content;?>
    </body>
</html>