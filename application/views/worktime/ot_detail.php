
<?php echo form_open($form_url) ?>
	<input type='hidden' name='hd_your_role' value='<?php echo $your_role ?>'>
	<input type='hidden' name='hd_ot_id' value='<?php echo $ot_id ?>'>

	<?php if ( $your_role == 'headman' || $your_role == 'hr' ): ?>
		<?php if ( $your_role == 'headman' ): ?>
			<div>
				<textarea name="input_headman_remark" id="input_headman_remark" cols="30" rows="10"></textarea>
				<br>
				<input type="radio" name='input_workflow_id' value='2'>อนุมัติ
				<input type="radio" name='input_workflow_id' value='3'>ไม่อนุมัติ
			</div>
		<?php endif ?>

		<?php if ( $your_role == 'hr' ): ?>
			<div>
				<textarea name="input_hr_remark" id="input_hr_remark" cols="30" rows="10"></textarea>
				<br>
				<input type="radio" name='input_workflow_id' value='4'>อนุมัติ
				<input type="radio" name='input_workflow_id' value='5'>ไม่อนุมัติ
			</div>
		<?php endif ?>
		
		<input type="submit" value='บันทึก'>
	<?php endif ?>
<?php echo form_close(); ?>
