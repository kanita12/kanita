<div class="row">
	<div class="col s12 m12 l3">
		<div class="col s12 m4 l12">
			<a href="<?php echo site_url("Userprofile") ?>">
				<div class="card light-blue hoverable center-align">
					<div class="card-content white-text">
						<i class="material-icons medium">face</i>
						<p class="flow-text">ข้อมูลส่วนตัว</p>
					</div>
				</div>
			</a>
		</div>
		<div class="col s12 m4 l12">
			<a href="<?php echo site_url("Leave") ?>">
				<div class="card hoverable" style="background-color:#72BF48;">
					<div class="card-content white-text center-align">
						<i class="material-icons medium">list</i>
						<p class="flow-text">การลางาน</p>
					</div>
				</div>
			</a>
		</div>
		<div class="col s12 m4 l12">
			<a href="<?php echo site_url("Worktime") ?>">
				<div class="card hoverable" style="background-color:#FB6648;">
					<div class="card-content white-text center-align">
						<i class="material-icons medium">query_builder</i>
						<p class="flow-text">เวลาเข้าออกงาน</p>
					</div>
				</div>
			</a>
		</div>
	</div>
	<div class="col s12 m12 l6">
	    <div class="row" style="margin:0;" >
	    	<div class="col s12">
				<div class="card hoverable" style="background-color:#EE6E73;">
					<div class="card-content white-text" style="height:292px;">
						<div class="row">
							<div class="col s6">
								<img class="responsive" src="<?php echo base_url().$emp_detail["EmpPictureImg"] ?>" style="max-height:235px;max-width:100%;" alt="" onerror="this.onerror=null;this.src='<?php echo base_url()."assets/images/no_image.jpg" ?>'">
							</div>
							<div class="col s6">
								<h4 class="white-text">Member Info</h4>
								<p class="flow-text"><?php echo $emp_detail["EmpFullnameThai"] ?></p>
								ฝ่าย <?php echo $emp_detail["DepartmentName"] ?>
								แผนก <?php echo $emp_detail["SectionName"] ?>
								หน่วยงาน <?php echo $emp_detail["UnitName"] ?>
								<?php if ($emp_detail["GroupName"] != ""): ?>
									กลุ่ม <?php echo $emp_detail["GroupName"] ?>
								<?php endif ?>
								ตำแหน่ง <?php echo $emp_detail["PositionName"] ?>
							</div>
						</div>
					</div>
				</div>
			</div>
	    </div>
	    <div class="row">
	        <div class="col s12 m6 l6" style="margin-top:0;">
	        	<a href="<?php echo site_url("Overtime/add") ?>">
	            	<div class="card hoverable" style="background-color:#0ECEAB;">
						<div class="card-content white-text center-align">
							<i class="material-icons medium">add_alarm</i>
							<p class="flow-text">ขอทำงานล่วงเวลา</p>
						</div>
					</div>
				</a>
	        </div>
	        <div class="col s12 m6 l6" style="margin-top:0;">
	        	<a href="#!">
	            	<div class="card hoverable" style="background-color:#FA6900;">
						<div class="card-content white-text center-align">
							<i class="material-icons medium">subject</i>
							<p class="flow-text">ส่งคำร้องอื่นๆ</p>
						</div>
					</div>
				</a>
	        </div>
	    </div>
	</div>
	<div class="col s12 m12 l3">
	    <div class="row">
			<div class="col s12 m4 l12">
				<a href="<?php echo site_url("News") ?>">
					<div class="card hoverable" style="background-color:#FB6648;">
						<div class="card-content white-text center-align">
							<i class="material-icons medium">announcement</i>
							<p class="flow-text">ข่าวสาร</p>
						</div>
					</div>
				</a>
			</div>
			<div class="col s12 m4 l12">
				<a href="<?php echo site_url("Activity") ?>">
					<div class="card hoverable" style="background-color:#0ECEAB;">
						<div class="card-content white-text center-align">
							<i class="material-icons medium">event</i>
							<p class="flow-text">กิจกรรม</p>
						</div>
					</div>
				</a>
			</div>
			<div class="col s12 m4 l12">
				<a href="<?php echo site_url("Message") ?>">
					<div class="card hoverable" style="background-color:#28ABE3;">
						<div class="card-content white-text center-align">
							<i class="material-icons medium">question_answer</i>
							<p class="flow-text">ส่งข้อความหา HR</p>
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>
</div>