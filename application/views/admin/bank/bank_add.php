<?php echo form_open($form_url); ?>
<input type='hidden' id='hd_bank_id' name='hd_bank_id' value='<?php echo $value_bank_id ?>'>
ชื่อธนาคาร : <input type='text' name='input_bank_name' id='input_bank_name' value='<?php echo $value_bank_name ?>'>
<br>
คำอธิบายเพิ่มเติม :
<textarea name="input_bank_desc" id="input_bank_desc" cols="30" rows="10"><?php echo $value_bank_desc ?></textarea>
<br>
<input type='submit' value='บันทึก' onclick='return check_before_submit();'>
<?php echo form_close(); ?>

<script type='text/javascript'>
	function check_before_submit()
	{
		var bank_name = $('#input_bank_name');

		if( $.trim(bank_name) === '' )
		{
			swal
			({
				title: 'กรุณากรอกชื่อธนาคาร',
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
