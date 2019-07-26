<?php $this->renderPartial('bar');?>
<form action="<?php echo $this->createUrl('db/operate')?>" method="post">
  <table class="content_list">
    <thead>
      <tr class="tb_header">
        <th width="4%"align="left"></th>
        <th>名称</th>
        <th width="10%">文件大小</th>
        <th width="20%">备份时间</th>
        <th width="10%">分卷</th>
        <th width="15%">恢复/下载</th>
      </tr>
    </thead>
    <tbody>
      <?php if(is_array($infos)):?>
      <?php foreach($infos as $info):?>
      <tr bgcolor="<?=$info['bgcolor']?>">
        <td ><input name="sqlfile[]" type="checkbox" id="sqlfile[]" value="<?php echo $info['filename']?>"></td>
        <td><?php echo $info['filename']?></td>
        <td><?php echo $info['filesize']?> M</td>
        <td><?php echo $info['maketime']?></td>
        <td><?php echo $info['number']?></td>
        <td><a href="<?php echo $this->createUrl('db/import',array('pre'=>$info['pre'], 'dosubmit'=>'1'))?>"><img src="<?php echo Yii::app()->baseUrl?>/common/images/refresh.png" align="absmiddle" /></a>&nbsp;&nbsp;&nbsp; <a href="<?php echo $this->createUrl('db/operate',array('command'=>'downloadFile','sqlfile'=>$info['filename']))?>"><img src="<?php echo Yii::app()->baseUrl?>/common/images/download.png" align="absmiddle" /></a></td>
      </tr>
      <?php endforeach?>
      <?php endif?>
    </tbody>
    <tr class="submit">
      <td colspan="6" ><input name="command" type="hidden" value="deleteFile" />
        <input type="checkbox" id="chkall" name="chkall" onclick="checkAll(this.form, 'file')">
        全选
        <input name="submit" type="submit" id="submit" value="删除" class="button"/>
        &nbsp;</td>
    </tr>
  </table>
</form>