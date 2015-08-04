<div class="row">
	<div class="col s12">
	<table class="bordered highlight">
		<thead>
			<tr>
				<th>บริษัท</th>
				<th>ตำแหน่ง</th>
				<th>เมือง</th>
				<th>รายละเอียดงาน</th>
				<th>ระยะการทำงาน</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($query_history_work as $row): ?>
				<tr>
					<td><?php echo $row["ehw_company"]?></td>
					<td><?php echo $row["ehw_position"]?></td>
					<td><?php echo $row["ehw_district"]?></td>
					<td><?php echo $row["ehw_desc"]?></td>
					<td><?php echo dateThaiFormatFromDB($row["ehw_date_from"]);?> <br>ถึง<br> <?php echo dateThaiFormatFromDB($row["ehw_date_to"]);?></td>
				</tr>
			<?php endforeach?>
		</tbody>
	</table>
	</div>
</div>