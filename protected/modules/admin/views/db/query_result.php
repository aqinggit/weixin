<?php $this->renderPartial('bar');?>
<h4>SQL:<?php echo $command?></h4>
<table class="table table-condensed" >
  <tr>
    <?php foreach((array)$fields as $k):?>
    <th><?php echo $k?></th>
    <?php endforeach?>
  </tr>
  <?php foreach((array)$dataList as $row):?>
  <tr>
    <?php foreach((array)$fields as $d):?>
    <td><?php echo $row[$d]?></td>
    <?php endforeach?>
  </tr>
  <?php endforeach?>
</table>
