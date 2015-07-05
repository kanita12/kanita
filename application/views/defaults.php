<div class="row col cssmenu2">
    <div class="w-col w-col-6 text-center">
      <a href="#" class="btn btn-primary" style="width:80%;">ข่าวสารประชาสัมพันธ์</a>
    </div>
    <div class="w-col w-col-6 text-center">
       <a href="#" class="btn btn-primary" style="width:80%;">กิจกรรมภายในองค์กร</a>
    </div>
</div>
<div id="divMember" class="w-row cssdivmember">
    <div class="w-col w-col-4">
     <img src="<?php echo base_url().'assets/images/people.png' ?>" widht="200px" height="300px" alt="553f845e2568456c5fb41ac7_people.png">
    </div>
    <div class="w-col w-col-8 text-center">
        <div class="txtblue16">
          <?php $emp = getEmployeeDetail($this->session->userdata('empid')); ?>
          <span class="csstextbig">
            <b>
              <?php echo $emp["EmpNameTitleThai"] ?><?php echo $emp["EmpFirstnameThai"] ?>
              <?php echo $emp["EmpLastnameThai"] ?>
            </b>
          </span>
          <br/><br/>
          <span>หน่วยงาน <?php echo $emp["InstitutionName"] ?></span><br/>
          <span>แผนก <?php echo $emp["DepartmentName"] ?></span><br/>
          <span>ตำแหน่ง <?php echo $emp["PositionName"] ?></span><br/>
          <span>สถานะ xx</span>
        </div>
        <div class="w-col w-col-12 cssct1">
           <div class="w-col w-col-6">
            <div class="csstextrdesktop txtwhite14">ขาดงาน xx วัน
              <br><span>ลางาน xx วัน</span>
              <br><span>มาสาย xx วัน</span>
              <br><span>จำนวน OT xx ชั่วโมง</span>
          </div>
          </div>
          <div class="w-col w-col-6 ">
        <a class="btn btn-default btn-block" href="<?php echo site_url('Leave'); ?>">ตรวจสอบใบลา</a>
        <a class="btn btn-default btn-block" href="#">ตรวจสอบเวลางาน</a>
        </div>
    </div>
    </div>                 
</div>
 <div class="w-row cssmenu3">
        <div class="w-col w-col-4">
          <a href="#" class="btn btn-primary cssmenu3">ข้อมูลส่วนตัว</a>
         
        </div>
        <div class="w-col w-col-4">
          <a href="#" class="btn btn-primary cssmenu3">ลางาน</a>
        </div>
         <div class="w-col w-col-4">
          <a href="#" class="btn btn-primary cssmenu3">ส่งข้อความถึง HR</a>
         
        </div>
</div>