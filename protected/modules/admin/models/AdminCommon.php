<?php

class AdminCommon extends CActiveRecord
{

    public static function navbar()
    {
        $c = Yii::app()->getController()->id;
        $a = Yii::app()->getController()->getAction()->id;
        $attr['login'] = array(
            'title' => '<i class="fa fa-tachometer"></i> 首页',
            'url' => Yii::app()->createUrl('admin/index/index'),
            'active' => in_array($c, array('index'))
        );
        $attr['navActivity'] = array(
            'title' => '<i class="fa fa-align-justify"></i> 活动',
            'url' => '#',
            'active' => in_array($c, array('Actives')),
            'seconds' => array(
                'Actives' => array(
                    'title' => '活动列表',
                    'url' => Yii::app()->createUrl('admin/activity/index'),
                    'active' => in_array($c, array('Actives'))
                ),
                'ActiveBindVolunteer' => array(
                    'title' => '活动申请管理',
                    'url' => Yii::app()->createUrl('admin/volunteerActive/index'),
                    'active' => in_array($c, array('volunteerActive'))
                ),
            )
        );
        $attr['navVolunteer'] = array(
            'title' => '<i class="fa fa-line-chart"></i> 志愿者',
            'url' => '#',
            'active' => in_array($c, array('volunteers', 'VolunteerChecks')),
            'seconds' => array(
                'VolunteerChecks' => array(
                    'title' => '待审核志愿者',
                    'url' => Yii::app()->createUrl('admin/volunteers/index'),
                    'active' => in_array($c, array('VolunteerChecks'))
                ), 'Volunteers' => array(
                    'title' => '全部志愿者',
                    'url' => Yii::app()->createUrl('admin/volunteers/index', array('type' => 'all')),
                    'active' => in_array($c, array('Volunteers'))
                ),

            )
        );
        $attr['navUsers'] = array(
            'title' => '<i class="fa fa-users"></i> 用户',
            'url' => '#',
            'active' => in_array($c, array('authors', 'users', 'group', 'groupPowerTypes', 'groupPowers')),
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
                    'url' => Yii::app()->createUrl('admin/config/index', array('type' => 'baseinfo')),
                    'active' => in_array($_GET['type'], array('baseinfo'))
                ),
                'configBase' => array(
                    'title' => '全局配置',
                    'url' => Yii::app()->createUrl('admin/config/index', array('type' => 'base')),
                    'active' => in_array($_GET['type'], array('base'))
                ),
                'configEmail' => array(
                    'title' => '邮件配置',
                    'url' => Yii::app()->createUrl('admin/config/index', array('type' => 'email')),
                    'active' => in_array($_GET['type'], array('email'))
                ),
                'configUpload' => array(
                    'title' => '上传配置',
                    'url' => Yii::app()->createUrl('admin/config/index', array('type' => 'upload')),
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
            } elseif (!empty ($v['seconds']) && $k != 'system') {
                foreach ($v['seconds'] as $_k => $_v) {
                    if (!Controller::checkPower($_k, '', true)) {
                        unset($attr[$k]['seconds'][$_k]);
                    }
                }
            }
        }
        return $attr;
    }

}
