<table>
	<tr>
		<td>#</td>
		<td>วันที่</td>
		<td>เวลา</td>
		<td>ผู้ขอ</td>
		<td>สถานะ</td>
	</tr>

<?php foreach ($query as $row): ?>
	<tr>
		<td><?php echo $row['wot_id'] ?></td>
		<td><?php echo $row['wot_date'] ?></td>
		<td><?php echo $row['wot_time_from'] ?> - <?php echo $row['wot_time_to'] ?></td>
		<td><?php echo $row['emp_fullname_thai'] ?></td>
		<td><?php echo $row['workflow_name'] ?></td>
		<td>
			<a href="<?php echo site_url('Overtime/detail/'.$row['wot_id']) ?>">
				รายละเอียด
			</a>
		</td>
	</tr>
<?php endforeach ?>
</table>