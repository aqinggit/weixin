<?php
$this->renderPartial('_nav');
?>
<div class="form">
    <?php 
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'search-form',
        'htmlOptions' => array('class'=>'search-form'),
        'action' => Yii::app()->createUrl('/admin/questions/byTitle',array('id'=>$info['id'])),
        'method'=>'get',
        'enableAjaxValidation' => false,
        ));
    ?>
    <div class="form-group">
        <?php echo CHtml::textField("title", $title, array("class" => "form-control")); ?>
        <p class="help-block">请输入要查询的关键词</p>
    </div>
    <div class="form-group">
        <?php echo CHtml::textField("page", $_GET['page'], array("class" => "form-control")); ?>
        <p class="help-block">翻页数</p>
    </div>
    <div class="form-group">
        <button class="btn btn-default" type="submit">查询</button>    
        <button class="btn btn-success getContent" type="button">获取内容</button> 
    </div>
    <?php $this->endWidget(); ?>   
    <style>
        .item{
            background: #f2f2f2;
            display: block;
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 15px;
        }
    </style>    
</div>
<?php 
if(!empty($urls)){
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'search-form',
    'htmlOptions' => array('class'=>'search-form'),
    'action' => Yii::app()->createUrl('/admin/questions/multiReply',array('id'=>$info['id'])),
    'enableAjaxValidation' => false,
    ));
?>
<div class="row">
    <div class="col-xs-6 col-sm-6">
        <p><b>采集的问题</b><a href="javascript:;" class="remoteQ pull-right">移除全部采集</a></p>
        <?php foreach($urls as $url){$id= zmf::randMykeys(8);?>
        <div class="item _caiji" id="<?php echo $id;?>">            
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-btn">
                        <a class="btn btn-default original-link" data-type="<?php echo $url['type'];?>" data-target="<?php echo $id;?>_content" type="button" href="<?php echo $url['url'];?>" target="_blank">原<?php echo $url['type'];?>链接</a>
                    </span>
                    <?php echo CHtml::textField("ptitle[]", $url['title'], array("class" => "form-control",'placeholder'=>'标题')); ?>
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button" onclick="$('#<?php echo $id;?>').remove()">删除</button>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button class="btn btn-default single-link" type="button" data-type="<?php echo $url['type'];?>" data-target="<?php echo $id;?>_content" type="button" href="<?php echo $url['url'];?>">获取内容</button>
                    </span>
                    <?php echo CHtml::textField("puid[]", $url['uid'], array("class" => "form-control",'placeholder'=>'用户')); ?>                
                </div>
            </div>
            <div class="form-group"><?php echo CHtml::textField("ptime[]", zmf::time($url['time']), array("class" => "form-control",'placeholder'=>'时间')); ?></div>
            <div class="form-group"><?php echo CHtml::textArea("pcontent[]", '', array("class" => "form-control",'placeholder'=>'正文','rows'=>8,'id'=>$id.'_content')); ?></div>            
        </div>
        <?php }?>
    </div>
    <div class="col-xs-6 col-sm-6">
        <p><b>本站相似文章</b><a href="javascript:;" class="remoteAr pull-right">移除全部文章</a></p>
        <?php foreach($articles as $url){$id= zmf::randMykeys(8);?>
        <div class="item _article" id="<?php echo $id;?>">            
            <div class="form-group">
                <div class="input-group">                    
                    <?php echo CHtml::textField("ptitle[]", $url['title'], array("class" => "form-control",'placeholder'=>'标题')); ?>
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button" onclick="$('#<?php echo $id;?>').remove()">删除</button>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">                    
                    <?php echo CHtml::textField("puid[]", $url['uid'], array("class" => "form-control",'placeholder'=>'用户')); ?>                
                </div>
            </div>
            <div class="form-group"><?php echo CHtml::textField("ptime[]", zmf::time($url['time']), array("class" => "form-control",'placeholder'=>'时间')); ?></div>
            <div class="form-group"><?php echo CHtml::textArea("pcontent[]", $url['content'], array("class" => "form-control",'placeholder'=>'正文','rows'=>8,'id'=>$id.'_content')); ?></div>       
        </div>
        <?php }?>
    </div>
</div>
<div class="form-group">
    <button class="btn btn-primary" type="submit">批量导入</button>
</div>
<?php $this->endWidget();} ?>
<script>
    $(document).ready(function(){
        $('.getContent').unbind('click').click(function(){
            $('a.original-link').each(function(){
                var dom=$(this);
                getContent(dom)
            })
        });
        $('.remoteQ').unbind('click').click(function(){
            $('._caiji').each(function(){
                $(this).remove();
            })
        });
        $('.remoteAr').unbind('click').click(function(){
            $('._article').each(function(){
                $(this).remove();
            })
        });

        $('.single-link').unbind('click').click(function(){
            var dom=$(this);
            getContent(dom)
        })        
    })
    function getContent(dom){
        
        var type=dom.attr('data-type');
        var target=dom.attr('data-target');
        var href=dom.attr('href')
        var passData={
            type:type,
            url:href,
            YII_CSRF_TOKEN: zmf.csrfToken
        };
        $.post('<?php echo Yii::app()->createUrl('admin/articles/getByAjax');?>', passData, function (result) {
            result = $.parseJSON(result);
            if (result.status === 1) {
                $('#' + target).val(result.msg);
            } else {
                simpleDialog({content:result.msg});
            }
            return false;
        });
    }
</script>