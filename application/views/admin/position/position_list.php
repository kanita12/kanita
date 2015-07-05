<a href="<?php echo site_url('admin/Position/add/'); ?>">เพิ่มตำแหน่ง</a>
<table>
	<tr>
		<td>#</td>
		<td>จัดการ</td>
	</tr>
<?php
	$last_institution_id 	= 0;
	$last_department_id 	= 0;
	$now_department_id 		= 0;
	$now_insitution_id 		= 0;
?>
<?php foreach ($query as $row): ?>
	<?php
		$now_department_id = intval($row['P_DID']);
		$now_insitution_id = intval($row['D_INSID']);
	?>

	<?php if( $now_insitution_id !== $last_institution_id ): ?>
		<tr class='topic--insitution' style='background-color:green'>
			<td><?php echo $row['INSName'] ?></td>
		</tr>
	<?php $last_institution_id = $now_insitution_id;
	endif ?>

	<?php if ( $now_department_id !== $last_department_id ): ?>
		<tr class='topic--department' style='background-color:#FFC'>
			<td>แผนก ​: <?php echo $row['DName'] ?></td>
		</tr>
	<?php $last_department_id = $now_department_id; 
	endif ?>

	<tr>
		<td><?php echo $row['PName'] ?></td>
		<td>
			<a href="<?php echo site_url('admin/Position/edit/'.$row['PID']) ?>">
				แก้ไข
			</a>

			<a href="javascript:void(0);" onclick="deleteThis(this,'Position/delete','<?php echo $row['PID'] ?>');">
				ลบ
			</a>
		</td>
	</tr>
<?php endforeach ?>
</table>