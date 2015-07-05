<?php echo form_open($form_url) ?>
	<div>
		เลือกผู้ใต้บังคับบัญชา <?php echo form_dropdown('input_team', $dropdown_team, $value_team,"id='input_team'"); ?>
		<br>
		วัน/เดือน/ปี : <input type='text' id='input_ot_date' name='input_ot_date'>
		<br>
		เวลา : <input type='text' id='input_ot_time_from' name='input_ot_time_from'>
		จนถึงเวลา : <input type='text' id='input_ot_time_to' name='input_ot_time_to'>
		<br>
		หมายเหตุ : <textarea name='input_ot_remark' id='input_ot_remark'></textarea>
		<br>
		<input type='submit' value='บันทึก' onclick="return confirm_before_submit();">
		<input type='reset' onclick='window.location.href = <?php echo site_url('overtime'); ?>'>
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
			yearOffset:543,
			closeOnDateSelect:true
		 });
		$('#input_ot_time_from , #input_ot_time_to').datetimepicker({
			datepicker:false,
			step:30,
			format:'H:i'
		});
	});

	function confirm_before_submit()
	{
		var text = "";
		var user_id = $("#input_team option:selected").val();
		var team = $("#input_team option:selected").text();
		var date = $("#input_ot_date").val();
		var time_from = $("#input_ot_time_from").val();
		var time_to = $("#input_ot_time_to").val();
		var msg = "";

		if(parseInt(user_id) === 0)
		{
			msg += "-เลือกผู้ใต้บังคับบัญชา<br>";
		}
		if(date === "")
		{
			msg += "-วันที่ต้องการทำ<br>";
		}
		if(time_from === "")
		{
			msg += "-เวลาเริ่ม<br>";
		}
		if(time_to === "")
		{
			msg += "-เวลาสิ้นสุด";
		}
		if(msg !== "")
		{
			swal
			({
				title: "กรุณากรอกข้อมูลต่อไปนี้",
				html: msg,
				type: "error"
			});
			return false;
		}
		else
		{
			text = 	team+"<br>"+
					"ในวันที่ "+date+"<br>"+
					"ตั้งแต่เวลา "+time_from+" จนถึง "+time_to;
			swal({
				title: "ต้องการส่งใบคำขอทำ OT แทน ",
				html: text,
				type: "warning",
				showCancelButton: true,
				confirmButtonText: "ใช่",
				cancelButtonText: "ยกเลิก",
				closeOnConfirm: true,
				closeOnCancel: true
			},function(isConfirm)
			{
				if(isConfirm)
				{
					$("form").submit();
					return false;
				}
				else
				{
					return false;
				}
			});
		}
		return false;
	}
</script>