<?php echo form_open($form_url) ?>
<input type="hidden" name='hd_emp_id' value='<?php echo $query['EmpID'] ?>'>
รหัสพนักงาน : <?php echo $query['EmpID'] ?>
<br>
ชื่อ-นามสกุล : <?php echo $query['EmpNameTitleThai'].$query['EmpFirstnameThai'].' '.$query['EmpLastnameThai'] ?>
<br>
หน่วยงาน : <?php echo $query['InstitutionName'] ?>
<br>
แผนก : <?php echo $query['DepartmentName'] ?>
<br>
ตำแหน่ง : <?php echo $query['PositionName'] ?>
<br>
เงินเดือนปัจจุบัน : <input type="text" id='txt_salary' name='txt_salary' value='<?php echo $query['EmpSalary'] ?>' readonly='true'>
<br>
ปรับเพิ่มขึ้น : <input type="text" id='txt_salary_increase' name='txt_salary_increase'>
<br>
รวมเป็นเงินเดือนสุทธิ : <input type="text" id='txt_salary_net' name='txt_salary_net' readonly='true'>
<br>
หมายเหตุเพิ่มเติม : <textarea name="txt_remark" id="txt_remark" cols="30" rows="10"></textarea>
<br>
<input type="submit" value='บันทึก'>
<input type="reset" value='ยกเลิก'>
<?php echo form_close(); ?>
<script type='text/javascript'>
	$(document).ready(function(){
		$('#txt_salary_increase').keyup(function(){
			if($(this).val() == '')
			{
				$('#txt_salary_net').val('');
			}
			else
			{
				var salary = $('#txt_salary').val();
				var increase = $(this).val();
				var numberonly = new RegExp("[^0-9]","g");
				if(increase.match(numberonly))
				{
					$(this).val($(this).val().slice(0,-1));
				}
				else
				{
					var net = (parseInt(salary) + parseInt(increase));
					$('#txt_salary_net').val(net);
				}
				
			}
		});
	});
</script>