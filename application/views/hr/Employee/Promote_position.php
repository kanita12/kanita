<input type="hidden" id="hd_validation_errors" value="<?php echo validation_errors(); ?>">
<?php echo form_open_multipart(); ?>
<div class="row">
	<div class="col s12">
		<div class="input-field col s12">
			<input type="text" name="nowPosition" id="nowPosition" value="<?php echo $query["PositionName"]; ?>" readonly="true"/>
			<label for="nowPosition">ตำแหน่งปัจจุบัน</label>
		</div>
		<div class="input-field col s12">
			<?php echo form_dropdown("ddlPromotePosition",$query_position,"","id='ddlPromotePosition'") ?>
			<label for="ddlPromotePosition">ปรับตำแหน่ง</label>
		</div>
		<div class="input-field col s12">
			<textarea name="inputDesc" id="inputDesc" class="materialize-textarea"></textarea>
			<label for="inputDesc">คำอธิบาย</label>
		</div>
	</div>
</div>
<div class="row">
	<div class="col s12">
		<div class="file-field input-field">
            <div class="btn">
              <span>เอกสารเพิ่มเติม</span>
              <input type="file" name="fuDoc" id="fuDoc">
            </div>
            <div class="file-path-wrapper">
              <input class="file-path validate" type="text">
            </div>
        </div>
	</div>
</div>
<div class="divider"></div>
<div class="section">
    <div class="row">
        <div class="col s2">
            <input type="submit" onclick="return checkBeforeSubmit();" class="btn" value="บันทึก">
        </div>
        <div class="col s2 offset-s6 m2 offset-m8 right-align"> 
            <a href="<?php echo site_url('hr/Employees') ?>" class="btn red lighten-1 right-align">ยกเลิก</a>
        </div>
    </div>
</div>
<?php echo form_close(); ?>

<div class="divider"></div>
<div class="section">
	<h4 class="header">ประวัติการปรับตำแหน่ง</h4>
	<table class="bordered highlight">
		<thead>
			<tr>
				<th>จากตำแหน่ง</th>
				<th>ปรับตำแหน่งเป็น</th>
				<th>คำอธิบาย</th>
				<th>เอกสารเพิ่มเติม</th>
				<th>วันที่ปรับ</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($query_log as $row): ?>
				<tr>
					<td><?php echo $row["PPFrom_PositionName"]; ?></td>
					<td><?php echo $row["PPTo_PositionName"]; ?></td>
					<td><?php echo $row["PPDesc"]; ?></td>
					<td>
						<?php if (trim($row["PPDocument"]) !== ""): ?>
							<a href="<?php echo site_url($row["PPDocument"]); ?>" target="_blank">เอกสาร</a>
						<?php endif ?>
					</td>
					<td><?php echo date_time_thai_format_from_db($row["PPCreatedDate"]); ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var site_url = "<?php echo site_url(); ?>";
		//check validation_errors if have then alert
		var validation_errors = $("#hd_validation_errors").val();
		if(validation_errors != "")
		{
			swal({
				title: "ผิดพลาด",
				html: validation_errors,
				type: "error"
			});
		}
	});
	function checkBeforeSubmit()
	{
		return true;
	}
</script>