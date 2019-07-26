<div class="city_box">
    <?php if(!empty($topAreas)){?>
    <h3>热门城市</h3>
    <ul class="city_lst hot">
        <?php foreach($topAreas as $area){?>
        <li><?php echo zmf::link($area['title'],array('index/index','colName'=>$area['name']),array('class'=>'nobor','data-type'=>'mip'));?></li>
        <?php }?>
    </ul>
    <?php }?>
    <h3>按字母排序</h3>
    <ul class="letters_lst">
        <?php foreach($areas as $char=>$items){?>
        <li><?php echo $char;?></li>
        <?php }?>
    </ul>
    <?php foreach($areas as $char=>$items){?>
    <h4><p><span><?php echo $char;?></span>(以<?php echo $char;?>为开头的城市名)</p></h4>
    <ul class="city_lst">
        <?php foreach($items as $area){?>
        <li><?php echo zmf::link($area['title'],array('index/index','colName'=>$area['name']),array('class'=>'nobor','data-type'=>'mip'));?></li>
        <?php }?>        
    </ul>
    <?php }?>
</div>