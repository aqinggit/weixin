<?php if(!empty($adsItems)){?>
    <mip-carousel
            autoplay
            defer="2000"
            layout="responsive"
            width="600"
            height="400">
        <?php foreach ($adsItems as $_img){?>
            <mip-img src="<?php echo $_img['faceUrl'];?>" layout="fixed" ></mip-img>
        <?php } ?>
    </mip-carousel>
<?php }?>
<div class="weui-grids index-grids">
    <div class="weui-grid">
        <p class="weui-grid__label">范围广</p>
        <p class="weui-grid__desc ui-nowrap">全国34个省份</p>
    </div>
    <div class="weui-grid">
        <p class="weui-grid__label">更专业</p>
        <p class="weui-grid__desc ui-nowrap">从业经验丰富</p>
    </div>
    <div class="weui-grid">
        <p class="weui-grid__label">性价高</p>
        <p class="weui-grid__desc ui-nowrap">省中间商对接</p>
    </div>
</div>
<div class="section _padding_5 index-posts">
    <div class="section-header"><i class="_l"></i><?php echo $this->areaInfo ? $this->areaInfo['title'].'' : '';?><?php echo $keyword;?>案例</div>
    <ul class="ui-grid-halve" id="JS_index_posts">
        <?php foreach($topPosts as $k=>$topPost){?>
            <li>
                <a class="ui-grid-halve-img" href="<?php echo zmf::createUrl('posts/view',['id'=>$topPost['id'],'urlPrefix'=>$topPost['urlPrefix']]);?>" data-type="mip">
                    <span><?php echo zmf::mipImg($topPost['faceUrl'],$topPost['title'],array('class'=>'weui-media-box__thumb'));?></span>
                </a>
            </li>
        <?php }?>
    </ul>
</div>
<div class="section _padding_5 index-gallery">
    <div class="section-header"><i class="_l"></i><?php echo $this->areaInfo ? $this->areaInfo['title'].'' : '';?><?php echo $keyword;?>图库</div>
    <ul class="ui-grid-halve" id="JS_index_gallery">
        <?php foreach($topGallery as $k=>$topPost){?>
            <li>
                <a class="ui-grid-halve-img" href="<?php echo zmf::createUrl('posts/view',['id'=>$topPost['id'],'urlPrefix'=>$topPost['urlPrefix']]);?>" data-type="mip">
                    <span><?php echo zmf::mipImg($topPost['faceUrl'],$topPost['title'],array('class'=>'weui-media-box__thumb'));?></span>
                </a>
            </li>
        <?php }?>
    </ul>
</div>
<section class="get-started">
    <div class="text-center">
        <p>尽早沟通，抢占商机</p>
        <a id="button" class="button-sign-up danger" href="<?php echo zmf::config('mobileDomain');?>" rel="nofollow">免费报价</a>
    </div>
</section>
<section class="section section-articles _padding_5">
    <div class="section-header"><i class="_l"></i><?php echo $this->areaInfo ? $this->areaInfo['title'].'' : '';?><?php echo $keyword;?>知识</div>
    <div class="weui-panel weui-panel_access weui-panel_hack">
        <div class="weui-panel__bd">
            <?php foreach($articles as $post){$this->renderPartial('/article/_item',array('data'=>$post));}?>
        </div>
    </div>
</section>
<section class="section section-articles _padding_5">
    <div class="section-header"><i class="_l"></i><?php echo $this->areaInfo ? $this->areaInfo['title'].'' : '';?><?php echo $keyword;?>问答</div>
    <div class="weui-panel weui-panel_access weui-panel_hack">
        <div class="weui-panel__bd">
            <?php foreach($questions as $post){$this->renderPartial('/questions/_item',array('data'=>$post));}?>
        </div>
    </div>
</section>