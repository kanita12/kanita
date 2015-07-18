<table class="bordered highlight">
	<thead>
		<tr>
			<th width="70%">หัวข้อ</th>
			<th>วันที่เพิ่ม</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($query as $row): ?>
			<tr>
				<td>
					<a href="<?php echo site_url("Activity/detail/".$row["news_id"]); ?>">
						<?php echo $row["news_topic"] ?>
					</a>
				</td>
				<td><?php echo date_time_thai_format_from_db($row["news_create_date"]) ?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>