<input type="hidden" id="hd_validation_error" name="hd_validation_error" value="<?php echo validation_errors()?>">
<div class="row">
	<div class="col s12 center-align">
		<img class="responsive" src="<?php echo base_url().$query["EmpPictureImg"] ?>" height="300" alt="" onerror="this.onerror=null;this.src='<?php echo base_url()."assets/images/no_image.jpg" ?>'">
	</div>
</div>
<br>
<!-- EmpID & Username -->
<div class="row">
	<div class="col s12">
		<div class="input-field col s6">
			<input readonly="true" type="text" id="input_emp_id" name="input_emp_id" value="<?php echo $query["EmpID"]?>">
			<label for="input_emp_id" class="green-text">รหัสพนักงาน</label>
		</div>
		<div class="input-field col s6">
			<input readonly="true" type="text" id="input_username" name="input_username" value="<?php echo $query["Username"]?>">
			<label for="input_username" class="green-text">Username</label>
		</div>
	</div>
</div>
<!-- Inst & Dept & Position -->
<div class="row">
	<div class="col s12">
		<div class="input-field col s4">
			<input readonly="true" type="text" id="input_inst_name" name="input_inst_name" value="<?php echo $query["InstitutionName"]?>">
			<label for="input_inst_name" class="green-text">หน่วยงาน</label>
		</div>
		<div class="input-field col s4">
			<input readonly="true" type="text" id="input_department_name" name="input_department_name" value="<?php echo $query["DepartmentName"]?>">
			<label for="input_department_name" class="green-text">แผนก</label>
		</div>
		<div class="input-field col s4">
			<input readonly="true" type="text" id="input_position_name" name="input_position_name" value="<?php echo $query["PositionName"]?>">
			<label for="input_position_name" class="green-text">ตำแหน่ง</label>
		</div>
	</div>
</div>
<!-- Headman -->
<div class="row">
	<div class="col s12">
		<?php foreach ($query_headman as $row): ?>
			<?php $detail = getEmployeeDetailByUserID($row["eh_headman_user_id"]);?>
			<div class="input-field col s4">
				<input readonly="true" type="text" id="input_inst_name" name="input_inst_name" value="<?php echo $detail["EmpFullnameThai"]?>">
				<label for="input_inst_name" class="green-text">หัวหน้าระดับที่<?php echo $row["eh_headman_level"]?></label>
			</div>
		<?php endforeach?>
	</div>
</div>
<!-- Work date -->
<div class="row">
	<div class="col s12">
		<div class="input-field col s4">
			<input readonly="true" type="text" id="input_start_work_date" name="input_start_work_date" value="<?php echo $query["EmpStartWorkDate"]?>">
			<label for="input_start_work_date" class="green-text">วันเริ่มงาน</label>
		</div>
		<div class="input-field col s4">
			<input readonly="true" type="text" id="input_success_trial_work_date" name="input_success_trial_work_date" value="<?php echo $query["EmpSuccessTrialWorkDate"]?>">
			<label for="input_success_trial_work_date" class="green-text">วันที่ผ่านทดลองงาน</label>
		</div>
		<div class="input-field col s4">
			<input readonly="true" type="text" id="input_promise_start_work_date" name="input_promise_start_work_date" value="<?php echo $query["EmpPromiseStartWorkDate"]?>">
			<label for="input_promise_start_work_date" class="green-text">วันที่เริ่มงาน (ตามสัญญา)</label>
		</div>
	</div>
</div>
<div class="row">
	<div class="col s12">
		<div class="input-field col s12">
			<input readonly="true" type="text" id="input_email" name="input_email" value="<?php echo $query["EmpEmail"]?>">
			<label for="input_email" class="green-text">E-mail</label>
		</div>
	</div>
</div>
<!-- Change Password -->
<?php echo form_open()?>
<div class="divider"></div>
<div class="section">
	<div class="row">
		<div class="col s12">
			<div class="input-field col s6">
				<input type="password" id="input_new_password" name="input_new_password" value="<?php echo set_value("input_new_password")?>">
				<label for="input_new_password">รหัสผ่านใหม่</label>
			</div>
			<div class="input-field col s6">
				<input type="password" id="input_confirm_new_password" name="input_confirm_new_password" value="<?php echo set_value("input_confirm_new_password")?>">
				<label for="input_confirm_new_password">รหัสผ่านใหม่อีกครั้ง</label>
			</div>
		</div>
	</div>
</div>
<div class="divider"></div>
<div class="section">
	<div class="row">
		<div class="col s12">
			<button type="submit" class="btn waves-effect waves-light" name="action" onclick="return check_before_submit();">บันทึก</button>
		</div>
	</div>
</div>
<?php echo form_close();?>

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
		return false;
	}
</script>