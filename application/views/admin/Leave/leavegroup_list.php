<div class="row">
	<div class="col s10">
		&nbsp;
		<!-- <div class="row">
			<div class="input-field col s12">
				<div class="col s2 m1 l1 left-align">
					<a href="#!"><i class="medium material-icons">search</i></a>
				</div>
				<div class="input-field col s9 offset-s1 m9">
					<input type="text" id="txtKeyword" name="txtKeyword" value="<?php echo $value_keyword ?>">
					<label for="txtKeyword">คำค้นหา</label>
				</div>
				<div class="input-field col s12 m2">
					<a href="javascript:void(0);" onclick="go_search();" class="btn" >ค้นหา</a>
				</div>
			</div>
		</div> -->
	</div>
	<div class="col s2">
		<div class="row right-align">
			<a href="<?php echo site_url("admin/Leavegroup/add"); ?>" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
		</div>
	</div>
</div>
<table class="responsive-table bordered highlight">
	<thead>
		<tr>
			<th>#</th>
			<th>ชื่อกรุ๊ป</th>
			<th>คำอธิบายเพิ่มเติม</th>
			<th>จัดการ</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($query->result_array() as $row): ?>
			<tr>
				<td><?php echo $row["LGID"] ?></td>
				<td><?php echo $row["LGName"] ?></td>
				<td><?php echo $row["LGDesc"] ?></td>
				<td>
					<a href="<?php echo site_url('admin/Leavegroup/edit/'.$row["LGID"]) ?>" 
						class="btn-floating btn-small waves-effect waves-light blue">
						<i class="material-icons">edit</i>
					</a>
					<a href="javascript:void(0);"
						data-id="<?php echo $row["LGID"] ?>" 
						class="btn-floating btn-small waves-effect waves-light red"
						onclick="deleteThis(this,'Leavegroup/delete','<?php echo $row['LGID'] ?>');">
						<i class="material-icons">delete</i>
					</a>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>