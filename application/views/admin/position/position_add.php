<?php echo form_open($form_url); ?>
<input type='hidden' id='hd_position_id' name='hd_position_id' value='<?php echo $value_position_id ?>'>
<div class="row">
	<div class="col s12">
		<div class="input-field col s6">
			<?php echo form_dropdown('select_insitution_id', $dropdown_institution, $value_institution_id,'id=select_insitution_id'); ?>
			<label for="select_institution_id">หน่วยงาน</label>
		</div>
		<div class="input-field col s6">
			<?php echo form_dropdown('select_department_id', $dropdown_department, $value_department_id,'id=select_department_id'); ?>
			<label for="select_department_id">แผนก</label>
		</div>
		<div class="input-field col s12">
			<?php echo form_dropdown('select_headman_position_id', $dropdown_position, $value_headman_position_id,'id=select_headman_position_id'); ?>
			<label for="select_headman_position_id">หัวหน้าของตำแหน่งนี้</label>
		</div>
		<div class="input-field col s12">
			<input type='text' id='input_position_name' name='input_position_name' value='<?php echo $value_position_name ?>'>
			<label for="input_position_name">ชื่อตำแหน่ง</label>
		</div>
		<div class="input-field col s12">
			<textarea name="input_position_desc" id="input_position_desc" class="materialize-textarea"><?php echo $value_position_desc ?></textarea>
			<label for="input_position_desc">คำอธิบายเพิ่มเติม</label>
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
			<a href="<?php echo site_url("admin/Position") ?>" class="btn waves-effect waves-light red">ยกเลิก</a>
		</div>
	</div>
</div>
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
		$("input[type=text][type=select]").click();
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