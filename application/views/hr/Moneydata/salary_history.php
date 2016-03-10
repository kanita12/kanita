<?php 
	$ci =& get_instance();
	$ci->load->library('Input_element'); 
?>

<div class="row">
	<div class="col s12">
		<h3 class="header">ประวัติการจ่ายเงินเดือน</h3>
		<div class="input-field col s11">
			<h4 class="header">
				<?php
					$ci->input_element->select_year( '', '', $year, '', '', '' );
				?>
				<label>ปี</label>
			</h4>
		</div>
	</div>
</div>

<table class="bordered highlight">
	<thead>
		<tr>
			<th>เดือน</th>
			<th>เงินได้สุทธิต่อเดือน</th>
			<th>วันที่ทำรายการ</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($history as $row): ?>
			<tr>
				<td><?php echo get_month_name_thai($row["sapay_month"]); ?></td>
				<td><?php echo $row["sapay_net"] ?></td>
				<td><?php echo date_time_thai_format_from_db($row["sapay_created_date"]); ?></td>
				<td><a href="<?php echo site_url("hr/moneydata/salary_printpdf/".$emp_id."/".$row["sapay_year"]."/".$row["sapay_month"]) ?>" class="btn waves-effect waves-light" target="_blank">Print PDF</a></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>

<script>
	$(document).ready(function(){
		$("#select_year").change(function(){
			var year = $("#select_year").val();
			var emp_id = "<?php echo $emp_detail['EmpID']; ?>";
			var go_url = "<?php echo site_url('Usersalary/history/'); ?>";
			go_url += '/'+year+'/';
			window.location.href = go_url;
		});
	});
</script>