<div class="form-group">
    <label>关联标签</label>
    <div class="input-group">
        <span class="input-group-addon">快速搜索</span>
        <?php $this->widget('CAutoComplete', array(
        'name'=>'tagname',
        'url'=>array('tags/search'),
        'multiple'=>false,
        'htmlOptions'=>array('class'=>"form-control",'placeholder'=>'请输入标签名称'),
        'methodChain'=>".result(function(event,item){_searchThisTag(item);})",
        )); ?>
        <span class="input-group-btn">
            <button class="btn btn-default" type="button" onclick="autoMatchTags()">自动匹配</button>
        </span>
    </div>
    <div class="add-tags-box">
        <div class="tags-holder">
            <div class="tags-label">已选标签：</div>
            <div class="tags-items" id="add-tags-box">
                <?php foreach($tags as $tag){$this->renderPartial('/tags/_formItem',array('data'=>$tag));}?>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>