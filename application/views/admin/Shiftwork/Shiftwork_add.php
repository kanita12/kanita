<?php
	$dayNameThai = array("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์");
	$dayNameEnglish = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
?>
<input type="hidden" id="hd_validation_errors" value="<?php echo validation_errors(); ?>">
<?php echo form_open(); ?>
<input type="hidden" id="hdId" name="hdId" value="<?php echo $valueId; ?>">
<input type="hidden" id="hdWorkDayId" name="hdWorkDayId" value="<?php echo $valueWorkDayId; ?>">
<div class="row">
	<div class="col s12">
		<div class="input-field col s12">
			<input type="text" id="inputCode" name="inputCode" value="<?php echo $valueCode; ?>">
			<label for="inputCode">รหัสเวลา</label>
		</div>
		<div class="input-field col s12">
			<input type="text" id="inputName" name="inputName" value="<?php echo $valueName; ?>">
			<label for="inputName">ชื่อ</label>
		</div>
		<div class="input-field col s12">
			<textarea name="inputDesc" id="inputDesc" class="materialize-textarea"><?php echo $valueDesc; ?></textarea>
			<label for="inputDesc">คำอธิบาย</label>
		</div>
	</div>
</div>
<div class="row">
	<div class="col s12">
		<table class="bordered highlight">
			<thead>
				<tr>
					<th rowspan="2">วัน</th>
					<th colspan="2">วันทำงาน</th>
					<th colspan="2">เวลา 1</th>
					<th rowspan="2">พัก</th>
					<th colspan="2">เวลา 2</th>
					<th rowspan="2">รวมจำนวนชั่วโมง</th>
				</tr>
				<tr>
					<th>ใช่
					<input name="inputWorkDayAll" type="radio" id="inputWorkDayAll_1" value="1" /><label for="inputWorkDayAll_1"></label></th>
					<th>ไม่ใช่
					<input name="inputWorkDayAll" type="radio" id="inputWorkDayAll_0" value="0" /><label for="inputWorkDayAll_0"></label></th>
					<th>เริ่ม
					<input type="text" id="inputTimeStart1DayAll" name="inputTimeStart1DayAll" value="">
					</th>
					<th>สิ้นสุด
					<input type="text" id="inputTimeEnd1DayAll" name="inputTimeEnd1DayAll" value=""></th>
					<th>เริ่ม
					<input type="text" id="inputTimeStart2DayAll" name="inputTimeStart2DayAll" value=""></th>
					<th>สิ้นสุด
					<input type="text" id="inputTimeEnd2DayAll" name="inputTimeEnd2DayAll" value=""></th>
				</tr>
			</thead>
			<tbody>
				<?php for ($i=0; $i < count($dayNameThai); $i++): ?>
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
	</div>
</div>
<div class="divider"></div>
<div class="section">
    <div class="row">
        <div class="col s2">
            <input type="submit" onclick="return checkBeforeSubmit();" class="btn" value="บันทึก">
        </div>
        <div class="col s2 offset-s6 m2 offset-m8 right-align"> 
            <a href="<?php echo site_url('admin/Shiftwork') ?>" class="btn red lighten-1 right-align">ยกเลิก</a>
        </div>
    </div>
</div>
<?php echo form_close(); ?>
<script type="text/javascript" src="<?php echo js_url() ?>datetimepicker/jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="<?php echo js_url() ?>datetimepicker/jquery.datetimepicker.css" media="screen" title="no title" charset="utf-8" />
<script type="text/javascript">
	$(document).ready(function()
	{
		setDatetimePicker();
		setCheckedRadio();

		//is new set default radio
		if($("#hdId").val() == "")
		{
			$("input[id^='inputWorkDay'][id$='_1']").each(function()
			{
				$(this).prop( "checked", true );
			});
		}
	});
	function setDatetimePicker()
	{
		$("[id^='inputTime'][id$='All']").datetimepicker({
			datepicker:false,
			step:30,
			format:'H:i',
			onSelectTime:function(currentTime,$input){
				var id = $input.attr("id");
				var spliter = id.split("All");
				var id2 = spliter[0];
				var currentTime = currentTime.dateFormat("H:i");
				//loop for enter time to all day

				//เช็คว่าถ้าเป็นค่าเริ่มต้นเป็นเท่าไหร่ให้ค่าสิ้นสุดไม่สามารถน้อยกว่านั้นสำหรับ All
				//มีแค่ Start , End
				if(id.indexOf('Start') >= 0)
				{
					var spliter = id.split("Start");
					var endid = $("#"+spliter[0]+"End"+spliter[1]);
					spliter = $input.val().split(":");
					var mintime = spliter[0]+':'+(parseInt(spliter[1])+30);

					endid.datetimepicker("destroy");

					endid.datetimepicker({
						datepicker:false,
						step:30,
						format:'H:i',
						minTime:mintime,
						defaultTime:mintime,
						onSelectTime:function(currentTime,$input){
							var id = $input.attr("id").split("All");
							var id2 = id[0];
							var currentTime = currentTime.dateFormat("H:i");
							
							$("[id^='"+id2+"']").not("[id$='All']").each(function(){
								var id = $(this).attr("id");
								var day = $(this).attr("id").slice(-1);
								$(this).val(currentTime);
								sumtime(day);

								if(id.indexOf('Start') >= 0)
								{
									var spliter = id.split("Start");
									var endid = $("#"+spliter[0]+"End"+spliter[1]);
									spliter = $input.val().split(":");
									var mintime = spliter[0]+':'+(parseInt(spliter[1])+30);

									endid.datetimepicker("destroy");

									endid.datetimepicker({
										datepicker:false,
										step:30,
										format:'H:i',
										minTime:mintime,
										defaultTime:mintime,	
										onSelectTime:function(currentTime,$input){
											var day = $input.attr("id").slice(-1);
											sumtime(day);
										}
									});
								}
							});
							$input.val("");
						}
					});
				}
				//เช็คว่าถ้าเป็นค่าเริ่มต้นเป็นเท่าไหร่ให้ค่าสิ้นสุดไม่สามารถน้อยกว่านั้นสำหรับวันต่างๆ
				$("[id^='"+id2+"']").not("[id$='All']").each(function(){
					var id = $(this).attr("id");
					var day = $(this).attr("id").slice(-1);
					
					$(this).val(currentTime);
					
					sumtime(day);

					if(id.indexOf('Start') >= 0)
					{
						var spliter = id.split("Start");
						var endid = $("#"+spliter[0]+"End"+spliter[1]);
						spliter = $input.val().split(":");
						var mintime = spliter[0]+':'+(parseInt(spliter[1])+30);

						endid.datetimepicker("destroy");

						endid.datetimepicker({
							datepicker:false,
							step:30,
							format:'H:i',
							minTime:mintime,
							defaultTime:mintime,	
							onSelectTime:function(currentTime,$input){
								var day = $input.attr("id").slice(-1);
								sumtime(day);
							}
						});
					}
				});
				$input.val("");
			}
		});

		$("[id^='inputTime']").not("[id$='All']").datetimepicker({
			datepicker:false,
			step:30,
			format:'H:i',
			onSelectTime:function(currentTime,$input){
				var id = $input.attr("id");
				var day = $input.attr("id").slice(-1);
				sumtime(day);
				//เช็คว่าถ้าเป็นค่าเริ่มต้นเป็นเท่าไหร่ให้ค่าสิ้นสุดไม่สามารถน้อยกว่านั้นสำหรับวันต่างๆ
				if(id.indexOf('Start') >= 0)
				{
					var spliter = id.split("Start");
					var endid = $("#"+spliter[0]+"End"+spliter[1]);
					spliter = $input.val().split(":");
					var mintime = spliter[0]+':'+(parseInt(spliter[1])+30);

					endid.datetimepicker("destroy");

					endid.datetimepicker({
						datepicker:false,
						step:30,
						format:'H:i',
						minTime:mintime,
						defaultTime:mintime,	
						onSelectTime:function(currentTime,$input){
							var day = $input.attr("id").slice(-1);
							sumtime(day);
						}
					});
				}
			}
		});
	}
	function setCheckedRadio()
	{
		$("input[id^='inputWorkDayAll_']").click(function(){
			var id = $("input[id^='inputWorkDayAll_']:checked").attr("id");
			var value = $("#"+id).val();
			$("[id^='inputWorkDay'][id$='_"+id.slice(-1)+"']").each(function(){
				$(this).prop( "checked", true );
			});
		});
		$("input[id^='inputWorkDay']").click(function(){
			var counterYes = 0;
			var counterNo = 0;
			var numRadio = 7;
			$("input[name^='inputWorkDay']:checked").not("[id*='inputWorkDayAll']").each(function()
			{
				var thisvalue = $(this).val();
				if(thisvalue=="1"){counterYes++;}
				else if(thisvalue=="0"){counterNo++;}
			});

			if(counterYes == numRadio)
			{
				$("#inputWorkDayAll_1").prop( "checked", true );
			}
			else if(counterNo == numRadio)
			{
				$("#inputWorkDayAll_0").prop( "checked", true );
			}
			else
			{
				$("#inputWorkDayAll_1").prop( "checked", false );
				$("#inputWorkDayAll_0").prop( "checked", false );
			}
		});

	}
	function sumtime(day)
	{
		var timestart1 = $.trim($("#inputTimeStart1Day"+day).val());
		var timeend1 = $.trim($("#inputTimeEnd1Day"+day).val());
		var timestart2 = $.trim($("#inputTimeStart2Day"+day).val());
		var timeend2 = $.trim($("#inputTimeEnd2Day"+day).val());
		if(timestart1 != "" && timeend1 != "" && timestart2 != "" && timeend2 != "")
		{
			var sumtime1 = timeDiff(timestart1,timeend1);
			var sumtime2 = timeDiff(timestart2,timeend2);
			$("#inputTotalTimeDay"+day).val(sumtime1+sumtime2);
		}
	}
	function checkBeforeSubmit()
	{
		return true;
	}
</script>