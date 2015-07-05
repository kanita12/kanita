<a href="<?php echo site_url('overtime/add') ?>">ขอทำงานล่วงเวลา</a>

<div>
	ปี <?php echo form_dropdown('select_year', $options_year,'', 'id=select_year'); ?>
	เดือน <?php echo form_dropdown('select_month', $options_month,'',	 'id=select_month'); ?>
	<input type='submit' value='ค้นหา' onclick='search_ot()'>
</div>

<table class="table table-bordered">
	<tr>
		<td>#</td>
		<td>วันที่</td>
		<td>เวลา</td>
		<td>จนถึงเวลา</td>
		<td>สถานะ</td>
		<td>จัดการ</td>
	</tr>
	<?php foreach ($query as $row): ?>
		<tr>
			<td rowspan="2">
				<?php echo $row['wot_id'] ?>
			</td>
			<td>
				<?php echo dateThaiFormatFromDB($row['wot_date']) ?>
			</td>
			<td>
				<?php echo $row['wot_time_from'] ?>
			</td>
			<td>
				<?php echo $row['wot_time_to'] ?>
			</td>
			<td rowspan="2">
				<?php echo $row['workflow_name'] ?>
			</td>
			<td rowspan="2">
				<?php if ( intval($row['wot_workflow_id']) < 2 ): ?>
					<?php echo anchor('Overtime/edit/'.$row['wot_id'], 'แก้ไข'); ?>
					<a href="javascript:void(0);" onclick="deleteThis(this,'Overtime/delete','<?php echo $row['wot_id'] ?>');">
						ลบ
					</a>
				<?php endif ?>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				หมายเหตุ : <?php echo $row['wot_remark'] ?>
			</td>
		</tr>
	<?php endforeach ?>
</table>

<script type='text/javascript'>
	function search_ot()
	{
		var year = $('#select_year').val();
		var month = $('#select_month').val();

		window.location.href = '<?php echo site_url() ?>'+'/Overtime/search/'+year+'/'+month;
	}
</script>