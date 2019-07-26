<?php foreach ($posts as $data) {?>
<a class="_floatItem" href="javascript:;" data-id="<?php echo $data['id'];?>" data-original="<?php echo $data['remote'];?>" data-from="<?php echo $from;?>">
    <img src="<?php echo $data['thumbnail'];?>"/>
</a>
<?php }?>
<div class="clearfix"></div>
<nav aria-label="Page navigation">
    <ul class="pagination">
        <?php foreach ($pages as $_page) {?>
        <li <?php echo $_page['active'] ? 'class="active"' : '';?>><?php echo CHtml::link($_page['title'],'javascript:;',array('onclick'=>($from=='zone' ? 'selectZoneImgs' : 'selectAttaches').'("'.$_page['url'].'","'.$from.'")'));?></li>
        <?php }?>
    </ul>
</nav>
<div class="clearfix"></div>