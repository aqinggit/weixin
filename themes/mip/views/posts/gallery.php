<article class="weui-article">
    <h1><?php echo $info['title'];?></h1>
    <section class="content"><?php echo $info['desc'];?></section>
    <section class="content"><?php echo $info['content'];?></section>
    <?php if(!empty($tags)){?><section class="post-tags"><?php foreach($tags as $tag){echo zmf::link($tag['title'],array('index/index','tagName'=>$tag['name']),['data-type'=>'mip']).'&nbsp;&nbsp;';}?></section><?php }?>
</article>
<div class="section _padding_5 index-posts">
    <div class="section-header"><i class="_l"></i>更多图库</div>
    <ul class="ui-grid-halve" id="JS_index_posts">
        <?php foreach($preAndNext as $k=>$topPost){?>
            <li>
                <a class="ui-grid-halve-img" href="<?php echo zmf::createUrl('posts/view',['id'=>$topPost['id'],'urlPrefix'=>$topPost['urlPrefix']]);?>" data-type="mip">
                    <span><?php echo zmf::mipImg($topPost['faceUrl'],$topPost['title']);?></span>
                </a>
            </li>
        <?php }?>
    </ul>
</div>
<div class="section _padding_5 index-posts">
    <div class="section-header"><i class="_l"></i>热门图库</div>
    <ul class="ui-grid-halve" id="JS_index_posts">
        <?php foreach($topPosts as $k=>$topPost){?>
            <li>
                <a class="ui-grid-halve-img" href="<?php echo zmf::createUrl('posts/view',['id'=>$topPost['id'],'urlPrefix'=>$topPost['urlPrefix']]);?>" data-type="mip">
                    <span><?php echo zmf::mipImg($topPost['faceUrl'],$topPost['title']);?></span>
                </a>
            </li>
        <?php }?>
    </ul>
</div>

<div class="weui-panel weui-panel_access weui-panel_hack">
    <?php if(!empty($relateArticles)){?>
        <div class="weui-panel__hd">相关知识</div>
        <div class="weui-panel__bd">
            <?php foreach($relateArticles as $post){$this->renderPartial('/article/_item',array('data'=>$post));}?>
        </div>
    <?php }?>
    <?php if(!empty($questions)){?>
        <div class="weui-panel__hd">更多问答</div>
        <div class="weui-panel__bd">
            <?php foreach($questions as $post){$this->renderPartial('/questions/_item',array('data'=>$post));}?>
        </div>
    <?php }?>
</div>