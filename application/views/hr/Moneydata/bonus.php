<?php $ie = new Input_element; ?>

<?php echo form_open_multipart();  ?>
<h2 class="header">เงินค่าตอบแทนพิเศษ (โบนัส)</h2>
<div class="row">
	<div class="input-field col s12">
		<?php $ie->select_year(); ?>
		<label for="select_year">ประจำปี</label>
	</div>
	<div class="input-field col s12">
		<input type="text" id="input_money" name="input_money" value="">
		<label for="input_money">จำนวนเงิน</label>
	</div>
</div>

<h2 class="header">เงื่อนไขการจ่ายโบนัส</h2>
<div class="row">
	<div class="col s2">
		งวดที่ 1
	</div>
	<div class="input-field col s2">
		<?php $ie->select_month( '', 'select_month_period_1', 'select_month_period_1', '' ); ?>
		<label for="select_month_period_1">เดือน</label>
	</div>
	<div class="input-field col s2">
		<?php $ie->select_year( '', '', '', 'select_year_period_1', 'select_year_period_1', '' ); ?>
		<label for="select_year_period_1">ปี</label>
	</div>
	<div class="input-field col s4">
		<input type="text" id="input_money_period_1" name="input_money_period_1" value="">
		<label for="input_money_period_1">จำนวนเงิน/บาท</label>
	</div>
</div>
<div class="row">
	<div class="col s2">
		งวดที่ 2
	</div>
	<div class="input-field col s2">
		<?php $ie->select_month( '', 'select_month_period_2', 'select_month_period_2', '' ); ?>
		<label for="select_month_period_2">เดือน</label>
	</div>
	<div class="input-field col s2">
		<?php $ie->select_year( '', '', '', 'select_year_period_2', 'select_year_period_2', '' ); ?>
		<label for="select_year_period_2">ปี</label>
	</div>
	<div class="input-field col s4">
		<input type="text" id="input_money_period_2" name="input_money_period_2" value="">
		<label for="input_money_period_2">จำนวนเงิน/บาท</label>
	</div>
</div>
<div class="divider"></div>
<div class="section">
	<div class="row">
		<div class="col s12 right-align">
			<input type="submit" onclick="return check_before_submit();" class="btn" value="บันทึก">
		</div>
	</div>
</div>
<?php echo form_close(); ?>

<!--space-->
<div>
<br>
<br>
<br>
<br>
</div>
<!--end space-->

<h2 class="header">รายงานการจ่ายค่าตอบแทนพิเศษ (โบนัส)</h2>
<div class="row">
	<div class="col s12">
		<table class="responsive-table bordered highlight">
			<thead>
				<tr>
					<th rowspan="2" class="center-align">โบนัสประจำปี</th>
					<th rowspan="2" class="center-align">จำนวนเงิน</th>
					<th colspan="2" class="center-align">ข้อมูลการจ่ายโบนัส</th>
				</tr>
				<tr>
					<th class="center-align">งวดที่/เดือน</th>
					<th class="center-align">จำนวนเงิน</th>
				</tr>
			</thead>
			<tbody>
				<!-- bonus data  -->
				<?php foreach ($history as $row): ?>
					<tr>
						<td><?php echo year_thai( $row['bonus_year'] ); ?></td>
						<td><?php echo $row['bonus_money']; ?></td>
						<td>งวดที่ <?php echo $row['bp_period']; ?> เดือน<?php echo get_month_name_thai( $row['bp_month'] ); ?></td>
						<td><?php echo $row['bp_money']; ?></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>
<div class="divider"></div>
<div class="section">
	<div class="row">
		<div class="col s12 right-align">
			<input type="button" onclick="return check_before_submit();" class="btn" value="Print Report">
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		$( '#input_money, #input_money_period_1, #input_money_period_2' ).onlyNumber();
	});
		/**
		 * ต้องเลือกจำนวนปี
		 * จำนวนเงิน ต้องเป็นตัวเลขเท่านั้น
		 * จำนวนงวด ถ้าแบ่งเป็น 2 งวด รวมกันแล้วต้องไม่เกินจำนวนเงินทั้งหมด
		 * จำนวนเงินงวดที่ 1 และจำนวนเงินรวมทั้งหมดต้องกรอก
		 */
	function check_before_submit()
	{
		var select_year = $.trim( $( '#select_year' ).val() );
		var total_money = $.trim( $( '#input_money' ).val() );
		var period_1 = $.trim( $( '#input_money_period_1' ).val() );
		var period_2 = $.trim( $( '#input_money_period_2' ).val());
		var msg = '';
		if( select_year == 0 )
		{
			msg += '- เลือกปีที่ต้องการจ่ายโบนัส<br>';
		}
		if( total_money == '' )
		{
			msg += '- จำนวนเงิน<br>';
		}
		if( period_1 == '' )
		{
			msg += '- จำนวนเงินงวดที่ 1<br>';
		}
		//เช็คว่า period_1 + period_2 = total_money
		if( period_1 != '' && total_money != '' )
		{
			if( parseInt( period_1 ) + parseInt( period_2 ) != total_money )
			{
				msg += '- จำนวนเงินงวดที่ 1 และ 2 รวมกัน เกินจำนวนเงินทั้งหมด<br>';
			}
		}

		if( msg != '' )
		{
			swal({
				title: 'กรุณากรอกข้อมูลต่อไปนี้',
				html: msg,
				type: 'error'
			});
			return false;
		}
		else
		{
			return true;
		}
	}
</script>