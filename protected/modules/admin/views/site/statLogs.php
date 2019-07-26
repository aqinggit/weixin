<?php
$this->breadcrumbs = array(
    '首页'=>array('index/index'),
    '小工具'=>array('tools/index'),
    '操作日志'=>array('site/logs'),
    '操作日志统计'
);
Yii::app()->clientScript->registerScriptFile('http://cdn.hcharts.cn/highcharts/highcharts.js', CClientScript::POS_END); ?>
<div id="userTotals"></div>

<div id="user-stat-detail"></div>

<script>
    $(function () {
        $('#userTotals').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: '用户操作'
            },
            tooltip: {
                headerFormat: '{series.name}<br>',
                pointFormat: '{point.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: '次数',
                data: [
                    <?php foreach($userTotal as $uid=>$num){?>
                    ['<?php echo $users[$uid] ? $users[$uid] : '未知';?>', <?php echo $num;?>],
                    <?php }?>
                ]
            }]
        });
        
        $('#user-stat-detail').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: '分类详情'
            },
            xAxis: {
                categories: [
                <?php foreach($classify as $_classify=>$_num){?>
                    '<?php echo $_classify;?>',
                <?php }?>    
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: '数量'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    borderWidth: 0
                }
            },
            series: [
        <?php foreach($userTotalLogs as $_uid=>$_uArr){?>
        {
                name: '<?php echo $users[$_uid] ? $users[$_uid] : '未知';?>',
                data: [
            <?php foreach($classify as $_classify=>$_num){?>
            <?php echo $userTotalLogs[$_uid][$_classify]>0 ? $userTotalLogs[$_uid][$_classify] : 0;?>,
            <?php }?>
        ]
            },
        <?php }?>    
        ]
        });
    });
    
    
</script>
