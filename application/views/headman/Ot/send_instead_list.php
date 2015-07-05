<?php echo anchor(site_url("headman/Sendotinsteadteam/add"), 'ส่งคำขอแทนผู้ใต้บังคับบัญชา'); ?>
<div>
	ผู้ใต้บังคับบัญชา <?php echo form_dropdown('select_team', $options_team,$value_team, 'id=select_team'); ?>
	ปี <?php echo form_dropdown('select_year', $options_year,$value_year, 'id=select_year'); ?>
	เดือน <?php echo form_dropdown('select_month', $options_month,$value_month,	 'id=select_month'); ?>
	<input type='submit' value='ค้นหา' onclick='search_ot()'>
</div>

<table class="table table-bordered">
	<tr>
		<td>ID</td>
		<td>ส่งแทน</td>
		<td>วันที่</td>
		<td>สถานะ</td>
	</tr>
	<?php foreach ($query as $row): ?>
		<tr>
			<td>
				<?php echo $row['wot_id'] ?>
			</td>
			<td>
				<?php echo $row["emp_fullname_thai"] ?>
				<br>
				หมายเหตุเพิ่มเติม : <?php echo $row["wot_remark"] ?>
			</td>
			<td>
				<?php echo dateThaiFormatFromDB($row['wot_date']) ?>
				<br>
				เวลา : <?php echo $row['wot_time_from'] ?> - <?php echo $row['wot_time_to'] ?>
			</td>
			<td>
				<?php echo $row['workflow_name'] ?>
			</td>
		</tr>
	<?php endforeach ?>
</table>

<script type='text/javascript'>
	function search_ot()
	{
		var year = $('#select_year').val();
		var month = $('#select_month').val();
		var team = $('#select_team').val();
		window.location.href = '<?php echo site_url() ?>'+'/headman/Sendotinsteadteam/search/'+team+'/'+year+'/'+month;
		return false;
	}
</script>