<?php 
	$ci =& get_instance();
	$ci->load->library('Input_element'); 
?>
<h2 class="header">เพิ่มรายการ</h2>
<?php echo form_open_multipart(); ?>
<div class="row">
	<div class="col s12">
		<div class="input-field col s12">
			<input type="text" name="inputTopic" id="inputTopic" value="<?php echo set_value("inputTopic"); ?>"/>
			<label for="inputTopic">ชื่อรายการ</label>
		</div>
		<div class="input-field col s6">
			<?php echo form_dropdown("ddlYear",$queryYear,set_value("ddlYear",date("Y")),"id='ddlYear'") ?>
			<label for="ddlYear">ปี</label>
		</div>
		<div class="input-field col s6">
			<?php echo form_dropdown("ddlMonth",$queryMonth,set_value("ddlMonth",date("m")),"id='ddlMonth'") ?>
			<label for="ddlMonth">เดือน</label>
		</div>
		<div class="input-field col s3">
			<input name="inputType" type="radio" id="type_plus" value="+" checked />
      		<label for="type_plus">รายได้</label>
      		<br>
      		<input name="inputType" type="radio" id="type_minus" value="-" />
      		<label for="type_minus">รายหัก</label>
		</div>  
		<div class="input-field col s8">
			<input type="text" name="inputMoney" id="inputMoney" class="green-text" value="<?php echo set_value("inputMoney"); ?>"/>
			<label id="label_desc" for="inputMoney" class="green-text">จำนวนเงิน</label>
		</div>
		<div class="input-field col s12">
			<textarea name="inputDesc" id="inputDesc" class="materialize-textarea"></textarea>
			<label for="inputDesc">คำอธิบายเพิ่มเติม</label>
		</div>
	</div>
</div>
<div class="divider"></div>
<div class="section">
    <div class="row">
        <div class="col s2">
        		<input type="hidden" name="hd_user_id" value="<?php echo $emp_detail['UserID']; ?>" />
        		<input type="hidden" name="hd_emp_id" value="<?php echo $emp_detail['EmpID']; ?>" />
            <input type="submit" onclick="return check_before_submit();" class="btn" value="บันทึก">
        </div>
    </div>
</div>
<?php echo form_close(); ?>



<div class="input-field col s6">
	<h4 class="header">ปี
		<?php
			$ci->input_element->select_year( '', '', $year, '', '', '' );
		?>
	</h4>
</div>
<table class="responsive-table bordered highlight">
	<thead>
		<tr>
			<th width="12%">เดือน/ปี</th>
			<th>รายการ</th>
			<th>จำนวนเงิน</th>		
		</tr>
	</thead>
	<tbody>
<?php foreach ($history as $row): ?>
			<tr>
				<td><?php echo get_month_name_thai( $row['sapay_month'] ); ?></td>
				<td><?php echo $row['smmtopic']; ?></td>
				<td><?php echo $row['smmmoney']; ?></td>
				<td><?php if ($row['spldsm_smm_money'] != null): ?>
					คำนวณแล้ว
				<?php else: ?>
					รอคำนวณ
				<?php endif ?></td>
			</tr>
<?php endforeach ?>
	</tbody>
</table>

<script>
	$(document).ready(function(){
		$("#select_year").change(function(){
			var year = $("#select_year").val();
			var emp_id = "<?php echo $emp_detail['EmpID']; ?>";
			var go_url = "<?php echo site_url('hr/Moneydata/specialmoney/' . $emp_detail['EmpID']).'/'; ?>";
			go_url += year+'/';
			window.location.href = go_url;
		});
	});
</script>