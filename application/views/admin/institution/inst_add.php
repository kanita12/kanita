<input type="hidden" id="hd_validation_errors" value="<?php echo validation_errors(); ?>">
<?php echo form_open() ?>
<input type="hidden" id="hd_inst_id" name="hd_inst_id" value="<?php echo $value_inst_id; ?>">
<div class="row">
	<div class="col s12">
		<div class="input-field col s12">
			<input type="text" id="input_name" name="input_name" value="<?php echo $value_inst_name; ?>">
			<label for="input_name">ชื่อหน่วยงาน</label>
		</div>
		<div class="input-field col s12">
			<textarea id="input_desc" name="input_desc" class="materialize-textarea"><?php echo $value_inst_desc; ?></textarea>
			<label for="input_desc">คำอธิบายเพิ่มเติม</label>
		</div>
	</div>
</div>
<div class="divider"></div>
<div class="section">
	<div class="row">
		<div class="col s4">
			<button class="btn waves-effect waves-light" type="submit" name="action" onclick="return check_before_submit();">บันทึก</button>
		</div>
		<div class="col s4 offset-s4 right-align">
			<a href="<?php echo site_url("admin/Institution") ?>" class="btn waves-effect waves-light red">ยกเลิก</a>
		</div>
	</div>
</div>
<?php echo form_close(); ?>
<script type="text/javascript">
	$(document).ready(function()
	{
		var validation = $("#hd_validation_errors").val();
		if($.trim(validation) !== "")
		{
			swal
			({
				title: "กรุณากรอกข้อมูลให้ครบ",
				html: validation,
				type: "error"
			});
		}
	});
	function check_before_submit()
	{

		var name = $("#input_name").val();
		var msg = "";
		if($.trim(name) == "")
		{
			msg += "-ชื่อหน่วยงาน";
		}
		if(msg != "")
		{
			swal({
				title: "กรุณากรอก",
				html: msg,
				type: "error"
			});
			return false;
		}
		else
		{
			return true;
		}
		return false;
	}
</script>