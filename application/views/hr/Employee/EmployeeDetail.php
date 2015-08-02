<script type="text/javascript">
    $(document).ready(function(){
       $("[id$='ddlAddressProvince']").change(function(){
           $.ajax({
               type: "POST",
               url: "./AjaxEmployee/getListAmphur/"+$(this).val(),
                success: function (data) {
                    $("[id$='ddlAddressAmphur']").html(data);
                    $("[id$='ddlAddressAmphur']").change();
                }
           });
       });
        $("[id$='ddlAddressAmphur']").change(function(){
            var provinceID = $("[id$='ddlAddressProvince']").val();
            $.ajax({
                type: "POST",
                url: "./AjaxEmployee/getListDistrict/"+provinceID+"/"+$(this).val(),
                success: function (data) {
                    $("[id$='ddlAddressDistrict']").html(data);
                    $("[id$='ddlAddressDistrict']").change();
                }
            });
        });
        $("[id$='ddlAddressDistrict']").change(function(){
            var provinceID = $("[id$='ddlAddressProvince']").val();
            var amphurID = $("[id$='ddlAddressAmphur']").val();
            $.ajax({
                type: "POST",
                url: "./AjaxEmployee/getListZipcode/"+provinceID+"/"+amphurID+"/"+$(this).val(),
                success: function (data) {
                    $("[id$='ddlAddressZipcode']").html(data);
                }
            });
        });
    });

    function checkBeforeSubmit(){
        var userName = $("[id$='txtUsername']").val();
        var passWord = $("[id$='txtPassword']").val();
        var cpassWord = $("[id$='txtPassword2']").val();
        var firstName = $("[id$='txtFirstname']").val();
        var lastName = $("[id$='txtLastname']").val();

        return true;
    }
</script>
<?php echo form_open_multipart($FormUrl); ?>
<h2>ชื่อผู้ใช้เข้าระบบ</h2>
Username : <?php echo form_input(array("name"=>"txtUsername","id"=>"txtUsername")); ?>
Password : <?php echo form_password(array("name"=>"txtPassword","id"=>"txtPassword")); ?>
<br/>
Confirm Password : <?php echo form_password(array("name"=>"txtPassword2","id"=>"txtPassword2")); ?>
<br/>
<h2>ชื่อ-นามสกุล</h2>
คำนำหน้า  <?php echo form_dropdown("ddlTitle",$queryTitle); ?>
ชื่อ : <?php echo form_input(array("name"=>"txtFirstname","id"=>"txtFirstname")); ?>
นามสกุล : <?php echo form_input(array("name"=>"txtLastname","id"=>"txtLastname")); ?>
<br/>
วันเกิด :  <?php echo form_dropdown("ddlBirthDayDay",$birthDayDay,array(),"id='ddlBirthDayDay'"); ?>
<?php echo form_dropdown("ddlBirthDayMonth",$birthDayMonth,array(),"id='ddlBirthDayMonth'"); ?>
<?php echo form_dropdown("ddlBirthDayYear",$birthDayYear,array(),"id='ddlBirthDayYear'"); ?>
<h2>เกี่ยวกับบัตรประชาชน</h2>
รหัสบัตรประชาชน : <?php echo form_input(array("name"=>"txtIDCard","id"=>"txtIDCard")); ?>
สำเนาบัตรประชาชน : <?php echo form_upload(array("name"=>"fuIDCard","id"=>"fuIDCard")); ?>
<h2>ที่อยู่พนักงาน</h2>
บ้านเลขที่ <?php echo form_input(array("name"=>"txtAddressNumber","id"=>"txtAddressNumber")); ?>
หมู่ <?php echo form_input(array("name"=>"txtAddressMoo","id"=>"txtAddressMoo")); ?>
จังหวัด <?php echo form_dropdown("ddlAddressProvince",$queryProvince,array(),"id='ddlAddressProvince'"); ?>
เขต/อำเภอ <?php echo form_dropdown("ddlAddressAmphur",array("0"=>"--เลือก--"),array(),"id='ddlAddressAmphur'"); ?>
แขวง/ตำบล <?php echo form_dropdown("ddlAddressDistrict",array("0"=>"--เลือก--"),array(),"id='ddlAddressDistrict'"); ?>
รหัสไปรษณีย์ <?php echo form_dropdown("ddlAddressZipcode",array("0"=>"--เลือก--"),array(),"id='ddlAddressZipcode'"); ?>
สำเนาบัตรทะเบียนบ้าน : <?php echo form_upload(array("name"=>"fuAddress","id"=>"fuAddress")); ?>
<h2>เกี่ยวกับพนักงาน</h2>
รหัสพนักงาน : <?php echo form_input(array("name"=>"txtEmpID","id"=>"txtEmpID")); ?>
แผนก : <?php echo form_dropdown("ddlDepartment",$queryDepartment,array(),"id='ddlDepartment'"); ?>
ตำแหน่ง : <?php echo form_dropdown("ddlPosition",$queryPosition,array(),"id='ddlPosition'"); ?>
<h2>เอกสารการสมัคร</h2>
รูปถ่าย : <?php echo form_upload(array("name"=>"fuEmpPicture","id"=>"fuEmpPicture")); ?>
ใบสำเร็จการศึกษา : <?php echo form_upload(array("name"=>"fuEmpTranscript","id"=>"fuEmpTranscript")); ?>
อื่นๆ : <?php echo form_upload(array("name"=>"fuEmpOther","id"=>"fuEmpOther")); ?>
<h2>เอกสารการโอนเงินเดือน</h2>
ธนาคาร : <?php echo form_dropdown("ddlBank",$queryBank,array(),"id='ddlBank'"); ?>
สาขา <?php echo form_input(array("name"=>"txtBankAccountBranch","id"=>"txtBankAccountBranch")); ?>
ประเภทบัญชี : <?php echo form_dropdown("ddlBankAccountType",$queryBankType,array(),"id='ddlBankAccountType'"); ?>
เลขที่บัญชี : <?php echo form_input(array("name"=>"txtBankAccountNumber","id"=>"txtBankAccountNumber")); ?>
สำเนาสมุดบัญชี <?php echo form_upload(array("name"=>"fuBankBook","id"=>"fuBankBook")); ?>
<?php
echo form_submit(array("value"=>"บันทึก","onclick"=>"return checkBeforeSubmit();"));
echo form_close();