<h3>数据库管理</h3>
<a href="<?php echo $this->createUrl('index')?>" class="btn btn-default" role="button"><span>常规管理</span></a>
<a href="<?php echo $this->createUrl('query')?>" class="btn btn-primary" role="button"><span>执行SQL</span></a>
<a href="<?php echo $this->createUrl('db/export')?>" class="btn btn-success" role="button"><span>数据库备份</span></a>
<a href="<?php echo $this->createUrl('db/import')?>" class="btn btn-info" role="button">数据库还原</a>