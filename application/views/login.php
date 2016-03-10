<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ | HRs</title>
    <link rel="stylesheet" href="<?php echo bootstrap_url(); ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo css_url(); ?>Google-Style-Login.css">
  </head>
  <body>
    <div class="login-card"><img src="<?php echo img_url(); ?>avatar_2x.png" class="profile-img-card">
      <p class="profile-name-card"> </p>
      <?php echo form_open('', array('class'=>'form-signin')); ?>
      <span class="reauth-username"> </span>
        <input class="form-control" type="username" required="" placeholder="Username" autofocus="" id="input_username" name="input_username">
        <input class="form-control" type="password" required="" placeholder="Password" id="input_password" name="input_password">
        <div class="checkbox">
          <div class="checkbox">
            <label>
              <input type="checkbox">Remember me</label>
          </div>
        </div>
        <button class="btn btn-primary btn-block btn-lg btn-signin" type="submit">Sign in</button>
      <?php echo form_close(); ?>
      <a href="#" class="forgot-password">Forgot your password?</a>
      <br>
      <a href="<?php echo site_url('admin/Login'); ?>" class="forgot-password">Administrator Login</a>
      </div>
  </body>
</html>