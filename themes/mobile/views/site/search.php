<?php
/**
 * @filename search.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2015 阿年飞少 
 * @datetime 2016-5-30  11:53:22 
 */
?>
<div class="weui-search-bar" id="searchBar">
    <form class="weui-search-bar__form" role="form" action="<?php echo zmf::createUrl("search/do");?>"  method="GET">
        <div class="weui-search-bar__box">            
            <input type="search" class="weui-search-bar__input" id="searchInput" placeholder="搜索你感兴趣的内容" name="keyword" autocomplete="off" disableautocomplete>            
        </div>
        <label class="weui-search-bar__label" id="searchText">
            <i class="fa fa-search"></i>
            <span>搜索</span>
        </label>
    </form>
    <a href="javascript:" class="weui-search-bar__cancel-btn" id="searchCancel">取消</a>
</div>
<?php if(!empty($posts['articles'])){?>
<div class="weui-panel weui-panel_hack">
    <div class="weui-panel__hd"><?php echo $this->searchKeyword;?>宠物</div>
    <div class="weui-panel__bd">
        <div class="weui-media-box weui-media-box_small-appmsg">
            <div class="weui-cells">
                <?php foreach($posts['pets'] as $pet){?>
                <a class="weui-cell weui-cell_access" href="<?php echo zmf::createUrl('/content/index',array('colName'=>$pet['sitepath']));?>">
                    <div class="weui-cell__hd"><img src="<?php echo $pet['faceImg'];?>" alt="<?php echo $pet['title'];?>" style="width:20px;margin-right:5px;display:block"></div>
                    <div class="weui-cell__bd weui-cell_primary">
                        <p><?php echo $pet['title'];?></p>
                    </div>
                    <span class="weui-cell__ft"></span>
                </a>
                <?php }?>
            </div>
        </div>
    </div>
</div>
<?php }?>
<?php if(!empty($posts['articles'])){?>
<div class="search-page weui-panel weui-panel_access weui-panel_hack">        
    <div class="weui-panel__hd"><?php echo $this->searchKeyword;?>志愿者</div>
    <div class="weui-panel__bd">
        <?php foreach ($posts['articles'] as $post){$this->renderPartial('/article/_item',array('data'=>$post));}?>
    </div> 
</div>
<?php }?>
<?php if(!empty($posts['questions'])){?>
<div class="weui-panel weui-panel_access weui-panel_hack">
    <div class="weui-panel__hd"><?php echo $this->searchKeyword;?>活动</div>
    <div class="weui-panel__bd">
        <?php foreach($posts['questions'] as $post){$this->renderPartial('/questions/_item',array('data'=>$post));}?>
    </div>
</div>
<?php }?>
<script type="text/javascript" class="searchbar js_show">
    $(function(){
        var $searchBar = $('#searchBar'),
            $searchResult = $('#searchResult'),
            $searchText = $('#searchText'),
            $searchInput = $('#searchInput'),
            $searchClear = $('#searchClear'),
            $searchCancel = $('#searchCancel');

        function hideSearchResult(){
            $searchResult.hide();
            $searchInput.val('');
        }
        function cancelSearch(){
            hideSearchResult();
            $searchBar.removeClass('weui-search-bar_focusing');
            $searchText.show();
        }

        $searchText.on('click', function(){
            $searchBar.addClass('weui-search-bar_focusing');
            $searchInput.focus();
        });
        $searchInput
            .on('blur', function () {
                if(!this.value.length) cancelSearch();
            })
            .on('input', function(){
                if(this.value.length) {
                    $searchResult.show();
                } else {
                    $searchResult.hide();
                }
            })
        ;
        $searchClear.on('click', function(){
            hideSearchResult();
            $searchInput.focus();
        });
        $searchCancel.on('click', function(){
            cancelSearch();
            $searchInput.blur();
        });
    });
</script>