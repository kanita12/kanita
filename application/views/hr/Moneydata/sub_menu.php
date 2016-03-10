<div class="row">
	<!--Menu-->
	<?php
		$sub_menu_name = array( 
		              'เงินเดือน' 						=> site_url( 'hr/Moneydata/salary/' . $emp_id ), 
		              'ทำงานล่วงเวลา' 				=> site_url( 'hr/Moneydata/overtime/' . $emp_id ), 
		              'โบนัส' 								=> site_url( 'hr/Moneydata/bonus/' . $emp_id ), 
		              'รายได้/รายหัก' 				=> site_url( 'hr/Moneydata/specialmoney/' . $emp_id ),  
		              'ประกันสังคม' 					=> site_url( 'hr/Moneydata/deduction/' . $emp_id ),  
		              'กองทุนสำรองเลี้ยงชีพ' 	=> site_url( 'hr/Moneydata/providentfund/' . $emp_id ), 
		              'ภาษีเงินได้' 					=> site_url( 'hr/Moneydata/taxes/' . $emp_id ),
		              );
		
	?>
	<div class="col l3 hide-on-med-and-down">
		<div id="sub_menu" class="collection hide-on-med-and-down">
			<?php foreach ($sub_menu_name as $key => $value): ?>
				<a href="<?php echo $value; ?>" class="collection-item"><?php echo $key; ?></a>
			<?php endforeach ?>
	  </div>
	  &nbsp;
	</div>
	<div class="col s12 hide-on-large-only">
		<div id="sub_menu_mobile" class="hide-on-large-only">
	    <?php foreach ($sub_menu_name as $key => $value): ?>
				<a href="<?php echo $value; ?>" class="waves-effect waves-light btn" style="margin:5px 0;"><?php echo $key; ?></a>
			<?php endforeach ?>
	  </div>
	</div> 
	<script>
		$(document).ready(function(){
			var now_url = window.location.href.toLowerCase();
			$('#sub_menu > a').each(function(){
				var href = $(this).attr("href").toLowerCase();
				if( href == now_url )
				{
					$(this).addClass("active");
				}
			});
		});
	</script>
	<!-- Content -->
	<div class="col s12 l9">
		<div>
			<p>รหัสพนักงาน: <?php echo $emp_detail['EmpID']; ?></p>
			<p>ชื่อ-นามสกุล: <?php echo $emp_detail['EmpFullnameThai']; ?></p>
			<p><?php echo $emp_detail['DepartmentName']; ?> แผนก<?php echo $emp_detail['SectionName']; ?> หน่วยงาน<?php echo $emp_detail['UnitName']; ?> ตำแหน่ง<?php echo $emp_detail['PositionName']; ?></p>
		</div>
