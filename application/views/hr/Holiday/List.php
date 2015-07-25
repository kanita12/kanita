<div class="row right-align">
<a href="<?php echo site_url("hr/Holiday/add"); ?>" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
</div>
<div class="row">
	<div class="input-field col s12">
		<div class="col s2 m1 l1 left-align">
			<a href="#!"><i class="medium material-icons">search</i></a>
		</div>
		<div class="input-field col s5 m4 l3">
			<?php echo form_dropdown("ddlYear",$ddlYear,$nowYear,"id='ddlYear'");?>
			<label for="ddlYear">ปี</label>
		</div>
		<div class="input-field col s3 m3 l3">
			<?php echo form_dropdown("ddlMonth",$ddlMonth,$nowMonth,"id='ddlMonth'");?>
			<label for="ddlMonth">เดือน</label>
		</div>
		<div class="input-field col s12 m2 l2">
			<a href="javascript:void(0);" onclick="go_search();" class="btn" >ค้นหา</a>
		</div>
	</div>
</div>

<table class="responsive-table bordered highlight">
	<thead>
		<tr>
			<th>เดือน</th>
			<th>วันที่</th>
			<th>ชื่อวันหยุด</th>
			<th>คำอธิบาย</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($query->result_array() as $row){ ?>
			<tr>
				<td><?php echo get_month_name_thai($row["HMonth"]);?></td>
				<td><?php echo $row["HDay"];?></td>
				<td><?php echo $row["HName"];?></td>
				<td><?php echo $row["HDesc"];?></td>
				<td>
					<a href="<?php echo site_url('hr/Holiday/edit/'.$row["HID"]) ?>" 
						class="btn-floating btn-small waves-effect waves-light blue">
						<i class="material-icons">edit</i>
					</a>
					<a href="<?php echo site_url('hr/Holiday/delete/') ?>"
						data-id="<?php echo $row["HID"] ?>" 
						class="btn-floating btn-small waves-effect waves-light red"
						onclick="return delete_this(this);">
						<i class="material-icons">delete</i>
					</a>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<script type="text/javascript">
	function go_search()
	{
		var year = $("#ddlYear").val();
		var month = $("#ddlMonth").val();
		var site_url = "<?php echo site_url() ?>";
		var redirect_url = site_url+"hr/Holiday/search/"+year+"/"+month;
		window.location.href = redirect_url;
		e.preventDefault();
	}
</script>