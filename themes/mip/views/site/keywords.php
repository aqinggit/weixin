<?php $keyword=zmf::config('mainKeyword');?>
<div class="ss_list">
    <div class="rmss_content">
        <div class="rmss_tit">
            <div class="line"></div>
            <div class="title">热门地区</div>
        </div>
        <div class="rmss_show">
            <div class="rmss_list clearfix">
                <ul><?php foreach($areas as $area){echo '<li>'.zmf::link($area['title'].$keyword,array('index/index','colName'=>$area['name']),array('title'=>$area['title'].$keyword,'data-type'=>'mip')).'</li>';}?></ul>
            </div>
        </div>
        <div class="rmss_tit">
            <div class="line"></div>
            <div class="title">内容分类</div>
        </div>
        <div class="rmss_show">
            <?php foreach($columns as $k=>$column){?>
                <div class="rmss_list_gn">
                    <div class="rmss_tit">
                        <div class="line"></div>
                        <div class="title"><?php echo '热门'.$column['title'];?></div>
                    </div>
                    <div class="rmss_list clearfix">
                        <ul><?php foreach($column['items'] as $col){echo '<li>'.zmf::link($col['title'],array('index/index','colName'=>$col['name']),array('data-type'=>'mip')).'</li>';}?></ul>
                    </div>
                </div>
            <?php }?>
        </div>
        <div class="rmss_tit">
            <div class="line"></div>
            <div class="title">关键词</div>
        </div>
        <div class="rmss_show">
            <?php foreach($tags as $tagVal){?>
                <div class="rmss_list_gn">
                    <div class="rmss_tit">
                        <div class="line"></div>
                        <div class="title"><?php echo '热门'.$tagVal['title'];?></div>
                    </div>
                    <div class="rmss_list clearfix">
                        <ul><?php foreach($tagVal['items'] as $col){echo '<li>'.zmf::link($col['title'],array('index/index','colName'=>$col['name']),array('data-type'=>'mip')).'</li>';}?></ul>
                    </div>
                </div>
            <?php }?>
        </div>
    </div>
</div>