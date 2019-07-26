<a href="<?php echo zmf::createUrl('article/view',array('id'=>$data['id'],'urlPrefix'=>$data['urlPrefix']));?>" class="weui-media-box weui-media-box_appmsg" data-type="mip">
    <div class="weui-media-box__bd">
        <h4 class="weui-media-box__title"><?php echo $data['title'];?></h4>
        <p class="weui-media-box__desc"><?php echo $data['desc'];?></p>
    </div>
    <div class="weui-media-box__hd">
        <?php echo zmf::mipImg($data['faceImg'],$data['title'],array('class'=>'weui-media-box__thumb'));?>
    </div>
</a>