<?php echo form_open_multipart($FormUrl); ?>
	<input type="hidden" id='hdPagetype' name='hd_pagetype' value='<?php echo $pagetype ?>'>
	<input type="hidden" id='hdLID' name='hdLID' value='<?php echo $leaveID ?>'>
	<input type="hidden" id='hdUserID' name='hdUserID' value='<?php echo $userID ?>'>
	<input type="hidden" id='hdEmpID' name='hdEmpID' value='<?php echo $empID ?>'>
	<input type="hidden" id="hdWorkTimeStart" name="hdWorkTimeStart" value="<?php echo $workTimeStart ?>"/>
	<input type="hidden" id="hdWorkTimeEnd" name="hdWorkTimeEnd" value="<?php echo $workTimeEnd ?>"/>
	<input type="hidden" id="hdWorkDateStart" name="hdWorkDateStart" value="<?php echo $workDateStart ?>"/>
	<input type="hidden" id="hdWorkDateEnd" name="hdWorkDateEnd" value="<?php echo $workDateEnd ?>"/>

<div class="row">
	<div class="input-field col s12 m6 l5">
		<?php echo form_dropdown("ddlLeaveType",$ddlLeaveType,$vddlLeaveType,"id='ddlLeaveType'"); ?>
		<label>ประเภทการลา</label>
	</div>
	<div class="col s12 m6 l7">
		<div id="divLeaveDetail">
			<?php echo $vdetailLeave; ?>
    </div>
	</div>
</div>
<div class="row">
	<div class="col s12">
			<h4 class="header">รายละเอียดการลา</h4>
			<div class="col s6">
				<table>
					<tr>
						<td>รหัสพนักงาน</td>
						<td>:</td>
						<td><?php echo $queryEmployee["EmpID"];?></td>
					</tr>
					<tr>
						<td>ชื่อ-นามสกุล</td>
						<td>:</td>
						<td><?php echo $queryEmployee["EmpFullnameThai"];?></td>
					</tr>
					<tr>
						<td>แผนก</td>
						<td>:</td>
						<td><?php echo $queryEmployee["DepartmentName"];?></td>
					</tr>
					<tr>
						<td>ตำแหน่ง</td>
						<td>:</td>
						<td><?php echo $queryEmployee["PositionName"];?></td>
					</tr>
					<?php $headman_detail = get_headman_detail_by_employee_user_id($queryEmployee['UserID']); ?>
					<?php if ( count($headman_detail) > 0 ) : ?>
						<tr>
							<td>หัวหน้างาน</td>
							<td>:</td>
							<td><?php echo $headman_detail["EmpFullnameThai"];?></td>
						</tr>
						<tr>
							<td>ประจำแผนก</td>
							<td>:</td>
							<td><?php echo $headman_detail["DepartmentName"];?></td>
						</tr>
					<?php endif ?>
				</table>
			</div>
	</div>
</div>
<div class="row">
	<div class="col s12">
		<div class="input-field">
		 	<textarea name="txtBecause" id="txtBecause" class="materialize-textarea"><?php echo $vleaveBecause ?></textarea>
	    <label for="txtBecause">เนื่องจาก</label>
	  </div>
	</div>
</div>
<div class="row">
	<div class="col s12">
		<div class="input-field col s3">
			<input type="text" id="txtStartDate" name="txtStartDate" value="<?php echo $vworkDateStart; ?>">
			<label for="txtStartDate">วันที่ขอลา</label>
		</div>
		<div class="input-field col s2">
			<input type="text" id="txtStartTime" name="txtStartTime" value="<?php echo $vworkTimeStart ?>">
			<label for="txtStartTime">เวลา</label>
		</div>
		<div class="input-field col s2">
			&nbsp;
		</div>
		<div class="input-field col s3">
			<input type="text" id="txtEndDate" name="txtEndDate" value="<?php echo $vworkDateEnd; ?>">
			<label for="txtEndDate">ลาถึงวันที่</label>
		</div>
		<div class="input-field col s2">
			<input type="text" id="txtEndTime" name="txtEndTime" value="<?php echo $vworkTimeEnd ?>">
			<label for="txtEndTime">เวลา</label>
		</div>
	</div>
</div>
<div class="row">
	<div class="col s12">
		<div class="file-field input-field">
		  <div class="btn">
		    <span>File</span>
		    <input type="file" name="fuDocument[]" id="fuDocument" multiple>
	    </div>
	    <div class="file-path-wrapper">
	     	<input class="file-path validate" type="text" placeholder="Upload one or more files">
	    </div>
	  </div>
	</div>
</div>
<div class="row">
	<div class="col s12">
		<div id="div_document">
				<?php if(count($query_leave_doc) > 0): ?> 
					<ul class="collection with-header"><li class="collection-header"><h4>เอกสาร</h4></li>
						<?php foreach ($query_leave_doc as $row): ?>						
			        <li class="collection-item">
			        	<div>
			        		<a href="<?php echo base_url($row["ldoc_filepath"]) ?>">
			        			<?php echo $row['ldoc_filename'] ?>
			        		</a>
			        		<a href="javascript:void(0);" class="secondary-content red-text" onclick="delete_doc('<?php echo $row["ldoc_id"] ?>');">
			        			<i class="material-icons">delete</i>
			        		</a>
			        	</div>
			        </li>
					<?php endforeach ?>
					</ul>
				<?php endif ?>

			</div>
	</div>
</div>
<div class="divider"></div>
<div class="section">
	<div class="row">
		<div class="col s4">
			<button class="btn waves-effect waves-light" type="submit" name="action">Submit
			  <i class="material-icons right">send</i>
			</button>
		</div>
	  <div class="col s4 offset-s5 m3 offset-m5 right-align">
	  	<a class="waves-effect waves-light btn red">ยกเลิก</a>
	  </div>
	</div>
</div>
<?php echo form_close(); ?>
<script type="text/javascript" src="<?php echo js_url() ?>datetimepicker/jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="<?php echo js_url() ?>datetimepicker/jquery.datetimepicker.css" media="screen" title="no title" charset="utf-8" />
<script type="text/javascript">
	$(document).ready(function()
	{
		var page_type = $("#hdPagetype")val();
		if(page_type === "editdoc")
		{
			disable_all_controls(false);
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
	function disable_all_controls(all)
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
