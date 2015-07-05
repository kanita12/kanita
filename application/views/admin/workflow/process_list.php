<?php echo anchor("admin/workflow/process/add/","เพิ่ม Process") ?>

<table border="1">
	<tr>
		<td>Condition</td>
		<td>Manage</td>
	</tr>

	<?php 
	$now_workflow_id = 0;
	$last_conditon_id = 0;
	$now_condition_id = 0;
	$last_now = 0;
	for ($i=0; $i < count($query) ; $i++) : ?>

		<!--workflow-->
		<?php if( $now_workflow_id !== $query[$i]["WFID"]):?>
			<tr>
				<td colspan="2" style="background-color:green;"><?php echo $query[$i]["WFName"]; ?></td>
			</tr>
		<?php 
		$now_workflow_id = $query[$i]["WFID"]; 
		endif ?>

		<!--condition-->
		<?php if( $now_condition_id !== $query[$i]["wfc_id"] ) : ?>
			<tr>
				<td>
					<?php echo $query[$i]["wfc_condition"] ?>
						<ul>
		<?php $now_condition_id = $query[$i]["wfc_id"]; endif ?>

		<!--function-->
		<li><?php echo $query[$i]["wfw_function"] ?></li>

		<!--endcondition-->
		<?php if(  !isset($query[$i+1]["wfc_id"]) || $now_condition_id !== $query[$i+1]["wfc_id"] ) : ?>
					</ul>
				</td>
				<td>
					<?php echo anchor("admin/workflow/process/edit/".$query[$i]["wfc_id"],"Edit"); ?>
					<?php echo anchor("admin/workflow/process/delete/".$query[$i]["wfc_id"],"Delete",array("onclick"=>"return confirm('ต้องการลบ?');")); ?>
				</td>
			</tr>
		<?php endif ?>


		


		


		

	<?php endfor ?>
</table>