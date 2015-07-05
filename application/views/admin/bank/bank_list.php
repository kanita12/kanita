<a href="<?php echo $add_url ?>">เพิ่มธนาคาร</a>

<table>
	<tr>
		<td>#</td>
		<td>ชื่อธนาคาร</td>
		<td>คำอธิบายเพิ่มเติม</td>
		<td>จัดการ</td>
	</tr>
	<?php foreach ($query as $row): ?>
		<tr>
			<td><?php echo $row['BID'] ?></td>
			<td><?php echo $row['BName'] ?></td>
			<td><?php echo $row['BDesc'] ?></td>
			<td>
				<a href="<?php echo $edit_url.'/'.$row['BID'] ?>">
				แก้ไข
				</a>

				<a href="javascript:void(0);" onclick="deleteThis(this,'delete','<?php echo $row['BID'] ?>');">
					ลบ
				</a>
			</td>
		</tr>
	<?php endforeach ?>
</table>