<ul id="nav-mobile" class="side-nav fixed" style="width: 200px;">
	<li class="logo">
		<a id="logo-container" href="<?php echo site_url('admin/dashboard'); ?>" class="brand-logo">
			<!--  <object id="front-page-logo" type="image/svg+xml" data="res/materialize.svg">Your browser does not support SVG</object> -->Admin HR System</a>
		</li>
		<li class="bold"><a href="<?php echo site_url('admin/dashboard') ?>">หน้าแรก</a></li>
		<li class="no-padding">
			<ul class="collapsible collapsible-accordion">
				<li class="bold"><a href="javascript:void(0);" class="collapsible-header waves-effect waves-teal">บริษัท</a>
					<div class="collapsible-body" style="">
						<ul>
							<li><a href="<?php echo site_url('admin/Company'); ?>">ข้อมูลบริษัท</a></li>
							<li><a href="<?php echo site_url('admin/Company/Department'); ?>">ฝ่าย/แผนก/หน่วยงาน</a></li>
							<li><a href="<?php echo site_url('admin/Company/Position'); ?>">ตำแหน่งใหม่</a></li>
			<!-- <li><a href="<?php echo site_url('admin/Institution'); ?>">หน่วยงาน</a></li>
			<li><a href="<?php echo site_url('admin/Department'); ?>">แผนก</a></li>
			<li><a href="<?php echo site_url('admin/Position'); ?>">ตำแหน่ง</a></li> -->
		</ul>
	</div>
</li>
<li class="bold"><a href="javascript:void(0);" class="collapsible-header waves-effect waves-teal">เวลาเข้า-ออก</a>
	<div class="collapsible-body" style="">
		<ul>
			<li><a href="<?php echo site_url('admin/Shiftwork'); ?>">เวลาการทำงาน</a></li>
		</ul>
	</div>
</li>
<li class="bold"><a href="javascript:void(0);" class="collapsible-header waves-effect waves-teal">ผู้ใช้งาน</a>
	<div class="collapsible-body" style="">
		<ul>
			<li><a href="<?php echo site_url('admin/Roles'); ?>">Roles</a></li>   
		</ul>
	</div>
</li>
	  <!-- <li class="bold"><a class="collapsible-header waves-effect waves-teal">Workflow</a>
		<div class="collapsible-body" style="">
		  <ul>
			<li><a href="<?php echo site_url('admin/Workflow/condition/'); ?>">Condition</a></li>
				<li><a href="<?php echo site_url('admin/Workflow/worker/'); ?>">Worker</a></li>
				<li><a href="<?php echo site_url('admin/Workflow/process/'); ?>">Process</a></li>
		  </ul>
		</div>
	</li> -->
</ul>
</li>
<!-- <li class="bold"><a href="<?php echo site_url('admin/News') ?>">ข่าวสาร</a></li> -->
<ul class="collapsible collapsible-accordion">
	<li class="bold"><a href="javascript:void(0);" class="collapsible-header waves-effect waves-teal">ระบบลา</a>
		<div class="collapsible-body" style="">
			<ul>
				<li><a href="<?php echo site_url('admin/Leavegroup'); ?>">กรุ๊ปลา</a></li>
				<li><a href="<?php echo site_url('admin/Leavetype'); ?>">ประเภทการลา</a></li>
				<li><a href="<?php echo site_url('admin/Config/Leave'); ?>">ตั้งค่าเงื่อนไขการลา</a></li>
			</ul>
		</div>
	</li>
</ul>
  <?php /* <ul class="collapsible collapsible-accordion">
	  <li class="bold"><a class="collapsible-header waves-effect waves-teal">ทำงานล่วงเวลา</a>
		<div class="collapsible-body" style="">
		  <ul>
			<li><a href="<?php echo site_url('admin/Worktime/get_ot_conditions'); ?>">ตั้งค่าเงื่อนไข OT</a></li>
		  </ul>
		</div>
	  </li>
	</ul> */ ?>
	<!--  <li class="bold"><a href="<?php echo site_url('admin/Config') ?>">ตั้งค่า</a></li> -->
	<li class="bold"><a href="<?php echo site_url('admin/providentfund') ?>">กองทุนสำรองเลี้ยงชีพ</a></li>
	<li class="bold"><a href="<?php echo site_url('Logout') ?>">ออกจากระบบ</a></li>
</ul>
<script type="text/javascript">
	$(document).ready(function()
	{
		var my_url = window.location.href.toLowerCase();
		var spliter = my_url.split('/');
	//for menu company
	if(my_url.indexOf('company') > 1)
	{

		if(spliter[2] == "localhost")
		{
			if(spliter[6] == undefined)
			{
				newpath = spliter[0]+"/"+spliter[1]+"/"+spliter[2]+"/"+spliter[3]+"/"+spliter[4]+"/"+spliter[5];
			}
			else 
			{
				if(spliter[6] == "section" || spliter[6] == "unit" || spliter[6] == "group")
				{
					spliter[6] = "department";
				}
				newpath = spliter[0]+"/"+spliter[1]+"/"+spliter[2]+"/"+spliter[3]+"/"+spliter[4]+"/"+spliter[5]+"/"+spliter[6];
			}
		}
		else
		{
			if(spliter[5] == undefined)
			{
				newpath = spliter[0]+"/"+spliter[1]+"/"+spliter[2]+"/"+spliter[3]+"/"+spliter[4];
			}
			else 
			{
				if(spliter[5] == "section" || spliter[5] == "unit" || spliter[5] == "group")
				{
					spliter[5] = "department";
				}
				newpath = spliter[0]+"/"+spliter[1]+"/"+spliter[2]+"/"+spliter[3]+"/"+spliter[4]+"/"+spliter[5];
			}
		}

		my_url = newpath;
	}
	else // for another menu
	{
		var newpath = spliter[0]+"/"+spliter[1]+"/"+spliter[2]+"/"+spliter[3]+"/"+spliter[4]+"/"+spliter[5];
		my_url = newpath;
	}

	$("#nav-mobile a").each(function()
	{
	  //alert($(this).attr("href").toLowerCase()+"===="+my_url);
	  if($(this).attr("href") != undefined && $(this).attr("href").toLowerCase() == my_url)
	  {
				//check not ul > li
				if($(this).parent().parent().attr("id") != "nav-mobile")
				{
					//check not ul > li > ul > li
					//only ul > li > ul > li > ul > li
					if($(this).parent().parent().parent().parent().attr("id") != "nav-mobile")
					{
						$(this).parent().addClass("active");
						var li = $(this).parent().parent().parent().parent();
						var ahref = $("a",li);
						if(ahref.hasClass("collapsible-header") === true)
						{
							li.addClass("active");
							ahref.click();
						}
					}
					else
					{

						$(this).parent().addClass("active");
					}
				}
				else
				{
					if($(this).parent().hasClass("logo") !== true)
					{
						$(this).parent().addClass("active");
					}
					
				}
			}
		});
});
</script>