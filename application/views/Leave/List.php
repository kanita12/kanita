<a href="<?php echo site_url("Leave/add"); ?>" class="btn btn-success btn-ws btn-block">เขียนใบลา</a>

<!-- ทำส่วนค้นหาใบลา-->
<div class="alert-info form__padding2">
    <b class="">ค้นหาใบลา</b>
    <br>
    <div class="form-group w-row">
        <div class="w-col w-col-5">
            <label for="select" class="col-lg-5 control-label">ประเภทการลา :</label>
            <div class="col-lg-7">
            	<?php echo form_dropdown("ddlLeaveType",$ddlLeaveType,$vddlLeaveType,"id='ddlLeaveType' class='form-control'");?>
            </div>
        </div>
        <div class="w-col w-col-5">
            <label for="select" class="col-lg-5 control-label">อยู่ในขั้นตอน :</label>
            <div class="col-lg-7">
            	<?php echo form_dropdown("ddlWorkFlow",$ddlWorkFlow,$vddlWorkFlow,"id='ddlWorkFlow' class='form-control'");?>
            </div>
        </div>
        <div class="col-lg-2 ">
            <button class="btn btn-warning" onclick="checkBeforeSubmit();">ค้นหา</button>
        </div>
    </div>
</div>


<!-- ตอนนี้ยังไม่เปลี่ยนสีเพราะโดน class CSSTableGenerator บังอยู่ แต่คิดว่าควรจะเปลี่ยนสีนะ -->
<div class="CSSTableGenerator">
	<table class='table--leave'>
		<tr>
			<td>รหัสใบลา</td>
			<td>ประเภทการลา</td>
			<td>วันที่ลา</td>
			<td>อยู่ในชั้นตอน</td>
			<td>สถานะ</td>
		</tr>
		<?php 
		$workflow_class = '';

		foreach ($query->result_array() as $row): ?>
			<?php
				switch ( $row['l_wfid'] ) 
				{
					case 1 : $workflow_class = 'wait';break;
					case 2 : $workflow_class = 'approve';break;
					case 3 : $workflow_class = 'disapprove';break;
					case 4 : $workflow_class = 'approve';break;
					case 5 : $workflow_class = 'disapprove';break;
					default: $workflow_class = 'wait';break;
				}
			?>
			<tr class='<?php echo $workflow_class ?>'>
				<td><?php echo $row["lid"]; ?></td>
				<td><?php echo $row["ltname"]; ?></td>
				<td><?php echo $row["lstartdate"]; ?> <?php echo $row["lstarttime"];?>
					<br>ถึง <?php echo $row["lenddate"]; ?> <?php echo $row["lendtime"];?>
				</td>
				<td><?php echo $row["wfname"];?></td>
				<td>
					<a href="javascript:void(0);" onclick="gotoURL('<?php echo site_url("Leave/detail/".$row["lid"]);?>');">
						รายละเอียด
					</a>
					<?php if($row["l_wfid"] == 1 || $row["l_wfid"] == 11)://1 is send request , 11 request document ?>
						<br>
						<a href="javascript:void(0);" onclick="gotoURL('<?php echo site_url("Leave/edit/".$row["l_userid"]."/".$row["lid"]);?>');">
							แก้ไข
						</a>
						<?php if ($row["l_wfid"] == 1)://only 1 can delete ?>
							<br>
							<a href="javascript:void(0);" onclick="if(checkBeforeDelete())gotoURL('<?php echo site_url("Leave/delete/".$row["lid"]);?>');">
								ลบ
							</a>
						<?php endif ?>
					<?php endif ?>
				</td>
			</tr>
		<?php endforeach ?>
	</table>
</div>
<div>
	<?php echo $paging_link; ?>
</div>

<script type='text/javascript'>
	function search_leave()
	{
		var leavetype_id = $('#ddlLeaveType').val();
		var workflow_id = $('#ddlWorkFlow').val();
		window.location.href = '<?php echo site_url() ?>'+'/Leave/search/'+leavetype_id+'/'+workflow_id;
	}
</script>