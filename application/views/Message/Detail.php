<div class="card-panel"><?php echo $query["MContent"]; ?></div>
<div class="section">
	<h4 class="header">ข้อความตอบกลับ</h4>
	<?php foreach($queryReply->result_array() as $row){ ?>
		<div class="card-panel">
			<div>
				<?php echo $row["MContent"]; ?>
			</div>
			<div>
				โดย
				<?php 
				$empDetail =  getEmployeeDetailByuserID($row["M_UserID"]);
				echo $empDetail["EmpFullnameThai"];?>
				&nbsp;เมื่อ
				<?php echo date_time_thai_format_from_db($row["MCreatedDate"]); ?>
			</div>
		</div>
	<?php } ?>
</div>
<br/>
<div class="divider"></div>
<div class="section">
	<?php echo form_open(site_url("Message/saveReply")); ?>
		<input type="hidden" name="hdMID" id="hdMID" value="<?php echo $query["MID"] ?>">
		<input type="hidden" name="hdOwnerUserID" id="hdOwnerUserID" value="<?php echo $query["M_UserID"] ?>">
		<div class="input-field col s12">
			<textarea id="txtContent" name="txtContent" class="materialize-textarea"></textarea>
			<label for="txtContent">ตอบกลับ</label>
		</div>
		<button class="btn btn-default" onclick="return checkBeforeSubmit();">บันทึก</button>
	<?php echo form_close();?>
</div>
<script type="text/javascript">
	function checkBeforeSubmit(){

		if($.trim($("[id$='txtContent']").val()) === ""){
			swal("กรุณากรอกข้อความ","","error");
			return false;
		}
		else{
			$("[id$='txtContent']").parents("form").submit();
			return false;
		}
		return false;
	}
</script>
