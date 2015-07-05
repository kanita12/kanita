<?php echo form_open_multipart($FormUrl); ?>
	<input type="hidden" id='hdPagetype' name='hd_pagetype' value='<?php echo $pagetype ?>'>
	<input type="hidden" id='hdLID' name='hdLID' value='<?php echo $leaveID ?>'>
	<input type="hidden" id='hdUserID' name='hdUserID' value='<?php echo $userID ?>'>
	<input type="hidden" id='hdEmpID' name='hdEmpID' value='<?php echo $empID ?>'>
	<input type="hidden" id="hdWorkTimeStart" name="hdWorkTimeStart" value="<?php echo $workTimeStart ?>"/>
	<input type="hidden" id="hdWorkTimeEnd" name="hdWorkTimeEnd" value="<?php echo $workTimeEnd ?>"/>
	<input type="hidden" id="hdWorkDateStart" name="hdWorkDateStart" value="<?php echo $workDateStart ?>"/>
	<input type="hidden" id="hdWorkDateEnd" name="hdWorkDateEnd" value="<?php echo $workDateEnd ?>"/>

	<div class="form__padding5 alert alert-dismissible alert-info">
		<div class="w-row form--text14">
			<strong>แบบฟอร์มการลางาน</strong>
			<br/><br/>
	        <div class="fr-text">
	        	ประเภทการลา
	        	<?php echo form_dropdown("ddlLeaveType",$ddlLeaveType,$vddlLeaveType,"id='ddlLeaveType'"); ?>
	        	<div id="divLeaveDetail">
	        		<?php echo $vdetailLeave; ?>
	            </div>
	    	</div>
		</div>
		<div class="form__padding">
			รายละเอียดการลางาน
			<br>
			<p>รหัสพนักงาน <?php echo $queryEmployee["EmpID"];?></p>
			<p>ชื่อ-นามสกุล <?php echo $queryEmployee["EmpFirstnameThai"]." ".$queryEmployee["EmpLastnameThai"]; ?></p>
			<br/>
			<p>แผนก <?php echo $queryEmployee["DepartmentName"]; ?></p>
			<p>ตำแหน่ง <?php echo $queryEmployee["PositionName"]; ?></p>
			<br/>
			<?php $headman_detail = get_headman_detail_by_employee_user_id($queryEmployee['UserID']); ?>
			<?php if ( count($headman_detail) > 0 ) : ?>
				<p>หัวหน้างาน : <?php echo $headman_detail["EmpFullnameThai"]; ?></p>
		    	<p>ประจำแผนก : <?php echo $headman_detail["DepartmentName"]; ?></p>
			<?php endif ?>
		</div>
		<div class="w-row">
	        <p class="w-col w-col-2 form__padding2 form__right">เนื่องจาก</p>
	        <textarea class="w-col w-col-9" name="txtBecause" cols="60" rows="8" 
	        id="txtBecause"><?php echo $vleaveBecause ?></textarea>
	    </div>
	    <div class="w-row form__padding">
	        <p>เพราะฉะนั้นจึงขอลาหยุดใน</p>
	        <p class="w-col w-col-6">
	            <b>วันที่ :</b>
	        	<input id="txtStartDate" name="txtStartDate" data-format="dd/MM/yyyy" type="text" class="add-on" readonly="true"  value="<?php echo $vworkDateStart ?>">
	        </p>
	        <p class="w-col w-col-6">
	            <b>เวลา :</b>
	            <input id="txtStartTime" name="txtStartTime" data-format="hh:mm" type="text" class="add-on" readonly="true"  value="<?php echo $vworkTimeStart ?>">
	        </p>
	        <p class="w-col w-col-6">
	            <b>จนถึงวันที่ :</b>
	            <input id="txtEndDate" name="txtEndDate" data-format="dd/MM/yyyy" type="text" class="add-on" readonly="true"  value="<?php echo $vworkDateEnd ?>">
	        </p>
	        <p class="w-col w-col-6">
	            <b>เวลา :</b>
	            <input id="txtEndTime" name="txtEndTime" data-format="hh:mm" type="text" class="add-on" readonly="true"  value="<?php echo $vworkTimeEnd ?>">
	        </p>
	    </div>
	    <div class="w-row form__padding">
			<p>เอกสารแนบ :</p>
			<br>
			<div id="div_document">
				<?php
				if(count($query_leave_doc) > 0) //for edit
				{
					$i = 1;
					foreach ($query_leave_doc as $row) 
					{
						echo form_upload(array("name" => "fuDocument[]", "id" => "fuDocument_".$i,"multiple"));
						echo anchor(base_url($row["ldoc_filepath"]), $row['ldoc_filename'], 'target="_blank"');
						echo "<span onclick=\"delete_doc('".$row["ldoc_id"]."');\">ลบ</span>";
						$i++;
					}
				}
				else
				{
					for ($i = 0; $i < 3; $i++) 
					{ 
						echo form_upload(array("name" => "fuDocument[]", "id" => "fuDocument_".$i,"multiple"));
					}
				}
				?>
			</div>
			<?php echo anchor('javascript:void(0);', 'เพิ่มช่องอัพโหลดอีก', 'onclick="return add_file_control();"'); ?>
		</div>
	    <div style=" padding-top: 20px;text-align:right;">
	            <input class="btn btn-primary" type="submit" value="บันทึก" onclick="return checkBeforeSubmit();"> &nbsp;
	            <input class="btn btn-primary" type="reset" value="ยกเลิก">
	    </div>
	</div>
<?php echo form_close(); ?>
<script type="text/javascript" src="<?php echo js_url() ?>datetimepicker/jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="<?php echo js_url() ?>datetimepicker/jquery.datetimepicker.css" media="screen" title="no title" charset="utf-8" />
<script type="text/javascript">
	$(document).ready(function()
	{
		if($("#hdPagetype").val() === "editdoc")
		{
			disable_all_controls();
		}
		var workTimeStart = $("#hdWorkTimeStart").val();
		var workTimeEnd = $("#hdWorkTimeEnd").val();
		var end = workTimeEnd.split(":");
		var workTimeEnd_plus30 = end[0]+':'+(parseInt(end[1])+30);


		var workDateStart = $("#hdWorkDateStart").val();
		var workDateEnd = $("#hdWorkDateEnd").val();
		$('#txtStartDate').datetimepicker({
			onGenerate:function( ct ){
					for (var i = 0; i < 7; i++) {
						if(i < workDateStart || i > workDateEnd)
						{
							jQuery(this).find('.xdsoft_date.xdsoft_day_of_week'+i).addClass('xdsoft_disabled');
						}

					}
						//xdsoft_day_of_week0 = Sunday
						//xdsoft_day_of_week1 = monday
						//xdsoft_day_of_week2 = tuesday
						//xdsoft_day_of_week6 = Saturday
			  },
			timepicker:false,
			format:'d/m/Y',
			lang:'th',
			
			closeOnDateSelect:true
		 });
		$('#txtStartTime').datetimepicker({
			datepicker:false,
			step:30,
			format:'H:i',
			minTime: workTimeStart,
			maxTime: workTimeEnd_plus30,
			defaultTime: workTimeStart
		});
		$('#txtEndDate').datetimepicker({
			onGenerate:function( ct ){
					for (var i = 0; i < 7; i++) {
						if(i < workDateStart || i > workDateEnd)
						{
							jQuery(this).find('.xdsoft_date.xdsoft_day_of_week'+i).addClass('xdsoft_disabled');
						}

					}

						//xdsoft_day_of_week0 = Sunday
						//xdsoft_day_of_week1 = monday
						//xdsoft_day_of_week2 = tuesday
						//xdsoft_day_of_week6 = Saturday
				},
			timepicker:false,
			format:'d/m/Y',
			lang:'th',
			
			closeOnDateSelect:true
		});
		$('#txtEndTime').datetimepicker({
			datepicker:false,
			step:30,
			format:'H:i',
			minTime: workTimeStart,
			maxTime: workTimeEnd_plus30,
			defaultTime: workTimeEnd
		});

		$("#ddlLeaveType").change(function(){
			getLeaveDetail();
		});
	});
	function disable_all_controls()
	{
		$(":input").not("[id^='fuDocument_']").not("[type='submit']").not("[type='reset']").not("[type='hidden']").attr("disabled","disabled");
	}
	function getHour(time)
	{
		var atime = time.split(":");
		var hours = Number(atime[0]);
		var minutes = Number(atime[1]);
		hours = hours+minutes;
		return hours;
	 }
	function checkBeforeSubmit()
	{
		$pass = false;
		var workTimeStart = $("#hdWorkTimeStart").val();
		var workTimeEnd = $("#hdWorkTimeEnd").val();
		var lType = $("#ddlLeaveType");
		var sDate = $("[id$='txtStartDate']").val();
		var sTime = $("#txtStartTime").val();
		var eDate = $("[id$='txtEndDate']").val();
		var eTime = $("#txtEndTime").val();
		var msg = "";
		var leaveID = $("#hdLID").val();


		if(lType.val() == '0') msg+="<br/>- ประเภทการลา";
		if(sDate == '') msg += "<br/>- วันที่ขอลา";
		if(sTime == '') msg += "<br/>- เวลาที่ขอลา";
		if(eDate == '') msg += "<br/>- วันสิ้นสุดที่ขอลา";
		if(eTime == '') msg += "<br/>- เวลาสิ้นสุดที่ขอลา";
		else{
			if(getHour(sTime) >= getHour(workTimeStart) && getHour(eTime) <= getHour(workTimeEnd)){

			}
			else{
				msg += "<br/>- เวลาเริ่มเวลาสิ้นสุดไม่ถูกต้อง";
			}
		}
		if(msg !== '')
		{
			swal({
				title: 'กรุณากรอกข้อมูลต่อไปนี้',
				html: msg,
				type: 'error'
			});
			return false;
		}
		else
		{
			$.ajax({
		        url: "<?php echo site_url('Leave/ajaxCheckExistsDate') ?>",
		        async: false,
		        type: 'POST',
		        data: {sdate:sDate,stime:sTime,edate:eDate,etime:eTime,leaveid:leaveID}, // $(this).serialize(); you can use this too
		        success: function(data){
	   				if(data == "duplicate")
					{
						swal('วันที่นี้มีการลาไปแล้ว','','error');
						return false;
					}
					else
					{
						$pass = true;
					}
		        }
		    });
		}
		return $pass;
	}
	function delete_doc(leave_doc_id)
	{
		alert(leave_doc_id);
	}
	function getLeaveDetail()
	{
		var leaveTypeID = $("#ddlLeaveType").val();
		$.ajax({
	    type:"POST",
	    url:"ajaxGetDetailLeave",
	    data: {id:leaveTypeID},
	    cache:false,
	    async:false,
	    timeout: 30000,
	    success:function(data) {
				$("#divLeaveDetail").html(data);
	    }
		});
	}
	function add_file_control()
	{
		var size = $("[id^='fuDocument_']").length;
		var text = "";
		for(var i = size; i < size+3 ; i++)
		{
			text += "<input type='file' name='fuDocument[]' id='fuDocument_"+i+"'>";
		}
		$("#div_document").append(text);
		return false;
	}
</script>
