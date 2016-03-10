<h2 class="header">กองทุนสำรองเลี้ยงชีพ</h2>
<?php foreach ($providentfund as $row): ?>
	<div>
		<p>ชื่อกองทุน: <?php echo $row['pvdname']; ?></p>
		<p>ผู้รับผิดชอบ: <?php echo $row['pvdresponsibleman']; ?></p>
		<p>ค่ากองทุน/ปี: 
		<?php
			$salary_year = intval($emp_detail['EmpSalary']) * 12;
			$percent_year = intval($row['pvdratepercent']) * 12;
			$fund_year = ( $salary_year * $percent_year ) / 100;
			echo $fund_year, 'บาท';
		?>
		</p>
	</div>
<?php	endforeach; ?>

<h2 class="header">รายการการจ่ายค่ากองทุน</h2>
<table class="responsive-table bordered highlight">
	<thead>
		<tr>
			<th width="12%">เดือน/ปี</th>
			<th>รายการ</th>
			<th>จำนวน/บาท</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($history_providentfund as $row): ?>
			<tr>
				<td><?php echo $row['sapay_month'], "/", $row['sapay_year']; ?></td>
				<td><?php echo $row['spldpf_pvdname']; ?></td>
				<td><?php echo $row['sapay_providentfund']; ?></td>
			</tr>
<?php endforeach ?>
	</tbody>
</table>