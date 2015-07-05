<?php echo form_open($form_url); ?>
<input type='hidden' id='hd_position_id' name='hd_position_id' value='<?php echo $value_position_id ?>'>
หน่วยงาน : <?php echo form_dropdown('select_insitution_id', $dropdown_institution, $value_institution_id,'id=select_insitution_id'); ?>
<br>
แผนก : <?php echo form_dropdown('select_department_id', $dropdown_department, $value_department_id,'id=select_department_id'); ?>
<br>
หัวหน้าของตำแหน่งนี้ : <?php echo form_dropdown('select_headman_position_id', $dropdown_position, $value_headman_position_id,'id=select_headman_position_id'); ?>
<br>
ชื่อตำแหน่ง : <input type='text' id='input_position_name' name='input_position_name' value='<?php echo $value_position_name ?>'>
<br>
คำอธิบายเพิ่มเติม :
<br>
<textarea name="input_position_desc" id="input_position_desc" cols="30" rows="10"><?php echo $value_position_desc ?></textarea>
<br>
<input type="submit" value='save' onclick='return check_before_submit();'>

<?php echo form_close(); ?>

<script type='text/javascript'>
	$(document).ready(function()
	{
		$('#select_insitution_id').change(function()
		{
			$('#select_department_id').html('');
			$('#select_headman_position_id').html('');

			$.ajax({
				url: 'get_list_for_dropdown/department/',
				type: 'POST',
				data: {id: $(this).val()},
			})
			.done(function(data) {
				$('#select_department_id').html(data);
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
			
		});

		$('#select_department_id').change(function()
		{
			$('#select_headman_position_id').html('');
			
			$.ajax({
				url: 'get_list_for_dropdown/position/',
				type: 'POST',
				data: {id: $(this).val()},
			})
			.done(function(data) {
				$('#select_headman_position_id').html(data);
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
			
		});
	});

	function check_before_submit()
	{
		var select_dept = $('#select_department_id');
		var pos_name = $('#input_position_name'); 
		var msg = '';
		
		if( select_dept.val() === '0' || select_dept.val() === null )
		{
			msg += '- แผนก<br/>';
		}

		if( $.trim(pos_name.val()) === '' )
		{
			msg += '- ชื่อตำแหน่ง<br/>';
		}
		if( msg !== '' )
		{
			swal
			({
				title: 'กรุณาเติมข้อมูลให้ครบถ้วน',
				html: msg,
				type: 'error'
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