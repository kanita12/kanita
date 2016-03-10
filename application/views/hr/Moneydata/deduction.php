<?php 
	$ci =& get_instance();
	$ci->load->library('Input_element'); 
?>

<div class="row">
	<div class="col s12">
		<h3 class="header">ประวัติการจ่ายประกันสังคม</h3>
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

<div class="row">
	<div class="col s12 card-panel teal">
		<p class="white-text">จำนวนประกันสังคมที่จ่าย: <?php echo $history[0]['sum_deduc_baht']; ?> บาท</p>
	</div>
</div>

<div class="row">
	<div class="col s12">
		<table class="responsive-table bordered highlight">
			<thead>
				<tr>
					<th>เดือน</th>
					<th>ประกันสังคม/บาท</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($history as $row): ?>
					<tr>
						<td><?php echo get_month_name_thai( $row['sapay_month'] ); ?></td>
						<td><?php echo $row['spldd_deduc_baht']; ?></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>


<script>
	$(document).ready(function(){
		$("#select_year").change(function(){
			var year = $("#select_year").val();
			var emp_id = "<?php echo $emp_detail['EmpID']; ?>";
			var go_url = "<?php echo site_url('hr/Moneydata/taxes/' . $emp_detail['EmpID']).'/'; ?>";
			go_url += year+'/';
			window.location.href = go_url;
		});
	});
</script>