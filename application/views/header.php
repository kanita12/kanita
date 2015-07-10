<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta charset="UTF-8">

    <!--jQuery-->
    <script type="text/javascript" src="<?php echo js_url();?>jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="<?php echo js_url();?>jquery-ui/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo js_url(); ?>jquery-ui/jquery-ui.css">
    <!--Bootstrap-->
    <script type="text/javascript" src="<?php echo bootstrap_url() ?>js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo bootstrap_url() ?>css/bootstrap.css" />
    <!--Other-->
    <script type="text/javascript" src="<?php echo js_url();?>common.js"></script>
    <script src="<?php echo js_url(); ?>sweetalert2/dist/sweetalert2.min.js"></script> 
    <link rel="stylesheet" type="text/css" href="<?php echo js_url(); ?>sweetalert2/dist/sweetalert2.css">
    <link rel="stylesheet" type="text/css" href="<?php echo css_url(); ?>basic.css">
    <link rel="stylesheet" type="text/css" href="<?php echo css_url() ?>Csstable.css">
</head>
<body>
    <!-- Header -->
    <div id="divHeader" class="header w-row">
        <div class="w-col w-col-4">
        </div>
        <div id="namesystem" class="w-col w-col-8 jumbotron form__HR">
            <h1>Welcome To Human Resources System</h1>
        </div>
    </div>
    <!-- Header -->
    <!-- ชื่อหน้า และ member -->
    <div class="w-row">
        <!-- <button type="button" class="close" data-dismiss="alert">×</button> -->
        <!-- member -->
        <div id="divMember" class="w-col w-col-8 w-row form--memberall">
            <div class="w-col w-col-2">
                <img src="<?php echo img_url() ?>/people.png" class="cssimgmember" alt="553f845e2568456c5fb41ac7_people.png">
            </div>
            <div class="w-col w-col-10">
                <div class="form--memberall__row" style='font-weight:bold;'>
                    <?php echo $emp_detail['EmpNameTitleThai'] ?>
                    <?php echo $emp_detail['EmpFirstnameThai'] ?>
                    <?php echo $emp_detail['EmpLastnameThai'] ?>
                    หน่วยงาน<?php echo $emp_detail['InstitutionName'] ?>
                    แผนก<?php echo $emp_detail['DepartmentName'] ?>
                    ตำแหน่ง<?php echo $emp_detail['PositionName'] ?>
                </div>
                <div class="w-row">
                    <a href="#" class="form--memberall__button w-col w-col-4 btn btn-info">
                        ข้อมูลส่วนตัว
                    </a>
                    <a href="#" class="form--memberall__button w-col w-col-4 btn btn-info">
                        ลางาน
                    </a>
                    <a href="#" class="form--memberall__button w-col w-col-4 btn btn-info">
                        ส่งข้อความถึง HR
                    </a>
                </div>
            </div>
        </div>
        <!-- member -->
        <!-- ชื่อหัวข้อ -->
        <div class="w-col w-col-4 form__title">
            <!-- แก้ไขหัวข้อ -->
            <b class="form--title__text40"><?php echo $title_eng ?></b>
            <br/>
            <b class="form--title__text20"><?php echo $title ?></b>
            <!-- แก้ไขหัวข้อ -->
        </div>
        <!-- ชื่อหัวข้อ -->
    </div>
    <!-- ชื่อหน้า และ member -->

    <?php $this->load->view('menu'); ?>

    <div id="divContent" class="form">