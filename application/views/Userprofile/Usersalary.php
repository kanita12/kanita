<div class="row">
	<div class="col s12">
		<h4 class="header">รายได้ประจำเดือน  <?php echo get_month_name_thai($query_now_salary["sapay_month"]); ?> ปี <?php echo year_thai($query_now_salary["sapay_year"]) ?></h4>
		<ul class="collection">
			<li class="collection-item">
				เงินเดือน : <?php echo $query_now_salary["sapay_salary"] ?>
			</li>
			<li class="collection-item">
				OT : <?php echo $query_now_salary["sapay_ot"] ?>
			</li>
			<li class="collection-item">
				รวมเงินได้ : <?php echo $query_now_salary["total_income"] ?>
			</li>
			<li class="collection-item">
				หักค่าประกันสังคม : <?php echo $query_now_salary["sapay_deduction"] ?>
			</li>
			<li class="collection-item">
				เงินได้สุทธิ : <?php echo $query_now_salary["total_income_deduction"] ?>
			</li>
			<li class="collection-item">
				หักภาษีเงินได้บุคคลธรรมดา : <?php echo $query_now_salary["sapay_tax"] ?>
			</li>
			<li class="collection-item">
				เงินได้สุทธิต่อเดือน : <?php echo $query_now_salary["sapay_net"] ?>
			</li>
		</ul>
		
		
		
		

	</div>
</div>
<table class="bordered highlight">
	<thead>
		<tr>
			<th>ปี</th>
			<th>เดือน</th>
			<th>เงินเดือน</th>
			<th>OT</th>
			<th>หักค่าประกันสังคม</th>
			<th>หักภาษีเงินได้บุคคลธรรมดา</th>
			<th>เงินได้สุทธิต่อเดือน</th>
			<th>วันที่ทำรายการ</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($query as $row): ?>
			<tr>
				<td><?php echo year_thai($row["sapay_year"]); ?></td>
				<td><?php echo $row["sapay_month"] ?></td>
				<td><?php echo $row["sapay_salary"] ?></td>
				<td><?php echo $row["sapay_ot"] ?></td>
				<td><?php echo $row["sapay_deduction"] ?></td>
				<td><?php echo $row["sapay_tax"] ?></td>
				<td><?php echo $row["sapay_net"] ?></td>
				<td><?php echo date_time_thai_format_from_db($row["sapay_created_date"]); ?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>