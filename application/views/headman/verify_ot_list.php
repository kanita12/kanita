<input type="hidden" id="hd_site_url" value="<?php echo site_url() ?>">
<div class="row">
	<div class=" col s12">
		<div class="input-field col s2 m2 l1 left-align">
			<a href="#!"><i class="medium material-icons">search</i></a>
		</div>
		<div class="input-field col s10 m5 l4">
			<?php echo form_dropdown("ddlTeam",$ddlTeam,$value_team,"id='ddlTeam'");?>
			<label for="ddlTeam">ผู้ใต้บังคับบัญชา</label>
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
			<td>#</td>
			<td>วันที่</td>
			<td>เวลา</td>
			<td>ผู้ขอ</td>
			<td>สถานะ</td>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($query as $row): ?>
			<tr>
				<td><?php echo $row['wot_id'] ?></td>
				<td><?php echo dateThaiFormatFromDB($row['wot_date']); ?></td>
				<td><?php echo $row['wot_time_from'] ?> - <?php echo $row['wot_time_to'] ?></td>
				<td><?php echo $row['emp_fullname_thai'] ?></td>
				<td id="<?php echo $row["wot_id"] ?>_workflow_name"><?php echo $row['workflow_name'] ?></td>
				<td>
					<?php if($row["workflow_name"] === "รออนุมัติจากหัวหน้างาน Level ".$row["eh_headman_level"]): ?>
						<!-- Modal Trigger -->
					  <a class="modal-trigger waves-effect waves-light btn" href="#modal<?php echo $row['wot_id'];?>">อนุมัติ/ไม่อนุมัติ</a>
					  <!-- Modal Structure -->
					  <div id="modal<?php echo $row['wot_id'];?>" class="modal modal-fixed-footer">
					    <div class="modal-content">
					      <h4>อนุมัติ/ไม่อนุมัติ</h4>
					      <br><br>
					      <div class="input-field">
					      	<textarea name="<?php echo $row["wot_id"] ?>_input_remark" id="<?php echo $row["wot_id"] ?>_input_remark" class="materialize-textarea"></textarea>
		    					<label for="<?php echo $row["wot_id"] ?>_input_remark">เหตุผลเพิ่มเติม</label>
					      </div>
					    </div>
					    <div class="modal-footer">
					    	 <a href="javascript:void(0);" class="red-text modal-action modal-close waves-effect waves-red btn-flat " onclick="approve_disapprove('disapprove','<?php echo $row['wot_id'];?>',this);">ไม่อนุมัติ</a>
					      <a href="javascript:void(0);" class="green-text modal-action modal-close waves-effect waves-green btn-flat " onclick="approve_disapprove('approve','<?php echo $row['wot_id'];?>',this);">อนุมัติ</a>
					      
					    </div>
					  </div>
					<?php endif ?>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<?php echo form_open() ?>
<script type="text/javascript">
	function approve_disapprove(type,ot_id,obj)
	{
		obj = $(obj);
		var submit_page = $("#hd_site_url").val()+"headman/Verifyot/approve_disapprove";
		var remark = $("#"+ot_id+"_input_remark").val()
		$.ajax({
			url: submit_page,
			type: 'POST',
			data: {type: type,id:ot_id,remark:remark},
			success: function(data)
			{
				var workflow_name = data;
				$("#"+ot_id+"_workflow_name").text(workflow_name);
				$(obj).parent().parent().addClass("lime lighten-3");
				$(obj).parent().children('a[href="javascript:void(0);"]').remove();
				
			}
		});		
	}
	function go_search()
	{
		var emp_id = $("#ddlTeam").val();
		var month = $("#ddlMonth").val();
		var year = $("#ddlYear").val();
		var ajax_url = $("#hd_site_url").val()+"headman/Verifyot/search/"+emp_id+"/"+year+"/"+month;
		window.location.href = ajax_url;
		return false;
	}
</script>