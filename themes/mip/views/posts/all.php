<div class="section _padding_5">
    <ul class="ui-grid-halve">
        <?php foreach($posts as $topPost){?>
            <li>
                <a class="ui-grid-halve-img" href="<?php echo zmf::createUrl('posts/view',['id'=>$topPost['id'],'urlPrefix'=>$topPost['urlPrefix']]);?>" data-type="mip">
                    <span><?php echo zmf::mipImg($topPost['faceUrl'],$topPost['title']);?></span>
                </a>
            </li>
        <?php }?>
    </ul>
</div>

