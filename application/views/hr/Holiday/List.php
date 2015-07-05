<h1>วันหยุดประจำปี <?php echo $nowYear;?></h1>

<br/>

<?php if(IsRoleHR()){ ?>
<a href="javascript:void(0)" id="btnAdd" onclick="addNew();" class="addButton">เพิ่ม</a>
<br/><br/>
<?php } ?>

<?php echo form_open(site_url("Holiday/getList"));?>
<br/>
<div>
เลือกปี <?php echo form_dropdown("ddlYear",$ddlYear,$nowYear,"id='ddlYear'");?>
</div>
<br/><br/>
<?php echo form_close(); ?>


<div class="CSSTableGenerator">
<table>
	<tr>
		<td>เดือน</td>
		<td>วันที่</td>
		<td>ชื่อวันหยุด</td>
		<td>คำอธิบาย</td>
		<?php if(IsRoleHR()){ ?>
			<td>#</td>
		<?php } ?>
	</tr>
<?php foreach($query->result_array() as $row){ ?>
<tr>
	<td><?php echo getMonthName($row["HMonth"]);?></td>
	<td><?php echo $row["HDay"];?></td>
	<td><?php echo $row["HName"];?></td>
	<td><?php echo $row["HDesc"];?></td>
	<?php if(IsRoleHR()){ ?>
		<td>
			<a href="<?php echo site_url("Holiday/editHoliday/".$row["HID"]);?>">แก้ไข</a>
			<a href="<?php echo site_url("Holiday/deleteHoliday/".$row["HID"]);?>" onclick="return checkBeforeDelete();">ลบ</a>
		</td>
	<?php } ?>
</tr>
<?php } ?>
</table>
</div>

<div id="addNew" style="display:none;">
	<table>
		<tr>
			<td>
				ชื่อวันหยุด
			</td>
			<td>
				<input type="text" name="txtHName" id="txtHName" style="width:100%;"/>
			</td>
		</tr>
		<tr>
			<td>
				คำอธิบาย
			</td>
			<td>
				<textarea name="txtHDesc" id="txtHDesc" cols="50" rows="10"></textarea>
			</td>
		</tr>
		<tr>
			<td>
				วันที่
			</td>
			<td>
				<input type="text" name="txtHDate" id="txtHDate" style="width:100%;"/>
			</td>
		</tr>
	</table>
</div>
<script type="text/javascript" src="<?php echo js_url() ?>datetimepicker/jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="<?php echo js_url() ?>datetimepicker/jquery.datetimepicker.css" media="screen" title="no title" charset="utf-8" />
<script type="text/javascript">
$(document).ready(function(){
	$("[id$='ddlYear']").change(function(){
		$(this).parents("form").submit();
	});
	
});

function addNew()
{
	var addHtml = $("#addNew").html();
	swal({
		title: 'เพิ่มวันหยุด',
		html: addHtml,
		showCancelButton: true,
		closeOnConfirm: false
	},function() {
		var newName = $('#txtHName').val();
		var newDesc = $('#txtHDesc').val();
		var newDate = $('#txtHDate').val();

		if(newName =='')
		{
			alert('กรุณากรอกชื่อวันหยุด');
			return false;
		}
		if(newDate == '')
		{
			alert('กรุณาเลือกวันหยุด');
			return false;
		}
		$.ajax({
					type: "POST",
					url: 'Message/addMessage/',
					data: { txtSubject: newSubject,txtContent:newContent,hdEmpID:empID,hdUserID:userID },
					cache: false,async: false,timeout: 30000,
					success: function (data) {
							swal({
								title:'เรียบร้อยแล้ว',
								type:'success'
							},function(){
								window.location.href = window.location.href;
							});
					}
			});

	});
}

</script>