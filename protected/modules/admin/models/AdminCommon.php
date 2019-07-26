<?php

class AdminCommon extends CActiveRecord {

    public static function navbar() {
        $c = Yii::app()->getController()->id;
        $a = Yii::app()->getController()->getAction()->id;
        $attr['login'] = array(
            'title' => '<i class="fa fa-tachometer"></i> 首页',
            'url' => Yii::app()->createUrl('admin/index/index'),
            'active' => in_array($c, array('index'))
        );
        $attr['navContent'] = array(
            'title' => '<i class="fa fa-align-justify"></i> 内容',
            'url' => '#',
            'active' => in_array($c, array('books','postThreads','comments')),
            'seconds' => array(
                'articles' => array(
                    'title' => '文章',
                    'url' => Yii::app()->createUrl('admin/articles/index'),
                    'active' => in_array($c, array('articles'))
                ),
                'questions' => array(
                    'title' => '问答',
                    'url' => Yii::app()->createUrl('admin/questions/index'),
                    'active' => in_array($c, array('questions'))
                ),
                'posts' => array(
                    'title' => '案例图库',
                    'url' => Yii::app()->createUrl('admin/posts/index'),
                    'active' => in_array($c, array('posts'))
                ),
                'column' => array(
                    'title' => '内容分类',
                    'url' => Yii::app()->createUrl('admin/column/index'),
                    'active' => in_array($c, array('column'))
                ),
                'attachments' => array(
                    'title' => '图片库',
                    'url' => Yii::app()->createUrl('admin/attachments/index'),
                    'active' => in_array($c, array('attachments'))
                ),
            )
        );
        $attr['navYunying'] = array(
            'title' => '<i class="fa fa-line-chart"></i> 运营',
            'url' => '#',
            'active' => in_array($c, array('task','groupTasks','showcases','column','postForums','tags','words','feedback')),
            'seconds' => array(
                'tags' => array(
                    'title' => '标签',
                    'url' => Yii::app()->createUrl('admin/tags/index'),
                    'active' => in_array($c, array('tags'))
                ),
                'area' => array(
                    'title' => '地区',
                    'url' => Yii::app()->createUrl('admin/area/index'),
                    'active' => in_array($c, array('area'))
                ),
                'sitepath' => array(
                    'title' => '路径',
                    'url' => Yii::app()->createUrl('admin/sitepath/index'),
                    'active' => in_array($c, array('sitepath'))
                ),
                'articleCaiji' => array(
                    'title' => '采集文章',
                    'url' => Yii::app()->createUrl('admin/articleCaiji/index'),
                    'active' => in_array($c, array('articleCaiji'))
                ),
                'searchRecords' => array(
                    'title' => '搜索记录',
                    'url' => Yii::app()->createUrl('admin/searchRecords/index'),
                    'active' => in_array($c, array('searchRecords'))
                ),
                'searchWords' => array(
                    'title' => '热门搜索词',
                    'url' => Yii::app()->createUrl('admin/searchWords/index'),
                    'active' => in_array($c, array('searchWords'))
                ),
                'words' => array(
                    'title' => '敏感词',
                    'url' => Yii::app()->createUrl('admin/words/index'),
                    'active' => in_array($c, array('words'))
                ),
                'keywords' => array(
                    'title' => '关键词',
                    'url' => Yii::app()->createUrl('admin/keywords/index'),
                    'active' => in_array($c, array('keywords'))
                ),
                'tdk' => array(
                    'title' => 'TDK',
                    'url' => Yii::app()->createUrl('admin/tdk/index'),
                    'active' => in_array($c, array('tdk'))
                ),
                'ads' => array(
                    'title' => '展示图',
                    'url' => Yii::app()->createUrl('admin/ads/index'),
                    'active' => in_array($c, array('ads'))
                ),
                'siteInfo' => array(
                    'title' => '站点文章',
                    'url' => Yii::app()->createUrl('admin/siteInfo/index'),
                    'active' => in_array($c, array('siteInfo'))
                ),
                'siteinfoColumns' => array(
                    'title' => '站点文章分类',
                    'url' => Yii::app()->createUrl('admin/siteinfoColumns/index'),
                    'active' => in_array($c, array('siteinfoColumns'))
                ),
                'navbar' => array(
                    'title' => '导航条',
                    'url' => Yii::app()->createUrl('admin/navbar/index'),
                    'active' => in_array($c, array('navbar'))
                ),
                'links' => array(
                    'title' => '友链',
                    'url' => Yii::app()->createUrl('admin/links/index'),
                    'active' => in_array($c, array('links'))
                ),
                'msg' => array(
                    'title' => '短信',
                    'url' => Yii::app()->createUrl('admin/msg/index'),
                    'active' => in_array($c, array('msg'))
                )
            )
        );
        $attr['navUsers'] = array(
            'title' => '<i class="fa fa-users"></i> 用户',
            'url' => '#',
            'active' => in_array($c, array('authors','users','group','groupPowerTypes','groupPowers')),
            'seconds' => array(
                'users' => array(
                    'title' => '用户',
                    'url' => Yii::app()->createUrl('admin/users/index'),
                    'active' => in_array($c, array('users'))
                ),
                'group' => array(
                    'title' => '用户组',
                    'url' => Yii::app()->createUrl('admin/group/index'),
                    'active' => in_array($c, array('group'))
                ),
                'admins' => array(
                    'title' => '管理员',
                    'url' => Yii::app()->createUrl('admin/users/admins'),
                    'active' => in_array($a, array('admins'))
                ),
                'adminTemplate' => array(
                    'title' => '管理员分组',
                    'url' => Yii::app()->createUrl('admin/adminTemplate/index'),
                    'active' => in_array($c, array('adminTemplate'))
                ),
            )
        );
        $attr['navSystem'] = array(
            'title' => '<i class="fa fa-cog"></i> 系统',
            'url' => Yii::app()->createUrl('admin/config/index'),
            'active' => in_array($c, array('site', 'config')),
            'seconds' => array(
                'configBaseinfo' => array(
                    'title' => '网站信息',
                    'url' => Yii::app()->createUrl('admin/config/index',array('type'=>'baseinfo')),
                    'active' => in_array($_GET['type'], array('baseinfo'))
                ),
                'configBase' => array(
                    'title' => '全局配置',
                    'url' => Yii::app()->createUrl('admin/config/index',array('type'=>'base')),
                    'active' => in_array($_GET['type'], array('base'))
                ),
                'configEmail' => array(
                    'title' => '邮件配置',
                    'url' => Yii::app()->createUrl('admin/config/index',array('type'=>'email')),
                    'active' => in_array($_GET['type'], array('email'))
                ),
                'configUpload' => array(
                    'title' => '上传配置',
                    'url' => Yii::app()->createUrl('admin/config/index',array('type'=>'upload')),
                    'active' => in_array($_GET['type'], array('upload'))
                ),
                'siteFiles' => array(
                    'title' => '站点文件',
                    'url' => Yii::app()->createUrl('admin/siteFiles/index'),
                    'active' => in_array($c, array('siteFiles'))
                ),
                'tools' => array(
                    'title' => '小工具',
                    'url' => Yii::app()->createUrl('admin/tools/index'),
                    'active' => in_array($c, array('tools'))
                ),
            )
        );
        foreach ($attr as $k => $v) {
            if (!Controller::checkPower($k, '', true)) {
                unset($attr[$k]);
            }elseif(!empty ($v['seconds']) && $k!='system'){
                foreach ($v['seconds'] as $_k=>$_v){
                    if (!Controller::checkPower($_k, '', true)) {
                        unset($attr[$k]['seconds'][$_k]);
                    }
                }
            }
        }
        return $attr;
    }

}
