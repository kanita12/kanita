<?php echo anchor("admin/workflow/condition/add/","เพิ่ม Condition") ?>

<table border="1">
	<tr>
		<td>#</td>
		<td>Workflow</td>
		<td>Condition</td>
		<td>Next Workflow</td>
	</tr>
	<?php foreach ($query as $row): ?>
		<tr>
			<td><?php echo $row->wfc_id ?></td>
			<td><?php echo $row->now_workflow_name ?></td>
			<td><?php echo $row->wfc_condition ?></td>
			<td><?php echo $row->next_workflow_name ?></td>
			<td>
				<?php echo anchor("admin/workflow/condition/edit/".$row->wfc_id,"Edit"); ?>
				<?php echo anchor("admin/workflow/condition/delete/".$row->wfc_id,"Delete",array("onclick"=>"return confirm('ต้องการลบ?');")); ?>
			</td>
		</tr>
	<?php endforeach ?>
</table>