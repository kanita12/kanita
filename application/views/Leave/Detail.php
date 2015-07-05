<h1>รายละเอียดใบลา</h1>
<br>
<br>
<div>
	ประเภทการลา : <?php echo $leave_detail['LTName'] ?>
	<br>
	รหัสพนักงาน : <?php echo $emp_detail['EmpID'] ?>
	<br>
	ชื่อ-นามสกุล : <?php echo $emp_detail['EmpNameTitleThai'].$emp_detail['EmpFirstnameThai'].' '.$emp_detail['EmpLastnameThai'] ?>
	<br>
	แผนก : <?php echo $emp_detail['DepartmentName'] ?>
	<br>
	ตำแหน่ง : <?php echo $emp_detail['PositionName'] ?>
	<br>
	เนื่องจาก : <?php echo $leave_detail['LBecause'] ?>
	<br>
	เพราะฉะนั้นจึงขอลาหยุดในวันที่ :
	<br>
	<?php echo dateThaiFormatFromDB($leave_detail['LStartDate']) ?> เวลา <?php echo $leave_detail['LStartTime'] ?>
	<br>
	จนถึงวันที่ <?php echo dateThaiFormatFromDB($leave_detail['LEndDate']) ?> เวลา <?php echo $leave_detail['LEndTime'] ?>
	<br>
	รวมเป็นจำนวนทั้งสิ้น <?php echo sum_show_leave_time($leave_time_detail) ?>
	<br>
	เอกสารเพิ่มเติม
	<br>
	<?php foreach ($query_leave_doc as $row): ?>
		<a href="<?php echo base_url($row['ldoc_filepath']) ?>" target="_blank"><?php echo $row['ldoc_filename'] ?></a>
	<?php endforeach ?>
	<br>
	<br>
	สถานะใบลา : <?php echo $leave_detail['WFName'] ?>

	<?php if ($can_approve === TRUE): ?>
		<div>
			<textarea name="txt_remark_approve_headman" id="txt_remark_approve_headman" cols="30" rows="10"></textarea>	
			<br>
			<a href="javascript:void(0);" onclick="approve_disapprove('approve','<?php echo $user_id ?>','<?php echo $leave_id ?>');">อนุมัติ</a>
			<a href="javascript:void(0);" onclick="approve_disapprove('disapprove','<?php echo $user_id ?>','<?php echo $leave_id ?>');">ไม่อนุมัติ</a>
			<a href="javascript:void(0);" onclick="approve_disapprove('requestdocument','<?php echo $user_id ?>','<?php echo $leave_id ?>');">ขอเอกสารเพิ่มเติม</a>
			<script type="text/javascript">
				function approve_disapprove(type,user_id,leave_id)
				{
					var title = '';
					var alert_success = '';
					if(type == 'approve')
					{
						title = 'ยืนยันการอนุมัติ';
						alert_success = 'อนุมัติใบลาเรียบร้อยแล้ว';
					}
					else if(type == 'disapprove')
					{
						title = 'ยืนยัน ไม่อนุมัติใบลานี้!!!';
						alert_success = 'ไม่อนุมัติใบลานี้ เรียบร้อยแล้ว';
					}
					else if(type == 'requestdocument')
					{
						title = 'ต้องการให้ผู้ขอลาส่งเอกสารเพิ่มเติม';
						alert_success = 'บันทึกเรียบร้อยแล้ว';
					}

					swal({
						title:title,
						type:"warning",
						showCancelButton: true,   
						confirmButtonColor: "#DD6B55",   
						confirmButtonText: "ใช่!",   
						cancelButtonText: "ไม่!",   
						closeOnConfirm: false,   
						closeOnCancel: true
					},function(isConfirm){
						if (isConfirm) 
						{
							var remark = $('#txt_remark_approve_headman').val();   
							 $.ajax({
							  	url: '../approve_disapprove_by_headman/',
							  	type: 'POST',
							   	data: {type:type,user_id:user_id,leave_id:leave_id,remark:remark},
							  })
							  .done(function() {
							  	swal("สำเร็จ!", alert_success, "success");   
							  });
						} 
					});
				}
			</script>
		</div>
	<?php endif ?>
				
</div>	


<div id='div_leave_log'>
	<?php if (count($query_log) > 0 ): ?>
	<table>
		<tr>
			<td>รายละเอียด</td>
			<td>วันที่</td>
			<td>โดย</td>
		</tr>	
	<?php foreach ($query_log as $row): ?>
		<tr>
			<td>
				<?php echo $row['LLDetail'] ?>
			</td>
			<td>
				<?php echo $row['LLDate'] ?>
			</td>
			<td>
				<?php echo $row['LLBy'] ?>
			</td>
		</tr>		
	<?php endforeach ?>
	</table>
	<?php endif ?>
</div>

