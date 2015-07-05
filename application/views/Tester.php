<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>Test Bootstrap</title>
		<link rel="stylesheet" type="text/css" href="<?php echo bootstrap_url() ?>css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo css_url() ?>stylesheet.css" />
		<script type="text/javascript" src="<?php echo js_url() ?>jquery-1.11.2.min.js"></script>
		<script type="text/javascript" src="<?php echo bootstrap_url() ?>js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="page-header text-right">
					<h1 class="header-topic">Welcome To Human Resources System</h1>
				</div>
			</div>
			<nav class="navbar navbar-default navbar-static-top">
				<div class="navbar-header">
					<button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menubar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">HR System Menu</a>
				</div>
				<div class="collapse navbar-collapse" id="menubar">
					<ul class="nav navbar-nav">
						<li class="active"><a href="#">หน้าแรก</a></li>
						<li><a href="#">แผนผังองค์กร</a></li>
						<li><a href="#">กฎเกณฑ์-ข้อบังคับ</a></li>
						<li><a href="#">ตำแหน่งงานว่าง</a></li>
						<li class="dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
								HR <span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li><a href="#">รายชื่อบุคคลากรทั้งหมด</a></li>
								<li><a href="#">ตรวจสอบเวลางาน</a></li>
								<li><a href="#">ตรวจสอบใบลา</a></li>
								<li><a href="#">ข่าวสาร</a></li>
								<li><a href="#">กิจกรรม</a></li>
								<li><a href="#">นโยบายองค์กร</a></li>
								<li><a href="#">คำร้องขอเพิ่มบุคคลากร</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
								Headman <span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li><a href="#">รายชื่อบุคคลากรภายในทีม</a></li>
								<li><a href="#">ส่งคำขอเพิ่มบุคคลากร</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
			<?php $query = getEmployeeDetail($this->session->userdata('empid')); ?>
			<?php if (count($query) > 0): ?>
				<div class="row">
					<div class="col-md-9">
						<div class="col-md-3">
							<img src="<?php echo base_url().$query['EmpPictureImg'] ?>" class="img-thumbnail img-responsive"/>
						</div>
						<div class="col-md-9">
							<?php echo $query['EmpNameTitleThai'].$query['EmpFirstnameThai'].' '.$query['EmpLastnameThai'] ?>
							<br/>
							หน่วยงาน <?php echo $query['InstitutionName'] ?>
							<br/>
							ตำแหน่ง <?php echo $query['PositionName'] ?>
							&nbsp;แผนก <?php echo $query['DepartmentName'] ?>
							<br/>
							Email <?php echo $query['EmpEmail'] ?>
							&nbsp;
							เบอร์ติดต่อ <?php echo $query['EmpMobilePhone'] ?>
						</div>
					</div>
					<div class="col-md-3">
						<div class="col-md-6">
							<p>
								<a href="#" class="btn btn-primary btn-sm">ข้อมูลส่วนตัว</a>
							</p>
							<p>
								<a href="#" class="btn btn-primary btn-sm">ตรวจสอบใบลา</a>
							</p>
						</div>
						<div class="col-md-6">
							<p>
								<a href="#" class="btn btn-primary btn-sm">ตรวจสอบเวลางาน</a>
								
							</p>
							<p>
								<a href="#" class="btn btn-warning btn-sm">ออกจากระบบ</a>
							</p>
						</div>
					</div>
				</div>
			<?php endif ?>
			

			<div class="row">
				<div class="col-md-9 col-md-offset-3">
					<div class="row">
						<div class="col-md-6">
							<a href="#" class="btn btn-primary btn-lg btn-block">ข่าวสารประชาสัมพันธ์</a>
						</div>
						<div class="col-md-6">
							<a href="#" class="btn btn-primary btn-lg btn-block">กิจกรรมภายในองค์กร</a>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<img src="<?php echo upload_url() ?>only_programmers_understand_only.png" class="img-responsive" />
						</div>
						<div class="col-md-8">
							<p>นายโปรแกรมเมอร์ PHP หน่วยงาน : โปรแกรมเมอร์หน่วยงาน : โปรแกรมเมอร์หน่วยงาน : โปรแกรมเมอร์หน่วยงาน : โปรแกรมเมอร์</p>
							<p>หน่วยงาน : โปรแกรมเมอร์</p>
							<p>หน่วยงาน : โปรแกรมเมอร์</p>
							<p>หน่วยงาน : โปรแกรมเมอร์</p>
							<p>หน่วยงาน : โปรแกรมเมอร์</p>

							<div class="row">
								<div class="col-md-7">
									ขาดงาน xx วัน<br/>
									ลางาน xx วัน<br/>
									มาสาย xx วัน<br/>
									จำนวน OT xx ชั่วโมง
								</div>
								<div class="col-md-5">
									<a href="#" class="btn btn-warning btn-block">ตรวจสอบเวลางาน</a>
									<a href="#" class="btn btn-warning btn-block">ตรวจสอบใบลา</a>

								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<a href="#" class="btn btn-primary btn-lg btn-block">ข้อมูลส่วนตัวของฉัน</a>
						</div>
						<div class="col-md-4">
							<a href="#" class="btn btn-primary btn-lg btn-block">ตรวจสอบใบลางาน</a>
						</div>	
						<div class="col-md-4">
							<a href="#" class="btn btn-primary btn-lg btn-block">ตรวจสอบเวลาเข้าออกงาน</a>
						</div>	
					</div>
				</div>
			</div>
		</div>
	</body>
</html>