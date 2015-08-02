<div class="row">
	<div class=" col s12">
		<div class="input-field col s2 m2 l1 left-align">
			<a href="#!"><i class="medium material-icons">search</i></a>
		</div>
		<div class="input-field col s10 m5 l3">
			<input type="text" id='input_keyword' value="<?php echo $value_keyword ?>">
			<label for="input_keyword">คำค้นหา</label>
		</div>
		<div class="input-field col s12 m5 l2">
			<?php echo form_dropdown("ddlLeaveType",$ddlLeaveType,$vddlLeaveType,"id='ddlLeaveType'");?>
			<label for="input_keyword">ประเภทการลา</label>
		</div>
		<div class="input-field col s12 m7 l4">
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
			<th>อยู่ในขั้นตอน</th>
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
				<td id="<?php echo $row["LID"] ?>_workflow_name"><?php echo $row["WFName"] ?></td>
				<td>
						<a href="<?php echo site_url("Leave/detail/".$row["LID"]);?>" class="btn-floating btn-medium waves-effect waves-light blue">
						<i class="material-icons">info_outline</i>
						</a>
						<?php if($row["WFName"] === "รออนุมัติจากหัวหน้างาน Level ".$row["eh_headman_level"]): ?>
						<!-- ส่วนอนุมัติตรงนี้จะใช้ ajax ในการทำงานเพื่อให้การทำงานไหลลื่น -->
						<a href="javascript:void(0);" class="btn-floating btn-medium waves-effect waves-light"
						onclick="approve_disapprove(this,'approve','<?php echo $row["LID"]; ?>')">
						<i class="material-icons">check</i>
						</a>
						<a href="javascript:void(0);" class="btn-floating btn-medium waves-effect waves-light red"
						onclick="approve_disapprove(this,'disapprove','<?php echo $row["LID"]; ?>')">
						<i class="material-icons">close</i>
						</a>
						<?php endif ?>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<script type="text/javascript">
	var instant_page = "verifyleave/instant_approve_disapprove";
	function go_search()
	{
		var keyword = $("#input_keyword").val();
		if(keyword === ""){ keyword = 0;}
		var workflow = $("#ddlWorkFlow").val();
		var leavetype = $("#ddlLeaveType").val();
		window.location.href = "/hrsystem/headman/verifyleave/search/"+keyword+"/"+leavetype+"/"+workflow;
		return false;
	}
	function approve_disapprove(obj,type,leave_id)
	{
		var title = "";
		if(type === "approve")
		{
			title = "ยืนยันการอนุมัติ";
		}
		else if(type === "disapprove")
		{
			title = "ยืนยันการไม่อนุมัติ"
		}
		swal
		({
			title: title,   
			text: "",
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "ไม่",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "ใช่",   
		},function(IsConfirm){
			if(IsConfirm)
			{
				$.ajax({
					url: instant_page,
					type: 'POST',
					data: {type: type,id:leave_id},
					success: function(data)
					{
						var workflow_name = data;
						$("#"+leave_id+"_workflow_name").text(workflow_name);
						$(obj).parent().parent().addClass("lime lighten-3");
						$(obj).parent().children('a[href="javascript:void(0);"]').remove();
						
					}
				});		
			}
		});
		
	}
</script>