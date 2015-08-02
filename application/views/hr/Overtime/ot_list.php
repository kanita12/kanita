<div class="row">
	<div class="col s12">
		<div class="input-field col s2 m2 l1 left-align">
			<a href="#!"><i class="medium material-icons">search</i></a>
		</div>
		<div class="input-field col s10 m5 l4">
			<input type="text" name="input_keyword" id="input_keyword" value="<?php echo $value_keyword ?>">
			<label for="input_keyword">คำค้นหา</label>
		</div>
		<div class="input-field col s5 m3 l3">
			<?php echo form_dropdown("ddlMonth",$ddlMonth,$value_month,"id='ddlMonth'");?>
			<label for="ddlMonth">เดือน</label>
		</div>
		<div class="input-field col s5 m2 l2">
			<?php echo form_dropdown("ddlYear",$ddlYear,$value_year,"id='ddlYear'");?>
			<label for="ddlYear">ปี</label>
		</div>
		<div class="input-field col s10 offset-s2 m2 l2">
			<a href="javascript:void(0);" onclick="go_search();" class="btn" >ค้นหา</a>
		</div>
	</div>
</div>
<table class="responsive-table bordered highlight">
	<thead>
		<tr>
			<th rowspan="2">#</th>
			<th rowspan="2">วันที่</th>
			<th colspan="2" class="center-align">เวลา</th>
			<th rowspan="2" class="center-align">ชั่วโมง</th>
			<th rowspan="2">ผู้ขอ</th>
			<th rowspan="2">สถานะ</th>
			<th rowspan="2">จัดการ</th>
		</tr>
		<tr>
			<th class="center-align">เริ่ม</th>
			<th class="center-align">สิ้นสุด</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($query as $row): ?>
			<tr>
				<td><?php echo $row['wot_id'] ?></td>
				<td><?php echo dateThaiFormatFromDB($row['wot_date']); ?></td>
				<td class="center-align"><?php echo $row['wot_time_from'] ?></td>
				<td class="center-align"><?php echo $row['wot_time_to'] ?></td>
				<td class="center-align"><?php echo timeDiff($row['wot_time_from'],$row["wot_time_to"]); ?>
				<td><?php echo $row['EmpFullnameThai'] ?></td>
				<td id="<?php echo $row["wot_id"] ?>_workflow_name"><?php echo $row['workflow_name'] ?></td>
				<td>
					<a href="<?php echo site_url("Overtime/detail/".$row["wot_id"]);?>" class="btn-floating btn-medium waves-effect waves-light blue" target="_blank">
						<i class="material-icons">info_outline</i>
					</a>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<script type='text/javascript'>
function go_search()
{
	var keyword = $.trim($("#input_keyword").val());
	keyword = keyword === "" ? "0" : keyword;
	var year = $('#ddlYear').val();
	var month = $('#ddlMonth').val();

	window.location.href = '<?php echo site_url() ?>'+'hr/Overtime/search/'+keyword+'/'+year+'/'+month;
	return false;
}
</script>