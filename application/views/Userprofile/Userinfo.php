<div class="page-header" style="background-color:red;">
	<h1>ข้อมูลพนักงาน</h1>
</div>
<div class="divider"></div>
<input type="hidden" id="hd_validation_error" name="hd_validation_error" value="<?php echo validation_errors() ?>">
<?php echo form_open() ?>
	รหัสพนักงาน : <?php echo $query['EmpID'] ?>
	<br>
	หน่วยงาน : <?php echo $query["InstitutionName"] ?>
	<br>
	แผนก : <?php echo $query["DepartmentName"] ?>
	<br>
	ตำแหน่ง : <?php echo $query["PositionName"] ?>
	<br>
	<?php foreach ($query_headman as $row): ?>
		<?php $detail = getEmployeeDetailByUserID($row["eh_headman_user_id"]); ?>
		หัวหน้าระดับที่ <?php echo $row["eh_headman_level"] ?> : <?php echo $detail["EmpFullnameThai"] ?>
		<br>
	<?php endforeach ?>
	<br>
	วันที่เริ่มงาน : <?php echo $query["EmpStartWorkDate"] ?>
	<br>
	วันที่ผ่านทดลองงาน : <?php echo $query["EmpSuccessTrialWorkDate"] ?>
	<br>
	วันที่เริ่มงาน (ตามสัญญา) : <?php echo $query["EmpPromiseStartWorkDate"] ?>
	<br>
	Username : <?php echo $query['Username'] ?>
	<br>
	New Password : <input type='password' id='input_new_password' name='input_new_password' value="<?php echo set_value("input_new_password") ?>">
	<br>
	Confirm New Password : <input type='password' id='input_confirm_new_password' name='input_confirm_new_password' value="<?php echo set_value("input_confirm_new_password") ?>">
	<br>
	<input type='submit' value='บันทึก' onclick='return check_before_submit();'>
<?php echo form_close(); ?>

<script type='text/javascript'>
	$(document).ready(function()
	{
		if($("#hd_validation_error").val() !== "")
		{
			swal(
			{
				title: "ผิดพลาด",
				html: $("#hd_validation_error").val(),
				type: "error"
			});
		}
	});
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
			return true;
		}
		else
		{
			return true;
		}

	}
</script>