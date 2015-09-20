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
    <!--Other-->
    <script type="text/javascript" src="<?php echo js_url();?>common.js"></script>
    <script src="<?php echo js_url(); ?>sweetalert2/dist/sweetalert2.min.js"></script> 
    <link rel="stylesheet" type="text/css" href="<?php echo js_url(); ?>sweetalert2/dist/sweetalert2.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="<?php echo css_url() ?>my_materialize.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="<?php echo css_url() ?>hr_style.css"  media="screen,projection"/>
    <script type="text/javascript" src="<?php echo materialize_url() ?>js/materialize.js"></script>
    

    <script type="text/javascript">
        $(document).ready(function()
        {
            var page = window.location.pathname;
            if(page == "/home" || page == "/")
            {
                $("#card_userdetail").hide();
                $("#cardNotify").removeClass("hide");
            }
            //default control for materialize
            $(".dropdown-button-f").dropdown({
                hover: true,
                constrain_width:false,
                belowOrigin:true
            });
            $(".dropdown-button").dropdown({
                hover: true,
                constrain_width:true,
                belowOrigin:true
            });
            $(".dropdown-button-m").dropdown({
                hover: true,
                constrain_width:false,
                belowOrigin:false,
                positionRight:true
            });
            $('select').material_select();
            $('.tooltipped').tooltip({delay: 50});
            $(".button-collapse").sideNav();
            $('.materialboxed').materialbox();
            $('.modal-trigger').leanModal({
              dismissible: true, // Modal can be dismissed by clicking outside of the modal
              opacity: .5, // Opacity of modal background
              in_duration: 300, // Transition in duration
              out_duration: 200, // Transition out duration
            });
            $('.scrollspy').scrollSpy();
        });
    </script>
</head>
<body>
    <?php $this->load->view('menu'); ?>
    <div class="container">
      <h1 class="header center orange-text">
        Human Resources System
      </h1>
      <div id="card_userdetail" class="card-panel center light-blue lighten-5">
        <a href="javascript:void(0);" class="waves-effect waves-teal btn-flat">รหัสพนักงาน <?php echo $emp_detail["EmpID"] ?></a>
        <a href="javascript:void(0);" class="waves-effect waves-teal btn-flat"><?php echo $emp_detail["EmpFullnameThai"] ?></a>
        <a href="javascript:void(0);" class="waves-effect waves-teal btn-flat">ฝ่าย <?php echo $emp_detail["DepartmentName"] ?></a>
        <a href="javascript:void(0);" class="waves-effect waves-teal btn-flat">แผนก <?php echo $emp_detail["SectionName"] ?></a>
        <a href="javascript:void(0);" class="waves-effect waves-teal btn-flat">หน่วย <?php echo $emp_detail["UnitName"] ?></a>
        <?php if ($emp_detail["GroupName"] != ""): ?>
            <a href="javascript:void(0);" class="waves-effect waves-teal btn-flat">กลุ่ม <?php echo $emp_detail["GroupName"] ?></a>
        <?php endif ?>
        <a href="javascript:void(0);" class="waves-effect waves-teal btn-flat">ตำแหน่ง <?php echo $emp_detail["PositionName"] ?></a>
      </div>
      <div id="cardNotify" class="hide red lighten-2 white-text" style="padding: 8px 0 13px 0;">
            <div class="notify-bar-icon">
                <a href="<?php echo site_url("headman/Verifyleave"); ?>">
                    <img src="<?php echo img_url()."Business-Overtime-icon.png";?>" style="width:25px;position:absolute;margin:5px 0 0 -15px;"><span class="mybadge error <?php echo $notifyHeadmanLeave > 0 ? "" : "green";?>"><?php echo $notifyHeadmanLeave; ?></span>
                </a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="<?php echo site_url("headman/Verifyot"); ?>">
                    <img src="<?php echo img_url()."notepad_pen.png";?>" style="width:25px;position:absolute;margin:5px 0 0 -15px;">
                    <span class="mybadge error <?php echo $notifyHeadmanLeave > 0 ? "" : "green";?>"><?php echo $notifyHeadmanLeave; ?></span>
                </a>

            </div>
            <div class="right hide-on-small-only" style="padding-top:5px;">
                มาสาย<label class="badge error <?php echo $notifyLate > 0 ? "" : "green";?>"><?php echo $notifyLate; ?></label>
                &nbsp;
                ขาดงาน<label class="badge error <?php echo $notifyAbsense > 0 ? "" : "green";?>"><?php echo $notifyAbsense; ?></label>
                &nbsp;
                <a href="<?php echo site_url("Leave"); ?>" class="white-text">การลางาน<label class="badge error green"><?php echo $notifyLeave; ?></label></a>
                &nbsp;
                <a href="<?php echo site_url("Overtime"); ?>" class="white-text">การทำงานล่วงเวลา<label class="badge error green"><?php echo $notifyOvertime; ?></label></a>
            </div>
            <div class="clearfix"></div>
      </div>
      <?php if ($show_card_panel === TRUE): ?>
        <div class="card-panel">
      <?php else: ?>
        <div>
      <?php endif ?>
      
        <?php if($show_header_title === TRUE): ?>
        <!-- for large -->
        <h2 class="header hide-on-med-and-down"><?php echo $title_eng ?> / <?php echo $title ?></h2>
        <!-- for medium -->
        <h4 class="header hide-on-small-only hide-on-large-only"><?php echo $title_eng ?> / <?php echo $title ?></h4>
        <!-- for small -->
        <h5 class="header hide-on-med-and-up"><?php echo $title_eng ?> / <?php echo $title ?></h5>
        <?php endif ?>
        <div class="section">