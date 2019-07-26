<?php if(!empty($weixinImgs)){?>
<style>
    .fixed-imgs{
        position: fixed;
        top: 100px;
        left: 910px;
        width: 360px;
        height: 600px;
        overflow-y: scroll
    }
    .fixed-imgs ._all{
        position: absolute;
        top: 0;
        right: 0
    }
    .fixed-imgs ._img_item{
        width: 110px;
        display: inline-block;
    }
    .fixed-imgs ._img_item img{
        width: 110px;
    }
</style>
<div class="fixed-imgs" id="fixed-imgs">
    <a href="javascript:;" class="_all">下载全部</a>
    <?php foreach($weixinImgs as $k=>$url){?>
    <?php if($thumbnail){?>
    <div id="weixin-img-<?php echo $k+1;?>" class="_img_item text-center">
        <?php echo CHtml::link('',array('tools/referer','url'=>$url,'imgId'=>($k+1)),array('target'=>'_blank','class'=>'_item'));?>
        <a href="<?php echo $url;?>" target="_blank"><img src="<?php echo $url;?>"/></a>
        <p><a href="javascript:;" onclick="_removeCaijiImgId(<?php echo $k+1;?>)">图片<?php echo $k+1;?> <i class="fa fa-remove"></i></a></p>
    </div>
    <?php }else{?>
    <div id="weixin-img-<?php echo $k+1;?>" class="_img_item text-center">
        <?php echo CHtml::link('',array('tools/referer','url'=>$url,'imgId'=>($k+1)),array('target'=>'_blank','class'=>'_item'));?>
        <a href="<?php echo Yii::app()->createUrl('admin/tools/referer',array('url'=>$url,'imgId'=>($k+1)));?>" class="_img" target="_blank">
            <img src="<?php echo Yii::app()->createUrl('admin/tools/referer',array('url'=>$url));?>"/>
        </a>
        <p>
            <a href="javascript:;" onclick="_removeCaijiImgId(<?php echo $k+1;?>)">图片<?php echo $k+1;?> <i class="fa fa-remove"></i></a>
            <?php echo CHtml::link('<i class="fa fa-forward"></i>',$url,array('target'=>'_blank'));?>
        </p>
    </div>
    <?php }?>
    <?php }?>
    <div class="form-group" style="width:250px">
        <input type="text" class="form-control" placeholder="裁剪比例，如 15 表示底部裁掉15%" id="crop-percent"/>
    </div>
</div>
<?php }?>
<script>
    $(document).ready(function(){
        $('a._all').click(function(){
            $('.fixed-imgs a._item').each(function(){
                var url=$(this).attr('href');
                $.ajax({  
                    type : "post",  
                    url : url,  
                    data : "",  
                    //async : false,  
                    success : function(data){                        
                      data = $.parseJSON(data);
                      if(data['status']===1){
                          var img = "<img src='" + data['thumbnail'] + "' data='" + data['attachid'] + "' class='img-responsive'/>";
                          var inputstr=myeditor.getContent();
                          inputstr = inputstr.replace('图片'+data['imgId'], img);
                          myeditor.setContent(inputstr,false);
                          $('#weixin-img-'+data['imgId']).remove();
                          simpleDialog({msg:'已成功替换->图片'+data['imgId']});
                      }
                    }
                });
            })
        });
        $('#crop-percent').change(function(){
            var per=parseInt($(this).val());
            $('.fixed-imgs a._item').each(function(){
                $(this).attr('href',$(this).attr('href')+'&percent='+per);
            });
            $('.fixed-imgs a._img').each(function(){
                $(this).attr('href',$(this).attr('href')+'&percent='+per);
            })
        })
    });
    function _removeCaijiImgId(id){
        $('#weixin-img-'+id).remove();
        var inputstr=myeditor.getContent();
        inputstr = inputstr.replace('图片'+id, '');
        myeditor.setContent(inputstr,false);
    }
</script>