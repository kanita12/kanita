<div class="row">
	<div class="col s12">
		<h5 class="header">
			เงินเดือนปัจจุบันของคุณ : <?php echo number_format($emp_detail["EmpSalary"]); ?> บาท
		</h5>
		<?php if ($query_now_salary["sapay_salary"] == ""): ?>
			<br>
			<h5 class="header">คุณยังไม่มีข้อมูลรายได้ประจำเดือน</h5>
		<?php else: ?>
			<h4 class="header">รายได้ประจำเดือน  <?php echo get_month_name_thai($query_now_salary["sapay_month"]); ?> ปี <?php echo year_thai($query_now_salary["sapay_year"]) ?></h4>
			<br>
			<div class="row">
				<div class="col s12 m10 offset-m1 l8 offset-l2">
					<table class="salary_present">
						<tbody>
							<tr>
								<td>เงินเดือน</td>
								<td><?php echo $query_now_salary["sapay_salary"] ?></td>
								<td>-</td>
							</tr>
							<tr>
								<td>ค่าทำงานล่วงเวลา</td>
								<td><?php echo $query_now_salary["sapay_ot"] ?></td>
								<td>-</td>
							</tr>
							<tr class="gray">
								<td>รวมเงินได้</td>
								<td><?php echo $query_now_salary["total_income"] ?></td>
								<td>-</td>
							</tr>
							<tr>
								<td>หักค่าประกันสังคม</td>
								<td>-</td>
								<td><?php echo $query_now_salary["sapay_deduction"] ?></td>
							</tr>
							<tr class="gray">
								<td>เงินได้สุทธิ</td>
								<td><?php echo $query_now_salary["total_income_deduction"] ?></td>
								<td>-</td>
							</tr>
							<tr>
								<td>หักภาษีเงินได้บุคคลธรรมดา</td>
								<td>-</td>
								<td><?php echo $query_now_salary["sapay_tax"] ?></td>
							</tr>
							<tr class="gray footer">
								<td>เงินได้สุทธิต่อเดือน</td>
								<td><?php echo $query_now_salary["sapay_net"] ?></td>
								<td></td>
							</tr>
						</tbody>
					</table>
					<br><br>
					<div class="row">
						<div class="col s12 right-align">
							<a href="<?php echo site_url("Usersalary/printpdf/".$query_now_salary["sapay_year"]."/".$query_now_salary["sapay_month"]) ?>" class="btn waves-effect waves-light" target="_blank">Print PDF</a>
							<a href="<?php echo site_url("Usersalary/history/".$query_now_salary["sapay_year"]."/".$query_now_salary["sapay_month"]) ?>" class="btn waves-effect waves-light" target="_blank">ประวัติการจ่ายเงินเดือน</a>
						</div>
					</div>
				</div>
			</div>
		<?php endif ?>
	</div>
</div>