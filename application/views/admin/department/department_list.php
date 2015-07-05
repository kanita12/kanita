<a href='<?php echo site_url('admin/Department/add') ?>'>เพิ่มแผนก</a>
<table>
	<tr>
		<td>#</td>
		<td>หน่วยงาน</td>
		<td>ชื่อแผนก</td>
		<td>คำอธิบาย</td>
		<td>จัดการ</td>
	</tr>
	<?php foreach ($query as $row): ?>
		<tr>
			<td><?php echo $row['DID'] ?></td>
			<td><?php echo $row['INSName'] ?></td>
			<td><?php echo $row['DName'] ?></td>
			<td><?php echo $row['DDesc'] ?></td>
			<td>
				<a href="<?php echo site_url('admin/Department/edit/'.$row['DID']) ?>">
					แกไ้ข
				</a>
				<a href="javascript:void(0);" onclick="deleteThis(this,'Department/delete/','<?php echo $row['DID'] ?>');">
					ลบ
				</a>
			</td>
		</tr>
	<?php endforeach ?>
</table>