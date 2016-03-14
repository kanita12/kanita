<div class="row">
	<div class="col s12 m3 l3">
		<div id="userprofile_menu" class="collection">
        <a href="<?php echo site_url('Userprofile/userinfo/'.$emp_id); ?>" class="collection-item">ข้อมูลพนักงาน</a>
        <a href="<?php echo site_url('Userprofile/profileinfo/'.$emp_id); ?>" class="collection-item">ประวัติส่วนตัว</a>
        <a href="<?php echo site_url('Userprofile/historyworkinfo/'.$emp_id); ?>" class="collection-item">ประวัติการทำงาน</a>
        <a href="<?php echo site_url('Userprofile/historystudyinfo/'.$emp_id); ?>" class="collection-item">ประวัติการศึกษา</a>
        <a href="<?php echo site_url('Userprofile/othercontactinfo/'.$emp_id) ?>" class="collection-item">บุคคลอื่นที่ติดต่อได้</a>
        <a href="<?php echo site_url('Userprofile/documentinfo/'.$emp_id) ?>" class="collection-item">เอกสาร</a>
        <a href="<?php echo site_url('Userprofile/providentfundinfo/'.$emp_id) ?>" class="collection-item">กองทุนสำรองเลี้ยงชีพ</a>
        <a href="<?php echo site_url('Userprofile/shiftworkinfo/'.$emp_id) ?>" class="collection-item">กะงาน</a>
    </div>
	</div>
	<div class="col s12 m9 l9 card-panel">
		<div class="section">