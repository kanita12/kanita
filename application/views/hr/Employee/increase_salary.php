<?php echo form_open($form_url) ?>
<input type="hidden" name='hd_emp_id' value='<?php echo $query['EmpID'] ?>'>
<div id="card_userdetail" class="card-panel center light-blue lighten-5">
    <a href="javascript:void(0);" class="waves-effect waves-teal btn-flat">
    	รหัสพนักงาน <?php echo $query["EmpID"] ?>
    </a>
    <a href="javascript:void(0);" class="waves-effect waves-teal btn-flat">
    	<?php echo $query["EmpFullnameThai"] ?>
    </a>
    <a href="javascript:void(0);" class="waves-effect waves-teal btn-flat">
    	หน่วยงาน <?php echo $query["InstitutionName"] ?>
    </a>
    <a href="javascript:void(0);" class="waves-effect waves-teal btn-flat">
    	แผนก <?php echo $query["DepartmentName"] ?>
    </a>
    <a href="javascript:void(0);" class="waves-effect waves-teal btn-flat">
    	ตำแหน่ง <?php echo $query["PositionName"] ?>
    </a>
</div>
<div class="row">
	<div class="input-field col s12">
		<input type="number" id='txt_salary' name='txt_salary' value='<?php echo $query['EmpSalary'] ?>' readonly='true'>
		<label for="txt_salary">เงินเดือนปัจจุบัน</label>
	</div>
	<div class="input-field col s12">
		<input type="number" id='txt_salary_net' name='txt_salary_net'>
		<label for="txt_salary_net">ปรับเพิ่มขึ้นเป็น</label>
	</div>
	<div class="input-field col s12">
		<textarea name="txt_remark" id="txt_remark" class="materialize-textarea"></textarea>
		<label for="txt_remark">หมายเหตุเพิ่มเติม</label>
	</div>
	<div class="input-field col s6">
		<input type="number" id='txt_salary_increase' name='txt_salary_increase' readonly='true' value="0">
		<label for="txt_salary_increase">ปรับเพิ่มขึ้นจากเงินเดือนเก่า</label>
	</div>
	<div class="input-field col s6">
		<input type="number" id='txt_salary_percent' name='txt_salary_percent' readonly='true' value="0">
		<label for="txt_salary_percent">คิดเป็นเปอร์เซ็นต์จากเงินเดือนเก่า</label>
	</div>

</div>
<div class="divider"></div>
<div class="section">
    <div class="row">
        <div class="col s2">
            <input type="submit" onclick="return check_before_submit();" class="btn" value="บันทึก">
        </div>
        <div class="col s2 offset-s6 m2 offset-m8 right-align"> 
            <a href="<?php echo site_url('hr/Employees') ?>" class="btn red lighten-1 right-align">ยกเลิก</a>
        </div>
    </div>
</div>
<?php echo form_close(); ?>
<script type='text/javascript'>
	$(document).ready(function(){
		$("#txt_salary_net").keydown(function (e) {

	        // Allow: backspace, delete, tab, escape, enter and .
	        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
	             // Allow: Ctrl+A, Command+A
	            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
	             // Allow: home, end, left, right, down, up
	            (e.keyCode >= 35 && e.keyCode <= 40)) {
	            // let it happen, don't do anything
	            
	            
	            return;
	        }
	        // Ensure that it is a number and stop the keypress
	        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
	            e.preventDefault();
	        }
	        
    	}).keyup(function (e) 
    	{
    		calc_increase_and_percent();
    	});
	});
	function calc_increase_and_percent()
	{
		var from = parseInt($("#txt_salary").val());
		var to = parseInt($("#txt_salary_net").val());
		var increase = to - from;
		$("#txt_salary_increase").val(increase);
		if(from === 0) {from = 1;}
		var percent = ((to-from)*100)/from;
		$("#txt_salary_percent").val(percent);

	}
	function check_before_submit()
	{

	}
</script>