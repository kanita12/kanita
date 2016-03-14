<?php
	$dayNameThai = array("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์");
	$dayNameEnglish = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
?>

<h3 class="header">กะงาน</h3>
<div class="divider"></div>
<br><br>
<div class="row">
	<div class="col s12">
			<?php foreach ($queryEmpShiftwork as $row): ?>
					<?php echo $row["esw_swid"]; ?>
					<?php echo $row["swname"] ?>

					<?php 
						$query2 = $this->Shiftwork_model->getDetail($row["esw_swid"]); 
						$dataList = $query2->result_array(); 
					?>

					<div class="row">
						<div class="col s12">
							<table class="bordered highlight">
								<thead>
									<tr>
										<th rowspan="2" class="center-align">วัน</th>
										<th colspan="2" class="center-align">วันทำงาน</th>
										<th colspan="2" class="center-align">เวลา 1</th>
										<th rowspan="2" class="center-align">พัก</th>
										<th colspan="2" class="center-align">เวลา 2</th>
										<th rowspan="2" class="center-align">รวมจำนวนชั่วโมง</th>
									</tr>
									<tr>
										<th class="center-align">ใช่
										<input name="inputWorkDayAll" type="radio" id="inputWorkDayAll_1" value="1" /><label for="inputWorkDayAll_1"></label></th>
										<th class="center-align">ไม่ใช่
										<input name="inputWorkDayAll" type="radio" id="inputWorkDayAll_0" value="0" /><label for="inputWorkDayAll_0"></label></th>
										<th class="center-align">เริ่ม
										<input type="text" id="inputTimeStart1DayAll" name="inputTimeStart1DayAll" value="" readonly="true">
										</th>
										<th class="center-align">สิ้นสุด
										<input type="text" id="inputTimeEnd1DayAll" name="inputTimeEnd1DayAll" value="" readonly="true"></th>
										<th class="center-align">เริ่ม
										<input type="text" id="inputTimeStart2DayAll" name="inputTimeStart2DayAll" value="" readonly="true"></th>
										<th class="center-align">สิ้นสุด
										<input type="text" id="inputTimeEnd2DayAll" name="inputTimeEnd2DayAll" value="" readonly="true"></th>
									</tr>
								</thead>
								<tbody>
									<?php for ($i=0; $i < count($dataList); $i++): ?>
										<tr>
											<td><?php echo $dayNameThai[$i];?></td>
											<td><input name="inputWorkDay<?php echo $i; ?>" type="radio" id="inputWorkDay<?php echo $i; ?>_1" value="1" <?php if(!empty($dataList[$i]["swdiswork"]) && intVal($dataList[$i]["swdiswork"]) === 1): echo "checked"; endif; ?> /><label for="inputWorkDay<?php echo $i; ?>_1"></label></td>
											<td><input name="inputWorkDay<?php echo $i; ?>" type="radio" id="inputWorkDay<?php echo $i; ?>_0" value="0" <?php if(!empty($dataList[$i]["swdiswork"]) && intVal($dataList[$i]["swdiswork"]) === 1): echo ""; else: echo "checked"; endif; ?>/><label for="inputWorkDay<?php echo $i; ?>_0"></label></td>
											<td><input type="text" id="inputTimeStart1Day<?php echo $i; ?>" name="inputTimeStart1Day<?php echo $i; ?>" value="<?php if(!empty($dataList[$i]["swdtimestart1"])): echo timeFormatNotSecond($dataList[$i]["swdtimestart1"]); endif; ?>"></td>
											<td><input type="text" id="inputTimeEnd1Day<?php echo $i; ?>" name="inputTimeEnd1Day<?php echo $i; ?>" value="<?php if(!empty($dataList[$i]["swdtimeend1"])): echo timeFormatNotSecond($dataList[$i]["swdtimeend1"]); endif; ?>"></td>
											<td></td>
											<td><input type="text" id="inputTimeStart2Day<?php echo $i; ?>" name="inputTimeStart2Day<?php echo $i; ?>" value="<?php if(!empty($dataList[$i]["swdtimestart2"])): echo timeFormatNotSecond($dataList[$i]["swdtimestart2"]); endif; ?>"></td>
											<td><input type="text" id="inputTimeEnd2Day<?php echo $i; ?>" name="inputTimeEnd2Day<?php echo $i; ?>" value="<?php if(!empty($dataList[$i]["swdtimeend2"])): echo timeFormatNotSecond($dataList[$i]["swdtimeend2"]); endif; ?>"></td>
											<td><input type="text" id="inputTotalTimeDay<?php echo $i; ?>" name="inputTotalTimeDay<?php echo $i; ?>" value="<?php if(!empty($dataList[$i]["swdtotaltime"])): echo $dataList[$i]["swdtotaltime"]; endif; ?>" readonly></td>
										</tr>
									<?php endfor; ?>
								</tbody>
							</table>
							<br>
							<div class="col s4 input-field">
								<input type="text" id="sumHourWeek" value="0" readonly="true">
								<label for="sumHourDay">ชั่วโมงต่อสัปดาห์</label>
							</div>
							<div class="col s4 input-field">
								<input type="text" id="sumHourMonth" value="0" readonly="true">
								<label for="sumHourDay">ชั่วโมงต่อเดือน</label>
							</div>
							<div class="col s4 input-field">
								<input type="text" id="sumHourYear" value="0" readonly="true">
								<label for="sumHourDay">ชั่วโมงต่อปี</label>
							</div>
	
						</div>
					</div>
			<?php endforeach ?>
		</table>
	</div>
</div>
<script>
	$(document).ready(function(){
		sumHour();
	});
	function sumHour()
	{
		var sumWeek = 0;
		var sumMonth = 0;
		var sumYear = 0;

		$("[id^='inputTotalTimeDay']").each(function()
		{
			sumWeek += parseInt($(this).val() == "" ? 0 : $(this).val());
		});
		sumMonth = Math.ceil((sumWeek / 7) * 30);
		sumYear = sumMonth * 12;

		$("#sumHourWeek").val(sumWeek);
		$("#sumHourMonth").val(sumMonth);
		$("#sumHourYear").val(sumYear);
	}
</script>