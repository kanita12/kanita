<?php 
	$ci =& get_instance();
	$ci->load->library('Input_element'); 
?>

<div class="input-field col s6">
	<h4 class="header">ปี
		<?php
			$ci->input_element->select_year( '', '', $year, '', '', '' );
		?>
	</h4>
</div>

<table class="responsive-table bordered highlight">
	<thead>
		<tr>
			<th width="12%">เดือน/ปี</th>
			<th>วันที่ขอทำโอที</th>
			<th>เวลาที่ขอทำ</th>
			<th>เวลาที่มาทำจริง</th>
			<th>จำนวนเงิน</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($history as $row): ?>
			<tr>	
				<td><?php echo get_month_name_thai( $row['sapay_month'] ) ?></td>
				<td><?php echo dateThaiFormatFromDB( $row['spldot_wot_date'] ); ?></td>
				<td><?php echo $row['spldot_wot_time_from'], "-", $row['spldot_wot_time_to']; ?></td>
				<td><?php echo $row['spldot_real_wot_time_from'], "-", $row['spldot_real_wot_time_to']; ?></td>
				<td><?php echo $row['spldot_money']; ?></td>
			</tr>
<?php endforeach ?>
	</tbody>
</table>

<script>
	$(document).ready(function(){
		$("#select_year").change(function(){
			var year = $("#select_year").val();
			var emp_id = "<?php echo $emp_detail['EmpID']; ?>";
			var go_url = "<?php echo site_url('hr/Moneydata/specialmoney/' . $emp_detail['EmpID']).'/'; ?>";
			go_url += year+'/';
			window.location.href = go_url;
		});
	});
</script>