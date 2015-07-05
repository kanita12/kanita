<?php

$now_wf_type = "";

?>
<table border="1">
	<tr>
		<td>#</td>
		<td>Name</td>
		<td>Desc</td>
		<td>จัดการ</td>
	</tr>
	<?php foreach ($query as $row): 
		if( $now_wf_type !== $row->WF_WFT_ID): ?>
			<tr>
				<td colspan="3"><?php echo $row->wft_name ?></td>
			</tr>
		<?php $now_wf_type = $row->WF_WFT_ID;
		endif ?>
		<tr>
			<td><?php echo $row->WFID ?></td>
			<td><?php echo $row->WFName ?></td>
			<td><?php echo $row->WFDesc ?></td>
			<td>
				
			</td>
		</tr>
	<?php endforeach ?>
</table>