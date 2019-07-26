<div class="question-page">
    <article class="weui-article question-holder">
        <h1><?php echo $info['title'];?></h1>
        <section><?php echo $info['content'];?></section>
        <?php if(!empty($tags)){?>
        <div class="post-tags">
            <?php foreach ($tags as $tag){echo zmf::link($tag['title'],array('index/index','colName'=>$tag['name']));}?>
        </div>
        <?php } ?>
    </article>
    <?php if(!$bestAnswer && empty($anwers)){?>
        <div class="no-answers">
            <p class="tip">暂无回答，快来抢沙发吧</p>
            <p><?php echo zmf::link('我来回答',array('questions/answer','id'=>$info['id']),array('class'=>'primary_btn'));?></p>
        </div>
    <?php }?>
    <?php if($bestAnswer){?>
    <div class="weui-panel weui-panel_hack">
        <div class="weui-panel__hd">最佳回答</div>
        <div class="weui-panel__bd">
            <div class="weui-media-box weui-media-box_text">                    
                <div class="_content"><?php echo $bestAnswer['content'];?></div>                
                <ul class="weui-media-box__info">
                    <li class="weui-media-box__info__meta"><?php echo $bestAnswer['truename'];?></li>
                    <li class="weui-media-box__info__meta"><?php echo zmf::time($bestAnswer['cTime'],'Y-m-d H:i');?></li>
                </ul>
            </div>
        </div>
    </div> 
    <?php }?>
    <?php if(!empty($anwers)){?>
    <div class="weui-panel weui-panel_hack">    
        <div class="weui-panel__hd">更多回答</div>
        <div class="weui-panel__bd">
            <?php foreach($anwers as $anwer){?>
            <div class="weui-media-box weui-media-box_text">                    
                <div class="_content"><?php echo $anwer['content'];?></div>                    
                <ul class="weui-media-box__info">
                    <li class="weui-media-box__info__meta"><?php echo $anwer['truename'];?></li>
                    <li class="weui-media-box__info__meta"><?php echo zmf::time($anwer['cTime'],'Y-m-d H:i');?></li>
                </ul>
            </div>
            <?php }?>
        </div>
    </div>
    <?php }?>
    <?php if(!empty($prevs) || !empty($nexts)){?>
    <div class="weui-panel weui-panel_access weui-panel_hack">        
        <div class="weui-panel__hd">相关问答</div>        
        <div class="weui-panel__bd">
            <?php foreach($prevs as $post){$this->renderPartial('/questions/_item',array('data'=>$post));}?>
            <?php foreach($nexts as $post){$this->renderPartial('/questions/_item',array('data'=>$post));}?>
        </div>
    </div>
    <?php }?>
    <?php if(!empty($articles)){?>
    <div class="weui-panel weui-panel_access weui-panel_hack">
        <div class="weui-panel__hd">相关文章</div>
        <div class="weui-panel__bd">
            <?php foreach($articles as $post){$this->renderPartial('/article/_item',array('data'=>$post));}?>
        </div>
    </div>    
    <?php }?>
</div>