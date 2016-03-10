<?php 
	$ci =& get_instance();
	$ci->load->library('Input_element'); 
?>
<div class="row">
	<div class="col s12">
		<h3 class="header">ข้อมูลการจ่ายเงินเดือนพนักงาน</h3>
		<!-- Select element month and year -->
			<div class="input-field col s6">
				<h4 class="header">ประจำเดือน  
				<?php
					$ci->input_element->select_month( $month, '', '', '' );
				?>
			</div>
			<div class="input-field col s6">
				<h4 class="header">ปี
					<?php
						$ci->input_element->select_year( '', '', $year, '', '', '' );
					?>
				</h4>
			</div>
		<?php if ($query_salary["sapay_salary"] == ""): ?>
			<div>&nbsp;</div>
			<h5 class="header">คุณยังไม่มีข้อมูลรายได้ประจำเดือน</h5>
		<?php else: ?>
			
			<!-- Detail of salary -->
			<div class="row">
				<div class="col s12 m10 offset-m1 l8 offset-l2">
					<table class="salary_present">
						<tbody>
							<tr>
								<td>เงินเดือน</td>
								<td><?php echo $query_salary["sapay_salary"] ?></td>
								<td>-</td>
							</tr>
							<tr>
								<td>ค่าทำงานล่วงเวลา</td>
								<td><?php echo $query_salary["sapay_ot"] ?></td>
								<td>-</td>
							</tr>
							<tr>
								<td>รายได้พิเศษ</td>
								<td><?php echo $query_salary["sapay_specialmoney_plus"] ?></td>
								<td>-</td>
							</tr>
							<tr>
								<td>โบนัส</td>
								<td><?php echo $query_salary["sapay_bonus"] ?></td>
								<td>-</td>
							</tr>
							<tr class="gray">
								<td>รวมเงินได้</td>
								<td><?php echo $query_salary["total_income"] ?></td>
								<td>-</td>
							</tr>
							<tr>
								<td>รายหักพิเศษ</td>
								<td>-</td>
								<td><?php echo $query_salary["sapay_specialmoney_minus"] ?></td>
							</tr>
							<tr>
								<td>หักค่าประกันสังคม</td>
								<td>-</td>
								<td><?php echo $query_salary["sapay_deduction"] ?></td>
							</tr>
							<tr>
								<td>กองทุนสำรองเลี้ยงชีพ</td>
								<td>-</td>
								<td><?php echo $query_salary["sapay_providentfund"] ?></td>
							</tr>
							<tr class="gray">
								<td>เงินได้สุทธิ</td>
								<td><?php echo $query_salary["total_income_deduction"] ?></td>
								<td>-</td>
							</tr>
							<tr>
								<td>หักภาษีเงินได้บุคคลธรรมดา</td>
								<td>-</td>
								<td><?php echo $query_salary["sapay_tax"] ?></td>
							</tr>
							<tr class="gray footer">
								<td>เงินได้สุทธิต่อเดือน</td>
								<td><?php echo $query_salary["sapay_net"] ?></td>
								<td></td>
							</tr>
						</tbody>
					</table>
					<br><br>
					<div class="row">
						<div class="col s12 right-align">
							<a href="<?php echo site_url("hr/moneydata/salary_printpdf/".$emp_id."/".$query_salary["sapay_year"]."/".$query_salary["sapay_month"]) ?>" class="btn waves-effect waves-light" target="_blank">Print PDF</a>
							<a href="<?php echo site_url("hr/moneydata/salary_history/".$emp_id."/".$query_salary["sapay_year"]); ?>" class="btn waves-effect waves-light" target="_blank">ประวัติการจ่ายเงินเดือน</a>
						</div>
					</div>
				</div>
			</div>
		<?php endif ?>
	</div>
</div>

<script>
	$(document).ready(function(){
		$("#select_month, #select_year").change(function(){
			var month = $("#select_month").val();
			var year = $("#select_year").val();
			var emp_id = "<?php echo $emp_detail['EmpID']; ?>";
			var go_url = "<?php echo site_url('hr/Moneydata/salary/' . $emp_detail['EmpID']).'/'; ?>";
			go_url += year+'/'+month+'/';
			window.location.href = go_url;
		});
	});
</script>