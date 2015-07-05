<a href="<?php echo site_url('admin/Worktime/add_ot_condition/'); ?>">เพิ่มเงื่อนไขการแลกเวลาทำ OT</a>
<br>
<table>
	<tr>
		<td>#</td>
		<td>จำนวนชั่วโมง OT</td>
		<td>แลกเป็นเงิน</td>
		<td>แลกเป็นวันหยุด</td>
		<td>จัดการ</td>
	</tr>
	<?php foreach ($query as $row): ?>
		<tr>
			<td><?php echo $row['wotcond_id'] ?></td>
			<td><?php echo $row['wotcond_ot_hour'] ?></td>
			<td><?php echo $row['wotcond_money'] ?></td>
			<td><?php echo $row['wotcond_leave'] ?></td>
			<td>
				<a href="<?php echo site_url('admin/Worktime/edit_ot_condition/'.$row['wotcond_id']) ?>">แก้ไข</a>
				<a href="#" onclick="deleteThis(this,'<?php echo site_url('admin/Worktime/delete_ot_condition/') ?>','<?php echo $row['wotcond_id'] ?>');">ลบ</a>
			</td>
		</tr>
	<?php endforeach ?>
</table>

<script type='text'