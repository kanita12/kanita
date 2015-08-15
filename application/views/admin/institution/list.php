<div class="row">
	<div class="col s10">
		<div class="row">
			<div class="input-field col s12">
				<div class="col s2 m1 l1 left-align">
					<a href="#!"><i class="medium material-icons">search</i></a>
				</div>
				<div class="input-field col s9 offset-s1 m9">
					<input type="text" id="txtKeyword" name="txtKeyword" value="<?php echo $vKeyword ?>">
					<label for="txtKeyword">คำค้นหา</label>
				</div>
				<div class="input-field col s12 m2">
					<a href="javascript:void(0);" onclick="go_search();" class="btn" >ค้นหา</a>
				</div>
			</div>
		</div>
	</div>
	<div class="col s2">
		<div class="row right-align">
			<a href="<?php echo site_url("admin/Institution/add"); ?>" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
		</div>
	</div>
</div>

<table class="responsive-table bordered highlight">
	<thead>
		<tr>
			<th>ชื่อหน่วยงาน</th>
			<th>คำอธิบายเพิ่มเติม</th>
			<th>จัดการ</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($query->result_array() as $row): ?>
			<tr id="trIns_<?php echo $row['INSID'];?>">
				<td id='tdInsName_<?php echo $row['INSID'];?>'><?php echo $row['INSName'] ?></td>
				<td id='tdInsDesc_<?php echo $row['INSID'];?>'><?php echo $row['INSDesc'] ?></td>
				<td id='tdInsStatus_<?php echo $row['INSID'];?>'><?php echo $row['INS_StatusName'] ?></td>
				<td>
					<a href="<?php echo site_url('admin/Institution/edit/'.$row["INSID"]) ?>" 
						class="btn-floating btn-small waves-effect waves-light blue">
						<i class="material-icons">edit</i>
					</a>
					<a href="javascript:void(0);"
						data-id="<?php echo $row["INSID"] ?>" 
						class="btn-floating btn-small waves-effect waves-light red"
						onclick="deleteThis(this,'institution/delete','<?php echo $row['INSID'] ?>');">
						<i class="material-icons">delete</i>
					</a>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<?php echo $links ?>
<script type="text/javascript">
	function go_search()
	{
		var site_url = '<?php echo site_url(); ?>';
		var keyword = $("#txtKeyword").val();
		if(keyword == ""){ keyword = "0";}
		var redirect_url = site_url+"admin/Institution/search/"+keyword+"/";
		window.location.href = redirect_url;
		return false;
	}
</script>