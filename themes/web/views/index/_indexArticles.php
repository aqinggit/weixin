<?php if(!empty($articles)){?>
<div class="index_module bg_grey index-strategy">
    <h2 class="_header text-center"><?php echo $this->areaInfo ? $this->areaInfo['title'].'' : '';?><?php echo zmf::config('mainKeyword');?>知识</h2>
    <div class="heng-line"></div>
    <div class="_body container">
        <div class="strategy-body">
            <ul class="strategy-title">
                <?php foreach($articles as $first=>$article){?>
                    <li class="<?php echo $first==0 ? 'active':'';?>">
                        <h3><?php echo zmf::link($article['title'],array('index/index','colName'=>$article['name']),array('target'=>'_blank')) ;?></h3>
                    </li>
                <?php }?>
            </ul>
            <div class="strategy-posts" id="strategy-posts">
                <?php foreach($articles as $j=>$article){?>
                    <ul class="<?php echo $j==0 ? 'active':'';?>">
                        <?php foreach ($article['posts'] as $_post){?>
                            <li>
                                <div class="posts-li-left">
                                    <a href="<?php echo zmf::createUrl('article/view',['id'=>$_post['id'],'urlPrefix'=>$_post['urlPrefix']]);?>">
                                        <img src="<?php echo zmf::lazyImg();?>" data-original="<?php echo $_post['faceImg']?>" class="lazy" alt="<?php echo $_post['title']?>">
                                    </a>
                                </div>
                                <div class="posts-li-right">
                                    <?php echo zmf::link($_post['title'],array('article/view','id'=>$_post['id'],'urlPrefix'=>$_post['urlPrefix']) ,array('target'=>'_blank','class'=>'_title'));?>
                                    <div class="strategy-tent"><?php echo zmf::subStr(zmf::trimText($_post['desc']),36);?></div>
                                </div>
                            </li>
                        <?php }?>
                        <?php echo zmf::link('查看更多'.$article['title'].'知识',array('index/index','colName'=>$article['name']) ,array('target'=>'_blank','class'=>'posts-gd','rel'=>'nofollow'));?>
                    </ul>
                <?php }?>
            </div>
        </div>
    </div>
</div>
<?php }?>