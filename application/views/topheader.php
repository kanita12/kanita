<div class="header">
        <?php if($this->acl->hasPermission('access_admin') == true): ?>
        <div class="header__topmenu">
          <ul class="darkmenu">
            <li><a href="<?php echo site_url('admin/Dashboard');?>">หน้าหลักแอดมิน</a></li>
            <li><a href="javascript:void(0);">&nbsp;</a></li>
          </ul>
        </div>
        <?php endif ?>
        <?php if($this->acl->hasPermission('access_hr') == true): ?>
        <div class="header__topmenu">
          <ul class="darkmenu">
            <li>Menu HR</li>
            <li><a href="<?php echo site_url('hr/Employee'); ?>">รายชื่อพนักงาน</a></li>
            <li><a href="<?php echo site_url('hr/News'); ?>">ข่าวสาร</a></li>
            <li><a href="<?php echo site_url('hr/Activity'); ?>">กิจกรรม</a></li>
            <li><a href="<?php echo site_url('hr/Verifyleave'); ?>">ตรวจสอบใบลา</a></li>
            <li><a href="#">ตรวจสอบข้อความจากพนักงาน</a></li>
          </ul>
        </div>
        <?php endif ?>
        <?php if(IsHeadman()): ?>
        <div class="header__topmenu">
          <ul class="darkmenu">
            <li>Menu Headman</li>
            <li><a href="<?php echo site_url('headman/Yourteam'); ?>">ทีมของคุณ</a></li>
            <li><a href="<?php echo site_url('headman/Verifyleave'); ?>">ตรวจสอบใบลา</a></li>
            <li><a href="<?php echo site_url('headman/Requestemployee'); ?>">ส่งคำขอเพิ่มบุคลากร</a></li>
            <li><a href="javascript:void(0);">&nbsp;</a></li>
          </ul>
        </div>
        <?php endif ?>
        <div class="header__logo">
          <img src="<?php echo img_url();?>thumbnail/logohr200x203.png" width="150">
        </div>
        <div class="header__menu">
          <ul class="whitemenu">
            <li>WELCOME</li>
            <li><?php echo $firstName." ".$lastName;?></li>
            <li>ตำแหน่ง<?php echo $positionName;?><li>
              <li>หัวหน้างาน </li>
              <li>แผนก<?php echo $departmentName; ?></li>
              <li>สถานะ<?php echo $statusName; ?></li>
              <li><a href="<?php echo site_url('/Logout');?>">ออกจากระบบ</a></li>
          </ul>
        </div>
</div>