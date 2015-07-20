<div class="row right-align">
<a href="<?php echo site_url("headman/Sendotinsteadteam/add"); ?>" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
</div>

<div class="row">
	<div class=" col s12">
		<div class="input-field col s2 m2 l1 left-align">
			<a href="#!"><i class="medium material-icons">search</i></a>
		</div>
		<div class="input-field col s10 m5 l4">
			<?php echo form_dropdown('select_team', $options_team,$value_team, 'id=select_team'); ?>
			<label for="ddlTeam">ผู้ใต้บังคับบัญชา</label>
		</div>
		<div class="input-field col s5 m3 l3">
			<?php echo form_dropdown('select_month', $options_month,$value_month,	 'id=select_month'); ?>
			<label for="ddlMonth">เดือน</label>
		</div>
		<div class="input-field col s5 m2 l2">
			<?php echo form_dropdown('select_year', $options_year,$value_year, 'id=select_year'); ?>
			<label for="ddlYear">ปี</label>
		</div>
		<div class="input-field col s10 offset-s2 m2 l2">
			<a href="javascript:void(0);" onclick="search_ot();" class="btn" >ค้นหา</a>
		</div>
	</div>
</div>

<table class="responsive-table bordered highlight">
	<thead>
		<tr>
			<th>#</th>
			<th>วันที่</th>
			<th>เวลา</th>
			<th>ส่งแทน</th>
			<th>สถานะ</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($query as $row): ?>
			<tr>
				<td>
					<?php echo $row['wot_id'] ?>
				</td>
				<td>
					<?php echo dateThaiFormatFromDB($row['wot_date']) ?>
				</td>
				<td>
					เวลา : <?php echo $row['wot_time_from'] ?> - <?php echo $row['wot_time_to'] ?>
				</td>
				<td>
					<?php echo $row["emp_fullname_thai"] ?>
				</td>
				<td>
					<?php echo $row['workflow_name'] ?>
				</td>
				<td>
					btn Hover เพื่อดูรายละเอียด
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
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