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

    <link type="text/css" rel="stylesheet" href="<?php echo css_url() ?>my_materialize.css"  media="screen,projection"/>
    <script type="text/javascript" src="<?php echo materialize_url() ?>js/materialize.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script type="text/javascript">
        $(document).ready(function()
        {
            var page = window.location.pathname;
            if(page == "/home" || page == "/")
            {
                $("#card_userdetail").hide();
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
            //$('.materialize-textarea').trigger('autoresize');
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
        <?php echo $emp_detail['EmpNameTitleThai'] ?>
        <?php echo $emp_detail['EmpFirstnameThai'] ?>
        <?php echo $emp_detail['EmpLastnameThai'] ?>
        หน่วยงาน<?php echo $emp_detail['InstitutionName'] ?>
        แผนก<?php echo $emp_detail['DepartmentName'] ?>
        ตำแหน่ง<?php echo $emp_detail['PositionName'] ?>
      </div>
      <div class="card-panel">
        <h2 class="header"><?php echo $title_eng ?> / <?php echo $title ?></h2>
        <div class="section">