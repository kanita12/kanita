<div class="row">
	<div class="col s10">
		<div class="row">
			<!-- <div class="input-field col s12">
				<div class="col s2 m1 l1 left-align">
					<a href="#!"><i class="medium material-icons">search</i></a>
				</div>
				<div class="input-field col s9 offset-s1 m4 offset-m1 l4 offset-l1">
					<?php echo form_dropdown('select_institution', $dropdown_institution, $value_institution,"id='select_institution'"); ?>
					<label for="select_institution">หน่วยงาน</label>
				</div>
				<div class="input-field col s11 offset-s1 m4 l4">
					<?php echo form_dropdown('select_department', $dropdown_department, $value_department,"id='select_department'"); ?>
					<label for="select_department">แผนก</label>
				</div>
				<div class="input-field col s12 m2 l2">
					<a href="javascript:void(0);" onclick="go_search();" class="btn" >ค้นหา</a>
				</div>
			</div> -->
		</div>
	</div>
	<div class="col s2">
		<div class="row right-align">
			<a href="<?php echo site_url("admin/roles/add"); ?>" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
		</div>
	</div>
</div>
<p class="flow-text">* ลบได้กรณีที่ไม่มีผู้ใช้คนไหนใช้งาน Role นั้นๆ อยู่</p>
<table class="bordered highlight">
	<thead>
		<tr>
			<th>#</th>
			<th>ชื่อ</th>
			<th>จัดการ</th>
		</tr>
	</thead>
	<tbody>
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
	</tbody>
</table>