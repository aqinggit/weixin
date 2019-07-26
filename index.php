<?php
error_reporting(E_ERROR);
function getUserIp(){
    return !empty($_SERVER['HTTP_ALI_CDN_REAL_IP']) ? $_SERVER['HTTP_ALI_CDN_REAL_IP']:(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])? $_SERVER['HTTP_X_FORWARDED_FOR']:'');
}
$blockIpsArr=@include_once(dirname(__FILE__) . '/protected/runtime/blockIps.php');
if(!empty($blockIpsArr)){
    $ip=getUserIp();
    if(in_array($ip,$blockIpsArr)){
        exit();
    }
}
$url=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$timeset = date_default_timezone_get();
if (!in_array($timeset, array('Etc/GMT-8', 'PRC', 'Asia/Shanghai', 'Asia/Shanghai', 'Asia/Chongqing'))) {
    date_default_timezone_set('Etc/GMT-8');
}
$configArr=require(dirname(__FILE__) . '/protected/runtime/config/zmfconfig.php');
function _checkUrlCache($configArr) {
    $currentUrl = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $urlStr=$configArr['notCacheUrls'];
    if(!$urlStr){
        return false;
    }
    $arr = explode(PHP_EOL,$urlStr);
    $set = true;
    if ($set) {
        foreach ($arr as $val) {
            if (!$set) {
                break;
            }
            if (strpos($currentUrl, $val) !== false) {
                $set = false;
                break;
            }
        }
    }
    return $set;
}
function _checkmobile() {
    //此条摘自TPM智能切换模板引擎，适合TPM开发
    if(isset ($_SERVER['HTTP_CLIENT']) &&'PhoneClient'==$_SERVER['HTTP_CLIENT']){
        return true;
    }
    //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA'])){
        //找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], 'wap') ? true : false;
    }
    $mobile = array();
    static $mobilebrowser_list = array('iphone', 'android', 'phone', 'mobile', 'wap', 'netfront', 'java', 'opera mobi', 'opera mini',
        'ucweb', 'windows ce', 'symbian', 'series', 'webos', 'sony', 'blackberry', 'dopod', 'nokia', 'samsung',
        'palmsource', 'xda', 'pieplus', 'meizu', 'midp', 'cldc', 'motorola', 'foma', 'docomo', 'up.browser',
        'up.link', 'blazer', 'helio', 'hosin', 'huawei', 'novarra', 'coolpad', 'webos', 'techfaith', 'palmsource',
        'alcatel', 'amoi', 'ktouch', 'nexian', 'ericsson', 'philips', 'sagem', 'wellcom', 'bunjalloo', 'maui', 'smartphone',
        'iemobile', 'spice', 'bird', 'zte-', 'longcos', 'pantech', 'gionee', 'portalmmm', 'jig browser', 'hiptop',
        'benq', 'haier', '^lct', '320x320', '240x320', '176x220');
    $pad_list = array('pad', 'gt-p1000');
    $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
    if (_dstrpos($useragent, $pad_list)) {
        return false;
    }
    if (($v = _dstrpos($useragent, $mobilebrowser_list, true))) {
        $platform = $v;
        return true;
    }
    $brower = array('mozilla', 'chrome', 'safari', 'opera', 'm3gate', 'winwap', 'openwave', 'myop');
    if (_dstrpos($useragent, $brower)) {
        return false;
    }
}
function _dstrpos($string, &$arr, $returnvalue = false) {
    if (empty($string)) {
        return false;
    }
    foreach ((array) $arr as $v) {
        if (strpos($string, $v) !== false) {
            $return = $returnvalue ? $v : true;
            return $return;
        }
    }
    return false;
}
//判断是否缓存
if($configArr['siteHtmlCache']=='1'){
    $isAjax=isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']==='XMLHttpRequest';
    $isPost=isset($_SERVER['REQUEST_METHOD']) && !strcasecmp($_SERVER['REQUEST_METHOD'],'POST');
    $isAjax=$isAjax && $isPost;
    if(!$isAjax && _checkUrlCache($configArr)){
        $url='http://'.$url;
        $hashCode=md5($url);
        $theme=(_checkmobile() || strpos($url,'m.woojuke.com')!==false) ? 'mobile' : 'web';
        $cacheTime=$configArr['siteHtmlCacheTime'];
        $dir=dirname(__FILE__) . '/protected/runtime/siteHtml/'.$theme.'/'.$hashCode.'.html';
        if(file_exists($dir) && $cacheTime>0){
            $time=filectime($dir);
            $now=time();
            if(($now-$time)<$cacheTime){
                header("Cache-Control:public");
                $expires = gmdate('D, d M Y H:i:s', $time + $cacheTime) . ' GMT';
                header("Expires:$expires");
                echo file_get_contents($dir);
                exit();
            }
        }
    }
}

// change the following paths if necessary
$yii=dirname(__FILE__).'/../framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';
// remove the following line when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
require_once($yii);
Yii::createWebApplication($config)->run();