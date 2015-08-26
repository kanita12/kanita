<input type="hidden" id="hd_validation_errors" value="<?php echo validation_errors(); ?>">
<?php echo form_open_multipart(); ?>
<div class="row">
	<div class="col s12">
		<div class="input-field col s12">
			<input type="text" name="inputTopic" id="inputTopic" value="<?php echo set_value("inputTopic"); ?>"/>
			<label for="inputTopic">ชื่อรายการ</label>
		</div>
		<div class="input-field col s6">
			<?php echo form_dropdown("ddlYear",$queryYear,set_value("ddlYear"),"id='ddlYear'") ?>
			<label for="ddlYear">ปี</label>
		</div>
		<div class="input-field col s6">
			<?php echo form_dropdown("ddlMonth",$queryMonth,set_value("ddlMonth"),"id='ddlMonth'") ?>
			<label for="ddlMonth">เดือน</label>
		</div>
		<div class="input-field col s3">
			<input name="inputType" type="radio" id="type_plus" value="+" checked />
      		<label for="type_plus">รายได้</label>
      		<br>
      		<input name="inputType" type="radio" id="type_minus" value="-" />
      		<label for="type_minus">รายจ่าย</label>
		</div>  
		<div class="input-field col s8">
			<input type="text" name="inputMoney" id="inputMoney" class="green-text" value="<?php echo set_value("inputMoney"); ?>"/>
			<label id="label_desc" for="inputMoney" class="green-text">จำนวนเงิน</label>
		</div>
		<div class="input-field col s12">
			<textarea name="inputDesc" id="inputDesc" class="materialize-textarea"></textarea>
			<label for="inputDesc">คำอธิบายเพิ่มเติม</label>
		</div>
	</div>
</div>
<div class="divider"></div>
<div class="section">
    <div class="row">
        <div class="col s2">
            <input type="submit" onclick="return check_before_submit();" class="btn" value="บันทึก">
        </div>
        <div class="col s2 offset-s6 m2 offset-m8 right-align"> 
            <a href="<?php echo site_url('hr/Employees') ?>" class="btn red lighten-1 right-align">ยกเลิก</a>
        </div>
    </div>
</div>
<?php echo form_close(); ?>

<div class="divider"></div>
<div class="section">
	<h4 class="header">ประวัติรายได้/รายหัก พิเศษ</h4>
	<table class="bordered highlight">
		<thead>
			<tr>
				<th>ปี</th>
				<th>เดือน</th>
				<th>ชื่อรายการ</th>
				<th>จำนวนเงิน</th>
				<th>วันที่ทำรายการ</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($query_log as $row): ?>
				<tr>
					<td><?php echo year_thai($row["SMMYear"]); ?></td>
					<td><?php echo get_month_name_thai($row["SMMMonth"]); ?></td>
					<td><?php echo $row["SMMTopic"]; ?></td>
					<td><?php echo $row["SMMMoney"] ?></td>
					<td><?php echo date_time_thai_format_from_db($row["SMMCreatedDate"]); ?></td>
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

		$("#inputMoney").keydown(function (e) {

	        // Allow: backspace, delete, tab, escape, enter and .
	        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
	             // Allow: Ctrl+A, Command+A
	            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
	             // Allow: home, end, left, right, down, up
	            (e.keyCode >= 35 && e.keyCode <= 40)) {
	                 // let it happen, don't do anything
	                 return;
	        }
	        // Ensure that it is a number and stop the keypress
	        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
	            e.preventDefault();
	        }
	    });

	    //set color after choose
	    $("[id^='type_']").click(function(){
	    	var type = this.value;
	    	if(type == "-"){
	    		$("#inputMoney, #label_desc").removeClass("green-text").addClass("red-text");
	    	}
	    	else if(type == "+"){
	    		$("#inputMoney, #label_desc").removeClass("red-text").addClass("green-text");
	    	}
	    });
	});
	function checkBeforeSubmit()
	{
		return true;
	}
</script>