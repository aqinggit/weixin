<?php $this->beginContent('/layouts/common'); ?>
<?php if($this->showTopbar){?>
    <header class="top-header">
        <div class="header-left">
            <?php echo zmf::link('['.($this->areaInfo ? $this->areaInfo['title'] : '切换地区').']',['site/area'],['data-type'=>'mip']);?>
        </div>
        <div class="header-center">
            <a href="<?php echo zmf::config('baseurl');?>" class="logo" title="<?php echo zmf::config('sitename');?>" data-type="mip">
                <?php echo zmf::mipImg(zmf::config('logo'),zmf::config('sitename'));?>
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
<?php $this->renderPartial('/layouts/_nav');$this->endContent();
