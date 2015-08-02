<?php echo form_open() ?>
<div class="row">
	<div class="col s12">
		<div class="input-field col s12 l4">
			<input type="text" id="input_ot_date" name="input_ot_date" value="<?php echo $value_ot_date ?>">
			<label for="input_ot_date">วันที่</label>
		</div>
		<div class="input-field col s6 l4">
			<input type='text' id='input_ot_time_from' name='input_ot_time_from' value="<?php echo $value_ot_time_from ?>">
			<label for="input_ot_time_from">ตั้งแต่เวลา</label>
		</div>
		<div class="input-field col s6 l4">
			<input type='text' id='input_ot_time_to' name='input_ot_time_to' value="<?php echo $value_ot_time_to ?>">
			<label for="input_ot_time_to">จนถึงเวลา</label>
		</div>
	</div>
</div>
<div class="row">
	<div class="col s12">
		<div class="input-field col s12">
			<textarea name='input_ot_remark' id='input_ot_remark' class="materialize-textarea"><?php echo $value_ot_remark ?></textarea>
			<label for="input_ot_remark">หมายเหตุ</label>
		</div>
	</div>
</div>
<div class="divider"></div>
<div class="section">
	<div class="row">
		<div class="col s4">
			<button class="btn waves-effect waves-light" type="submit" name="action" onclick="return check_before_submit();">บันทึก</button>
		</div>
		<div class="col s4 offset-s4 right-align">
			<a href="<?php echo site_url("overtime") ?>" class="btn waves-effect waves-light red">ยกเลิก</a>
		</div>
	</div>
</div>
<?php echo form_close(); ?>

<script type="text/javascript" src="<?php echo js_url() ?>datetimepicker/jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="<?php echo js_url() ?>datetimepicker/jquery.datetimepicker.css" media="screen" title="no title" charset="utf-8" />
<script type='text/javascript'>
	$(document).ready(function()
	{
		$('#input_ot_date').datetimepicker({
			timepicker:false,
			format:'d/m/Y',
			lang:'th',
			closeOnDateSelect:true
		 });
		$('#input_ot_time_from , #input_ot_time_to').datetimepicker({
			datepicker:false,
			step:30,
			format:'H:i'
		});
	});
	function check_before_submit()
	{
		var date = $("#input_ot_date").val();
		var time_from = $("#input_ot_time_from").val();
		var time_to = $("#input_ot_time_to").val();
		var msg = "";
		if($.trim(date) === "")
		{
			msg += "- วันที่<br>";
		}
		if($.trim(time_from) === "")
		{
			msg += "- ตั้งแต่เวลา<br>";
		}
		if($.trim(time_to) === "")
		{
			msg += "- จนถึงเวลา";
		}
		if(msg !== "")
		{
			swal({
				title : "กรุณากรอกข้อมูลให้ครบ",
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