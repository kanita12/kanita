<?php echo form_open($form_url) ?>
<input type='hidden' id='hd_department_id' name='hd_department_id' value='<?php echo $department_id ?>'>
<div class="row">
	<div class="col s12">
		<div class="input-field col s12">
			<?php echo form_dropdown('input_institution_id', $dropdown_institution,$value_institution_id,'id=input_institution_id'); ?>
			<label for="input_institution_id">หน่วยงาน</label>
		</div>
		<div class="col s12">
			<a href="<?php echo site_url('admin/Institution/add') ?>" class="btn waves-effect waves-light">
			เพิ่มหน่วยงาน
			</a>
			<br/><br/>
		</div>
		<div class="input-field col s12">
			<input type='text' id='input_department_name' name='input_department_name' value='<?php echo $value_department_name ?>'>
			<label for="input_department_name">ชื่อแผนก</label>
		</div>
		<div class="input-field col s12">
			<textarea name="input_department_desc" id="input_department_desc" class="materialize-textarea"><?php echo $value_department_desc ?></textarea>
			<label for="input_department_desc">คำอธิบายเพิ่มเติม</label>
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
			<a href="<?php echo site_url("admin/Department") ?>" class="btn waves-effect waves-light red">ยกเลิก</a>
		</div>
	</div>
</div>
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