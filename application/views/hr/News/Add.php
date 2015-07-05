
<?php echo form_open_multipart($formURL); ?>
<input type="hidden" name="hdNewsID" value="<?php echo $newsID; ?>" id="hdNewsID"/>
<div class="reg__content__detail">
	หัวข้อ : <?php echo form_input(array("name"=>"txtTopic","id"=>"txtTopic","value"=>"$valueTopic")); ?>
	<br/>
	เนื้อหา
	<br/>
	<?php echo form_textarea(array("name"=>"txtContent","id"=>"txtContent","value"=>"$valueContent")); ?>
	<br/>
	วันที่แสดงข่าว
	<?php echo form_input(array("name"=>"txtStartDate","id"=>"txtStartDate","value"=>"$valueStartDate","class"=>"datepicker")); ?>
	วันสิ้นสุด
	<?php echo form_input(array("name"=>"txtEndDate","id"=>"txtEndDate","value"=>"$valueEndDate","class"=>"datepicker")); ?>
	<br/>
	*หากไม่กำหนดวันสิ้นสุดจะแสดงผลตลอดเวลา
</div>
<button class="btn btn-default" onclick="checkBeforeSubmit();">บันทึก</button>



<?php echo form_close(); ?>

<?php echo form_open_multipart(site_url("uploadFile"),array("id"=>"upload")); ?>
 
            <div id="drop">
                Drop Here
                
                <a>Browse</a>
                <input type="file" name="upl" multiple />
            </div>

            <ul>
                <!-- The file uploads will be shown here -->
            </ul>

<?php echo form_close(); ?>
<script src="<?php echo js_url(); ?>miniUpload/js/jquery.knob.js"></script>

        <!-- jQuery File Upload Dependencies -->
        <script src="<?php echo js_url(); ?>miniUpload/js/jquery.ui.widget.js"></script>
        <script src="<?php echo js_url(); ?>miniUpload/js/jquery.iframe-transport.js"></script>
        <script src="<?php echo js_url(); ?>miniUpload/js/jquery.fileupload.js"></script>
        <script src="<?php echo js_url(); ?>miniUpload/js/script.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo js_url(); ?>miniUpload/css/style.css">
        <script type="text/javascript" src="<?php echo bootstrap_url()."js/bootstrap-datepicker.js";?>"></script>

<script type="text/javascript">
$(document).ready(function(){
	$(".datepicker").datepicker({
		format: "yyyy-mm-dd"
	});
	
});
function checkBeforeSubmit(){
	var topic = $("[id$='txtTopic']");
	if(topic.val()==""){
		alert("กรุณากรอกหัวข้อข่าว");
		topic.focus();
	}
	else{
		topic.parents("form").submit();
	}
	return false;
}
function getNewsPic(){

}
</script>


    



