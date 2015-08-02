<div class="row">
    <div class="col s4 m4 l4">รหัสพนักงาน <?php echo $emp_detail["EmpID"] ?></div>
    <div class="col s8 m8 l8"><?php echo $emp_detail["EmpFullnameThai"] ?></div>
    <div class="col s4 m4 l4">หน่วยงาน<?php echo $emp_detail["InstitutionName"] ?></div>
    <div class="col s4 m4 l4">แผนก<?php echo $emp_detail["DepartmentName"] ?></div>
    <div class="col s4 m4 l4">ตำแหน่ง<?php echo $emp_detail["PositionName"] ?></div>
	</div>
	<div style="padding: 1px;-color: cadetblue;margin-top: 1%;margin-bottom: 0;">
</div>
<div class="card-panel center-align">
	<a href="javascript:void(0);" class="waves-effect waves-teal btn-flat">ปี <?php echo year_thai($query_pay["otpay_year"]) ?></a>
	<a href="javascript:void(0);" class="waves-effect waves-teal btn-flat">เดือน <?php echo get_month_name_thai($query_pay["otpay_month"]) ?></a>
	<a href="javascript:void(0);" class="waves-effect waves-teal btn-flat">สรุปจำนวนชั่วโมง	<?php echo $query_pay["otpay_hour"] ?> ชั่วโมง</a>
	<a href="javascript:void(0);" class="waves-effect waves-teal btn-flat">สรุปรายได้ <?php echo $query_pay["otpay_money"] ?> บาท</a>			
</div>
<h4 class="header">รายละเอียด</h4>
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
		<?php foreach ($query_ot as $row): ?>
			<tr>
				<td><?php echo $row["wot_id"]; ?></td>
				<td><?php echo dateThaiFormatFromDB($row["wot_date"]); ?> </td>
				<td><?php echo $row["wot_time_from"] ?></td>
				<td><?php echo $row["wot_time_to"] ?></td>
				<td><?php echo $row["wot_request_hour"] ?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>