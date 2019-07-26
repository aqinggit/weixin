<?php

/**
 * @filename forCreate.php 
 * @Description
 * @author 阿年飞少 <ph7pal@qq.com> 
 * @link http://www.newsoul.cn 
 * @copyright Copyright©2015 阿年飞少 
 * @datetime 2016-11-15  10:03:45 
 */
$columns=  Column::getProductTypes();
?>
<style>
    /*栏目*/
.columns-holder{
    padding: 15px;
}
.columns-holder .even{
    background: #efefef;
}
.columns-holder .odd{
    background: #FFF;
}
.columns-holder .column-item p{
    padding: 5px
}
.columns-holder .column-item p:hover{
    background: #f8f8f8
}
</style>
<div class="modal fade" id="columnForListHolder">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">请选择栏目</h4>
            </div>
            <div class="modal-body">
                <div class="columns-holder">
                    <?php $i=0;foreach ($columns as $val){?>
                    <div class="column-item <?php echo $i%2==0 ? 'even' : 'odd';?>">
                        <p><?php echo $val['title'];?><span class="pull-right">
                            <?php echo !empty($val['items']) ? CHtml::link('展开','javascript:;',array('onclick'=>"$('#column-table-{$val['id']}').toggle();")) : '';?>
                            <?php echo CHtml::link('选择','javascript:;',array('onclick'=>"selectThis('{$val['id']}','{$val['title']}')"));?></span>
                        </p>
                        <?php if(!empty($val['items'])){?>
                        <div class="second-item displayNone" id="column-table-<?php echo $val['id'];?>">
                            <?php foreach($val['items'] as $val2){?>
                            <p class="padding-2x"><?php echo $val2['title'];?>
                                <span class="pull-right">
                                    <?php echo !empty($val2['items']) ? CHtml::link('展开','javascript:;',array('onclick'=>"$('#column-table-{$val2['id']}').toggle();")) : '';?>
                                    <?php echo CHtml::link('选择','javascript:;',array('onclick'=>"selectThis('{$val2['id']}','{$val2['title']}')"));?>
                                </span>
                            </p>
                            <?php if(!empty($val2['items'])){?>
                            <div class="third-item displayNone" id="column-table-<?php echo $val2['id'];?>">
                                <?php foreach($val2['items'] as $val3){?>
                                <p class="padding-3x"><?php echo $val3['title'];?><span class="pull-right"><?php echo CHtml::link('选择','javascript:;',array('onclick'=>"selectThis('{$val3['id']}','{$val3['title']}')"));?></span></p>
                                <?php }?>
                            </div>
                            <?php }?>
                        <?php }?>
                        </div>
                        <?php }?>
                    </div>
                    <?php $i+=1;}?>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    function selectThis(id,title){
        if(!id){
            alert('缺少数据');
            return false;
        }
        $('#columnForListHolder').modal('hide');
        var passData = {
            YII_CSRF_TOKEN: zmf.csrfToken,
            typeId: id,
            tagId: tagId
        };
        $.post('<?php echo zmf::createUrl('/admin/tags/updateColumn');?>', passData, function (data) {
            data = $.parseJSON(data);
            ajaxReturn = true;
            if (data.status === 1) {
                simpleDialog({msg: data.msg});                
                tagDom.text(title)
            } else {
                simpleDialog({msg: data.msg});
                return false;
            }
        });
    }
</script>