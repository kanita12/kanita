<input type="hidden" id="hd_validation_errors" value="<?php echo validation_errors(); ?>">
<?php echo form_open_multipart(); ?>
<input type="hidden" id="hdCID" name="hdCID" value="<?php echo $query["CID"]; ?>">
<div class="row">
	<div class="col s12">
		<div class="input-field col s12">
			<input type="text" name="inputName" id="inputName" value="<?php echo $query["CName"]; ?>" />
			<label for="inputName">ชื่อบริษัท</label>
		</div>
		<div class="input-field col s12">
			<input type="text" name="inputNameEnglish" id="inputNameEnglish" value="<?php echo $query["CNameEnglish"]; ?>" />
			<label for="inputNameEnglish">ชื่อบริษัท ภาษาอังกฤษ</label>
		</div>
		<div class="input-field col s12">
			<textarea name="inputDesc" id="inputDesc" class="materialize-textarea"><?php echo $query["CDesc"] ?></textarea>
			<label for="inputDesc">คำอธิบาย</label>
		</div>
		<div class="input-field col s12">
			<input type="text" name="inputEntrepreneurName" id="inputEntrepreneurName" value="<?php echo $query["CEntrepreneurName"]; ?>" />
			<label for="inputEntrepreneurName">ชื่อผู้ประกอบการ</label>
		</div>
		<div class="input-field col s12">
			<input type="text" name="inputTaxID" id="inputTaxID" value="<?php echo $query["CTaxID"]; ?>" />
			<label for="inputTaxID">เลขประจำตัวผู้เสียภาษีอากร</label>
		</div>
		<div class="input-field col s12">
			<input type="text" name="inputTelephone" id="inputTelephone" value="<?php echo $query["CTelephone"]; ?>" />
			<label for="inputTelephone">เบอร์โทรศัพท์</label>
		</div>
	</div>
</div>
<div class="row">
	<div class="col s12">
		<div class="center-align">
			<?php if ($query["CLogo"] != "") : ?>
				<img src="<?php echo base_url($query["CLogo"]) ?>" class="responsive-img materialboxed">
			<?php endif ?>	
		</div>
		<div class="file-field input-field">
            <div class="btn">
              <span>Logo บริษัท</span>
              <input type="file" name="fuLogo" id="fuLogo">
            </div>
            <div class="file-path-wrapper">
              <input class="file-path validate" type="text">
            </div>
        </div>
	</div>
</div>
<div class="row">
	<div class="col s12">
		<h4 class="header">ที่อยู่</h4>
		<div class="input-field col s4">
			<input type="text" id="inputAddressNumber" name="inputAddressNumber" class="validate" value="<?php echo $query["CAddressNumber"]; ?>">
			<label for="inputAddressNumber">บ้านเลขที่</label>
		</div>
		<div class="input-field col s4">
			<input type="text" id="inputAddressMoo" name="inputAddressMoo" class="validate" value="<?php echo $query["CAddressMoo"]; ?>">
			<label for="inputAddressMoo">หมู่</label>
		</div>
		<div class="input-field col s4">
			<input type="text" id="inputAddressRoad" name="inputAddressRoad" class="validate" value="<?php echo $query["CAddressRoad"]; ?>">
			<label for="inputAddressRoad">ถนน</label>
		</div>
		<div class="input-field col s4">
			<?php echo form_dropdown("ddlAddressProvince", $queryProvince, $query["C_ProvinceID"], "id='ddlAddressProvince'");?>
			<label for="ddlAddressProvince">จังหวัด</label>
		</div>
		<div class="input-field col s4">
			<?php echo form_dropdown("ddlAddressAmphur", $queryAmphur, $query["C_AmphurID"], "id='ddlAddressAmphur'");?>
			<label for="ddlAddressAmphur">เขต/อำเภอ</label>
		</div>
		<div class="input-field col s4">
			<?php echo form_dropdown("ddlAddressDistrict", $queryDistrict, $query["C_DistrictID"], "id='ddlAddressDistrict'");?>
			<label for="ddlAddressDistrict">แขวง/ตำบล</label>
		</div>
		<div class="input-field col s4">
			<?php echo form_dropdown("ddlAddressZipcode", $queryZipcode, $query["C_ZipcodeID"], "id='ddlAddressZipcode'");?>
			<label for="ddlAddressZipcode">รหัสไปรษณีย์</label>
		</div>
	</div>
</div>
<div class="divider"></div>
<div class="section">
	<div class="row">
		<div class="col s12 center-align">
			<input type="submit" onclick="return checkBeforeSubmit();" class="btn" value="บันทึก">
		</div>
	</div>
</div>
<?php echo form_close(); ?>
<script type="text/javascript">
	$(document).ready(function(){
		var site_url = "<?php echo site_url(); ?>";
		//check validation_errors if have then alert
		var validation_errors = $("#hd_validation_errors").val();
		if(validation_errors != "")
		{
			swal({
				title: "ผิดพลาด",
				html: validation_errors,
				type: "error"
			});
		}
		$("[id$='ddlAddressProvince']").change(function() {
			$.ajax({
				type : "POST",
				url : site_url+"hr/AjaxEmployee/getListAmphur/" + $(this).val(),
				success : function(data) {
					$("[id$='ddlAddressAmphur']").html(data);
					$('#ddlAddressAmphur').material_select();
					$("select").closest('.input-field').children('span.caret').remove();
					$("[id$='ddlAddressAmphur']").change();
				}
			});
		});
		$("[id$='ddlAddressAmphur']").change(function() {
			var provinceID = $("[id$='ddlAddressProvince']").val();
			$.ajax({
				type : "POST",
				url : site_url+"hr/AjaxEmployee/getListDistrict/" + provinceID + "/" + $(this).val(),
				success : function(data) {
					$("[id$='ddlAddressDistrict']").html(data);
					$('#ddlAddressDistrict').material_select();
					$("select").closest('.input-field').children('span.caret').remove();
					$("[id$='ddlAddressDistrict']").change();
				}
			});
		});
		$("[id$='ddlAddressDistrict']").change(function() {
			var provinceID = $("[id$='ddlAddressProvince']").val();
			var amphurID = $("[id$='ddlAddressAmphur']").val();
			$.ajax({
				type : "POST",
				url : site_url+"hr/AjaxEmployee/getListZipcode/" + provinceID + "/" + amphurID + "/" + $(this).val(),
				success : function(data) {
					$("[id$='ddlAddressZipcode']").html(data);
					$('#ddlAddressZipcode').material_select();
					$("select").closest('.input-field').children('span.caret').remove();
				}
			});
		});
	});
	function checkBeforeSubmit()
	{
		return true;
	}
</script