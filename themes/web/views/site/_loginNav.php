<li><a href="javascript:;" rel="nofollow"><i class="fa fa-phone"></i> <?php echo zmf::config('sitePhone');?></a></li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->userInfo['truename']; ?> <span class="caret"></span></a>
    <ul class="dropdown-menu">
        <?php if ($this->userInfo['isAdmin']) { ?>
            <li><?php echo zmf::link('管理中心', array('admin/index/index'), array('role' => 'menuitem','target'=>'_blank')); ?></li>
            <li role="separator" class="divider"></li>
        <?php } ?>
        <li><?php echo zmf::link('退出', array('site/logout'), array('role' => 'menuitem')); ?></li>
    </ul>
</li>