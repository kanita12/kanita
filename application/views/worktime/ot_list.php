<div class="row right-align">
<a href="<?php echo site_url("overtime/add"); ?>" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
</div>
<div class="row">
	<div class="col s12">
		<div class="input-field col s2 m1 l1 left-align">
			<a href="#!"><i class="medium material-icons">search</i></a>
		</div>
		<div class="input-field col s6 m4 l3">
			<?php echo form_dropdown("select_year",$options_year,$value_year,"id='select_year'");?>
			<label for="select_year">ปี</label>
		</div>
		<div class="input-field col s4 m3 l3">
			<?php echo form_dropdown("select_month",$options_month,$value_month,"id='select_month'");?>
			<label for="select_month">เดือน</label>
		</div>
	</div>
</div>

<table class="responsive-table bordered highlight">
	<thead>
		<tr>
			<td>#</td>
			<td>วันที่</td>
			<td>เวลา</td>
			<td>จนถึงเวลา</td>
			<td>สถานะ</td>
			<td>จัดการ</td>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($query as $row): ?>
			<tr>
				<td><?php echo $row['wot_id'] ?></td>
				<td><?php echo dateThaiFormatFromDB($row['wot_date']) ?></td>
				<td><?php echo $row['wot_time_from'] ?></td>
				<td><?php echo $row['wot_time_to'] ?></td>
				<td><?php echo $row['workflow_name'] ?></td>
				<td>
					<a href="javascript:void(0);" class="btn-floating btn-medium waves-effect waves-light blue" onclick="gotoURL('<?php echo site_url("Overtime/detail/".$row["wot_id"]);?>');">
						<i class="material-icons">info_outline</i>
					</a>
					<?php if($row["wot_workflow_id"] == 1)://1 is send request , 11 request document ?>
							<a href="javascript:void(0);" class="btn-floating btn-medium waves-effect waves-light blue" onclick="gotoURL('<?php echo site_url("Overtime/edit/".$row["wot_id"]);?>');">
								<i class="material-icons">edit</i>
							</a>
							<a href="javascript:void(0);" class="btn-floating btn-medium waves-effect waves-light blue" onclick="if(checkBeforeDelete())gotoURL('<?php echo site_url("Overtime/delete/".$row["wot_id"]);?>');">
								<i class="material-icons">delete</i>
							</a>
					<?php endif ?>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>

<script type='text/javascript'>
	$(document).ready(function()
	{
		$("#select_year , #select_month").change(function()
		{
			search_ot();
		});
	});
	function search_ot()
	{
		var year = $('#select_year').val();
		var month = $('#select_month').val();

		window.location.href = '<?php echo site_url() ?>'+'/Overtime/search/'+year+'/'+month;
		return false;
	}
</script>