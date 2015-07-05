<input type="hidden" id="hdReqID" value="<?php echo $reqID ?>"/>
<?php foreach ($query->result_array() as $row): ?>
	ตำแหน่งที่ร้องขอ <?php echo $row["REPositionName"] ?>
	<br/>
	จำนวนคนที่ต้องการ <?php echo $row["REAmount"] ?>
	<br/>
	คุณสมบัติที่ต้องการ <?php echo $row["REAttribute"] ?>
	<br/>
	หมายเหตุเพิ่มเติม <?php echo $row["RERequestRemark"] ?>
	<br/>
	คำร้องขอบุคคลากรเพิ่มโดย 
	<?php 
	$empDetail = getEmployeeDetailByUserID($row["RERequestBy"]);
	echo $empDetail["EmpNameTitleThai"].$empDetail["EmpFirstnameThai"]." ".$empDetail["EmpLastnameThai"] 
	?>
	<br/>
	ส่งคำร้องขอเมื่อ <?php echo $row["RERequestDate"] ?>
<?php endforeach ?>
<?php echo form_open("headman/Requestemployee/saveApprove"); ?>
<div>
จำนวนคนที่อนุมัติ <input type="text" name="inputApproveAmount" id="inputApproveAmount"/>
<br/>
หมายเหตุเพิ่มเติม <textarea name="inputApproveRemark" id="inputApproveRemark"></textarea>
<br/>
<a href="javascript:void(0);" class="btn btn-success btn-md" onclick="approveThis();">อนุมัติ</a>
<a href="javascript:void(0);" class="btn btn-danger btn-md" onclick="disApproveThis();">ไม่อนุมัติ</a>
</div>

<script type="text/javascript">
	function approveThis()
	{
		var amount = $("#inputApproveAmount").val();
		var remark = $("#inputApproveRemark").val();
		var reqID = $("#hdReqID").val();
		if(amount == "")
		{
			swal("กรุณากรอกจำนวนคนที่อนุมัติ","","error");
			return false;
		}
		else if(isNaN(amount))
		{
			swal("กรุณากรอกจำนวนคนที่อนุมัติเป็นตัวเลขเท่านั้น","","error");
			return false;
		}
		swal({
			 title: "แน่ใจนะว่า?",
			 text: "คุณต้องการอนุมัติคำร้องขอนี้",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonColor: "#DD6B55",
			  confirmButtonText: "ใช่!!",
			  cancelButtonText:"ยกเลิก",
			  closeOnConfirm: false
		},function(){
			$.ajax({
				type:"POST",
				url: "../saveApprove",
				data: {id:reqID,status:"approve",inputApproveAmount:amount,inputApproveRemark:remark},
				async:false,
				success:function(data)
				{
					swal("ทำการอนุมัติเรียบร้อยแล้ว","","success");
				}
			});
		});
	}
	function disApproveThis()
	{
		var amount = 0;
		var remark = $("#inputApproveRemark").val();
		var reqID = $("#hdReqID").val();
		swal({
			 title: "แน่ใจนะว่า?",
			 text: "คุณไม่ต้องการอนุมัติคำร้องขอนี้",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonColor: "#DD6B55",
			  confirmButtonText: "ใช่!!",
			  cancelButtonText:"ยกเลิก",
			  closeOnConfirm: false
		},function(){
			$.ajax({
				type:"POST",
				url: "../saveApprove",
				data: {id:reqID,status:"disapprove",inputApproveAmount:amount,inputApproveRemark:remark},
				async:false,
				success:function(data)
				{
					swal("ทำการไม่อนุมัติคำร้องขอนี้เรียบร้อยแล้ว","","success");
				}
			});
		});
		
	}
</script>