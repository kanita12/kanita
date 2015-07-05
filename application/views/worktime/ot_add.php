<?php echo form_open($form_url) ?>
	<div>
		วัน/เดือน/ปี : <input type='text' id='input_ot_date' name='input_ot_date'>
		<br>
		เวลา : <input type='text' id='input_ot_time_from' name='input_ot_time_from'>
		จนถึงเวลา : <input type='text' id='input_ot_time_to' name='input_ot_time_to'>
		<br>
		หมายเหตุ : <textarea name='input_ot_remark' id='input_ot_remark'></textarea>
		<br>
		<input type='submit' value='บันทึก'>
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
</script>