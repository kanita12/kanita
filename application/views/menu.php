<div id="divmenu" class="menu">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="nav navbar-brand" href="<?php echo site_url() ?>">
                        <b>หน้าแรก</b>
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li id="company" class="dropdown">
                            <a href="" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-expanded="false">บริษัท<span class="caret"></span>
                        </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo site_url('company/regulation') ?>">กฏเกณฑ์-ข้อบังคับ</a></li>
                                <li><a href="<?php echo site_url('company/organization') ?>">แผนผังองค์กร</a></li>
                                <li><a href="<?php echo site_url('company/wantedposition') ?>">ตำแหน่งงานว่าง</a></li>
                                <li><a href="<?php echo site_url('company/Holiday') ?>">วันหยุดประจำปี</a></li>
                                <li><a href="<?php echo site_url('Activity') ?>">กิจกรรมภายในองค์กร</a></li>
                            </ul>
                        </li>
                        <li id="profile">
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                                ข้อมูลส่วนตัว
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo site_url('Worktime'); ?>">เวลาเข้า-ออก</a></li>
                                <li><a href="<?php echo site_url('Userprofile'); ?>">แก้ไขข้อมูลส่วนตัว</a></li>
                                </li>
                            </ul>
                        </li>
                        <li id="profile">
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                                OT
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo site_url('Overtime') ?>">รายการ OT</a></li>
                                <li><a href="<?php echo site_url('Overtime/add') ?>">ส่งใบขอทำ OT</a></li>
                                <li><a href="<?php echo site_url('Overtime/exchange_ot') ?>" >แลกเวลาทำ OT</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                                ลางาน<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo site_url('Leave'); ?>">รายการลา</a></li>
                                <li><a href="<?php echo site_url('Leave/add') ?>">ส่งใบลา</a></li>
                                <li><a href="<?php echo site_url('report/Reportleave') ?>">รายงานการลา</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                            ข้อความ<span class="caret"></span>
                        </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo site_url('Message') ?>">รายการข้อความ</a></li>
                            </ul>
                        </li>
                        
                        <!-- เมนู HEAD MAN -->
                        <?php if (is_headman()): ?>
                        <li class="dropdown">
                            <a href="" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-expanded="false">เมนูหัวหน้า 
                            <span class="caret"></span>
                          </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo site_url('headman/Yourteam') ?>">รายชื่อทีมตัวเอง</a></li>
                                <li><a href="<?php echo site_url('headman/Verifyleave') ?>">ตรวจสอบใบลาลูกทีม</a></li>
                                <li><a href="<?php echo site_url('headman/Verifyot') ?>">ตรวจสอบ OT ลูกทีม</a></li>
                                <li><a href="<?php echo site_url('headman/Sendotinsteadteam') ?>">ส่ง OT แทนลูกทีม</a></li>
                                <li><a href="<?php echo site_url('headman/Requestemployee') ?>">คำขอเพิ่มลูกทีม</a></li>
                                <li><a href="#">ตรวจสอบข้อความจากลูกทีม</a></li>
                            </ul>
                        </li>
                        <?php endif ?>
                        <!-- เมนู HEAD MAN -->
                        <!-- เมนู HR -->
                        <?php if($this->acl->hasPermission('access_hr') == true): ?>
                            <li class="dropdown">
                              <a href="#" class="dropdown-toggle txtwhite14" data-toggle="dropdown" 
                              aria-expanded="false" id="MENU HR">เมนู HR
                                <span class="caret"></span>
                              </a>
                              <ul class="dropdown-menu" aria-labelledby="MENU HR">
                                <li><a class="txtwhite14" href="<?php echo site_url('hr/Employee'); ?>">รายชื่อพนักงานทั้งหมด</a></li>
                                <li><a class="txtwhite14" href="<?php echo site_url('hr/Verifyleave') ?>">ตรวจสอบการลางาน</a></li>
                                <li><a class="txtwhite14" href="#">ตรวจสอบข้อความจากพนักงาน</a></li>
                                <li><a class="txtwhite14" href="#">คำขอเพิ่มลูกทีม</a></li>
                                <li><a class="txtwhite14" href="<?php echo site_url('hr/News') ?>">จัดการข่าวสาร</a></li>
                                <li><a class="txtwhite14" href="<?php echo site_url('hr/Activity') ?>">จัดการกิจกรรม</a></li>
                                <li><a class="txtwhite14" href="<?php echo site_url('hr/Regulation') ?>">จัดการกฎเกณฑ์-ข้อบังคับ</a></li>
                                <li><a class="txtwhite14" href="#">จัดการแผนผังองค์กร</a></li>
                                <li><a class="txtwhite14" href="<?php echo site_url('hr/Holiday') ?>">จัดการวันหยุดประจำปี</a></li>
                                <li><a class="txtwhite14" href="#">เขียนใบลาแทน</a></li>
                                <li><a class="txtwhite14" href="<?php echo site_url('hr/salary') ?>">ปรับเงินเดือนพนักงาน</a></li>
                                <!-- การปรับเงินเดือนมีแบบ ปรับทั้งหมด , ปรับเป็นแผนก , ปรับเป็นตำแหน่ง , ปรับเป็ฯรายบุคคล , ปรับเป็นรายทีม -->
                              </ul>
                            </li>
                        <?php endif ?>
                        <!-- เมนู HR -->
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?php echo site_url('logout'); ?>">ออกจากระบบ</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>