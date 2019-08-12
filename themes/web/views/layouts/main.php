<?php
$this->beginContent('/layouts/common');
?>

<nav class="navbar navbar-primary navbar-fixed-top" id="navigation" style="width: 1200px;height: 60px;margin: 0 auto">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo zmf::config('baseurl');?>">
                <img src="<?php echo zmf::config('logo');?>" alt="<?php echo zmf::config('sitename');?>">
            </a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="height: 60px">
            <?php $this->renderPartial('/layouts/_user');?>
        </div>
    </div>
</nav>
<div class="main-container <?php echo $this->currentModule=='index' ? '' : 'container';?>">
    <?php echo $content; ?>
</div>

<?php $this->endContent();