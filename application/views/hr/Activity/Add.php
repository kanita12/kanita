
<?php echo form_open_multipart($formURL); ?>
<input type="hidden" name="hdACTID" value="<?php echo $actID; ?>" id="hdACTID"/>
<div class="reg__content__detail">
	ชื่อกิจกรรม : <?php echo form_input(array("name"=>"txtTopic","id"=>"txtTopic","value"=>"$valueTopic")); ?>
	<br/>
	เนื้อหา
	<br/>
	<?php echo form_textarea(array("name"=>"txtContent","id"=>"txtContent","value"=>"$valueContent","rows"=>"80")); ?>
	<br/>
	วันเริ่มกิจกรรม
	<?php echo form_input(array("name"=>"txtStartDate","id"=>"txtStartDate","value"=>"$valueStartDate","class"=>"datepicker","readonly"=>true)); ?>
	วันสิ้นสุดกิจกรรม
	<?php echo form_input(array("name"=>"txtEndDate","id"=>"txtEndDate","value"=>"$valueEndDate","class"=>"datepicker","readonly"=>true)); ?>
	<br/>
	วันที่แสดงกิจกรรม
	<?php echo form_input(array("name"=>"txtShowDateFrom","id"=>"txtShowDateFrom","value"=>"$valueShowDateFrom","class"=>"datepicker","readonly"=>true)); ?>
	วันสิ้นสุดแสดงกิจกรรม
	<?php echo form_input(array("name"=>"txtShowDateTo","id"=>"txtShowDateTo","value"=>"$valueShowDateTo","class"=>"datepicker","readonly"=>true)); ?>
	<br/>
	*หากไม่กำหนดวันสิ้นสุดจะแสดงผลตลอดเวลา
</div>
<button class="btn btn-default" onclick="checkBeforeSubmit();">บันทึก</button>



<?php echo form_close(); ?>


<script type="text/javascript" src="<?php echo js_url() ?>datetimepicker/jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="<?php echo js_url() ?>datetimepicker/jquery.datetimepicker.css" media="screen" title="no title" charset="utf-8" />
<script type="text/javascript" src="<?php echo js_url() ?>ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo js_url() ?>ckeditor/config.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".datepicker").datetimepicker({
		timepicker:false,
		format:'d/m/Y',
		lang:'th',
		yearOffset:543,
		closeOnDateSelect:true
	});
	CKEDITOR.replace( 'txtContent',{
		height:'500px'
	} );
});
function checkBeforeSubmit(){
	var topic = $("[id$='txtTopic']");
	if(topic.val()==""){
		alert("กรุณากรอกชื่อกิจกรรม");
		topic.focus();
	}
	else{
		topic.parents("form").submit();
	}
	return false;
}
</script>


    



