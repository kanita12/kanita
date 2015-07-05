<h1> <?php echo $query["MSubject"]; ?></h1>
<div>
<?php echo $query["MContent"]; ?>
</div>

<div>
	<br/><br/><br/>
<?php foreach($queryReply->result_array() as $row){ ?>
<div>
	<div>
		<?php echo $row["MContent"]; ?>
	</div>
	<div>
		โดย
		<?php 
		$empDetail =  getEmployeeDetailByuserID($row["M_UserID"]);
		echo $empDetail["Username"];?>
		เมื่อ
		<?php echo $row["MCreatedDate"]; ?>
	</div>
</div>
<?php } ?>
<br/><br/>
</div>



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
