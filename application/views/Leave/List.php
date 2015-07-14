<div class="row right-align">
<a href="<?php echo site_url("Leave/add"); ?>" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
</div>

<div class="row">
	<div class="input-field col s12">
		<div class="col s2 m1 l1 left-align">
			<a href="#!"><i class="medium material-icons">search</i></a>
		</div>
		<div class="col s6 m4 l3">
			<?php echo form_dropdown("ddlLeaveType",$ddlLeaveType,$vddlLeaveType,"id='ddlLeaveType'");?>
		</div>
		<div class="col s4 m3 l3">
			<?php echo form_dropdown("ddlWorkFlow",$ddlWorkFlow,$vddlWorkFlow,"id='ddlWorkFlow'");?>
		</div>
	</div>
</div>

<table class="responsive-table bordered highlight">
	<thead>
		<tr>
			<th>รหัสใบลา</th>
			<th>ประเภทการลา</th>
			<th>วันที่ลา</th>
			<th>อยู่ในชั้นตอน</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php 
		foreach ($query->result_array() as $row): ?>
			<tr>
				<td><?php echo $row["lid"]; ?></td>
				<td><?php echo $row["ltname"]; ?></td>
				<td><?php echo $row["lstartdate"]; ?> <?php echo $row["lstarttime"];?>
					<br>ถึง <?php echo $row["lenddate"]; ?> <?php echo $row["lendtime"];?>
				</td>
				<td><?php echo $row["wfname"];?></td>
				<td>
					<!-- ตรงรายละเอียด ให้ชี้แล้วมีายละเอียดขึ้นอ่านได้เลย -->
					<a href="javascript:void(0);" class="btn-floating btn-medium waves-effect waves-light blue" onclick="gotoURL('<?php echo site_url("Leave/detail/".$row["lid"]);?>');">
						<i class="material-icons">info_outline</i>
					</a>
					<?php if($row["l_wfid"] == 1 || $row["l_wfid"] == 11)://1 is send request , 11 request document ?>
							<a href="javascript:void(0);" class="btn-floating btn-medium waves-effect waves-light blue" onclick="gotoURL('<?php echo site_url("Leave/edit/".$row["l_userid"]."/".$row["lid"]);?>');">
								<i class="material-icons">edit</i>
							</a>
						<?php if ($row["l_wfid"] == 1)://only 1 can delete ?>
							<a href="javascript:void(0);" class="btn-floating btn-medium waves-effect waves-light blue" onclick="if(checkBeforeDelete())gotoURL('<?php echo site_url("Leave/delete/".$row["lid"]);?>');">
								<i class="material-icons">delete</i>
							</a>
						<?php endif ?>
					<?php endif ?>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<div>
	<?php echo $paging_link; ?>
</div>

<script type="text/javascript">
	$(document).ready(function()
	{
		$("#ddlLeaveType , #ddlWorkFlow").change(function()
		{
				var leavetype_id = $('#ddlLeaveType').val();
				var workflow_id = $('#ddlWorkFlow').val();
				window.location.href = '<?php echo site_url() ?>'+'/Leave/search/'+leavetype_id+'/'+workflow_id;
		})
	});
</script>