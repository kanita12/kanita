<h1><?php echo $topic ?></h1>
<br/>
<a href="<?php echo site_url("hr/Activity/add"); ?>" class="addButton">เพิ่มกิจกรรม</a>
<br/><br/>
<div class="CSSTableGenerator">
<table>
	<tr>
		<td>กิจกรรม</td>
		<td>โดย</td>
		<td>วันเริ่มกิจกรรม</td>
		<td>วันสิ้นสุดกิจกรรม</td>
		<td>จัดการ</td>
	</tr>
<?php foreach ($query->result_array() as $row): ?>
	<tr>
		<td>
			<a href="<?php echo site_url('hr/Activity/detail/'.$row["ACTID"]); ?>" target="_blank">
			<?php echo $row["ACTTopic"]; ?></a>
		</td>
		<td><?php echo $row["ACTCreatedBy"]; ?></td>
		<td>
			<?php echo dateThaiFormatFromDB($row["ACTStartDate"])?>
		</td>
		<td>
			<?php echo dateThaiFormatFromDB($row["ACTEndDate"])  ?>
		</td>
		<td>
			<a href="<?php echo site_url('hr/Activity/edit/'.$row["ACTID"]); ?>">แก้ไข</a>
			<a href="javascript:void(0);" onclick="deleteThis(this,'<?php echo site_url('hr/Activity/delete/'); ?>','<?php echo $row['ACTID'] ?>');">ลบ</a>
		</td>
	</tr>
<?php endforeach ?>
</table>
</div>