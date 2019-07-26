<div id="owl-demo" class="owl-carousel owl-theme">
    <?php if(!empty($adsItems)){?>
        <?php foreach ($adsItems as $_img){?>
            <div class="item" style="background:url(<?php echo $_img['faceUrl'];?>) no-repeat center;background-size:cover;height: 180px;"></div>
        <?php } ?>
    <?php }?>
</div>
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
            <li class="<?php echo $k>5 ? 'hidden' : '';?>">
                <a class="ui-grid-halve-img" href="<?php echo zmf::createUrl('posts/view',['id'=>$topPost['id'],'urlPrefix'=>$topPost['urlPrefix']]);?>">
                    <span style="background-image:url(<?php echo $topPost['faceUrl'];?>)"></span>
                </a>
            </li>
        <?php }?>
        <p class="showmore"><a href="javascript:;" class="_showmore" data-holder="JS_index_posts">展开更多 <i class="fa fa-angle-down"></i></a></p>
    </ul>
</div>
<div class="section _padding_5 index-gallery">
    <div class="section-header"><i class="_l"></i><?php echo $this->areaInfo ? $this->areaInfo['title'].'' : '';?><?php echo $keyword;?>图库</div>
    <ul class="ui-grid-halve" id="JS_index_gallery">
        <?php foreach($topGallery as $k=>$topPost){?>
            <li class="<?php echo $k>5 ? 'hidden' : '';?>">
                <a class="ui-grid-halve-img" href="<?php echo zmf::createUrl('posts/view',['id'=>$topPost['id'],'urlPrefix'=>$topPost['urlPrefix']]);?>">
                    <span style="background-image:url(<?php echo $topPost['faceUrl'];?>)"></span>
                </a>
            </li>
        <?php }?>
        <p class="showmore"><a href="javascript:;" class="_showmore" data-holder="JS_index_gallery">展开更多 <i class="fa fa-angle-down"></i></a></p>
    </ul>
</div>
<section class="get-started">
    <div class="text-center">
        <p>尽早沟通，抢占商机</p>
        <a id="button" class="button-sign-up danger" href="javascript:;" rel="nofollow">免费报价</a>
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

<script>
    $(document).ready(function(){
        $("#owl-demo").owlCarousel({
            autoPlay:true,
            navigation: false, // Show next and prev buttons
            pagination:true,
            paginationNumbers:false,//是否显示为数字
            slideSpeed: 300,
            paginationSpeed: 400,
            singleItem: true
        });
        $('._showmore').tap(function(){
            $(this).remove();
            $('#'+$(this).attr('data-holder')+'>li').each(function(){
                $(this).removeClass('hidden')
            });
            stopDefault();
        })
    });
</script>