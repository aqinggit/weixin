<div class="thumbnail" id="img-<?php echo $data['id'];?>">
    <img src="<?php echo zmf::lazyImg();?>" data-original="<?php echo $data['remote'];?>" class="lazy img-responsive"/>
    <div class="fixed-badge">
        <?php echo CHtml::link('<i class="fa fa-remove"></i>','javascript:;',array('action'=>'delContent','data-type'=>'img','data-id'=>  $data['id'],'data-confirm'=>1,'data-target'=>'img-'.$data['id'])); ?>
    </div>
</div>