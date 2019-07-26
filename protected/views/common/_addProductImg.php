<?php

/**
 * @filename _addImg.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2015 阿年飞少 
 * @datetime 2015-11-18  13:35:50 
 */
$id=zmf::randMykeys(8);
?>
<div class="thumbnail col-xs-4 col-sm-4 attach-item goods_faceimg" id="uploadAttach<?php echo $id;?>"><span class="right-bar"><?php echo CHtml::link('<i class="fa fa-remove"></i>','javascript:;',array('title'=>'删除图片','class'=>'del-btn','onclick'=>"$('#uploadAttach{$id}').remove()"));?><?php echo CHtml::link('<i class="fa fa-bookmark-o"></i>','javascript:;',array('title'=>'设置为封面图','onclick'=>'setProductFaceimg(\''.$data['id'].'\',this,\''.$data['imgurl'].'\',\''.$data['imgsrc'].'\')','class'=>'face-btn'));?></span><img src="<?php echo $data['imgurl'];?>" class="img-responsive"><input type="hidden" name="faceUrls[]" value="<?php echo $data['id'];?>"/></div>