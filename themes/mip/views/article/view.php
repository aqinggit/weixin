<article class="weui-article">
    <h1><?php echo $info['title'];?></h1>
    <section class="content"><?php echo $info['content'];?></section>
    <?php if(!empty($tags)){?><section class="post-tags"><?php foreach($tags as $tag){echo zmf::link($tag['title'],array('index/index','tagName'=>$tag['name'])).'&nbsp;&nbsp;';}?></section><?php }?>
</article>
<?php if(!empty($relatePosts) || !empty($topsPosts)){?>
<div class="weui-panel weui-panel_access weui-panel_hack">    
    <?php if(!empty($relatePosts)){?>
    <div class="weui-panel__hd">更多阅读</div>
    <div class="weui-panel__bd">
        <?php foreach($relatePosts as $post){$this->renderPartial('/article/_item',array('data'=>$post));}?>
    </div>
    <?php }if(!empty($topsPosts)){?>
    <div class="weui-panel__hd">热门文章</div>
    <div class="weui-panel__bd">
        <?php foreach($topsPosts as $post){$this->renderPartial('/article/_item',array('data'=>$post));}?>
    </div>
    <?php }?>
</div>
<?php }?>