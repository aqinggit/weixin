<?php

/**
 * @filename stat.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2015 阿年飞少 
 * @datetime 2016-3-2  15:39:41 
 */
$this->breadcrumbs=array(
    '首页'=>array('index/index'),
);
?>
<style>
    .charts{
        min-height:900px; 
    }
</style>
<?php Yii::app()->clientScript->registerScriptFile('http://cdn.hcharts.cn/highcharts/highcharts.js', CClientScript::POS_END); ?>
<?php $modelStat=new SiteStat;?>
<div id="chart-canvas" class="charts well"></div>
<script>
$(function () {
    $('#chart-canvas').highcharts({
        chart: {type: 'line'},
        title: {text: '内容'},
        xAxis: {categories: [<?php foreach ($stats as $_val) {echo "'".(zmf::time($_val['date'],'Y-m-d'))."'".',';} ?>]},
        yAxis: {title: {text: '数量'}},
        tooltip: {valueSuffix: ''},
        plotOptions: {line: {dataLabels: {enabled: true},enableMouseTracking: true}},
        series: [<?php foreach($statStrArr as $val){if(in_array($val, array('date'))){continue;}?>{name: '<?php echo $modelStat->getAttributeLabel($val);?>',data: [<?php foreach ($stats as $_val) {echo $_val[$val].',';} ?>]},<?php unset($val);}?>]
    });
});
</script>