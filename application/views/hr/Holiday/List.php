<h1>วันหยุดประจำปี <?php echo $nowYear;?></h1>
<br>
<a href="<?php echo site_url("hr/Holiday/add") ?>" id="btnAdd" class="addButton">เพิ่มวันหยุด</a>
<br>
<br>
<?php echo form_open(site_url("Holiday/getList"));?>
<div>
ปี <?php echo form_dropdown("ddlYear",$ddlYear,$nowYear,"id='ddlYear'");?>
</div>
<?php echo form_close(); ?>
<br>
<div class="CSSTableGenerator">
	<table>
		<tr>
			<td>เดือน</td>
			<td>วันที่</td>
			<td>ชื่อวันหยุด</td>
			<td>คำอธิบาย</td>
			<td>#</td>
		</tr>
		<?php foreach($query->result_array() as $row){ ?>
			<tr>
				<td><?php echo getMonthName($row["HMonth"]);?></td>
				<td><?php echo $row["HDay"];?></td>
				<td><?php echo $row["HName"];?></td>
				<td><?php echo $row["HDesc"];?></td>
				<td>
					<a href="<?php echo site_url("hr/Holiday/edit/".$row["HID"]);?>">แก้ไข</a>
					<a href="<?php echo site_url("hr/Holiday/delete/");?>" data-id="<?php echo $row["HID"]; ?>" onclick="return delete_this(this);">ลบ</a>
				</td>
			</tr>
		<?php } ?>
	</table>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("[id$='ddlYear']").change(function()
		{
			window.location.href = "/hrsystem/hr/Holiday/search/"+$(this).val();
		});
	});
</script>