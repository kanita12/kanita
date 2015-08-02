<?php echo form_open($form_url) ?>
	<input type='hidden' name='hd_ot_id' value='<?php echo $ot_id ?>'>
	<div class="row">
	    <div class="col s4 m4 l4">รหัสพนักงาน <?php echo $emp_detail["EmpID"] ?></div>
	    <div class="col s8 m8 l8"><?php echo $emp_detail["EmpFullnameThai"] ?></div>
	    <div class="col s4 m4 l4">หน่วยงาน<?php echo $emp_detail["InstitutionName"] ?></div>
	    <div class="col s4 m4 l4">แผนก<?php echo $emp_detail["DepartmentName"] ?></div>
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
