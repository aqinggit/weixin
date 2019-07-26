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
<?php if(empty($posts)){?>
    <p style="padding: 30px 20px;margin-bottom: 10px;margin-top:30px;font-size: 14px;font-weight: 700;background-color: #fffdee;border: 1px solid #edd28b;">抱歉，没有找到与“<?php echo $this->searchKeyword;?>”相关的内容</p>
<?php }?>
<?php if(!empty($posts['articles']) || !empty($posts['questions']) || !empty($posts['tags'])){?>
<div class="row">
    <div class="col-xs-12 col-sm-8 col-lg-8">
        <div class="module">
            <?php if(!empty($posts['articles'])){?>
            <div class="module-header"><?php echo $this->searchKeyword;?>相关文章</div>
            <div class="module-body articles">
                <?php foreach($posts['articles'] as $post){$this->renderPartial('/article/_item',array('data'=>$post));}?>
            </div>
            <?php }?>
            <?php if(!empty($posts['questions'])){?>
            <div class="module-header"><?php echo $this->searchKeyword;?>相关问答</div>
            <div class="module-body questions">
                <?php foreach($posts['questions'] as $post){$this->renderPartial('/questions/_item',array('data'=>$post));}?>
            </div>
            <?php }?>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-lg-4">
        <div class="tags">
            <?php foreach($posts['tags'] as $col){echo zmf::link($col['title'],array('index/index','colName'=>$col['name']),array('target'=>'_blank')).' ';}?>
        </div>
    </div>
</div>
<?php }?>