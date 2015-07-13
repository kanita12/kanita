<div class="row">
	<div class=" col s12">
		<div class="input-field col s2 m2 l1 left-align">
			<a href="#!"><i class="medium material-icons">search</i></a>
		</div>
		<div class="input-field col s10 m4 l4">
			<input type="text" id='input_keyword' value="<?php echo $value_keyword ?>">
			<label for="input_keyword">คำค้นหา</label>
		</div>
		<div class="input-field col s12 m4 l5">
			<?php echo form_dropdown("ddlLeaveType",$ddlLeaveType,$vddlLeaveType,"id='ddlLeaveType'");?>
			<label for="input_keyword">ประเภทการลา</label>
		</div>
		<div class="input-field col s12 m4 l5">
			<?php echo form_dropdown("ddlWorkFlow",$ddlWorkFlow,$vddlWorkFlow,"id='ddlWorkFlow'");?>
			<label for="input_keyword">อยู่ในขั้นตอน</label>
		</div>
		<div class="input-field col s12 m2 l2">
			<a href="javascript:void(0);" onclick="go_search();" class="btn" >ค้นหา</a>
		</div>
	</div>
</div>

<table class="responsive-table bordered highlight">
	<thead>
		<tr>
			<th>เลขที่ใบลา</th>
			<th>ประเภทการลา</th>
			<th>วันลา</th>
			<th>ผู้ลา</th>
			<th>สถานะ</th>
			<th>จัดการ</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($query->result_array() as $row): ?>
			<tr>
				<td class="center-align"><?php echo $row["LID"] ?></td>
				<td class="center-align"><?php echo $row["LTName"] ?></td>
				<td><?php echo date_time_thai_format_from_db($row["LStartDate"]." ".$row["LStartTime"]); ?>
					<br>ถึง<br>
					<?php echo date_time_thai_format_from_db($row["LEndDate"]." ".$row["LEndTime"]); ?></td>
				<td><?php echo $row["EmpFirstnameThai"]." ".$row["EmpLastnameThai"] ?></td>
				<td><?php echo $row["WFName"] ?></td>
				<td>
						<a href="<?php echo site_url("Leave/detail/".$row["LID"]);?>" class="btn-floating btn-medium waves-effect waves-light blue">
						<i class="material-icons">info_outline</i>
						</a>
						<?php if($row["WFName"] === "รออนุมัติจากหัวหน้างาน Level ".$row["eh_headman_level"]): ?>
						<!-- ส่วนอนุมัติตรงนี้จะใช้ ajax ในการทำงานเพื่อให้การทำงานไหลลื่น -->
						<a href="<?php echo site_url("Leave/detail/".$row["LID"]);?>" class="btn-floating btn-medium waves-effect waves-light ">
						<i class="material-icons">check</i>
						</a>
						<a href="<?php echo site_url("Leave/detail/".$row["LID"]);?>" class="btn-floating btn-medium waves-effect waves-light red">
						<i class="material-icons">close</i>
						</a>
						<?php endif ?>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<script type="text/javascript">
	function go_search()
	{
		var keyword = $("#input_keyword").val();
		if(keyword === ""){ keyword = 0;}
		var workflow = $("#ddlWorkFlow").val();
		var leavetype = $("#ddlLeaveType").val();
		window.location.href = "/hrsystem/headman/verifyleave/search/"+keyword+"/"+leavetype+"/"+workflow;
		return false;
	}
</script>