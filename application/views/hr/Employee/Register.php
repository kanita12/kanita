	<script type="text/javascript" src="<?php echo bootstrap_url().'js/bootstrap-datepicker.js' ?>"></script>
	<!-- เกี่ยวกับ jquery ย้ายไปใช้ไฟล์นอกทั้งหมด มันเยอะเกินไป -->
	<script type="text/javascript" src="<?php echo js_url().'employee/register.js' ?>"></script>
		<?php
			$inputUsername = '';
			$inputPassword = '';
			$inputConfirmPassword = '';
			$descriptionPassword = '';
			$inputEmpID = '';
			
			if ($empPassword != '')
			{
				$inputUsername = $empUsername;
				$inputPassword = 'New Password : '.form_password(array("name" => "txtPassword", "id" => "txtPassword"));
				$inputConfirmPassword = 'Confirm Password : '.form_password(array("name" => "txtPassword2", "id" => "txtPassword2"));
				$inputEmpID = $empID;
			}
			else
			{
				$inputUsername = form_input(array("name" => "txtUsername", "id" => "txtUsername"), $empUsername);
				$descriptionPassword = '<br/><br/>* พาสเวิร์ดอัตโนมัติเลขท้าย 4 ตัวสุดท้ายของเลขบัตรประชาชน';
				$inputEmpID = form_input(array("name" => "txtEmpID", "id" => "txtEmpID"), $empID);
			}
		
			echo form_open_multipart($FormUrl); 
		?>

		<input type='hidden' id='hdEmpPassword' name='hdEmpPassword' value='<?php echo $empPassword ?>'>
		<input type='hidden' id='hdEmpID' name='hdEmpID' value='<?php echo $empID ?>'>
		<input type="hidden" id="hd_emp_headman_level_1" value="<?php echo $empHeadmanID_level_1 ?>">
		<input type="hidden" id="hd_emp_headman_level_2" value="<?php echo $empHeadmanID_level_2 ?>">
		<input type="hidden" id="hd_emp_headman_level_3" value="<?php echo $empHeadmanID_level_3 ?>">
		<input type="hidden" id="hd_site_url" value="<?php echo site_url() ?>/">

		<div  class="reg__content__detail">
			<div class="fr-text">
				รหัสพนักงาน : <?php echo $inputEmpID ?>
				<br/><br/>
				หน่วยงาน :
				<?php echo form_dropdown("ddlInstitution", $queryInstitution, $empInstitutionID, "id='ddlInstitution'"); ?>
				แผนก  :
				<?php echo form_dropdown("ddlDepartment", $queryDepartment, $empDepartmentID, "id='ddlDepartment'"); ?>
				ตำแหน่ง    :
				<?php echo form_dropdown("ddlPosition", $queryPosition, $empPositionID, "id='ddlPosition'"); ?>
				<br/><br/>
				หัวหน้าของคุณ Level 1 : <?php echo form_dropdown("ddlHeadman_level_1", $queryHeadman_level_1, $empHeadmanID_level_1, "id='ddlHeadman_level_1'"); ?>
				<br>
				หัวหน้าของคุณ Level 2 : <?php echo form_dropdown("ddlHeadman_level_2", $queryHeadman_level_2, $empHeadmanID_level_2, "id='ddlHeadman_level_2'"); ?>
				<br>
				หัวหน้าของคุณ Level 3 : <?php echo form_dropdown("ddlHeadman_level_3", $queryHeadman_level_3, $empHeadmanID_level_3, "id='ddlHeadman_level_3'"); ?>
				<br/><br/>
				วันที่เริ่มงาน :
				<?php echo form_input(array('name'=>'txtStartWorkDate','id'=>'txtStartWorkDate','value'=>$empStartWorkDate,'class'=>'datepicker')) ?>
				วันที่ผ่านทดลองงาน :
				<?php echo form_input(array('name'=>'txtSuccessTrialWorkDate','id'=>'txtSuccessTrialWorkDate','value'=>$empSuccessTrialWorkDate,'class'=>'datepicker')) ?>
				<br/><br/>
				วันที่เริ่มงาน (ตามสัญญา) :
				<?php echo form_input(array('name'=>'txtPromiseStartWorkDate','id'=>'txtPromiseStartWorkDate','value'=>$empPromiseStartWorkDate,'class'=>'datepicker')) ?>
				เงินเดือน :
				<?php echo form_input(array('name'=>'txtSalary','id'=>'txtSalary','value'=>$empSalary)) ?>
				<br/><br/>
				Username : <?php echo $inputUsername ?>
				<br/>
				<?php echo $inputPassword; ?>
				<?php echo $inputConfirmPassword; ?>
				<?php echo $descriptionPassword; ?>
				<br/><br/>
				<div>
					รูปถ่าย :
					<?php echo form_upload(array("name" => "fuEmpPicture", "id" => "fuEmpPicture")); ?>

					<?php
					if ($empPictureImg != "")
						echo "<br/><br/><img src='" . base_url($empPictureImg) . "' style='max-width:100%;max-height:300px;' />";
					?>
				</div>
			</div>
		</div>
		<br/>
		<div  class="reg__content__detail">
			<b class="ht1">ประวัติส่วนตัว (Personal Information)</b>
			<div class="fr-text">
				<br>
				ชื่อ-นามสกุล ภาษาไทย
				<br/>
				<?php echo form_dropdown("ddlNameTitleThai", $queryNameTitleThai, $empNameTitleThai, "id='ddlNameTitleThai'"); ?>
				<?php echo form_input(array("name" => "txtFirstnameThai", "id" => "txtFirstnameThai"), $empFirstnameThai); ?>
				<?php echo form_input(array("name" => "txtLastnameThai", "id" => "txtLastnameThai"), $empLastnameThai); ?>
				<br/><br/>
				Firstname Lastname English
				<br/>
				<?php echo form_dropdown("ddlNameTitleEnglish", $queryNameTitleEnglish, $empNameTitleEnglish, "id='ddlNameTitleEnglish'"); ?>
				<?php echo form_input(array("name" => "txtFirstnameEnglish", "id" => "txtFirstnameEnglish"), $empFirstnameEnglish); ?>
				<?php echo form_input(array("name" => "txtLastnameEnglish", "id" => "txtLastnameEnglish"), $empLastnameEnglish); ?>
				<br/><br/>
				ชื่อเล่น : <?php echo form_input(array('name'=>'txtCallName','id'=>'txtCallName'),$empCallName); ?>
				<br/><br/>
				เบอร์โทรศัพท์ :
				<?php echo form_input(array('name'=>'txtTelePhone','id'=>'txtTelePhone',"maxlength"=>"9"),$empTelePhone); ?>
				เบอร์มือถือ :
				<?php echo form_input(array('name'=>'txtMobilePhone','id'=>'txtMobilePhone',"maxlength"=>"10"),$empMobilePhone); ?>
				<br/><br/>
				E-mail :
				<?php echo form_input(array('name'=>'txtEmail','id'=>'txtEmail'),$empEmail); ?>
				<br/><br/>
				สถานที่เกิด :
				<?php echo form_input(array('name'=>'txtBirthPlace','id'=>'txtBirthPlace'),$empBirthPlace); ?>
				<br/><br/>
				วัน-เดือน-ปี เกิด :
				<?php echo form_dropdown("ddlBirthDayDay", $ddlBirthDayDay, $birthDayDay, "id='ddlBirthDayDay'"); ?>
				<?php echo form_dropdown("ddlBirthDayMonth", $ddlBirthDayMonth, $birthDayMonth, "id='ddlBirthDayMonth'"); ?>
				<?php echo form_dropdown("ddlBirthDayYear", $ddlBirthDayYear, $birthDayYear, "id='ddlBirthDayYear'"); ?>
				<br/><br/>
				เพศ : <?php echo form_radio(array('name'=>'rdoSex','id'=>'rdoSex','value'=>'M','checked'=>$empSex=='M'?TRUE:FALSE)); ?>ชาย
				<?php echo form_radio(array('name'=>'rdoSex','id'=>'rdoSex','value'=>'F','checked'=>$empSex=='F'?TRUE:FALSE)); ?>หญิง
				<br/><br/>
				ส่วนสูง : <?php echo form_input(array('name'=>'txtHeight','id'=>'txtHeight','value'=>$empHeight)); ?>
				น้ำหนัก : <?php echo form_input(array('name'=>'txtWeight','id'=>'txtWeight','value'=>$empWeight)); ?>
				กรุ๊ปเลือด : <?php echo form_input(array('name'=>'txtBlood','id'=>'txtBlood','value'=>$empBlood)); ?>
				<br/><br/>
				เชื้อชาติ : <?php echo form_input(array('name'=>'txtNationality','id'=>'txtNationality','value'=>$empNationality)); ?>

				สัญชาติ : <?php echo form_input(array('name'=>'txtRace','id'=>'txtRace','value'=>$empRace)); ?>

				ศาสนา : <?php echo form_input(array('name'=>'txtReligion','id'=>'txtReligion','value'=>$empReligion)); ?>
				<br/><br/>
				สถานภาพ :
				<?php foreach ($queryMartialStatus->result_array() as $row): ?>
					<?php echo form_radio(array('name'=>'rdoMaritalStatus','id'=>'rdoMaritalStatus','value'=>$row['MARSID'],'checked'=>$row['MARSID']==$empMartialStatus?TRUE:FALSE)); ?>
					<?php echo $row['MARSName'] ?>
				<?php endforeach ?>
				<br/><br/>
				สถานภาพทางทหาร :
				<?php echo form_radio(array('name'=>'rdoMilitaryStatus','id'=>'rdoMilitaryStatus','value'=>'1','checked'=>$empMilitaryStatus==1?TRUE:FALSE)); ?>
				ผ่านการศึกษาวิชาทหาร
				<?php echo form_radio(array('name'=>'rdoMilitaryStatus','id'=>'rdoMilitaryStatus','value'=>'2','checked'=>$empMilitaryStatus==2?TRUE:FALSE)); ?>
				ผ่านเกณฑ์ทหาร
				<?php echo form_radio(array('name'=>'rdoMilitaryStatus','id'=>'rdoMilitaryStatus','value'=>'3','checked'=>$empMilitaryStatus==3?TRUE:FALSE)); ?>
				ได้รับการยกเว้นเนื่องจาก
				<?php echo form_input(array('name'=>'txtMilitaryReason','id'=>'txtMilitaryReason','value'=>$empMilitaryReason)); ?>
				<br/>

			</div>
		</div>
		<br>

		<div class="reg__content__detail">
			<b claas="ht1">เกี่ยวบัตรประชาชน</b>
			<div class="fr-text">
				<br>
				รหัสบัตรประชาชน :
				<?php echo form_input(array("name" => "txtIDCard", "id" => "txtIDCard","maxlength"=>"13"), $empIDCard); ?>
				<br>
				<br/>
				<div >
					สำเนาบัตรประชาชน
					<?php echo form_upload(array("name" => "fuIDCard", "id" => "fuIDCard")); ?>
					<?php
					if ($empIDCardImg != "")
						echo "<br/><br/><img src='" . base_url($empIDCardImg) . "' />";
					?>
				</div>
			</div>
		</div>
		<br>
		<div class="reg__content__detail">
			<b class="ht1">ที่อยู่พนักงาน</b>
			<br>
			<br>
			<div class="fr-text">
				บ้านเลขที่ :
				<?php echo form_input(array("name" => "txtAddressNumber", "id" => "txtAddressNumber"), $empAddressNumber); ?>
				หมู่ :
				<?php echo form_input(array("name" => "txtAddressMoo", "id" => "txtAddressMoo"), $empAddressMoo); ?>
				ถนน : <?php echo form_input(array("name" => "txtAddressRoad", "id" => "txtAddressRoad"), $empAddressRoad); ?>
				<br/>
				<br/>
				จังหวัด : <?php echo form_dropdown("ddlAddressProvince", $queryProvince, $empAddressProvince, "id='ddlAddressProvince'"); ?>
				เขต/อำเภอ : <?php echo form_dropdown("ddlAddressAmphur", $queryAmphur, $empAddressAmphur, "id='ddlAddressAmphur'"); ?>
				แขวง/ตำบล : <?php echo form_dropdown("ddlAddressDistrict", $queryDistrict, $empAddressDistrict, "id='ddlAddressDistrict'"); ?>
				<br>
				<br>
				รหัสไปรษณีย์ : <?php echo form_dropdown("ddlAddressZipcode", $queryZipcode, $empAddressZipcode, "id='ddlAddressZipcode'"); ?>
				<br>
				<br>
				<div>
					สำเนาทะเบียนบ้าน
					<?php echo form_upload(array("name" => "fuAddress", "id" => "fuAddress")); ?>
					<?php
					if ($empAddressImg != "")
						echo "<br/><img src='" . base_url($empAddressImg) . "' />";
					?>
				</div>
			</div>
		</div>
		<br/>
		<div class="reg__content__detail">
			<b class="ht1">บุคคลที่สามารถติดต่อได้</b>
			<br>
			<br>
			<div class="fr-text">
				ชื่อ - นามสกุล<br/>
				<?php echo form_dropdown("ddlNameTitleFriend", $queryNameTitleFriend, $empNameTitleFriend, "id='ddlNameTitleFriend'"); ?>
				<?php echo form_input(array("name" => "txtFirstnameFriend", "id" => "txtFirstnameFriend"), $empFirstnameFriend); ?>
				<?php echo form_input(array("name" => "txtLastnameFriend", "id" => "txtLastnameFriend"), $empLastnameFriend); ?>
				<br/><br/>
				บ้านเลขที่ :
				<?php echo form_input(array("name" => "txtAddressNumberFriend", "id" => "txtAddressNumberFriend"), $empAddressNumberFriend); ?>
				หมู่ :
				<?php echo form_input(array("name" => "txtAddressMooFriend", "id" => "txtAddressMooFriend"), $empAddressMooFriend); ?>
				ถนน : <?php echo form_input(array("name" => "txtAddressRoadFriend", "id" => "txtAddressRoadFriend"), $empAddressRoadFriend); ?>
				<br/>
				<br/>
				จังหวัด : <?php echo form_dropdown("ddlAddressProvinceFriend", $queryProvinceFriend, $empAddressProvinceFriend, "id='ddlAddressProvinceFriend'"); ?>
				เขต/อำเภอ : <?php echo form_dropdown("ddlAddressAmphurFriend", $queryAmphurFriend, $empAddressAmphurFriend, "id='ddlAddressAmphurFriend'"); ?>
				แขวง/ตำบล : <?php echo form_dropdown("ddlAddressDistrictFriend", $queryDistrictFriend, $empAddressDistrictFriend, "id='ddlAddressDistrictFriend'"); ?>
				<br>
				<br>
				รหัสไปรษณีย์ : <?php echo form_dropdown("ddlAddressZipcodeFriend", $queryZipcodeFriend, $empAddressZipcodeFriend, "id='ddlAddressZipcodeFriend'"); ?>
				<br/><br/>
				เบอร์โทรศัพท์ : <?php echo form_input(array("name" => "txtTelePhoneFriend", "id" => "txtTelePhoneFriend"), $empTelePhoneFriend); ?>
				เบอร์โทรศัพท์มือถือ : <?php echo form_input(array("name" => "txtMobilePhoneFriend", "id" => "txtMobilePhoneFriend"), $empMobilePhoneFriend); ?>
			</div>
		</div>
		<br>
		<div class="reg__content__detail">
			<b class="ht1">เอกสารการสมัครงาน : </b>
			<br>
			<div>
				<?php echo form_upload(array("name" => "fuDocRegisterJob", "id" => "fuDocRegisterJob")); ?>

				<?php
				if ($empDocumentRegisterJobImg != "")
					echo "<br/><br/><img src='" . base_url($empDocumentRegisterJobImg) . "' />";
				?>
			</div>
		</div>
		<br/>
		<div class="reg__content__detail">
			<b class="ht1">ประวัติการศึกษา : </b>
			<br>
			<?php 
			$i = 0;
			foreach ($query_history_study as $row): $i++; ?>
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
			<a href="javascript:void(0);" onclick='gen_history_studt_template();'>เพิ่มประวัติการศึกษา</a>
		</div>
		<br>
		<div class="reg__content__detail">
			<b class="ht1">ประวัติการทำงาน : </b>
			<br>
			<?php 
			$i = 0;
			foreach ($query_history_work as $row): $i++; ?>
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
			<a href="javascript:void(0);" onclick='gen_history_work_template();'>เพิ่มประวัติการทำงาน</a>
		</div>
		<br>
		<div class="reg__content__detail">
			<b class="ht1">เอกสารการโอนเงินเดือน : </b>
			<br>
			<br>
			<div class="fr-text ">
				ธนาคาร : <?php echo form_dropdown("ddlBank", $queryBank, $empBankID, "id='ddlBank'"); ?>
				สาขา : <?php echo form_input(array("name" => "txtBankAccountBranch", "id" => "txtBankAccountBranch"), $empBankBranch); ?>
				<br>
				<br>
				เลขที่บัญชี : <?php echo form_input(array("name" => "txtBankAccountNumber", "id" => "txtBankAccountNumber"), $empBankNumber); ?>
				บัญชี : <?php echo form_dropdown("ddlBankAccountType", $queryBankType, $empBankType, "id='ddlBankAccountType'"); ?>
				<br>
				<br>
			</div>
			<br>
			<div>
				สำเนาสมุดบัญชี
				<br>
				<br>
				<?php echo form_upload(array("name" => "fuBank", "id" => "fuBank")); ?>
				<?php
				if ($empBankImg != "")
					echo "<br/><br/><img src='" . base_url($empBankImg) . "' />";
				?>
			</div>
			<br>
		</div>
		<br>

		<br>
		<div>
			<div style="text-align:center;">
				<?php
				echo form_submit(array("value" => "บันทึก", "onclick" => "return checkBeforeSubmit();"));
				echo "&nbsp;";
				echo form_reset(array("value" => "ยกเลิก"));
				?>
			</div>
		</div>


		<?php echo form_close(); ?>
