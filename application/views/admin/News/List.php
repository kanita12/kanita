<a class="btn waves-effect waves-light" href="<?php echo site_url('admin/News/add') ?>">เพิ่มข่าว</a>
<br>
<br>
<table class="striped">
	<thead>
		<tr>
			<th data-field="news_id">ID</th>
			<th data-field="newstype_name">ประเภทข่าว</th>
			<th data-field="news_topic">หัวข้อข่าว</th>
			<th data-field="news_show_date">วันที่แสดงข่าว</th>
			<th data-field="news_latest_update_date">แก้ไขล่าสุด</th>
			<th>จัดการ</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($query as $row): ?>
			<tr>
				<td><?php echo $row["news_id"] ?></td>
				<td><?php echo $row["newstype_name"] ?></td>
				<td><?php echo $row["news_topic"] ?></td>
				<td>
					<?php if ($row["news_show_start_date"] === "0000-00-00" || $row["news_show_end_date"] === "0000-00-00"): ?>
						แสดงตลอด
					<?php else: ?>
						<?php echo $row["news_show_start_date"] ?> - <?php echo $row["news_show_end_date"] ?>
					<?php endif ?>
				</td>
				<td><?php echo date_time_thai_format_from_db($row["news_latest_update_date"]) ?></td>
				<td>
					<a href="<?php echo site_url('admin/News/edit/'.$row["news_id"]) ?>" 
						class="btn-floating btn-small waves-effect waves-light blue">
						<i class="material-icons">edit</i>
					</a>
					<a href="<?php echo site_url('admin/News/delete/') ?>"
						data-id="<?php echo $row["news_id"] ?>" 
						class="btn-floating btn-small waves-effect waves-light red"
						onclick="return delete_this(this);">
						<i class="material-icons">delete</i>
					</a>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>