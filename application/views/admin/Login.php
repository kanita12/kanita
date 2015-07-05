<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title><?php echo $title ?></title>
    <link rel="stylesheet" href="<?php echo css_url() ?>style.css">
    <script type="text/javascript" src="<?php echo js_url();?>jquery-1.11.2.min.js"></script>
    <script type='text/javascript' src="<?php echo js_url(); ?>sweetalert2/dist/sweetalert2.min.js"></script> 
    <link rel="stylesheet" type="text/css" href="<?php echo js_url(); ?>sweetalert2/dist/sweetalert2.css">
  </head>
  <body>
    <div class="wrapper">
        <div class="container">
            <h1><?php echo $title ?></h1>
            <?php echo form_open(); ?>
            <input type="hidden" name="hd_redirect_url" value="<?php echo $redirect_url ?>">
            <div class='formlogin'>
                <input type="text" name='input_username' id='input_username' placeholder="Username">
                <input type="password" name='input_password' id='input_password' placeholder="Password">
                <button type="submit" id="login-button">Login</button>
                <br>
                <br>
                <br>
                <div>
                    <?php echo anchor('/Login/', 'Member Login', ''); ?>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
        <ul class="bg-bubbles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>
  </body>
</html>
