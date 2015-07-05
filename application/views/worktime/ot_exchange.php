<h1>แบบฟอร์มการขอค่าตอบแทนจากการทำงานล่วงเวลาของพนักงาน</h1>

<?php echo form_open($form_url) ?>

<!-- section select date you want to exchange -->
<div>
	เลือกวันที่ต้องการใช้แลก
	<table>
		<tr>
			<td>#</td>
			<td>วันที่</td>
			<td>จำนวนชั่วโมง</td>
		</tr>
		<?php foreach ($query_ot as $row): ?>
			<tr>
				<td>
					<input type='checkbox' name='input_ot[]' 
					id='input_ot_<?php echo $row['wot_id']; ?>' 
					value='<?php echo $row['wot_id'] ?>'
					ot-hour='<?php echo $row['wot_request_hour'] ?>'
					>
				</td>
				<td>
					<?php echo $row['wot_date'] ?>
				</td>
				<td>
					<?php echo $row['wot_request_hour'] ?>
				</td>
			</tr>
		<?php endforeach ?>
	</table>
</div>
<div>
	รวมเป็นจำนวนทั้งสิ้น <span id='sum_choose_hour'>0</span> ชั่วโมง
</div>


<!-- <table>
	<tr>
		<td>#</td>
		<td>จำนวนชั่วโมง</td>
		<td>แลกเป็นเงิน/บาท</td>
		<td>แลกเป็นวันหยุด/วัน</td>
	</tr>
	<?php foreach ($query_ot_conditions as $row): ?>
		<tr style='color:#CCC;'>
			<td><?php echo $row['wotcond_ot_hour'] ?></td>
			<td>
				<input type='radio' name='input_condition_id' id='input_condition_id_<?php echo $row['wotcond_id'] ?>' 
				value='<?php echo $row['wotcond_id'] ?>_money'
				use-hour='<?php echo $row['wotcond_ot_hour'] ?>'
				disabled='disabled'
				>
				<?php echo $row['wotcond_money'] ?>
			</td>
			<td>
				<input type='radio' name='input_condition_id' id='input_condition_id_<?php echo $row['wotcond_id'] ?>' 
				value='<?php echo $row['wotcond_id'] ?>_leave'
				use-hour='<?php echo $row['wotcond_ot_hour'] ?>'
				disabled='disabled'
				>
				<?php echo $row['wotcond_leave'] ?>
			</td>
		</tr>
	<?php endforeach ?>
</table> -->


<input type='button' value='คำนวณค่าตอบแทน' onclick='calculate_pay();'>

<div>
	ประเภทค่าตอบแทน 
	<br>
	<input type='radio' id='input_exchange_type_money' name='input_exchange_type' value='money' disabled='disabled'>
	เงิน คุณจะได้รับค่าตอบแทน 
	<span id='pay_money'> 0 </span> บาท
	<br>
	<input type='radio' id='input_exchange_type_leave' name='input_exchange_type' value='leave' disabled='disabled'>
	วันหยุด คุณจะได้รับวันหยุด 
	<span id='pay_leave'> 0 </span> วัน
</div>

<input type='submit' value='บันทึก' onclick='return check_before_submit();'>
<?php echo form_close(); ?>

<!-- sector for show log exchange -->


<script type='text/javascript'>
	$(document).ready(function()
	{
		$('[id^=input_ot_]').change(function()
		{
			var is_check 		= $(this).is(':checked');
			var sum_choose_hour = $('#sum_choose_hour');
			if( is_check )
			{
				sum_choose_hour.text(parseInt(sum_choose_hour.text()) + parseInt($(this).attr('ot-hour')));
			}
			else
			{
				sum_choose_hour.text(parseInt(sum_choose_hour.text()) - parseInt($(this).attr('ot-hour')));
			}
			enable_disable_condition_by_tick_hour();
		});
	});

	function enable_disable_condition_by_tick_hour()
	{
		var tick_hour = parseInt($('#sum_choose_hour').text());
		var condition_hour = 0;
		$('[id^=input_condition_id_]').each(function()
		{
			condition_hour = parseInt($(this).attr('use-hour'));
			//ถ้าตัวเงื่อนไขมีจำนวนชั่วโมงมากกว่าที่เลือกมาให้ disable  ไม่ให้เลือก
			if(condition_hour > tick_hour)
			{
				$(this).attr('disabled','disabled');
				$(this).parent().parent().css('color','#CCC');
			}
			else
			{
				$(this).removeAttr('disabled');
				$(this).parent().parent().css('color','black');
			}
		});
	}

	function calculate_pay()
	{
		var ot_hour = $('#sum_choose_hour').text();

		$.ajax({
			url: 'calculate_exchange_ot_condition/'+ot_hour,
			type: 'POST',
			dataType: 'html'
		})
		.done(function(data) {
			var spliter = data.split('//--//');
			var money = spliter[0];
			var leave = spliter[1];
			var cond_id = spliter[2];
			$('#pay_money').text(money);
			$('#pay_leave').text(leave);
			$('#input_exchange_type_money').removeAttr('disabled');
			$('#input_exchange_type_leave').removeAttr('disabled');
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});		
	}

	function check_before_submit()
	{
		var is_checked = $('[name=input_exchange_type]').is(':checked');
		if( is_checked )
		{
			return true;
		}
		else
		{
			return false;
		}
		return false;
	}
</script>
