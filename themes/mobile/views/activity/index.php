<!--<a href="javascript:;" class="weui-btn weui-btn_primary">登录</a>-->
<style>

    .fs12 {
        font-size: 12px;
    }

    .fs16 {
        font-size: 16px;
    }

    .active_img {
        width: 120px;
        height: 80px;
        margin-right: 15px;
    }

    .article_detail {
        padding: 10px 15px;
    }

    .article_detail img {
        display: block;
        width: 100%;
        margin: 15px 0;
    }

    .article_detail p {
        text-align: justify;
    }
</style>
<!--文章列表-->
<?php foreach ($items as $item) { ?>

    <div class="weui-cells">
        <div class="weui-cell">
            <div class="weui-cell__bd fs16">
                <p><?php echo $item['title']; ?>
                <?php zmf::link('')?>
            </div>
            <div class="weui-cell__ft fs12"><?php echo zmf::time($item['cTime'], 'Y-m-d') ?></div>
        </div>
    </div>

<?php } ?>
