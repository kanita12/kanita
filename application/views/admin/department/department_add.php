<?php echo form_open($form_url) ?>

<input type='hidden' id='hd_department_id' name='hd_department_id' value='<?php echo $department_id ?>'>

หน่วยงาน : <?php echo form_dropdown('input_institution_id', $dropdown_institution,$value_institution_id,'id=input_institution_id'); ?> 
<a href="<?php echo site_url('admin/Institution/') ?>">
	เพิ่มหน่วยงาน
</a>
<br>
ชื่อแผนก : <input type='text' id='input_department_name' name='input_department_name' value='<?php echo $value_department_name ?>'>
<br>
คำอธิบาย :
<textarea name="input_department_desc" id="input_department_desc" cols="30" rows="10"><?php echo $value_department_desc ?></textarea>
<br>
<input type='submit' value='save' onclick='return check_before_submit();'>
<?php echo form_close(); ?>

<script type='text/javascript'>
	function check_before_submit()
	{
		var inst_id = $('#input_institution_id');
		var dept_name = $('#input_department_name');
		var msg = '';
		
		if( inst_id.val() === '0' )
		{
			msg += "- หน่วยงาน<br>";
		}
		if( dept_name.val() === '' )
		{
			msg += "- ชื่อแผนก<br>";
		}
		if( msg !== '' )
		{
			swal(
			{
				title : 'กรอกข้อมูลต่อไปนี้',
				html : msg,
				type : 'error'
			});
			return false;
		}
		else
		{
			return true;
		}

	}
</script>