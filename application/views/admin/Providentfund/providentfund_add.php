<input type="hidden" id="hd_validation_errors" value="<?php echo validation_errors(); ?>">
<?php echo form_open(); ?>
<input type="hidden" id="hdId" name="hdId" value="<?php echo $valueId; ?>">
<div class="row">
	<div class="col s12">
		<div class="input-field col s3">
			<input type="text" id="inputCode" name="inputCode" value="<?php echo $valueCode; ?>">
			<label for="inputCode">รหัสกองทุน</label>
		</div>
		<div class="input-field col s9">
			<input type="text" id="inputName" name="inputName" value="<?php echo $valueName; ?>">
			<label for="inputName">ชื่อกองทุน</label>
		</div>
		<div class="input-field col s12">
			<input type="text" id="inputResponsible" name="inputResponsible" value="<?php echo $valueResponsible; ?>">
			<label for="inputResponsible">ชื่อผู้รับผิดชอบ</label>
		</div>
		<div class="input-field col s12">
			<textarea name="inputDesc" id="inputDesc" class="materialize-textarea"><?php echo $valueDesc; ?></textarea>
			<label for="inputDesc">รายละเอียด</label>
		</div>
		<div class="input-field col s12">
			<input type="text" id="inputRate" name="inputRate" value="<?php echo $valueRate; ?>">
			<label for="inputRate">อัตราการหักกองทุนกี่เปอร์เซ็นต์ต่อปี</label>
		</div>
	</div>
</div>
<div class="divider"></div>
<div class="section">
    <div class="row">
        <div class="col s2">
            <input type="submit" onclick="return checkBeforeSubmit();" class="btn" value="บันทึก">
        </div>
        <div class="col s2 offset-s6 m2 offset-m8 right-align"> 
            <a href="<?php echo site_url('admin/Providentfund') ?>" class="btn red lighten-1 right-align">ยกเลิก</a>
        </div>
    </div>
</div>
<?php echo form_close(); ?>
<script type="text/javascript">
	function checkBeforeSubmit(){
		return true;
	}
</script>