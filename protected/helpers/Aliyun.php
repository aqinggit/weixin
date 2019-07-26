<?php

Yii::import('application.vendors.aliyun.*');
include_once 'aliyun-php-sdk-core/Config.php';

use Cdn\Request\V20180510 as cdn;

class Aliyun {

    public static function refreshCache($path,$type='File'){
        $regionId = 'cn-shanghai';
        $profile = DefaultProfile::getProfile($regionId, 'LTAI3gcMe9IqR57p', 'Ec1AI0ZZKFnCkyoTySY0QuYjDGXETm');
        $client = new DefaultAcsClient($profile);
        $request=new cdn\RefreshObjectCachesRequest();
        $request->setObjectPath($path);
        $request->setObjectType($type);//Directory | File
        $response = $client->getAcsResponse($request);
        return $response;
    }

}
