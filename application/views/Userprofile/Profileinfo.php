<?php echo form_open()?>
<!-- Title , Firstname , Lastname in Thai -->
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
</div>
<!-- Title , Firstname , Lastname in English -->
<div class="row">
	<div class="col s12">
		<div class="input-field col s3">
			<?php echo form_dropdown("ddlNameTitleEnglish", $queryNameTitleEnglish, $empNameTitleEnglish, "id='ddlNameTitleEnglish' disabled");?>
			<label for="ddlNameTitleEnglish" class="green-text">Name title</label>
		</div>
		<div class="input-field col s4">
			<input readonly="true" type="text" id="txtFirstnameEnglish" name="txtFirstnameEnglish" value="<?php echo $empFirstnameEnglish?>">
			<label for="txtFirstnameEnglish" class="green-text">Firstname</label>
		</div>
		<div class="input-field col s5">
			<input readonly="true" type="text" id="txtLastnameEnglish" name="txtLastnameEnglish" value="<?php echo $empFirstnameEnglish?>">
			<label for="txtLastnameEnglish" class="green-text">Lastname</label>
		</div>
	</div>
</div>
<!-- call name , birthday, birthplace -->
<div class="row">
	<div class="col s12">
		<div class="input-field col s4">
			<input readonly="true" type="text" id="txtCallName" name="txtCallName" value="<?php echo $empCallName?>">
			<label for="txtCallName" class="green-text">ชื่อเล่น</label>
		</div>
		<div class="input-field col s4">
			<input readonly="true" type="text" id="txtTelePhone" name="txtTelePhone" value="<?php echo $empTelePhone?>">
			<label for="txtTelePhone" class="green-text">เบอร์โทรศัพท์</label>
		</div>
		<div class="input-field col s4">
			<input readonly="true" type="text" id="txtMobilePhone" name="txtMobilePhone" value="<?php echo $empMobilePhone?>">
			<label for="txtMobilePhone" class="green-text">เบอร์มือถือ</label>
		</div>
	</div>
</div>
<!-- Birthday , Birthplace -->
<div class="row">
	<div class="col s12">
		<div class="input-field col s5">
			<input readonly="true" type="text" id="txtBirthPlace" name="txtBirthPlace" value="<?php echo $empBirthPlace?>">
			<label for="txtBirthPlace" class="green-text">สถานที่เกิด</label>
		</div>
		<div class="col s7">
			<div class="input-field col s4">
				<?php echo form_dropdown("ddlBirthDayDay", $ddlBirthDayDay, $birthDayDay, "id='ddlBirthDayDay'");?>
				<label for="input_birthday" class="green-text">วันที่เกิด</label>
			</div>
			<div class="input-field col s4">
				<?php echo form_dropdown("ddlBirthDayMonth", $ddlBirthDayMonth, $birthDayMonth, "id='ddlBirthDayMonth'");?>
			</div>
			<div class="input-field col s4">
				<?php echo form_dropdown("ddlBirthDayYear", $ddlBirthDayYear, $birthDayYear, "id='ddlBirthDayYear'");?>
			</div>
		</div>
	</div>
</div>
<!-- profile -->
<div class="row">
	<div class="col s12">
		<div class="input-field col s3">
			<!-- for style equal other control -->
			<input type="text" readonly="true" name="gender_hidden" id="gender_hidden" value="0" style="display:none;">
			<label for="gender_hidden" class="green-text">เพศ</label>
			<p>
				<input name="gender" type="radio" id="male" value="m" <?php echo set_value('gender', $empSex) === "M" ? "checked" : "";?> />
				<label for="male">ชาย</label>
			</p>
			<p>
				<input name="gender" type="radio" id="female" value="f" <?php echo set_value('gender', $empSex) === "F" ? "checked" : "";?> />
				<label for="female">หญิง</label>
			</p>
		</div>
		<div class="col s9">
			<div class="input-field col s4">
				<input type="text" readonly="true" name="txtHeight" id="txtHeight" value="<?php echo $empHeight?>">
				<label for="txtHeight" class="green-text">ส่วนสูง</label>
			</div>
			<div class="input-field col s4">
				<input type="text" readonly="true" name="txtWeight" id="txtWeight" value="<?php echo $empWeight?>">
				<label for="txtWeight" class="green-text">น้ำหนัก</label>
			</div>
			<div class="input-field col s4">
				<input type="text" readonly="true" name="txtBlood" id="txtBlood" value="<?php echo $empBlood?>">
				<label for="txtBlood" class="green-text">กรุ๊ปเลือด</label>
			</div>
			<div class="input-field col s4">
				<input type="text" readonly="true" name="txtNationality" id="txtNationality" value="<?php echo $empNationality?>">
				<label for="txtNationality" class="green-text">เชื้อชาติ</label>
			</div>
			<div class="input-field col s4">
				<input type="text" readonly="true" name="txtRace" id="txtRace" value="<?php echo $empRace?>">
				<label for="txtRace" class="green-text">สัญชาติ</label>
			</div>
			<div class="input-field col s4">
				<input type="text" readonly="true" name="txtReligion" id="txtReligion" value="<?php echo $empReligion?>">
				<label for="txtReligion" class="green-text">ศาสนา</label>
			</div>
		</div>
	</div>
</div>
<!-- martial status -->
<div class="row">
	<div class="col s12">
		<div class="input-field col s12">
			<input type="text" readonly="true" name="martial_hidden" id="martial_hidden" value="0" style="display:none;">
			<label for="martial_hidden" class="green-text">สถานภาพ</label>
			<br>
			<?php foreach ($queryMartialStatus->result_array() as $row): ?>
				<span style="padding-right:40px;">
					<input name="rdoMartialStatus" id="rdoMartialStatus_<?php echo $row["MARSID"];?>" type="radio" value="<?php echo $row["MARSID"];?>"
					<?php echo set_value('martialstatus', $empMartialStatus) == $row["MARSID"] ? "checked" : "";?>
					>
					<label for="rdoMartialStatus_<?php echo $row["MARSID"]?>"><?php echo $row["MARSName"]?></label>
				</span>
			<?php endforeach?>
		</div>
	</div>
</div>
<!-- military status -->
<div class="row">
	<div class="col s12">
		<div class="input-field col s12">
			<input type="text" readonly="true" name="military_hidden" id="military_hidden" value="0" style="display:none;">
			<label for="military_hidden" class="green-text">สถานภาพทางทหาร</label>
			<br>
			<span style="padding-right:40px;">
				<input name="rdoMilitaryStatus" id="rdoMilitaryStatus_1" type="radio" value="1"
				<?php echo set_value('militarystatus', $empMilitaryStatus) == 1 ? "checked" : "";?> >
				<label for="rdoMilitaryStatus_1">ผ่านการศึกษาวิชาทหาร</label>
			</span>
			<span style="padding-right:40px;">
				<input name="rdoMilitaryStatus" id="rdoMilitaryStatus_2" type="radio" value="2"
				<?php echo set_value('militarystatus', $empMilitaryStatus) == 2 ? "checked" : "";?> >
				<label for="rdoMilitaryStatus_2">ผ่านเกณฑ์ทหาร</label>
			</span>
			<p>
				<input name="rdoMilitaryStatus" id="rdoMilitaryStatus_3" type="radio" value="3"
				<?php echo set_value('militarystatus', $empMilitaryStatus) == 3 ? "checked" : "";?> >
				<label for="rdoMilitaryStatus_3">ได้รับการยกเว้นเนื่องจาก</label>
			</p>
			<p>
				<textarea name="txtMilitaryReason" id="txtMilitaryReason" class="materialize-textarea"><?php echo $empMilitaryReason?></textarea>
			</p>
		</div>
	</div>
</div>
<!-- ID Card -->
<div class="row">
	<div class="col s12">
		<div class="input-field col s12">
			<input type="text" readonly="true" id="txtIDCard" name="txtIDCard" value="<?php echo $empIDCard?>">
			<label for="txtIDCard" class="green-text">รหัสบัตรประชาชน</label>
		</div>
	</div>
	<div class="col s12">
		<h3 class="header">รูปบัตรประชาชน</h3>
		<div class="input-field col s12">
			<?php if ($empIDCardImg): ?>
				<img src="<?php echo base_url($empIDCardImg);?>">
			<?php endif?>
			<?php /*echo form_upload(array("name" => "fuIDCard", "id" => "fuIDCard"));*/?>
		</div>
	</div>
</div>
<!-- Address -->
<div class="row">
	<div class="col s12">
		<h3 class="header">ที่อยู่ปัจจุบัน</h3>
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
<div class="row">
	<div class="col s12">
		<h3 class="header">ที่อยู่ตามทะเบียนบ้าน</h3>
		<div class="input-field col s4">
			<input readonly="true" type="text" id="txtAddressNumberHouseReg" name="txtAddressNumberHouseReg" value="<?php echo $empAddressNumberHouseReg; ?>">
			<label for="txtAddressNumberHouseReg" class="green-text">บ้านเลขที่</label>
		</div>
		<div class="input-field col s4">
			<input readonly="true" type="text" id="txtAddressMooHouseReg" name="txtAddressMooHouseReg" value="<?php echo $empAddressMooHouseReg; ?>">
			<label for="txtAddressMooHouseReg" class="green-text">หมู่</label>
		</div>
		<div class="input-field col s4">
			<input readonly="true" type="text" id="txtAddressRoadHouseReg" name="txtAddressRoadHouseReg" value="<?php echo $empAddressRoadHouseReg; ?>">
			<label for="txtAddressRoadHouseReg" class="green-text">ถนน</label>
		</div>
		<div class="input-field col s4">
			<?php echo form_dropdown("ddlAddressProvinceHouseReg", $queryProvince, $empAddressProvinceHouseReg, "id='ddlAddressProvinceHouseReg' disabled");?>
			<label for="ddlAddressProvinceHouseReg" class="green-text">จังหวัด</label>
		</div>
		<div class="input-field col s4">
			<?php echo form_dropdown("ddlAddressAmphurHouseReg", $queryAmphurHouseReg, $empAddressAmphurHouseReg, "id='ddlAddressAmphurHouseReg' disabled");?>
			<label for="ddlAddressAmphurHouseReg" class="green-text">เขต/อำเภอ</label>
		</div>
		<div class="input-field col s4">
			<?php echo form_dropdown("ddlAddressDistrictHouseReg", $queryDistrictHouseReg, $empAddressDistrictHouseReg, "id='ddlAddressDistrictHouseReg' disabled");?>
			<label for="ddlAddressDistrictHouseReg" class="green-text">แขวง/ตำบล</label>
		</div>
		<div class="input-field col s4">
			<?php echo form_dropdown("ddlAddressZipcodeHouseReg", $queryZipcodeHouseReg, $empAddressZipcodeHouseReg, "id='ddlAddressZipcodeHouseReg' disabled");?>
			<label for="ddlAddressZipcodeHouseReg" class="green-text">รหัสไปรษณีย์</label>
		</div>
		<div class="input-field col s12">
			<h3 class="header">รูปสำเนาทะเบียนบ้าน</h3>
			<?php if ($empAddressImg): ?>
				<img src="<?php echo base_url($empAddressImg);?>">
			<?php endif?>
			<?php /*echo form_upload(array("name" => "fuAddress", "id" => "fuAddress"));*/?>
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