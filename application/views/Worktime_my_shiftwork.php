<?php
	$dayNameThai = array("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์");
	$dayNameEnglish = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
?>
<div class="row">
	<div class="col s12">
		<?php if (!empty($empDetail)): ?>
			<div class="input-field col s12">
				<input type="text" value="<?php echo $empDetail["EmpFullnameThai"]; ?>">
				<label for="inputCode">ชื่อ-นามสกุล</label>
			</div>
		<?php endif ?>
		<div class="input-field col s12">
			<input type="text" id="inputCode" name="inputCode" value="<?php echo $dataDetail["swcode"]; ?>">
			<label for="inputCode">รหัสเวลา</label>
		</div>
		<div class="input-field col s12">
			<input type="text" id="inputName" name="inputName" value="<?php echo $dataDetail["swname"]; ?>">
			<label for="inputName">ชื่อ</label>
		</div>
		<div class="input-field col s12">
			<textarea name="inputDesc" id="inputDesc" class="materialize-textarea"><?php echo $dataDetail["swdesc"]; ?></textarea>
			<label for="inputDesc">คำอธิบาย</label>
		</div>
	</div>
</div>
<div class="row">
	<div class="col s12">
		<table class="bordered highlight">
			<thead>
				<tr>
					<th rowspan="2" class="center-align">วัน</th>
					<th colspan="2" class="center-align">เวลา 1</th>
					<th rowspan="2" class="center-align">พัก</th>
					<th colspan="2" class="center-align">เวลา 2</th>
					<th rowspan="2" class="center-align">รวมจำนวนชั่วโมง</th>
				</tr>
				<tr>
					<th class="center-align">เริ่ม</th>
					<th class="center-align">สิ้นสุด</th>
					<th class="center-align">เริ่ม</th>
					<th class="center-align">สิ้นสุด</th>
				</tr>
			</thead>
			<tbody>
				<?php for ($i=0; $i < count($dayNameThai); $i++): ?>
					<?php if(!empty($dataList[$i]["swdtimestart1"])): ?>
						<tr>
							<td><?php echo $dayNameThai[$i];?></td>	
							<td><input type="text" id="inputTimeStart1Day<?php echo $i; ?>" name="inputTimeStart1Day<?php echo $i; ?>" value="<?php if(!empty($dataList[$i]["swdtimestart1"])): echo timeFormatNotSecond($dataList[$i]["swdtimestart1"]); endif; ?>" readonly="true"></td>
							<td><input type="text" id="inputTimeEnd1Day<?php echo $i; ?>" name="inputTimeEnd1Day<?php echo $i; ?>" value="<?php if(!empty($dataList[$i]["swdtimeend1"])): echo timeFormatNotSecond($dataList[$i]["swdtimeend1"]); endif; ?>" readonly="true"></td>
							<td></td>
							<td><input type="text" id="inputTimeStart2Day<?php echo $i; ?>" name="inputTimeStart2Day<?php echo $i; ?>" value="<?php if(!empty($dataList[$i]["swdtimestart2"])): echo timeFormatNotSecond($dataList[$i]["swdtimestart2"]); endif; ?>" readonly="true"></td>
							<td><input type="text" id="inputTimeEnd2Day<?php echo $i; ?>" name="inputTimeEnd2Day<?php echo $i; ?>" value="<?php if(!empty($dataList[$i]["swdtimeend2"])): echo timeFormatNotSecond($dataList[$i]["swdtimeend2"]); endif; ?>" readonly="true"></td>
							<td><input type="text" id="inputTotalTimeDay<?php echo $i; ?>" name="inputTotalTimeDay<?php echo $i; ?>" value="<?php if(!empty($dataList[$i]["swdtotaltime"])): echo $dataList[$i]["swdtotaltime"]; endif; ?>" readonly="true"></td>
						</tr>
					<?php endif; ?>
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
<script type="text/javascript">
	$(document).ready(function()
	{
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