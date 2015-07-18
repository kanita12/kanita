<nav class="red lighten-2" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="<?php echo site_url()?>" class="brand-logo">HRS</a>
      <ul id="main-menu-nav" class="right hide-on-med-and-down">
        <li>
            <a class="dropdown-button-f" href="#!" data-activates="ddl_company">
                บริษัท<i class="material-icons right">arrow_drop_down</i>
            </a>
            <ul id="ddl_company" class="dropdown-content">
                <li><a href="<?php echo site_url('company/regulation')?>">กฏเกณฑ์-ข้อบังคับ</a></li>
                <li><a href="<?php echo site_url('company/organization')?>" disabled>แผนผังองค์กร</a></li>
                <li><a href="<?php echo site_url('company/wantedposition')?>">ตำแหน่งงานว่าง</a></li>
                <li><a href="<?php echo site_url('company/Holiday')?>">วันหยุดประจำปี</a></li>
                <li><a href="<?php echo site_url('news')?>">ข่าวสาร</a></li>
                <li><a href="<?php echo site_url('Activity')?>">กิจกรรม</a></li>
            </ul>
        </li>
        <?php if (is_hr()): ?>
            <li>
                <a class="dropdown-button-f" href="#!" data-activates="ddl_hr">
                    เมนู Hr<i class="material-icons right">arrow_drop_down</i>
                </a>
                <ul id="ddl_hr" class="dropdown-content">
                    <li><a href="<?php echo site_url('hr/Employee');?>">รายชื่อพนักงานทั้งหมด</a></li>
                    <li><a href="<?php echo site_url('hr/Verifyleave')?>">ตรวจสอบการลางาน</a></li>
                    <li><a href="#">ตรวจสอบข้อความจากพนักงาน</a></li>
                    <li><a href="#">คำขอเพิ่มลูกทีม</a></li>
                    <li><a href="<?php echo site_url('hr/News')?>">จัดการข่าวสาร</a></li>
                    <li><a href="<?php echo site_url('hr/Activity')?>">จัดการกิจกรรม</a></li>
                    <li><a href="<?php echo site_url('hr/Regulation')?>">จัดการกฎเกณฑ์-ข้อบังคับ</a></li>
                    <li><a href="#">จัดการแผนผังองค์กร</a></li>
                    <li><a href="<?php echo site_url('hr/Holiday')?>">จัดการวันหยุดประจำปี</a></li>
                    <li><a href="#">เขียนใบลาแทน</a></li>
                    <li><a href="<?php echo site_url('hr/salary')?>">ปรับเงินเดือนพนักงาน</a></li>
                </ul>
            </li>
        <?php endif?>
        <?php if (is_headman()): ?>
            <li>
                <a class="dropdown-button-f" href="#!" data-activates="ddl_headman">
                    เมนูหัวหน้า<i class="material-icons right">arrow_drop_down</i>
                </a>
                <ul id="ddl_headman" class="dropdown-content">
                    <li><a href="<?php echo site_url('headman/Yourteam')?>">รายชื่อทีมตัวเอง</a></li>
                    <li><a href="<?php echo site_url('headman/Verifyleave')?>">ตรวจสอบใบลาลูกทีม</a></li>
                    <li><a href="<?php echo site_url('headman/Verifyot')?>">ตรวจสอบ OT ลูกทีม</a></li>
                    <li><a href="<?php echo site_url('headman/Sendotinsteadteam')?>">ส่ง OT แทนลูกทีม</a></li>
                    <li><a href="<?php echo site_url('headman/Requestemployee')?>">คำขอเพิ่มลูกทีม</a></li>
                </ul>
            </li>
        <?php endif?>
        <li>
            <a class="dropdown-button" href="<?php echo site_url('Userprofile');?>" data-activates="ddl_userprofile">
                ข้อมูลส่วนตัว<i class="material-icons right">arrow_drop_down</i>
            </a>
            <ul id="ddl_userprofile" class="dropdown-content">
                <li><a href="<?php echo site_url('Worktime');?>">เวลาเข้า-ออก</a></li>
                <li><a href="<?php echo site_url('Userprofile');?>">ข้อมูลส่วนตัว</a></li>
            </ul>
        </li>
        <li>
            <a class="dropdown-button-f" href="<?php echo site_url('Overtime');?>" data-activates="ddl_ot">
                OT<i class="material-icons right">arrow_drop_down</i>
            </a>
            <ul id="ddl_ot" class="dropdown-content">
                <li><a href="<?php echo site_url('Overtime')?>">รายการ OT</a></li>
                <li><a href="<?php echo site_url('Overtime/add')?>">ส่งใบขอทำ OT</a></li>
                <li><a href="<?php echo site_url('Overtime/exchange_ot')?>" >แลกเวลาทำ OT</a>
            </ul>
        </li>
        <li>
            <a class="dropdown-button-f" href="<?php echo site_url('Leave');?>" data-activates="ddl_leave">
                ลางาน<i class="material-icons right">arrow_drop_down</i>
            </a>
            <ul id="ddl_leave" class="dropdown-content">
                <li><a href="<?php echo site_url('Leave');?>">รายการลา</a></li>
                <li><a href="<?php echo site_url('Leave/add')?>">ส่งใบลา</a></li>
                <li><a href="<?php echo site_url('report/Reportleave')?>">รายงานการลา</a></li>
            </ul>
        </li>
        <li>
            <a href="<?php echo site_url('Message');?>">
                ข้อความ
            </a>
        </li>
        <li><a href="<?php echo site_url('logout');?>">ออกจากระบบ</a></li>
      </ul>
      <ul class="side-nav" id="nav-mobile">
        <li>
            <a class="dropdown-button-m" href="#!" data-activates="m_ddl_company">
                บริษัท<i class="material-icons right">keyboard_arrow_right</i>
            </a>
            <ul id="m_ddl_company" class="dropdown-content">
                <li><a href="<?php echo site_url('company/regulation')?>">กฏเกณฑ์-ข้อบังคับ</a></li>
                <li><a href="<?php echo site_url('company/organization')?>">แผนผังองค์กร</a></li>
                <li><a href="<?php echo site_url('company/wantedposition')?>">ตำแหน่งงานว่าง</a></li>
                <li><a href="<?php echo site_url('company/Holiday')?>">วันหยุดประจำปี</a></li>
                <li><a href="<?php echo site_url('Activity')?>">กิจกรรมภายในองค์กร</a></li>
            </ul>
        </li>
        <?php if (is_hr()): ?>
            <li>
                <a class="dropdown-button-m" href="#!" data-activates="m_ddl_hr">
                    เมนู Hr<i class="material-icons right">keyboard_arrow_right</i>
                </a>
                <ul id="m_ddl_hr" class="dropdown-content">
                    <li><a href="<?php echo site_url('hr/Employee');?>">รายชื่อพนักงานทั้งหมด</a></li>
                    <li><a href="<?php echo site_url('hr/Verifyleave')?>">ตรวจสอบการลางาน</a></li>
                    <li><a href="#">ตรวจสอบข้อความจากพนักงาน</a></li>
                    <li><a href="#">คำขอเพิ่มลูกทีม</a></li>
                    <li><a href="<?php echo site_url('hr/News')?>">จัดการข่าวสาร</a></li>
                    <li><a href="<?php echo site_url('hr/Activity')?>">จัดการกิจกรรม</a></li>
                    <li><a href="<?php echo site_url('hr/Regulation')?>">จัดการกฎเกณฑ์-ข้อบังคับ</a></li>
                    <li><a href="#">จัดการแผนผังองค์กร</a></li>
                    <li><a href="<?php echo site_url('hr/Holiday')?>">จัดการวันหยุดประจำปี</a></li>
                    <li><a href="#">เขียนใบลาแทน</a></li>
                    <li><a href="<?php echo site_url('hr/salary')?>">ปรับเงินเดือนพนักงาน</a></li>
                </ul>
            </li>
        <?php endif?>
        <?php if (is_headman()): ?>
            <li>
                <a class="dropdown-button-m" href="#!" data-activates="m_ddl_headman">
                    เมนูหัวหน้า<i class="material-icons right">keyboard_arrow_right</i>
                </a>
                <ul id="m_ddl_headman" class="dropdown-content">
                    <li><a href="<?php echo site_url('headman/Yourteam')?>">รายชื่อทีมตัวเอง</a></li>
                    <li><a href="<?php echo site_url('headman/Verifyleave')?>">ตรวจสอบใบลาลูกทีม</a></li>
                    <li><a href="<?php echo site_url('headman/Verifyot')?>">ตรวจสอบ OT ลูกทีม</a></li>
                    <li><a href="<?php echo site_url('headman/Sendotinsteadteam')?>">ส่ง OT แทนลูกทีม</a></li>
                    <li><a href="<?php echo site_url('headman/Requestemployee')?>">คำขอเพิ่มลูกทีม</a></li>
                </ul>
            </li>
        <?php endif?>
        <li>
            <a class="dropdown-button-m" href="<?php echo site_url('Userprofile');?>" data-activates="m_ddl_userprofile">
                ข้อมูลส่วนตัว<i class="material-icons right">keyboard_arrow_right</i>
            </a>
            <ul id="m_ddl_userprofile" class="dropdown-content">
                <li><a href="<?php echo site_url('Worktime');?>">เวลาเข้า-ออก</a></li>
            </ul>
        </li>
        <li>
            <a class="dropdown-button-m" href="<?php echo site_url('Overtime');?>" data-activates="m_ddl_ot">
                OT<i class="material-icons right">keyboard_arrow_right</i>
            </a>
            <ul id="m_ddl_ot" class="dropdown-content">
                <li><a href="<?php echo site_url('Overtime')?>">รายการ OT</a></li>
                <li><a href="<?php echo site_url('Overtime/add')?>">ส่งใบขอทำ OT</a></li>
                <li><a href="<?php echo site_url('Overtime/exchange_ot')?>" >แลกเวลาทำ OT</a>
            </ul>
        </li>
        <li>
            <a class="dropdown-button-m" href="<?php echo site_url('Leave');?>" data-activates="m_ddl_leave">
                ลางาน<i class="material-icons right">keyboard_arrow_right</i>
            </a>
            <ul id="m_ddl_leave" class="dropdown-content">
                <li><a href="<?php echo site_url('Leave');?>">รายการลา</a></li>
                <li><a href="<?php echo site_url('Leave/add')?>">ส่งใบลา</a></li>
                <li><a href="<?php echo site_url('report/Reportleave')?>">รายงานการลา</a></li>
            </ul>
        </li>
        <li>
            <a href="<?php echo site_url('Message');?>">
                ข้อความ
            </a>
        </li>
        <li><a href="<?php echo site_url('logout');?>">ออกจากระบบ</a></li>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
</nav>