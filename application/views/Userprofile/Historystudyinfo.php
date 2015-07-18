<div class="row">
	<div class="col s12">
		<?php foreach ($query_history_study as $row): ?>
			<div class="col s6">
				<div class="card">
					<div class="card-content">
						<div class="row">
							<div class="col s5 right-align">
								สถานศึกษา :
								<br>
								วิชาเอก :
								<br>
								คำอธิบาย :
								<br>
								ระยะเวลา :
							</div>
							<div class="col s7">
								<?php echo $row["ehs_academy"]?><br>
								<?php echo $row["ehs_major"]?><br>
								<?php echo $row["ehs_desc"]?><br>
								<?php echo dateThaiFormatFromDB($row["ehs_date_from"]);?> <br>ถึง<br> <?php echo dateThaiFormatFromDB($row["ehs_date_to"]);?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach?>
	</div>
</div>