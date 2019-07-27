<?php $this->beginContent('/layouts/common'); ?>
<section class="ui-container">
    <?php echo $content; ?>
</section>
<div class="text-center" style="padding: 20px 0;background: #f2f2f2;margin-bottom: 45px">
    <p class="color-666"><span class="yen"><?php echo zmf::config('copyright');?></span><span><?php echo zmf::config('sitename');?></span></p>
    <p><a href="http://www.miibeian.gov.cn/" target="_blank" class="color-666" rel="nofollow"><?php echo zmf::config('beian');?></a></p>
</div>
<?php $this->renderPartial('/layouts/_nav');echo zmf::config('tongji');$this->endContent();
