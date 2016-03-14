<input type="hidden" id="hd_validation_errors" value="<?php echo validation_errors(); ?>">
<?php echo form_open_multipart(); ?>
<input type="hidden" id="hdId" name="hdId" value="<?php echo $valueId; ?>">
<div class="row">
	<div class="col s12">
		<div class="input-field col s12">
			<?php echo form_dropdown('inputParent', $dataParent, $valueParent,'id=inputParent'); ?>
			<label for="inputParent">หัวหน้าของตำแหน่งนี้</label>
		</div>
		<div class="input-field col s12">
			<input type="text" name="inputName" id="inputName" value="<?php echo $valueName; ?>" />
			<label for="inputName">ชื่อ</label>
		</div>
		<div class="input-field col s12">
			<input type="text" name="inputNameEng" id="inputNameEng" value="<?php echo $valueNameEng; ?>" />
			<label for="inputNameEng">ชื่อภาษาอังกฤษ</label>
		</div>
		<div class="input-field col s12">
			<textarea name="inputDesc" id="inputDesc" class="materialize-textarea"><?php echo $valueDesc; ?></textarea>
			<label for="inputDesc">คำอธิบาย</label>
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
            <a href="<?php echo site_url('admin/Company/position') ?>" class="btn red lighten-1 right-align">ยกเลิก</a>
        </div>
    </div>
</div>
<?php echo form_close(); ?>
<script type="text/javascript">
	function checkBeforeSubmit()
	{
		return true;
	}
</script>