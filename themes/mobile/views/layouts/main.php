<?php $this->beginContent('/layouts/common'); ?>
<?php if($this->showTopbar){?>
    <header class="top-header">
        <div class="header-left">
            <?php echo zmf::link('['.($this->areaInfo ? $this->areaInfo['title'] : '切换地区').']',['site/area']);?>
        </div>
        <div class="header-center">
            <a href="<?php echo zmf::config('baseurl');?>" class="logo" title="<?php echo zmf::config('sitename');?>">
                <img src="<?php echo zmf::config('logo');?>"/>
            </a>
        </div>
        <div class="header-right">
            <?php echo zmf::link('<i class="fa fa-phone"></i>','tel:'.zmf::config('sitePhone'));?>
        </div>
    </header>
<?php }?>
<section class="ui-container">
    <?php echo $content; ?>
</section>
<div class="text-center" style="padding: 20px 0;background: #f2f2f2;margin-bottom: 45px">
    <p class="color-666"><span class="yen"><?php echo zmf::config('copyright');?></span><span><?php echo zmf::config('sitename');?></span></p>
    <p><a href="http://www.miibeian.gov.cn/" target="_blank" class="color-666" rel="nofollow"><?php echo zmf::config('beian');?></a></p>
</div>
<?php $this->renderPartial('/layouts/_nav');echo zmf::config('tongji');$this->endContent();
