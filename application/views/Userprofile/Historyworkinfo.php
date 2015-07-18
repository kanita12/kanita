<div class="row">
	<div class="col s12">
		<?php foreach ($query_history_work as $row): ?>
			<div class="col s6">
				<div class="card">
					<div class="card-content">
						<div class="row">
							<div class="col s5 right-align">
								บริษัท :
								<br>
								ตำแหน่ง :
								<br>
								เมือง :
								<br>
								คำอธิบาย :
								<br>
								ระยะเวลา :
							</div>
							<div class="col s7">
								<?php echo $row["ehw_company"]?><br>
								<?php echo $row["ehw_position"]?><br>
								<?php echo $row["ehw_district"]?><br>
								<?php echo $row["ehw_desc"]?><br>
								<?php echo dateThaiFormatFromDB($row["ehw_date_from"]);?> <br>ถึง<br> <?php echo dateThaiFormatFromDB($row["ehw_date_to"]);?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach?>
	</div>
</div>