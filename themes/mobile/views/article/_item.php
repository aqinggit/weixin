<a href="<?php echo zmf::createUrl('article/view',array('id'=>$data['id'],'urlPrefix'=>$data['urlPrefix']));?>" class="weui-media-box weui-media-box_appmsg">
    <div class="weui-media-box__bd">
        <h4 class="weui-media-box__title"><?php echo $data['title'];?></h4>
        <p class="weui-media-box__desc"><?php echo $data['desc'];?></p>
    </div>
    <div class="weui-media-box__hd">
        <img class="weui-media-box__thumb lazy" data-original="<?php echo $data['faceImg'];?>" src="<?php echo zmf::lazyImg();?>" class="lazy" alt="<?php echo $data['title'];?>">
    </div>
</a>