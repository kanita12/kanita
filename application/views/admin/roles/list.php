<a href="<?php echo site_url('admin/roles/add'); ?>">เพิ่ม Role</a>

* ลบได้กรณีที่ไม่มีผู้ใช้คนไหนใช้งาน Role นั้นๆ อยู่
<table>
	<tr>
		<td>ID</td>
		<td>Name</td>
		<td>Manage</td>
	</tr>
<?php foreach ($query->result_array() as $row): ?>
	<tr>
		<td><?php echo floatval($row['RoleID']) ?></td>
		<td><?php echo $row['RoleName'] ?></td>
		<td>
			<a href="<?php echo site_url('admin/roles/edit/'.floatval($row['RoleID'])); ?>">แก้ไข</a>
			<a href="<?php echo site_url('admin/roles/delete/'.floatval($row['RoleID'])); ?>">ลบ</a>
		</td>
	</tr>
<?php endforeach ?>
</table>