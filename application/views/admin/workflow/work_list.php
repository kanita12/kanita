<?php echo anchor("admin/workflow/worker/add/","เพิ่ม Worker") ?>

<table border="1">
	<tr>
		<td>#</td>
		<td>Name</td>
		<td>Function</td>
		<td>Manage</td>
	</tr>
	<?php foreach ($query as $row): ?>
		<tr>
			<td><?php echo $row->wfw_id ?></td>
			<td><?php echo $row->wfw_name ?></td>
			<td><?php echo $row->wfw_function ?></td>
			<td>
				<?php echo anchor("admin/workflow/worker/edit/".$row->wfw_id,"Edit"); ?>
				<?php echo anchor("admin/workflow/worker/delete/".$row->wfw_id,"Delete",array("onclick"=>"return confirm('ต้องการลบ?');")); ?>
			</td>
		</tr>
	<?php endforeach ?>
</table>