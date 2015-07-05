<?php echo form_open(); ?>
ชื่อ : <input type="text" id="input_name" name="input_name" value="<?php echo $value_name ?>" size="50">
<br/>
ฟังก์ชั่น : <input type="text" id="input_function" name="input_function" value="<?php echo $value_function ?>" size="50">
<br/>		
<input type="submit" value="บันทึก">
<?php echo form_close(); ?>