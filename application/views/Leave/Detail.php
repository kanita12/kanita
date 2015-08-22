<div class="row">
	<div class="col s12">
			<h4 class="header">รายละเอียดผู้ลา</h4>
			<div class="col s6">
				<table>
					<tr>
						<td>รหัสพนักงาน</td>
						<td>:</td>
						<td><?php echo $emp_detail["EmpID"];?></td>
					</tr>
					<tr>
						<td>ชื่อ-นามสกุล</td>
						<td>:</td>
						<td><?php echo $emp_detail["EmpFullnameThai"];?></td>
					</tr>
					<tr>
						<td>แผนก</td>
						<td>:</td>
						<td><?php echo $emp_detail["DepartmentName"];?></td>
					</tr>
					<tr>
						<td>ตำแหน่ง</td>
						<td>:</td>
						<td><?php echo $emp_detail["PositionName"];?></td>
					</tr>
					<?php $headman_detail = get_headman_detail_by_employee_user_id($emp_detail['UserID']); ?>
					<?php if ( count($headman_detail) > 0 ) : ?>
						<tr>
							<td>หัวหน้างาน</td>
							<td>:</td>
							<td><?php echo $headman_detail["EmpFullnameThai"];?></td>
						</tr>
						<tr>
							<td>ประจำแผนก</td>
							<td>:</td>
							<td><?php echo $headman_detail["DepartmentName"];?></td>
						</tr>
					<?php endif ?>
				</table>
			</div>
	</div>
</div>
<div class="row">
	<div class="col s12">
		<h4 class="header">รายละเอียดการลา</h4>
		<div class="input-field col s12">
			<input readonly="true" type="text" id="leave_type" value="<?php echo $leave_detail['LTName'] ?>">
			<label for="leave_type">ประเภทการลา</label>
		</div>
		<div class="input-field col s12">
		 	<textarea readonly="true" name="txtBecause" id="txtBecause" class="materialize-textarea"><?php echo $leave_detail['LBecause'] ?></textarea>
	    <label for="txtBecause">เนื่องจาก</label>
	  </div>
	</div>
</div>
<div class="row">
	<div class="col s12">
		<div class="input-field col s3">
			<input readonly="true" type="text" id="txtStartDate" name="txtStartDate" value="<?php echo dateThaiFormatUn543FromDB($leave_detail['LStartDate']); ?>">
			<label for="txtStartDate">วันที่ขอลา</label>
		</div>
		<div class="input-field col s2">
			<input readonly="true" type="text" id="txtStartTime" name="txtStartTime" value="<?php echo timeFormatNotSecond($leave_detail['LStartTime']); ?>">
			<label for="txtStartTime">เวลา</label>
		</div>
		<div class="input-field col s2">
			&nbsp;
		</div>
		<div class="input-field col s3">
			<input readonly="true" type="text" id="txtEndDate" name="txtEndDate" value="<?php echo dateThaiFormatUn543FromDB($leave_detail['LEndDate']); ?>">
			<label readonly="true" for="txtEndDate">ลาถึงวันที่</label>
		</div>
		<div class="input-field col s2">
			<input readonly="true" type="text" id="txtEndTime" name="txtEndTime" value="<?php echo timeFormatNotSecond($leave_detail['LEndTime']); ?>">
			<label for="txtEndTime">เวลา</label>
		</div>
	</div>
</div>

<div class="row">
	<div class="col s12">
		<div id="div_document">
				<?php if(count($query_leave_doc) > 0): ?> 
					<ul class="collection with-header"><li class="collection-header"><h4>เอกสาร</h4></li>
						<?php foreach ($query_leave_doc as $row): ?>						
			        <li class="collection-item">
			        	<div>
			        		<a href="<?php echo base_url($row["ldoc_filepath"]) ?>">
			        			<?php echo $row['ldoc_filename'] ?>
			        		</a>
			        	</div>
			        </li>
					<?php endforeach ?>
					</ul>
				<?php endif ?>
			</div>
	</div>
</div>
<div class="divider"></div>
<div class="section">
	<h4 class="header">สถานะใบลา : <?php echo $leave_detail['WFName'] ?></h4>
	<?php if ($can_approve === TRUE): ?>
		<div class="input-field">
		 	<textarea name="txt_remark_approve_headman" id="txt_remark_approve_headman" class="materialize-textarea"></textarea>
	    <label for="txt_remark_approve_headman">เนื่องจาก</label>
			<a href="javascript:void(0);" class="btn" onclick="approve_disapprove('approve','<?php echo $user_id ?>','<?php echo $leave_id ?>');">อนุมัติ</a>
			<a href="javascript:void(0);" class="btn red" onclick="approve_disapprove('disapprove','<?php echo $user_id ?>','<?php echo $leave_id ?>');">ไม่อนุมัติ</a>
			<a href="javascript:void(0);" class="btn orange" onclick="approve_disapprove('requestdocument','<?php echo $user_id ?>','<?php echo $leave_id ?>');">ขอเอกสารเพิ่มเติม</a>
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
							  	swal({
							  		title:"สำเร็จ!", 
							  		html: alert_success, 
							  		type:"success"
							  	},function(){
							  		window.location.href = window.location.href;
							  	}); 

							  });
						} 
					});
				}
			</script>
		</div>
		<br><br>
	<?php endif ?>
</div>
<div class="divider"></div>
<div class="section">
	<h4 class="header">Log</h4>
	<div id="div_leave_log">
		<?php if (count($query_log) > 0 ): ?>
		<table class="bordered highlight">
			<thead>
			<tr>
				<th width="60%">รายละเอียด</th>
				<th>วันที่</th>
				<th>โดย</th>
			</tr>	
		</thead>
		<tbody>
		<?php foreach ($query_log as $row): ?>
			<tr>
				<td>
					<?php echo $row['LLDetail'] ?>
				</td>
				<td>
					<?php echo date_time_thai_format_from_db($row['LLDate']) ?>
				</td>
				<td>
					<?php echo $row['EmpID'] ?>
				</td>
			</tr>		
		<?php endforeach ?>
	</tbody>
		</table>
		<?php endif ?>
	</div>
</div>
</div>



<div>

	<!-- รวมเป็นจำนวนทั้งสิ้น <?php echo sum_show_leave_time($leave_time_detail) ?> -->


	
				
</div>	




