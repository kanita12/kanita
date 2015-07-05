<ul id="primaryMenu" class="nav nav-tabs">
	<li data-tab="userinfo"><a href="<?php echo site_url('Userprofile/userinfo'); ?>">ชื่อผู้ใช้</a></li>
  <li data-tab="profileinfo"><a href="<?php echo site_url('Userprofile/profileinfo'); ?>">ประวัติส่วนตัว</a></li>
  <li data-tab="addressinfo"><a href="<?php echo site_url('Userprofile/addressinfo') ?>">ที่อยู่</a></li>
  <li data-tab="othercontactinfo"><a href="<?php echo site_url('Userprofile/othercontactinfo') ?>">บุคคลอื่นที่ติดต่อได้</a></li>
</ul>

<input type="hidden" id="hdMain" value="<?php echo $menuMain ?>">
<script type="text/javascript">
	$(document).ready(function(){
		$("#primaryMenu li").removeClass("active");
		$("#primaryMenu li[data-tab='"+$("#hdMain").val()+"']").addClass("active");
	});
</script>