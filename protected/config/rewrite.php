<?php

return array(
    'urlFormat' => 'path', //get
    'showScriptName' => false, //隐藏index.php   
    'urlSuffix' => '.html', //后缀
    'rules' => array(
        'user/<id:\d+>' => 'user/index',
        'siteInfo/<id:\d+>' => 'site/info',
        //搜索
        'keyword/<logCode:\w+>' => array(
            'search/do'
        ),
        'keyword' => array(
            'site/keywords',
            'urlSuffix' => '/'
        ),
        'area' => array(
            'site/area',
            'urlSuffix' => '/'
        ),
        'search' => array(
            'search/do',
            'urlSuffix' => '/'
        ),
        //案例
        '<urlPrefix:\w+>/c<id:\d+>' => array(
            'posts/view'
        ),
        'case/<page:\d+>' => array(
            'index/posts',
            'urlSuffix' => '/'
        ),
        'gallery' => array(
            'index/gallery',
            'urlSuffix' => '/'
        ),
        'case' => array(
            'index/posts',
            'urlSuffix' => '/'
        ),
        //文章
        '<urlPrefix:\w+>/a<id:\d+>' => array(
            'article/view'
        ),
        '<colName:\w+>/article/<page:\d+>' => array(
            'index/articles',
            'urlSuffix' => '/'
        ),
        '<colName:\w+>/article' => array(
            'index/articles',
            'urlSuffix' => '/'
        ),
        'article/<page:\d+>' => array(
            'index/articles',
            'urlSuffix' => '/'
        ),
        'article' => array(
            'index/articles',
            'urlSuffix' => '/'
        ),
        //问答
        '<urlPrefix:\w+>/q<id:\d+>' => array(
            'questions/view'
        ),
        '<colName:\w+>/question/<page:\d+>' => array(
            'index/questions',
            'urlSuffix' => '/'
        ),
        '<colName:\w+>/question' => array(
            'index/questions',
            'urlSuffix' => '/'
        ),
        'question/<page:\d+>' => array(
            'index/questions',
            'urlSuffix' => '/'
        ),
        'question' => array(
            'index/questions',
            'urlSuffix' => '/'
        ),

        //内容
        '<colName:\w+>/<page:\d+>' => array(
            'index/index',
            'urlSuffix' => '/'
        ),
        '<colName:\w+>' => array(
            'index/index',
            'urlSuffix' => '/'
        ),
        '<tagName:\w+>' => array(
            'index/index',
            'urlSuffix' => '/'
        ),
        //站点地图
        'sitemap/all' => array(
            'sitemap/all',
            'urlSuffix' => '.xml'
        ),
        'sitemap/<type:\w+>-<page:\d+>' => array(
            'sitemap/list',
            'urlSuffix' => '.xml'
        ),
        '<fileName:\w+>' => array(
            'site/txt',
            'urlSuffix' => '.txt'
        ),
        '<controller:\w+>/<action:\w+>' => array(
            '<controller>/<action>'
        ),
        '<module:\w+>/<controller:\w+>/<action:\w+>' => array(
            '<module>/<controller>/<action>',
            'urlSuffix' => ''
        )
    )
);