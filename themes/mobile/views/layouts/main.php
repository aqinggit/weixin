<?php $this->beginContent('/layouts/common'); ?>
<section class="ui-container">
    <?php echo $content; ?>
</section>

<?php $this->renderPartial('/layouts/_nav');echo zmf::config('tongji');$this->endContent();
