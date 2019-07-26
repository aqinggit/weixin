<?php foreach($articles as $k=>$article){?>
    <div class="grid<?php echo ($k+1)%2==0 ? ' grid-grey' : '';?>">
        <h2 class="grid-title"><?php echo zmf::link($article['title'],array('index/index','colName'=>$article['name']) ,array('target'=>'_blank'));?></h2>
        <div class="grid-en"></div>
        <?php foreach ($article['posts'] as $_post){?>
            <div class="media">
                <div class="media-left">
                    <a href="<?php echo zmf::createUrl('article/view',array('id'=>$_post['id'],'urlPrefix'=>$_post['urlPrefix']));?>" title="<?php echo $_post['title'];?>" target="_blank">
                        <img src="<?php echo zmf::lazyImg();?>" class="lazy" alt="<?php echo $_post['title'];?>" data-original="<?php echo $_post['faceImg'];?>"/>
                    </a>
                </div>
                <div class="media-body">
                    <p class="title ui-nowrap"><?php echo zmf::link($_post['title'],array('article/view','id'=>$_post['id'],'urlPrefix'=>$_post['urlPrefix']) ,array('target'=>'_blank'));?></p>
                    <p class="content ui-nowrap-multi"><?php echo $_post['desc'];?></p>
                </div>
            </div>
        <?php }?>
    </div>
<?php }?>