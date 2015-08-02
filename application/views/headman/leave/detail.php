<!-- ไม่ใช้แล้วเพราะตอนนี้รวมกับ Leave/Detail.php เพื่อให้ทั้ง พนักงาน/หัวหน้า/ฝ่ายบุคคล ใช้รวมกันแล้ว -->

<h1>รายละเอียดใบลา</h1>
<br>
<br>
<details>
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
		<?php if ($leave_detail['LAttachFile'] != ''): ?>
			<a href="<?php echo base_url($leave_detail['LAttachFile']) ?>" target="_blank"><?php echo $leave_detail['LAttachFileName'] ?></a>
		<?php endif ?>
		<br>
		<br>
		สถานะใบลา : <?php echo $leave_detail['WFName'] ?>
		
		<?php if (is_your_headman($leave_detail['L_UserID'],$this->session->userdata('userid')) || is_hr()): ?>
			<?php if ((int)$leave_detail['L_WFID'] < 2): ?>
				<?php if (is_your_headman($leave_detail['L_UserID'],$this->session->userdata('userid'))): ?>
					<div>
						<textarea name="txt_remark_approve_headman" id="txt_remark_approve_headman" cols="30" rows="10"></textarea>	
						<br>
						<a href="javascript:void(0);" onclick="approveThis('<?php echo $leave_id ?>');">อนุมัติ</a>
						<a href="javascript:void(0);" onclick="disApproveThis('<?php echo $leave_id ?>');">ไม่อนุมัติ</a>
						<script type="text/javascript">
							function approveThis(ID)
							{
								swal({
									title:"ยืนยันการอนุมัติ",
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
										$.ajax({
								          type : "POST",
								          url : "../approve/",
								          data: {id:ID},
								          async:false,
								          success : function(data) {
								            swal("สำเร็จ!", "อนุมัติใบลาเรียบร้อยแล้ว", "success");   
								          }
								        });
										
									} 
								});
							}
							function disApproveThis(ID)
							{
								swal({
									title:"ไม่อนุมัติใบลานี้!!",
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
										$.ajax({
								          type : "POST",
								          url : "../disApprove/",
								          data: {id:ID},
								          async:false,
								          success : function(data) {
								            swal("สำเร็จ!", "ไม่อนุมัติใบลา", "success");  
								          }
								        });
										 
									} 
								});
							}
						</script>
					</div>
				<?php endif ?>
			<?php elseif ((int)$leave_detail['L_WFID'] < 4): ?>
				<?php if (is_hr()): ?>
					<div>
						<textarea name="txt_remark_approve_hr" id="txt_remark_approve_hr" cols="30" rows="10"></textarea>	
						<br>
						<a href="javascript:void(0);" onclick="approveThis('<?php echo $leave_id ?>');">อนุมัติ</a>
						<a href="javascript:void(0);" onclick="disApproveThis('<?php echo $leave_id ?>');">ไม่อนุมัติ</a>
						<script type="text/javascript">
							function approveThis(ID)
							{
								swal({
									title:"ยืนยันการอนุมัติ",
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
										$.ajax({
								          type : "POST",
								          url : "../approve/",
								          data: {id:ID},
								          async:false,
								          success : function(data) {
								            swal("สำเร็จ!", "อนุมัติใบลาเรียบร้อยแล้ว", "success");   
								          }
								        });
										
									} 
								});
							}
							function disApproveThis(ID)
							{
								swal({
									title:"ไม่อนุมัติใบลานี้!!",
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
										$.ajax({
								          type : "POST",
								          url : "../disApprove/",
								          data: {id:ID},
								          async:false,
								          success : function(data) {
								            swal("สำเร็จ!", "ไม่อนุมัติใบลา", "success");  
								          }
								        });
										 
									} 
								});
							}
						</script>
					</div>	
				<?php endif ?>
			<?php endif ?>
		<?php endif ?>
</details>	




