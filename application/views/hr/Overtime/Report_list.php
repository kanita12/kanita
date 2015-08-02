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
			<th>ปี</th>
			<th>เดือน</th>
			<th>ลูกทีม</th>
			<th>สรุปจำนวนชั่วโมง</th>
			<th>สรุปรายได้</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$sum_ot = 0;
		$sum_all_hour = 0;
		foreach ($query as $row): ?>
			<tr>
				<td><?php echo year_thai($row["otpay_year"]) ?></td>
				<td><?php echo get_month_name_thai($row["otpay_month"]) ?></td>
				<td><?php echo $row["empid"]." - ".$row["EmpFullnameThai"] ?></td>
				<td><?php echo $row["otpay_hour"] ?></td>
				<td><?php echo $row["otpay_money"] ?></td>
				<td>
					<a href="<?php echo site_url("hr/Reportot/detail/".$row["otpay_id"]) ?>" class="btn-floating btn-medium waves-effect waves-light blue" target="_blank">
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
	var keyword = $("#input_keyword").val();
	var year = $('#ddlYear').val();
	var month = $('#ddlMonth').val();

	window.location.href = '<?php echo site_url() ?>'+'hr/Reportot/search/'+keyword+'/'+year+'/'+month;
	return false;
}
</script>