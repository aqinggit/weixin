<?php $res = new assets();?>
<!DOCTYPE html>
<html>  
    <head>    
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
        <meta name="renderer" content="webkit">
        <link rel="shortcut icon" href="<?php echo zmf::config('baseurl');?>favicon.ico" type="image/x-icon" />
        <?php $res->loadCssJs('admin','admin'); ?>        
        <title><?php echo $this->pageTitle ? $this->pageTitle : '管理中心';?></title>     
    </head>
    <body>
        <?php echo $content; ?>
        <?php $res->jsConfig('admin');?> 
    </body>
</html>