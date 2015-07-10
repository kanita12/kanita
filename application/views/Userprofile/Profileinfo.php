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