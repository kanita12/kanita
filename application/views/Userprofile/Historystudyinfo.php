<div class="row">
	<div class="col s12">
		<table class="bordered highlight">
			<thead>
				<tr>
					<th>สถาบันการศึกษา</th>
					<th>สาขาวิชา</th>
					<th>คำอธิบาย</th>
					<th>ระยะการทำงาน</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($query_history_study as $row): ?>
					<tr>
						<td><?php echo $row["ehs_academy"]?></td>
						<td><?php echo $row["ehs_major"]?></td>
						<td><?php echo $row["ehs_desc"]?></td>
						<td><?php echo dateThaiFormatFromDB($row["ehs_date_from"]);?> <br>ถึง<br> <?php echo dateThaiFormatFromDB($row["ehs_date_to"]);?></td>
					</tr>
				<?php endforeach?>
			</tbody>
		</table>
	</div>
</div>