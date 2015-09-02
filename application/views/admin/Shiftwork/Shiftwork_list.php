<div class="row">
	<div class="col s10">
		<div class="row">
			<div class="input-field col s12">
				<div class="col s2 left-align">
					<a href="#!"><i class="medium material-icons">search</i></a>
				</div>
				<div class="input-field col s7">
					<input type="text" id="inputKeyword" name="inputKeyword" value="<?php echo $valueKeyword; ?>">
					<label for="inputKeyword">คำค้นหา</label>
				</div>
				<div class="input-field col s3">
					<a href="javascript:void(0);" id="submitSearch" onclick="goSearch();" class="btn" >ค้นหา</a>
				</div>
			</div>
		</div>
	</div>
	<div class="col s2">
		<div class="row right-align">
			<a href="<?php echo site_url("admin/Shiftwork/add"); ?>" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
		</div>
	</div>
</div>
<div class="divider"></div>
<table class="bordered highlight" >
	<thead>
		<tr>
			<th>รหัสเวลา</th>
			<th>ชื่อ</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($dataList as $data): ?>
			<tr>
				<td><?php echo $data["swcode"] ?></td>
				<td><?php echo $data["swname"] ?></td>
				<td class="right-align">
					<a href="<?php echo site_url('admin/Shiftwork/detail/'.$data["swid"]) ?>" 
						class="btn-floating btn-small waves-effect waves-light blue tooltipped"
						data-position="bottom" data-tooltip="เพิ่มพนักงานลงกะ">
						<i class="material-icons">assignment_ind</i>
					</a>
					<a href="<?php echo site_url('admin/Shiftwork/detail/'.$data["swid"]) ?>" 
						class="btn-floating btn-small waves-effect waves-light blue tooltipped"
						data-position="bottom" data-tooltip="รายละเอียด">
						<i class="material-icons">info_outline</i>
					</a>
					<a href="<?php echo site_url('admin/Shiftwork/edit/'.$data["swid"]) ?>" 
						class="btn-floating btn-small waves-effect waves-light blue tooltipped"
						data-position="bottom" data-tooltip="แก้ไข">
						<i class="material-icons">edit</i>
					</a>
					<a href="javascript:void(0);"
						data-id="<?php echo $data["swid"] ?>" 
						class="btn-floating btn-small waves-effect waves-light red tooltipped"
						data-position="bottom" data-tooltip="ลบ"
						onclick="deleteThis(this,'Shiftwork/delete','<?php echo $data['swid'] ?>');">
						<i class="material-icons">delete</i>
					</a>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<script type="text/javascript">
	function goSearch()
	{
		var site_url = '<?php echo site_url(); ?>';
		var keyword = $("#inputKeyword").val();
		if(keyword === ""){ keyword = 0; }
		var redirect_url = site_url+"admin/Shiftwork/search/"+keyword+"/";
		window.location.href = redirect_url;
		return false;
	}
</script>