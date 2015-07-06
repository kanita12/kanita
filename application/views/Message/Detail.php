<h1> <?php echo $query["MSubject"]; ?></h1>
<div>
<?php echo $query["MContent"]; ?>
</div>
<br/>
<br/>
<br/>
<div>
	<?php foreach($queryReply->result_array() as $row){ ?>
		<div class="message__reply">
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
<br/>
<style type="text/css">
.message__reply
{
	border:1px solid #000;
	padding: 10px;
}
</style>
<?php
echo form_open(site_url("Message/saveReply"));
echo form_hidden("hdMID",$query["MID"]);
echo form_hidden("hdOwnerUserID",$query["M_UserID"]);
?>

<div>
ตอบกลับ<br/>
<?php echo form_textarea("txtContent","","id='txtContent'");?>
<br/>
<button class="btn btn-default" onclick="checkBeforeSubmit();">บันทึก</button>
</div>
<?php echo form_close();
 ?>
<script type="text/javascript">
function checkBeforeSubmit(){
	if($("[id$='txtContent']").val() == ""){
		alert("กรุณากรอกข้อความ");
	}
	else{
		$("[id$='txtContent']").parents("form").submit();
	}
	return false;
}
</script>
