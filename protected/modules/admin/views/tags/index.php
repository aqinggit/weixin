<?php

/**
 * @filename index.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2015 阿年飞少 
 * @datetime 2016-1-4  12:55:36 
 */
$this->renderPartial('_nav');
echo CHtml::link('新增', array('create'), array('class' => 'btn btn-danger addBtn'));
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'search-form',
    'htmlOptions' => array('class' => 'search-form'),
    'action' => Yii::app()->createUrl('/admin/tags/index'),
    'enableAjaxValidation' => false,
    'method' => 'GET'
    ));
?>
<div class="fixed-width-group">
    <div class="form-group">
        <?php echo CHtml::textField("title", $_GET["title"], array("class" => "form-control", "placeholder" => $model->getAttributeLabel("title"))); ?> 
    </div>
    <div class="form-group">
        <?php echo CHtml::textField("name", $_GET["name"], array("class" => "form-control", "placeholder" => $model->getAttributeLabel("name"))); ?> 
    </div>
    <div class="form-group">
        <?php echo CHtml::dropDownList("classify", $_GET["classify"], Column::classify('admin'), array("class" => "form-control", "empty" => $model->getAttributeLabel("classify"))); ?> 
    </div>
    <div class="form-group">
        <button class="btn btn-default" type="submit">搜索</button>
        <span class="dropdown" >
            <button data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="btn btn-default">
                批量匹配<span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><?php echo CHtml::link('链接文章',array('articles/linkTags'));?></li>
                <li><?php echo CHtml::link('链接问答',array('questions/linkTags'));?></li>
            </ul>
        </span>
    </div>
</div>
<?php $this->endWidget(); ?>
<table class="table table-hover">
    <tr>
        <th style="width:80px;">ID</th>
        <th style="width:120px;">分类</th>
        <th>名称</th>
        <th style="width:100px;">分类</th>
        <th style="width:80px;">路径</th>
        <th style="width:60px;">显示</th>
        <th style="width:60px;">首页</th>
        <th style="width:150px;">操作</th>
    </tr>
    <?php foreach ($posts as $tag){?>
    <tr id="item-<?php echo $tag['id'];?>">
        <td><?php echo $tag['id'];?></td>
        <td><?php echo CHtml::link($tag['typeId'] ? $tag->typeInfo->title : '未设置','javascript:;',array('data-id'=>$tag['id'],'class'=>'setColumn'));?></td>
        <td><?php echo $tag['title'];?></td>
        <td><?php echo CHtml::link(Column::classify($tag['classify']),array('index','classify'=>$tag['classify']));?></td>
        <td><?php echo CHtml::link($tag['name'],'javascript:;',array('class'=>'setName','data-id'=>$tag['id'],'data-title'=>$tag['title']));?></td>
        <td><?php echo zmf::yesOrNo($tag['isDisplay']);?></td>
        <td><?php echo zmf::yesOrNo($tag['toped']);?></td>
        <td>
            <?php echo CHtml::link('预览',array('/index/index','tagName'=>$tag['name']),array('target'=>'_blank'));?>
            <?php echo CHtml::link('编辑',array('tags/update','id'=>$tag['id']));?>
            <span class="dropdown" >
                <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    更多操作<span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><?php echo CHtml::link('链接文章',array('linkArticles','id'=>$tag['id']));?></li>
                    <li><?php echo CHtml::link('链接问答',array('linkQuestions','id'=>$tag['id']));?></li>
                    <li role="separator" class="divider"></li>
                    <li><?php echo CHtml::link('排序',array('order','type'=>$tag['classify']),array('target'=>'_blank'));?></li>
                    <li><?php echo CHtml::link('TDK', array('tdk/jump', 'url' => zmf::createUrl('/index/index',array('colName'=>$tag['name']))),array('target'=>'_blank')); ?></li>
                    <li role="separator" class="divider"></li>
                    <li><?php echo CHtml::link('删除',array('delete','id'=>$tag['id']),array('class'=>'delete','data-id'=>$tag['id']));?></li>
                </ul>
            </span>
        </td>
    </tr>
    <?php }?>
</table>
<?php $this->renderPartial('/common/pager',array('pages'=>$pages));?>
<div class="modal fade" id="columnHolder">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">设置路径</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-success">
                    <p id='tag-title-holder'></p>
                </div>
                <div class="form-group">
                    <input class="form-control" id="tag-name-holder"/>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->renderPartial('/column/forList',array('model'=>$model));?>
<script>
    var tagId=0;
    var tagDom;
    $(document).ready(function(){
        $('.setColumn').unbind('click').click(function () {
            var dom = $(this);
            var id = dom.attr('data-id');      
            tagId=id;
            tagDom=dom;
            $('#columnForListHolder').modal({
                backdrop: false,
                keyboard: false
            });
        });
        $('.setName').unbind('click').click(function () {
            var dom = $(this);
            var id = dom.attr('data-id');            
            var title = dom.attr('data-title');            
            if (!id) {
                simpleDialog({msg: '参数错误'});
                return false;
            }
            $('#columnHolder').modal({
                backdrop: false,
                keyboard: false
            });
            $('#tag-title-holder').html(title);
            $('#tag-name-holder').focus();
            $('#tag-name-holder').unbind('keydown').keydown(function(e) {  
                // 回车键事件  
               if(e.keyCode === 13) {
                   var name = $('#tag-name-holder').val();
                    if (!name) {
                        simpleDialog({msg: '请填写路径'});
                        return false;
                    }
                    var passData = {
                        YII_CSRF_TOKEN: zmf.csrfToken,
                        id: id,
                        name: name
                    };
                    $.post('<?php echo zmf::createUrl('/admin/tags/updateName');?>', passData, function (data) {
                        data = $.parseJSON(data);
                        ajaxReturn = true;
                        if (data.status === 1) {
                            simpleDialog({msg: data.msg});
                            $('#columnHolder').modal('hide');
                            $('#tag-name-holder').val('');
                            $('#tag-title-holder').html('');
                            dom.text(name)
                        } else {
                            simpleDialog({msg: data.msg});
                            return false;
                        }
                    });
               }
            }); 
        });
    })
</script>
