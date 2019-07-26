<?php $this->renderPartial('bar');?>
<form action="<?php echo $this->createUrl('db/doExport')?>" method="post">
  <table class="table table-condensed">
    <tr>
      <td>分卷大小：</td>
    </tr>
    <tr>
      <td ><input type="hidden" name="tabletype" value="zmfcms" id="zmfcms">
        大小
        <input name="sizelimit" type="text" id="sizelimit" value="2048" />
        kb<br /></td>
    </tr>
    <tr>
      <td>建表语句格式：</td>
    </tr>
    <tr>
      <td ><label><input type="radio" name="sqlcompat" value="" checked="">
        默认</label> &nbsp;
        <label><input type="radio" name="sqlcompat" value="MYSQL40">
        MySQL 3.23/4.0.x</label> &nbsp;
        <label><input type="radio" name="sqlcompat" value="MYSQL41">
        MySQL 4.1.x/5.x</label> &nbsp;</td>
    </tr>
    <tr>
      <td>强制字符集：</td>
    </tr>
    <tr >
        <td ><label><input type="radio" name="sqlcharset" value="" checked="">
        默认&nbsp;</label>
        <label><input type="radio" name="sqlcharset" value="latin1">
        LATIN1 &nbsp;</label>
        <label><input type="radio" name="sqlcharset" value="utf8">
        UTF-8 </label></td>
    </tr>
    <tr class="submit">
      <td ><input type="submit" name="dosubmit" value="开始备份" class="button" tabindex="3" id="dosubmit" /></td>
    </tr>
  </table>
</form>