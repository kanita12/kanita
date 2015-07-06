<input type="hidden" id="hd_validation" name="hd_validation" value="<?php echo validation_errors(); ?>">
<?php echo form_open();?>
<input type="hidden" id="hd_hid" name="hd_hid" value="<?php echo $value_hid ?>">
ชื่อ : <input type="text" id="input_name" name="input_name" value="<?php echo set_value("input_name",$value_name) ?>">
<br>
คำอธิบาย : <textarea id="input_desc" name="input_desc"><?php echo $value_desc ?></textarea>
<br>
วันที่ : <input type="text" id="input_date" name="input_date" value="<?php echo set_value("input_date",$value_date) ?>">
<br>
<input type="submit" value="บันทึก" onclick="return check_before_submit();">
<?php echo form_close(); ?>

<script type="text/javascript" src="<?php echo js_url() ?>datetimepicker/jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="<?php echo js_url() ?>datetimepicker/jquery.datetimepicker.css" media="screen" charset="utf-8" />
<script type="text/javascript">
	$(document).ready(function(){
		$('#input_date').datetimepicker({
			timepicker:false,
			format:'d/m/Y',
			lang:'th',
			closeOnDateSelect:true
		});

		if($.trim($("#hd_validation").val()) !== "")
		{
			swal
			({
				title: "กรุณากรอกข้อมูลให้ครบ",
				html: validation,
				type: "error"
			});
		}
	});
	function check_before_submit()
	{
		var name = $("#input_name").val();
		var date = $("#input_date").val();
		var msg	= "";
		if($.trim(name) === ""){ msg += "- ชื่อวันหยุด<br>"; }
		if($.trim(date) === ""){ msg += "- วันที่<br>"; }
		if(msg !== "")
		{
			swal(
			{
				title: "กรุณากรอกข้อมูลเหล่านี้",
				html: msg,
				type: "error"
			});
			return false;
		}
		else
		{
			return true;
		}
		return false;
	}
</script>