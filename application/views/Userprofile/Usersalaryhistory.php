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