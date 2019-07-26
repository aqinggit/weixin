<div class="section _padding_5">
    <ul class="ui-grid-halve">
        <?php foreach($posts as $topPost){?>
            <li>
                <a class="ui-grid-halve-img" href="<?php echo zmf::createUrl('posts/view',['id'=>$topPost['id'],'urlPrefix'=>$topPost['urlPrefix']]);?>">
                    <span style="background-image:url(<?php echo $topPost['faceUrl'];?>)"></span>
                </a>
            </li>
        <?php }?>
    </ul>
</div>

