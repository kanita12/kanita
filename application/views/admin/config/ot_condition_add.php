<?php echo form_open($form_url) ?>

<input type='hidden' name='hd_ot_condition_id' id='hd_ot_condition_id' value='<?php echo $ot_condition_id ?>'>

จำนวนชั่วโมง OT : <input type='text' name='input_ot_hour' id='input_ot_hour' value='<?php echo $value_ot_hour ?>'>
<br>
แลกเป็นเงิน : <input type='text' name='input_money' id='input_money' value='<?php echo $value_money ?>'>
<br>
แลกเป็นวันหยุด : <input type='text' name='input_leave' id='input_leave' value='<?php echo $value_leave ?>'>
<br>
<input type='submit' value='บันทก'>

<?php echo form_close(); ?>