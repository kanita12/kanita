<?php echo form_open('hr/Verifyleave/search/'); ?>
<input type="text" id="txtEmpID" name="txtEmpID" value="<?php echo $empID ?>" /> 
<input type="submit" value="ค้นหา"/>
<?php echo form_close(); ?>
<?php if ($query->num_rows() > 0): ?>
<table>
	<tr>
		<td>
			เลขที่ใบลา
		</td>
		<td>
			ประเภทการลา
		</td>
		<td>
			วันลา
		</td>
		<td>
			ผู้ลา
		</td>
		<td>
			สถานะ
		</td>
		<td>
			จัดการ
		</td>
	</tr>
<?php foreach ($query->result_array() as $row): ?>
	<tr>
		<td>
			<?php echo $row["LID"] ?>
		</td>
		<td>
			<?php echo $row["LTName"] ?>
		</td>
		<td>
			<?php echo $row["LStartDate"]." ".$row["LStartTime"] ?>
			<?php echo $row["LEndDate"]." ".$row["LEndTime"] ?>
		</td>
		<td>
			<?php echo $row["EmpFirstnameThai"]." ".$row["EmpLastnameThai"] ?>
		</td>
		<td>
			<?php echo $row["WFName"] ?>
		</td>
		<td>
			<a href="<?php echo site_url('Leave/detail/'.$row['LID']) ?>">
			ดูรายละเอียด
			</a> อนุมัติ ไม่อนุมัติ
		</td>
	</tr>
<?php endforeach ?>
</table>
<?php endif ?>
<script type="text/javascript">
$(document).ready(function(){
	$("#txtEmpID").setTextboxShowUnShowMessage('รหัสพนักงาน');
});
</script>