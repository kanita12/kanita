<?php echo form_open(); ?>
Workflow : <?php echo form_dropdown('select_workflow', $select_workflow,$value_workflow); ?>
<br/>
Condition : <input type="text" id="input_condition" name="input_condition" value="<?php echo $value_condition ?>" size="50">
<br/>
Next Workflow : <?php echo form_dropdown('select_next_workflow', $select_workflow,$value_next_workflow); ?>
<br/>
<input type="submit" value="บันทึก">
<?php echo form_close(); ?>