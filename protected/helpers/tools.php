<?php

class tools {

    public static function submitBaiduUrls($urls, $type, $baiduPushCode = '') {
        if (!$baiduPushCode) {
            return;
        }
        if ($type != 1) {//mip，熊掌号都是手机版
            $urls = str_replace('http://www', 'http://m', $urls);
        }
        $urlsArr = array_filter(explode(PHP_EOL, $urls));
        $appid= zmf::config('xzh_appid');
        $mipToken= zmf::config('mip_token');
        $mipDomain= zmf::config('mip_submit_domain');
        $baiduDomain= zmf::config('baiduPushDomain');
        if ($type == 3) {
            $api = 'http://data.zz.baidu.com/urls?appid='.$appid.'&token='.$mipToken.'&type=realtime';
        } elseif ($type == 4) {
            $api = 'http://data.zz.baidu.com/urls?appid='.$appid.'&token='.$mipToken.'&type=batch';
        } elseif ($type == 5) {
            $api = 'http://data.zz.baidu.com/urls?appid='.$appid.'&token='.$mipToken.'&type=original';
        } elseif ($type == 2) {
            $api = 'http://data.zz.baidu.com/urls?site='.$mipDomain.'&token=' . $baiduPushCode . '&type=mip';
        } else {
            $api = 'http://data.zz.baidu.com/urls?site='.$baiduDomain.'&token=' . $baiduPushCode;
        }
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $urlsArr),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        $json = CJSON::decode($result, true);
        return $json;
    }

    /**
     * 获取链接的参数
     * @param string $url
     * @return array
     */
    public static function parseUrlParams($url) {
        $temp = parse_url($url);
        $queryParts = explode('&', $temp['query']);
        $params = array();
        foreach ($queryParts as $param) {
            $item = explode('=', $param);
            $params[$item[0]] = $item[1];
        }
        return $params;
    }
    
    public static function imagecropper($source_path,$percent=0) {
        $source_info = getimagesize($source_path);
        $source_width = $source_info[0];
        $source_height = $source_info[1];
        $x = 0;
        $per=$percent>0 ? number_format($percent/100, 2, '.', '') : 0;
        $h = $source_height * (1 - $per);
        $source = imagecreatefromjpeg($source_path);
        $croped = imagecreatetruecolor($source_width, $h);
        imagecopyresampled($croped, $source, 0, 0, 0, 0,$source_width,$h,$source_width, $h);
        imagejpeg($croped, $source_path);
        imagedestroy($croped);
        imagedestroy($source);
    }
    
    public static function refreshPage($time = 3) {
        $time = $time * 1000;
        $html = '<script>function refreshPage() {window.location.reload();window.setTimeout("refreshPage()", ' . $time . ');}refreshPage();</script>';
        echo $html;
    }
    
    public static function rmDir($path = '.', $echo = false) {
        $current_dir = opendir($path);
        while (($file = readdir($current_dir)) !== false) {
            $sub_dir = $path . DIRECTORY_SEPARATOR . $file;
            if ($file == '.' || $file == '..') {
                continue;
            } else if (is_dir($sub_dir)) {
                static::_dF($sub_dir);
            } else {
                if (unlink($path . '/' . $file)) {
                    if ($echo) {
                        echo $path . '/' . $file . '<font color="green">OK!</font><br>';
                    }
                } else {
                    if ($echo) {
                        echo $path . '/' . $file . '<font color="red">Failed!</font><br>';
                    }
                }
            }
        }
    }

    public static function getWeixinImg($url,$imgType='posts'){
        $ctime = zmf::now();
        $dir = zmf::uploadDirs($ctime, 'app', $imgType);
        zmf::createUploadDir($dir);
        $fileName = md5($url) . '.jpg';
        if(file_exists($dir . $fileName)){
            return zmf::uploadDirs($ctime, 'site', $imgType). $fileName;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0');
        // 在HTTP请求头中"Referer: "的内容。
        curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate, sdch");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //302redirect
        //针对微信
        curl_setopt($ch, CURLOPT_REFERER, "https://mp.weixin.qq.com/");
        // 针对https的设置
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $data = curl_exec($ch);
        curl_close($ch);
        if(!$data){
            return 'failed';
        }
        file_put_contents($dir . $fileName, $data);
        return zmf::uploadDirs($ctime, 'site', $imgType). $fileName;;
    }

}
