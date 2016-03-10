<?php echo form_open($form_url) ?>
	<input type='hidden' name='hd_ot_id' value='<?php echo $ot_id ?>'>
	<div class="row">
	    <div class="col s4 m4 l4">รหัสพนักงาน <?php echo $emp_detail["EmpID"] ?></div>
	    <div class="col s8 m8 l8"><?php echo $emp_detail["EmpFullnameThai"] ?></div>
	    <div class="col s4 m4 l4">หน่วยงาน<?php echo $emp_detail["DepartmentName"] ?></div>
	    <div class="col s4 m4 l4">แผนก<?php echo $emp_detail["SectionName"] ?></div>
	    <div class="col s4 m4 l4">ตำแหน่ง<?php echo $emp_detail["PositionName"] ?></div>
  	</div>
  	<div style="padding: 1px;-color: cadetblue;margin-top: 1%;margin-bottom: 0;">
    </div>
    <table class="responsive-table bordered highlight">
    	<thead>
    		<tr>
    			<th>ID</th>
    			<th>วันที่</th>
    			<th>เริ่มเวลา</th>
    			<th>สิ้นสุดเวลา</th>
    			<th>จำนวนชั่วโมง</th>
    		</tr>
    	</thead>
		<tbody>
			<tr>
				<td><?php echo $query["wot_id"]; ?></td>
				<td><?php echo dateThaiFormatFromDB($query["wot_date"]); ?> </td>
				<td><?php echo $query["wot_time_from"] ?></td>
				<td><?php echo $query["wot_time_to"] ?></td>
				<td><?php echo $query["wot_request_hour"] ?></td>
			</tr>
		</tbody>
	</table>
	<?php if ($can_approve): ?>
		<div class="divider"></div>
		<div class="section">
			<h4 class="header">สถานะใบขอทำงานล่วงเวลา : <?php echo $query["WFName"] ?></h4>
				<div class="input-field">
				 	<textarea name="txt_remark_approve_headman" id="txt_remark_approve_headman" class="materialize-textarea"></textarea>
			    	<label for="txt_remark_approve_headman">เนื่องจาก</label>
					<a href="javascript:void(0);" class="btn" onclick="approve_disapprove('approve','<?php echo $query["wot_request_by"] ?>','<?php echo $ot_id ?>');">อนุมัติ</a>
					<a href="javascript:void(0);" class="btn red" onclick="approve_disapprove('disapprove','<?php echo $query["wot_request_by"] ?>','<?php echo $ot_id ?>');">ไม่อนุมัติ</a>
					<!-- <a href="javascript:void(0);" class="btn orange" onclick="approve_disapprove('requestdocument','<?php echo $query["wot_request_by"] ?>','<?php echo $ot_id ?>');">ขอเอกสารเพิ่มเติม</a> -->
					<script type="text/javascript">
						function approve_disapprove(type,user_id,ot_id)
						{
							var title = '';
							var alert_success = '';
							if(type == 'approve')
							{
								title = 'ยืนยันการอนุมัติ';
								alert_success = 'อนุมัติเรียบร้อยแล้ว';
							}
							else if(type == 'disapprove')
							{
								title = 'ยืนยัน ไม่อนุมัติ!!!';
								alert_success = 'ไม่อนุมัติ เรียบร้อยแล้ว';
							}
							// else if(type == 'requestdocument')
							// {
							// 	title = 'ต้องการให้ผู้ขอลาส่งเอกสารเพิ่มเติม';
							// 	alert_success = 'บันทึกเรียบร้อยแล้ว';
							// }

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
									var site_url = "<?php echo site_url();?>"; 
									 $.ajax({
									  	url: site_url+'headman/Verifyot/approve_disapprove/',
									  	type: 'POST',
									   	data: {type:type,id:ot_id,remark:remark},
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
		</div>
	<?php endif ?>
<?php echo form_close(); ?>
<div class="divider"></div>
<div class="section">
	<div class="row">
		<div class="col s12">
			<h4 class="header">Log</h4>
			<table class="bordered highlight responsive-table">
				<thead>
					<tr>
						<th>วันที่</th>
						<th>รายละเอียด</th>
						<th>โดย</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($query_log as $row): ?>
						<tr>
							<td><?php echo date_time_thai_format_from_db($row["wotlog_date"]); ?></td>
							<td><?php echo $row["wotlog_detail"]; ?></td>
							<td><?php echo $row["EmpID"]."-".$row["EmpFullnameThai"]; ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
			
		</div>
	</div>
</div>
