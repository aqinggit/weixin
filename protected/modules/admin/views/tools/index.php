<?php

/**
 * @filename index.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2015 阿年飞少 
 * @datetime 2015-7-9  17:55:32 
 */
$this->breadcrumbs = array(
    '首页'=>array('index/index'),
    '小工具'
);
?>
<table class="table table-hover">
    <tr>
        <td><?php echo CHtml::link('查看应用日志',array('checkLog','type'=>'app'));?></td>
        <td style="width: 80px"><?php echo CHtml::link('清空',array('checkLog','type'=>'delApp'));?></td>
    </tr>
    <tr>
        <td><?php echo CHtml::link('查看慢查询日志',array('checkLog','type'=>'slowlog'));?></td>
        <td style="width: 80px"></td>
    </tr>
    <tr>
        <td><?php echo CHtml::link('查看异常日志',array('checkLog','type'=>'log'));?></td>
        <td style="width: 80px"><?php echo CHtml::link('清空',array('checkLog','type'=>'delLog'));?></td>
    </tr>
    <tr>
        <td><?php echo CHtml::link('查看APP运行记录',array('checkLog','type'=>'appLogs'));?></td>
        <td style="width: 80px"></td>
    </tr>
    <tr>
        <td><?php echo CHtml::link('查看操作记录',array('site/logs'));?></td>
        <td style="width: 80px"></td>
    </tr>
    <tr>
        <td><?php echo CHtml::link('本站链接',array('site/urls'),array('target'=>'_blank'));?></td>
        <td style="width: 80px"></td>
    </tr>
    <tr>
        <td><?php echo CHtml::link('清理mip缓存',array('clearMip'));?></td>
        <td style="width: 80px"></td>
    </tr>
    <tr>
        <td><?php echo CHtml::link('清理Css Js缓存文件',array('clearStatics'));?></td>
        <td style="width: 80px"></td>
    </tr>
    <tr>
        <td><?php echo CHtml::link('清理PC缓存页面',array('clearHtml','type'=>'web'));?></td>
        <td style="width: 80px"></td>
    </tr>
    <tr>
        <td><?php echo CHtml::link('清理Mobile缓存页面',array('clearHtml','type'=>'mobile'));?></td>
        <td style="width: 80px"></td>
    </tr>
    <tr>
        <td><?php echo CHtml::link('清理CDN缓存',array('refreshCache'));?></td>
        <td style="width: 80px"></td>
    </tr>
    <tr>
        <td><?php echo CHtml::link('提交链接',array('submitUrls','type'=>'appLogs'));?></td>
        <td style="width: 80px"></td>
    </tr>
</table>