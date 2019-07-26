<div class="weui-panel weui-panel_access weui-panel_hack" id="ajax-content-box">
    <?php if($petInfo || $tagInfo){?>
    <div class="weui-panel__hd"><?php echo ($petInfo ? $petInfo['title'] : $tagInfo['title']);?>解疑</div>
    <?php }?>
    <div class="weui-panel__bd" id="ajax-content">
        <?php foreach($posts as $post){$this->renderPartial('/questions/_item',array('data'=>$post));}?>
    </div>
    <?php if($loadMore){?>
    <div class="loading-holder"><a href="<?php echo zmf::url('page',($pages->validateCurrentPage+1));?>" class="btn btn-default" action="ajax-contents" action-target="ajax-content" action-page="2">加载更多</a></div>
    <?php }?>
</div>