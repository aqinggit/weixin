<?php $this->renderPartial('bar');?>
<form action="<?php echo $this->createUrl('execute')?>" method="post" id="queryForm">
  <table class="table table-condensed">
    <tr>
      <td class="tb_title">输入SQL：</td>
    </tr>
    <tr >
      <td ><textarea name="command" cols="100" rows="8" id="command" class="form-control"></textarea></td>
    </tr>
    <tr >
      <td >每行一条SQL语句</td>
    </tr>
    <tr class="submit">
      <td ><input name="execute" type="submit" id="execute" value="提交" class="btn btn-primary" /></td>
    </tr>
  </table>
</form>
<div id="_tips"></div>
<script type='text/javascript'>
<!--
$('#queryForm').ajaxForm({
    beforeSubmit: function() {
		if($("#command").val() == ''){
			alert("SQL不能为空");
			return false;
		}
    },
    success: function(html) {
    	if(html.length > 0){
			$("#_tips").html(html);
    	}
    }
});
//-->
</script> 