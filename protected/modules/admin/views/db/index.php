<?php $this->renderPartial('bar');?>
<form action="<?php echo $this->createUrl('db/doQuery')?>" method="post" id="queryForm">
  <table class="table table-hover table-condensed">
    <thead>
      <tr class="operate">
          <th colspan="8" >当前数据库尺寸：<?php echo zmf::formatBytes($dataSize);?></th>
      </tr>
      <tr class="tb_header">
        <th style="width:5%">&nbsp;</th>
        <th>名称</th>
        <th style="width:10%">类型</th>
        <th style="width:15%">字符集</th>
        <th style="width:8%">记录数</th>
        <th style="width:8%">大小</th>
        <th style="width:8%">碎片</th>
        <th style="width:15%">注释</th>
      </tr>
    </thead>
    <?php foreach((array)$dataList as $row ):?>
    <tr class="tb_list">
      <td><input type="checkbox" name="table[]" value="<?php echo $row['Name']?>" id="<?php echo $row['Name']?>"></td>
      <td><label for="<?php echo $row['Name']?>"><?php echo $row['Name']?></label></td>
      <td><?php echo $row['Engine']?></td>
      <td><?php echo $row['Collation']?></td>
      <td><?php echo $row['Rows']?></td>
      <td><?php echo zmf::formatBytes($row['Data_length']);?></td>
      <td><?php echo $row['Data_free']?></td>
      <td><?php echo $row['Comment']?></td>
    </tr>
    <?php endforeach?>
    <tr class="submit">
      <td colspan="8">
        <input type="checkbox" id="chkall" name="chkall" onclick="">
        全选
        <select name="command">
          <option value="optimzeTable">优化表</option>
          <option value="showTable">查看表结构</option>
          <option value="checkTable">检查</option>
          <option value="analyzeTable">分析</option>
          <option value="repairTable">修复</option>
        </select>
        <input name="submit" type="submit" id="submit" value="执行"/></td>
    </tr>
  </table>
</form>
<div id="_tips"></div>