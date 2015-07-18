<?php echo form_open();?>
	<div class="row">
		<div class="col s12">
			<div class="input-field col s3">
				<?php echo form_dropdown("ddlNameTitleThai", $queryNameTitleThai, $empNameTitleThai, "id='ddlNameTitleThai' disabled");?>
				<label for="ddlNameTitleThai" class="green-text">คำนำหน้า</label>
			</div>
			<div class="input-field col s4">
				<input readonly="true" type="text" id="txtFirstnameThai" name="txtFirstnameThai" value="<?php echo $empFirstnameThai?>">
				<label for="txtFirstnameThai" class="green-text">ชื่อ</label>
			</div>
			<div class="input-field col s5">
				<input readonly="true" type="text" id="txtLastnameThai" name="txtLastnameThai" value="<?php echo $empLastnameThai?>">
				<label for="txtLastnameThai" class="green-text">นามสกุล</label>
			</div>
		</div>
		<div class="col s12">
			<div class="input-field col s4">
				<input readonly="true" type="text" id="txtAddressNumber" name="txtAddressNumber" value="<?php echo $empAddressNumber?>">
				<label for="txtAddressNumber" class="green-text">บ้านเลขที่</label>
			</div>
			<div class="input-field col s4">
				<input readonly="true" type="text" id="txtAddressMoo" name="txtAddressMoo" value="<?php echo $empAddressMoo?>">
				<label for="txtAddressMoo" class="green-text">หมู่</label>
			</div>
			<div class="input-field col s4">
				<input readonly="true" type="text" id="txtAddressRoad" name="txtAddressRoad" value="<?php echo $empAddressRoad?>">
				<label for="txtAddressRoad" class="green-text">ถนน</label>
			</div>
			<div class="input-field col s4">
				<?php echo form_dropdown("ddlAddressProvince", $queryProvince, $empAddressProvince, "id='ddlAddressProvince' disabled");?>
				<label for="ddlAddressProvince" class="green-text">จังหวัด</label>
			</div>
			<div class="input-field col s4">
				<?php echo form_dropdown("ddlAddressAmphur", $queryAmphur, $empAddressAmphur, "id='ddlAddressAmphur' disabled");?>
				<label for="ddlAddressAmphur" class="green-text">เขต/อำเภอ</label>
			</div>
			<div class="input-field col s4">
				<?php echo form_dropdown("ddlAddressDistrict", $queryDistrict, $empAddressDistrict, "id='ddlAddressDistrict' disabled");?>
				<label for="ddlAddressDistrict" class="green-text">แขวง/ตำบล</label>
			</div>
			<div class="input-field col s4">
				<?php echo form_dropdown("ddlAddressZipcode", $queryZipcode, $empAddressZipcode, "id='ddlAddressZipcode' disabled");?>
				<label for="ddlAddressZipcode" class="green-text">รหัสไปรษณีย์</label>
			</div>
		</div>
	</div>
<?php echo form_close();?>
<div class="divider"></div>
<input type="hidden" id="hd_validation_error" name="hd_validation_error" value="<?php echo validation_errors()?>">
<div class="section">
	<div class="row">
		<div class="col s12">
			<button type="submit" class="btn waves-effect waves-light" name="action" onclick="return check_before_submit();">บันทึก</button>
		</div>
	</div>
</div>