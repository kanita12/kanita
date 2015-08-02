<div class="row">
	<div class=" col s12">
		<div class="input-field col s2 m2 l1 left-align">
			<a href="#!"><i class="medium material-icons">search</i></a>
		</div>
		<div class="input-field col s10 m5">
			<input type="text" id='input_keyword' name="input_keyword" value="<?php echo $value_keyword ?>">
			<label for="input_keyword">คำค้นหา</label>
		</div>
		<div class="input-field col s10 m5">
			<?php echo form_dropdown("ddlLeaveType",$ddlLeaveType,$value_leavetype,"id='ddlLeaveType'");?>
			<label for="ddlLeaveType">ประเภทการลา</label>
		</div>
		<div class="input-field col s10 offset-s2 m5">
			<?php echo form_dropdown("ddlDepartment",$ddlDepartment,$value_department,"id='ddlDepartment'");?>
			<label for="ddlDepartment">แผนก</label>
		</div>
		<div class="input-field col s10 offset-s2 m5">
			<?php echo form_dropdown("ddlPosition",$ddlPosition,$value_position,"id='ddlPosition'");?>
			<label for="ddlPosition">ตำแหน่ง</label>
		</div>
		<div class="input-field col s6 m5 offset-m2 l5 offset-l1">
			<?php echo form_dropdown("ddlYear",$ddlYear,$value_year,"id='ddlYear'");?>
			<label for="ddlYear">ปี</label>
		</div>
		<div class="input-field col s6 m5 l5">
			<?php echo form_dropdown("ddlMonth",$ddlMonth,$value_month,"id='ddlMonth'");?>
			<label for="ddlMonth">เดือน</label>
		</div>
		<div class="input-field col s3 m3 offset-m2 l2 offset-l1">
			<a href="javascript:void(0);" onclick="go_search();" class="btn" >ค้นหา</a>
		</div>
	</div>
</div>
<table class="responsive-table bordered highlight">
	<thead>
		<tr>
			<th class="center-align">เลขที่ใบลา</th>
			<th>ประเภทการลา</th>
			<th class="center-align">วันลา</th>
			<th>ผู้ลา</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($query->result_array() as $row): ?>
			<tr>
				<td class="center-align"><?php echo $row["LID"] ?></td>
				<td ><?php echo $row["LTName"] ?></td>
				<td class="center-align"><?php echo date_time_thai_format_from_db($row["LStartDate"]." ".$row["LStartTime"]); ?>
					<br>ถึง<br>
					<?php echo date_time_thai_format_from_db($row["LEndDate"]." ".$row["LEndTime"]); ?></td>
				<td>
					<p><?php echo $row["EmpFullnameThai"] ?></p>
					<p>แผนก<?php echo $row["DName"] ?></p>
					<p>ตำแหน่ง<?php echo $row["PName"] ?></p>
				</td>
				<td>
					<a href="<?php echo site_url("Leave/detail/".$row["LID"]);?>" class="btn-floating btn-medium waves-effect waves-light blue" target="_blank">
					<i class="material-icons">info_outline</i>
					</a>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<script type="text/javascript">
	function go_search()
	{
		var site_url = '<?php echo site_url(); ?>';
		var keyword = $("#input_keyword").val();
		if(keyword == ""){ keyword = 0;}
		var leavetype = $("#ddlLeaveType").val();
		var department = $("#ddlDepartment").val();
		var position = $("#ddlPosition").val();
		var year = $("#ddlYear").val();
		var month = $("#ddlMonth").val();
		var redirect_url = site_url+"hr/Verifyleave/search/"+keyword+"/"+leavetype+"/"+department+"/"+position+"/"+year+"/"+month;
		window.location.href = redirect_url;
		return false;
	}
</script>