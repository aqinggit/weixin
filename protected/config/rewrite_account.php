<?php

return array(
    'urlFormat' => 'path', //get
    'showScriptName' => false, //隐藏index.php   
    'urlSuffix' => '', //后缀   
    'rules' => array(
        'http://account.jianjuke.cn' => 'account/index/index',
        '<controller:\w+>/<action:\w+>' => 'account/<controller>/<action>',
    )
);