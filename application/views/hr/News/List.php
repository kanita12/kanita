<h1><?php echo $topic ?></h1>
<br/>
<a href="<?php echo site_url("hr/News/addNews"); ?>" class="addButton">เพิ่มข่าวสาร</a>
<br/><br/>
<div class="CSSTableGenerator">
<table>
	<tr>
		<td>หัวข้อข่าว</td>
		<td>โดย</td>
		<td>วันสิ้นสุด</td>
		<td>จัดการ</td>
	</tr>
<?php foreach ($query->result_array() as $row): ?>
	<tr>
		<td><a href="<?php echo site_url('hr/News/detail/'.$row["NSID"]); ?>" target="_blank"><?php echo $row["NSTopic"]; ?></a></td>
		<td><?php echo $row["NSCreatedBy"]; ?></td>
		<td>
			<?php if ($row["NSEndDate"] == null): ?>
				ไม่มีวันสิ้นสุดข่าว
			<?php else: echo $row["NSEndDate"];?>
			<?php endif ?>

		</td>
		<td>
			<a href="<?php echo site_url('hr/News/editNews/'.$row["NSID"]); ?>">แก้ไข</a>
			<a href="<?php echo site_url('hr/News/deleteNews/'.$row["NSID"]); ?>">ลบ</a>
		</td>
	</tr>
<?php endforeach ?>
</table>
</div>