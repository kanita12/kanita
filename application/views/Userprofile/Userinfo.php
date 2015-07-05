<?php $this->load->view("Userprofile/Primarymenu"); ?>

<?php echo form_open($form_url) ?>
<input type='hidden' name='hd_user_id' id='hd_user_id' value='<?php echo $query['UserID'] ?>'>
<input type='hidden' name='hd_emp_id' id='hd_emp_id' value='<?php echo $query['EmpID'] ?>'>

รหัสพนักงาน : <?php echo $query['EmpID'] ?>
<br>
Username : <?php echo $query['Username'] ?>
<br>
New Password : <input type='password' id='input_new_password' name='input_new_password'>
<br>
Confirm New Password : <input type='password' id='input_confirm_new_password' name='input_confirm_new_password'>
<br>
<input type='submit' value='บันทึก' onclick='return check_before_submit();'>
<?php echo form_close(); ?>

<script type='text/javascript'>
	function check_before_submit()
	{
		var new_pass = $('#input_new_password');
		var conf_new_pass = $('#input_confirm_new_password');
		if( new_pass.val() != '' && conf_new_pass.val() == '' )
		{
			swal('กรอกข้อมูลรหัสผ่านให้ครบทั้ง 2 ช่อง','','warning');
			return false;
		}
		else if( new_pass.val() != conf_new_pass.val() )
		{
			swal('กรอกข้อมูลรหัสผ่านทั้ง 2 ช่องให้ตรงกัน','','warning');
			return false;
		}
		else
		{
			return true;
		}
	}
</script>