<script type="text/javascript" src="<?php echo js_url().'employee/register.js'; ?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".collection > .collection-item").click(function(){
			activeCollection(this);
		});

		var menu = $('#menu');
		$(document).scroll(function(){
	        if ( $(this).scrollTop() >= $(window).height() - menu.height() ){
	        menu.css("position","fixed").css("top",50).css("width","250px");
	        } else {
	        menu.css("position","relative").css("top",0);
	        }
    	});
	});

	function activeCollection(obj)
	{
		obj = $(obj);
		var now_active = "";
		$(".collection > a").each(function(){
			if($(this).hasClass("active"))
			{
				now_active = $(this).attr("href");
			}
			$(this).removeClass("active");
		});
		
		$(".collection > a[href='"+obj.attr("href")+"']").addClass("active");

	}
</script>

<div class="row">
	<!-- Left menu -->
	<div class="col s12 m3 l3">
        <ul id="menu" class="collection">
            <a class="collection-item active" href="#userinfo">ข้อมูลพนักงาน</a>
            <a class="collection-item" href="#profileinfo">ประวัติส่วนตัว</a>
            <a class="collection-item" href="#historyworkinfo">ประวัติการทำงาน</a>
            <a class="collection-item" href="#historystudyinfo">ประวัติการศึกษา</a>
            <a class="collection-item" href="#othercontactinfo">บุคคลอื่นที่ติดต่อได้</a>
            <a class="collection-item" href="#documentinfo">เอกสาร</a>
        </ul>
        &nbsp;
    </div>
	<div class="col s12 m9 l9 card-panel">
		<div id="userinfo" class="section">
			<h4 class="header">ข้อมูลพนักงาน</h4>
			<?php
				$inputPassword = '';
				$inputConfirmPassword = '';
				$descriptionPassword = '';

				if ($empPassword != '')
				{//edit
					$inputPassword = 'New Password : '.form_password(array("name" => "txtPassword", "id" => "txtPassword"));
					$inputConfirmPassword = 'Confirm Password : '.form_password(array("name" => "txtPassword2", "id" => "txtPassword2"));
				}
				else
				{ //register

					$descriptionPassword = "<p class='flow-text center-align red-text'>* พาสเวิร์ดอัตโนมัติเลขท้าย 4 ตัวสุดท้ายของเลขบัตรประชาชน</p>";

				}

				echo form_open_multipart($FormUrl); 
			?>
			<input type='hidden' id='hdEmpPassword' name='hdEmpPassword' value='<?php echo $empPassword ?>'>
			<input type='hidden' id='hdEmpID' name='hdEmpID' value='<?php echo $empID ?>'>
			<input type="hidden" id="hd_emp_headman_level_1" value="<?php echo $empHeadmanID_level_1 ?>">
			<input type="hidden" id="hd_emp_headman_level_2" value="<?php echo $empHeadmanID_level_2 ?>">
			<input type="hidden" id="hd_emp_headman_level_3" value="<?php echo $empHeadmanID_level_3 ?>">
			<input type="hidden" id="hd_site_url" value="<?php echo site_url() ?>/">
			<!-- emp id & username -->
			<div class="input-field col s6">
				<input type="text" class="validate" name="txtEmpID" id="txtEmpID" value="<?php echo set_value("txtEmpID",$empID) ?>">
				<label for="txtEmpID">รหัสพนักงาน</label>
			</div>
			<div class="input-field col s6">
				<input type="text" class="validate" name="txtUsername" id="txtUsername" value="<?php echo set_value("txtUsername",$empUsername) ?>">
				<label for="txtUsername">Username</label>
			</div>
			<!-- Inst & Dept & Position -->
			<div class="row">
				<div class="col s12">
					<div class="input-field col s4">
						<?php echo form_dropdown("ddlInstitution", $queryInstitution, $empInstitutionID, "id='ddlInstitution'"); ?>
						<label for="ddlInstitution">หน่วยงาน</label>
					</div>
					<div class="input-field col s4">
						<?php echo form_dropdown("ddlDepartment", $queryDepartment, $empDepartmentID, "id='ddlDepartment'"); ?>
						<label for="ddlDepartment">แผนก</label>
					</div>
					<div class="input-field col s4">
						<?php echo form_dropdown("ddlPosition", $queryPosition, $empPositionID, "id='ddlPosition'"); ?>
						<label for="ddlPosition">ตำแหน่ง</label>
					</div>
				</div>
			</div>
			<!-- Headman -->
			<div class="row">
				<div class="col s12">
					<div class="input-field col s4">
						<?php echo form_dropdown("ddlHeadman_level_1", $queryHeadman_level_1, $empHeadmanID_level_1, "id='ddlHeadman_level_1'"); ?>
						<label for="ddlHeadman_level_1">หัวหน้า Level 1</label>
					</div>
					<div class="input-field col s4">
						<?php echo form_dropdown("ddlHeadman_level_2", $queryHeadman_level_2, $empHeadmanID_level_2, "id='ddlHeadman_level_2'"); ?>
						<label for="ddlHeadman_level_2">หัวหน้า Level 2</label>
					</div>
					<div class="input-field col s4">
						<?php echo form_dropdown("ddlHeadman_level_3", $queryHeadman_level_3, $empHeadmanID_level_3, "id='ddlHeadman_level_3'"); ?>
						<label for="ddlHeadman_level_3">หัวหน้า Level 3</label>
					</div>
				</div>
			</div>
			<!-- Work date -->
			<div class="row">
				<div class="col s12">
					<div class="input-field col s4">
						<input type="text" class="validate" id="txtStartWorkDate" name="txtStartWorkDate" value="<?php echo $empStartWorkDate;?>">
						<label for="txtStartWorkDate">วันเริ่มงาน</label>
					</div>
					<div class="input-field col s4">
						<input type="text" class="validate" id="txtSuccessTrialWorkDate" name="txtSuccessTrialWorkDate" value="<?php echo $empSuccessTrialWorkDate?>">
						<label for="txtSuccessTrialWorkDate">วันที่ผ่านทดลองงาน</label>
					</div>
					<div class="input-field col s4">
						<input type="text" class="validate" id="txtPromiseStartWorkDate" name="txtPromiseStartWorkDate" value="<?php echo $empPromiseStartWorkDate?>">
						<label for="txtPromiseStartWorkDate">วันที่เริ่มงาน (ตามสัญญา)</label>
					</div>
				</div>
			</div>
			<!-- Email -->
			<div class="row">
				<div class="col s12">
					<div class="input-field col s12">
						<input type="text" id="txtEmail" name="txtEmail" value="<?php echo $empEmail;?>">
						<label for="txtEmail">E-mail</label>
					</div>
				</div>
			</div>
			<!-- Salary -->
			<div class="row">
				<div class="col s12">
					<div class="input-field col s12">
						<input type="text" id="txtSalary" name="txtSalary" value="<?php echo $empSalary;?>">
						<label for="txtSalary">เงินเดือน</label>
					</div>
				</div>
			</div>
			<!-- Password -->
			<div class="divider"></div>
			<div class="section">
				<div class="row">
					<div class="col s12">
						<?php echo $inputPassword; ?>
						<?php echo $inputConfirmPassword; ?>
						<?php echo $descriptionPassword; ?>
					</div>
				</div>
			</div>
			<!-- Picture  -->
			<div class="divider"></div>
			<div class="section">
				<div class="row">
					<div class="col s12">
						<div class="file-field input-field">
				            <div class="btn">
				              <span>รูปถ่าย</span>
				              <input type="file" name="fuEmpPicture" id="fuEmpPicture">
				            </div>
				            <div class="file-path-wrapper">
				              <input class="file-path validate" type="text">
				            </div>
				          </div>
						<div>
							<?php if ($empPictureImg != "") : ?>
								<img src="<?php echo base_url($empPictureImg) ?>" class="responsive-img materialboxed">
							<?php endif ?>	
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="divider"></div>
		<div id="profileinfo" class="section">
			<h4 class="header">ประวัติส่วนตัว</h4>
			<!-- Title , Firstname , Lastname in Thai -->
			<div class="row">
				<div class="col s12">
					<div class="input-field col s3">
						<?php echo form_dropdown("ddlNameTitleThai", $queryNameTitleThai, $empNameTitleThai, "id='ddlNameTitleThai'");?>
						<label for="ddlNameTitleThai">คำนำหน้า</label>
					</div>
					<div class="input-field col s4">
						<input type="text" class="validate" id="txtFirstnameThai" name="txtFirstnameThai" value="<?php echo $empFirstnameThai?>">
						<label for="txtFirstnameThai">ชื่อ</label>
					</div>
					<div class="input-field col s5">
						<input type="text" class="validate" id="txtLastnameThai" name="txtLastnameThai" value="<?php echo $empLastnameThai?>">
						<label for="txtLastnameThai">นามสกุล</label>
					</div>
				</div>
			</div>
			<!-- Title , Firstname , Lastname in English -->
			<div class="row">
				<div class="col s12">
					<div class="input-field col s3">
						<?php echo form_dropdown("ddlNameTitleEnglish", $queryNameTitleEnglish, $empNameTitleEnglish, "id='ddlNameTitleEnglish'");?>
						<label for="ddlNameTitleEnglish">Name title</label>
					</div>
					<div class="input-field col s4">
						<input type="text" class="validate" id="txtFirstnameEnglish" name="txtFirstnameEnglish" value="<?php echo $empFirstnameEnglish?>">
						<label for="txtFirstnameEnglish">Firstname</label>
					</div>
					<div class="input-field col s5">
						<input type="text" class="validate" id="txtLastnameEnglish" name="txtLastnameEnglish" value="<?php echo $empFirstnameEnglish?>">
						<label for="txtLastnameEnglish">Lastname</label>
					</div>
				</div>
			</div>
			<!-- call name , birthday, birthplace -->
			<div class="row">
				<div class="col s12">
					<div class="input-field col s4">
						<input type="text" id="txtCallName" name="txtCallName" class="validate" value="<?php echo $empCallName?>">
						<label for="txtCallName">ชื่อเล่น</label>
					</div>
					<div class="input-field col s4">
						<input type="text" id="txtTelePhone" name="txtTelePhone" class="validate" value="<?php echo $empTelePhone?>">
						<label for="txtTelePhone">เบอร์โทรศัพท์</label>
					</div>
					<div class="input-field col s4">
						<input type="text" id="txtMobilePhone" name="txtMobilePhone" class="validate" value="<?php echo $empMobilePhone?>">
						<label for="txtMobilePhone">เบอร์มือถือ</label>
					</div>
				</div>
			</div>
			<!-- Birthday , Birthplace -->
			<div class="row">
				<div class="col s12">
					<div class="input-field col s5">
						<input type="text" id="txtBirthPlace" name="txtBirthPlace" class="validate" value="<?php echo $empBirthPlace?>">
						<label for="txtBirthPlace">สถานที่เกิด</label>
					</div>
					<div class="col s7">
						<div class="input-field col s4">
							<?php echo form_dropdown("ddlBirthDayDay", $ddlBirthDayDay, $birthDayDay, "id='ddlBirthDayDay' ");?>
							<label for="ddlBirthDayDay">วันที่เกิด</label>
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
						<input type="text" name="gender_hidden" id="gender_hidden" value="0" style="display:none;">
						<label for="gender_hidden">เพศ</label>
						<p>
							<input name="rdoSex" type="radio" id="male" value="m" <?php echo set_value('rdoSex', $empSex) === "M" ? "checked" : "";?> />
							<label for="male">ชาย</label>
						</p>
						<p>
							<input name="rdoSex" type="radio" id="female" value="f" <?php echo set_value('rdoSex', $empSex) === "F" ? "checked" : "";?> />
							<label for="female">หญิง</label>
						</p>
					</div>
					<div class="col s9">
						<div class="input-field col s4">
							<input type="text" name="txtHeight" id="txtHeight" class="validate" value="<?php echo $empHeight?>">
							<label for="txtHeight">ส่วนสูง</label>
						</div>
						<div class="input-field col s4">
							<input type="text" name="txtWeight" id="txtWeight" class="validate" value="<?php echo $empWeight?>">
							<label for="txtWeight">น้ำหนัก</label>
						</div>
						<div class="input-field col s4">
							<input type="text" name="txtBlood" id="txtBlood" class="validate" value="<?php echo $empBlood?>">
							<label for="txtBlood">กรุ๊ปเลือด</label>
						</div>
						<div class="input-field col s4">
							<input type="text" name="txtNationality" id="txtNationality" class="validate" value="<?php echo $empNationality?>">
							<label for="txtNationality">เชื้อชาติ</label>
						</div>
						<div class="input-field col s4">
							<input type="text" name="txtRace" id="txtRace" class="validate" value="<?php echo $empRace?>">
							<label for="txtRace">สัญชาติ</label>
						</div>
						<div class="input-field col s4">
							<input type="text" name="txtReligion" id="txtReligion" class="validate" value="<?php echo $empReligion?>">
							<label for="txtReligion">ศาสนา</label>
						</div>
					</div>
				</div>
			</div>
			<!-- martial status -->
			<div class="row">
				<div class="col s12">
					<div class="input-field col s12">
						<input type="text" name="martial_hidden" id="martial_hidden" value="0" style="display:none;">
						<label for="martial_hidden">สถานภาพ</label>
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
						<input type="text" name="military_hidden" id="military_hidden" value="0" style="display:none;">
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
			<!-- Id card -->
			<div class="row">
				<div class="col s12">
					<div class="input-field col s12">
						<input type="text" id="txtIDCard" name="txtIDCard" value="<?php echo $empIDCard?>">
						<label for="txtIDCard">รหัสบัตรประชาชน</label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col s12">
					<div class="file-field input-field">
			            <div class="btn">
			              <span>รูปบัตรประชาชน</span>
			              <input type="file" name="fuIDCard" id="fuIDCard">
			            </div>
			            <div class="file-path-wrapper">
			              <input class="file-path validate" type="text">
			            </div>
			          </div>
					<div>
						<?php if ($empIDCardImg != "") : ?>
							<img src="<?php echo base_url($empIDCardImg) ?>" class="responsive-img materialboxed">
						<?php endif ?>	
					</div>
				</div>
			</div>
			<!-- Address -->
			<div class="row">
				<div class="col s12">
					<div class="input-field col s4">
						<input type="text" id="txtAddressNumber" name="txtAddressNumber" class="validate" value="<?php echo $empAddressNumber?>">
						<label for="txtAddressNumber">บ้านเลขที่</label>
					</div>
					<div class="input-field col s4">
						<input type="text" id="txtAddressMoo" name="txtAddressMoo" class="validate" value="<?php echo $empAddressMoo?>">
						<label for="txtAddressMoo">หมู่</label>
					</div>
					<div class="input-field col s4">
						<input type="text" id="txtAddressRoad" name="txtAddressRoad" class="validate" value="<?php echo $empAddressRoad?>">
						<label for="txtAddressRoad">ถนน</label>
					</div>
					<div class="input-field col s4">
						<?php echo form_dropdown("ddlAddressProvince", $queryProvince, $empAddressProvince, "id='ddlAddressProvince'");?>
						<label for="ddlAddressProvince">จังหวัด</label>
					</div>
					<div class="input-field col s4">
						<?php echo form_dropdown("ddlAddressAmphur", $queryAmphur, $empAddressAmphur, "id='ddlAddressAmphur'");?>
						<label for="ddlAddressAmphur">เขต/อำเภอ</label>
					</div>
					<div class="input-field col s4">
						<?php echo form_dropdown("ddlAddressDistrict", $queryDistrict, $empAddressDistrict, "id='ddlAddressDistrict'");?>
						<label for="ddlAddressDistrict">แขวง/ตำบล</label>
					</div>
					<div class="input-field col s4">
						<?php echo form_dropdown("ddlAddressZipcode", $queryZipcode, $empAddressZipcode, "id='ddlAddressZipcode'");?>
						<label for="ddlAddressZipcode">รหัสไปรษณีย์</label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col s12">
					<div class="file-field input-field">
			            <div class="btn">
			              <span>สำเนาทะเบียนบ้าน</span>
			              <input type="file" name="fuAddress" id="fuAddress">
			            </div>
			            <div class="file-path-wrapper">
			              <input class="file-path validate" type="text">
			            </div>
			          </div>
					<div>
						<?php if ($empAddressImg != "") : ?>
							<img src="<?php echo base_url($empAddressImg) ?>" class="responsive-img materialboxed">
						<?php endif ?>	
					</div>
				</div>
			</div>
		</div>
		<div class="divider"></div>
		<div id="historyworkinfo" class="section">
			<h4 class="header">ประวัติการทำงาน</h4>
			<div class="row">
				<div class="col s12 input-field">
					<?php $i = 0; foreach ($query_history_work as $row): $i++; ?>
						<input type="hidden" id="hd_history_work_id_<?php echo $i; ?>" name="hd_history_work_id[]" value="<?php echo $row["ehw_id"] ?>">
						<input type="hidden" id="hd_history_work_user_id_<?php echo $i; ?>" name="hd_history_work_user_id[]" value="<?php echo $row["ehw_user_id"] ?>">
						<input type="hidden" id="hd_history_work_company_<?php echo $i; ?>" name="hd_history_work_company[]" value="<?php echo $row["ehw_company"] ?>">
						<input type="hidden" id="hd_history_work_position_<?php echo $i; ?>" name="hd_history_work_position[]" value="<?php echo $row["ehw_position"] ?>">
						<input type="hidden" id="hd_history_work_district_<?php echo $i; ?>" name="hd_history_work_district[]" value="<?php echo $row["ehw_district"] ?>">
						<input type="hidden" id="hd_history_work_desc_<?php echo $i; ?>" name="hd_history_work_desc[]" value="<?php echo $row["ehw_desc"] ?>">
						<input type="hidden" id="hd_history_work_date_from_<?php echo $i; ?>" name="hd_history_work_date_from[]" value="<?php echo $row["ehw_date_from"] ?>">
						<input type="hidden" id="hd_history_work_date_to_<?php echo $i; ?>" name="hd_history_work_date_to[]" value="<?php echo $row["ehw_date_to"] ?>">
					<?php endforeach ?>
					<div id='history_work_list'>

					</div>
					<a href="javascript:void(0);" class="btn waves-effect waves-light blue" onclick='gen_history_work_template();'>เพิ่มประวัติการทำงาน</a>
				</div>
			</div>
		</div>
		<div class="divider"></div>
		<div id="historystudyinfo" class="section">
			<h4 class="header">ประวัติการศึกษา</h4>
			<div class="row">
				<div class="col s12 input-field">
					<?php $i = 0; foreach ($query_history_study as $row): $i++; ?>
						<input type="hidden" id="hd_history_study_id_<?php echo $i; ?>" name="hd_history_study_id[]" value="<?php echo $row["ehs_id"] ?>">
						<input type="hidden" id="hd_history_study_user_id_<?php echo $i; ?>" name="hd_history_study_user_id[]" value="<?php echo $row["ehs_user_id"] ?>">
						<input type="hidden" id="hd_history_study_academy_<?php echo $i; ?>" name="hd_history_study_academy[]" value="<?php echo $row["ehs_academy"] ?>">
						<input type="hidden" id="hd_history_study_major_<?php echo $i; ?>" name="hd_history_study_major[]" value="<?php echo $row["ehs_major"] ?>">
						<input type="hidden" id="hd_history_study_desc_<?php echo $i; ?>" name="hd_history_study_desc[]" value="<?php echo $row["ehs_desc"] ?>">
						<input type="hidden" id="hd_history_study_date_from_<?php echo $i; ?>" name="hd_history_study_date_from[]" value="<?php echo $row["ehs_date_from"] ?>">
						<input type="hidden" id="hd_history_study_date_to_<?php echo $i; ?>" name="hd_history_study_date_to[]" value="<?php echo $row["ehs_date_to"] ?>">
					<?php endforeach ?>
					<div id='history_study_list'>
					</div>
					<a href="javascript:void(0);" class="btn waves-effect waves-light blue" onclick='gen_history_study_template();'>เพิ่มประวัติการศึกษา</a>
				</div>
			</div>
		</div>
		<div class="divider"></div>
		<div id="othercontactinfo" class="section">
			<h4 class="header">บุคคลอื่นที่ติดต่อได้</h4>
			<div class="row">
				<div class="col s12">
					<div class="input-field col s3">
						<?php echo form_dropdown("ddlNameTitleFriend", $queryNameTitleFriend, $empNameTitleFriend, "id='ddlNameTitleFriend'");?>
						<label for="ddlNameTitleFriend">คำนำหน้า</label>
					</div>
					<div class="input-field col s4">
						<input readonly="true" type="text" id="txtFirstnameFriend" name="txtFirstnameFriend" class="validate" value="<?php echo $empFirstnameFriend?>">
						<label for="txtFirstnameFriend">ชื่อ</label>
					</div>
					<div class="input-field col s5">
						<input readonly="true" type="text" id="txtLastnameFriend" name="txtLastnameFriend" class="validate" value="<?php echo $empLastnameFriend?>">
						<label for="txtLastnameFriend">นามสกุล</label>
					</div>
				</div>
				<div class="col s12">
					<div class="input-field col s4">
						<input type="text" id="txtAddressNumberFriend" name="txtAddressNumberFriend" value="<?php echo $empAddressNumberFriend?>">
						<label for="txtAddressNumberFriend">บ้านเลขที่</label>
					</div>
					<div class="input-field col s4">
						<input type="text" id="txtAddressMooFriend" name="txtAddressMooFriend" value="<?php echo $empAddressMooFriend?>">
						<label for="txtAddressMooFriend">หมู่</label>
					</div>
					<div class="input-field col s4">
						<input type="text" id="txtAddressRoadFriend" name="txtAddressRoadFriend" value="<?php echo $empAddressRoadFriend?>">
						<label for="txtAddressRoadFriend">ถนน</label>
					</div>
					<div class="input-field col s4">
						<?php echo form_dropdown("ddlAddressProvinceFriend", $queryProvinceFriend, $empAddressProvinceFriend, "id='ddlAddressProvinceFriend'");?>
						<label for="ddlAddressProvinceFriend">จังหวัด</label>
					</div>
					<div class="input-field col s4">
						<?php echo form_dropdown("ddlAddressAmphurFriend", $queryAmphurFriend, $empAddressAmphurFriend, "id='ddlAddressAmphurFriend'");?>
						<label for="ddlAddressAmphurFriend">เขต/อำเภอ</label>
					</div>
					<div class="input-field col s4">
						<?php echo form_dropdown("ddlAddressDistrictFriend", $queryDistrictFriend, $empAddressDistrictFriend, "id='ddlAddressDistrictFriend'");?>
						<label for="ddlAddressDistrictFriend">แขวง/ตำบล</label>
					</div>
					<div class="input-field col s4">
						<?php echo form_dropdown("ddlAddressZipcodeFriend", $queryZipcodeFriend, $empAddressZipcodeFriend, "id='ddlAddressZipcodeFriend'");?>
						<label for="ddlAddressZipcodeFriend">รหัสไปรษณีย์</label>
					</div>
				</div>
			</div>
		</div>
		<div class="divider"></div>
		<div id="documentinfo" class="section">
			<h4 class="header">เอกสาร</h4>
			<div class="row">
				<div class="col s12">
					<h5>เอกสารการสมัครงาน</h5>
					<div class="file-field input-field">
			            <div class="btn">
			              <span>เอกสารการสมัครงาน</span>
			              <input type="file" name="fuDocRegisterJob" id="fuDocRegisterJob">
			            </div>
			            <div class="file-path-wrapper">
			              <input class="file-path validate" type="text">
			            </div>
			          </div>
					<div>
						<?php if ($empDocumentRegisterJobImg != "") : ?>
							<img src="<?php echo base_url($empDocumentRegisterJobImg) ?>" class="responsive-img materialboxed">
						<?php endif ?>	
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col s12">
					<h5>เอกสารการโอนเงินเดือน</h5>
					<div class="input-field col s6">
						<?php echo form_dropdown("ddlBank", $queryBank, $empBankID, "id='ddlBank'"); ?>
						<label for="ddlBank">ธนาคาร</label>
					</div>
					<div class="input-field col s6">
						<input type="text" name="txtBankAccountBranch" id="txtBankAccountBranch" value="<?php echo $empBankBranch ?>">
						<label for="txtBankAccountBranch">สาขา</label>
					</div>
					<div class="input-field col s6">
						<?php echo form_dropdown("ddlBankAccountType", $queryBankType, $empBankType, "id='ddlBankAccountType'"); ?>
						<label for="ddlBankAccountType">ประเภทบัญชี</label>
					</div>
					<div class="input-field col s6">
						<input type="text" name="txtBankAccountNumber" id="txtBankAccountNumber" value="<?php echo $empBankNumber ?>">
						<label for="txtBankAccountNumber">ประเภทบัญชี</label>
					</div>
				</div>
				<div class="col s12">
					<div class="file-field input-field">
			            <div class="btn">
			              <span>สำเนาสมุดบัญชีธนาคาร</span>
			              <input type="file" name="fuBank" id="fuBank">
			            </div>
			            <div class="file-path-wrapper">
			              <input class="file-path validate" type="text">
			            </div>
			          </div>
					<div>
						<?php if ($empBankImg != "") : ?>
							<img src="<?php echo base_url($empBankImg) ?>" class="responsive-img materialboxed">
						<?php endif ?>	
					</div>
				</div>
			</div>
		</div>
		<!-- Submit Button -->
		<div class="divider"></div>
		<div class="section">
			<div class="row">
				<div class="col s2">
					<input type="submit" onclick="return check_before_submit();" class="btn" value="บันทึก">
				</div>
				<div class="col s2 offset-s8 right-align"> 
					<a href="<?php echo site_url('hr/Employees') ?>" class="btn red lighten-1 right-align">ยกเลิก</a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo form_close(); ?>