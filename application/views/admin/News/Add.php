<input type="hidden" id="hd_validation_errors" value="<?php echo validation_errors(); ?>">
<?php echo form_open_multipart(); ?>
<input type="hidden" id="hd_news_id" name="hd_news_id" value="">
<div class="row">
	<div class="input-field col s12">
		<?php echo form_dropdown('input_newstype', $dropdownlist_newstype, set_value('input_newstype',$value_newstype), "id='input_newstype'"); ?>
		<label for="input_newstype">ประเภทข่าว</label>
	</div>
	<div class="input-field col s12">
		<input type="text" id="input_topic" name="input_topic" class="validate" value="<?php echo set_value('input_topic',$value_topic); ?>">
		<label for="input_topic">หัวข้อข่าว</label>
	</div>
	<div class="input-field col s12">
		<br/><br/>
		<textarea name="input_detail" class="materialize-textarea editor"><?php echo $value_detail; ?></textarea>
		<label for="input_detail">เนื้อข่าว</label>
	</div>
</div>
<div class="row">
	<div class="input-field col s3">
		<input type="text" id="input_show_start_date" name="input_show_start_date" class="validate" value="<?php echo $value_show_start_date; ?>">
		<label for="input_show_start_date">วันที่เริ่มแสดงข่าว</label>
	</div>
	<div class="input-field col s3 offset-s1">
		<input type="text" id="input_show_end_date" name="input_show_end_date" class="validate" value="<?php echo $value_show_end_date; ?>">
		<label for="input_show_end_date">วันสิ้นสุดแสดงข่าว</label>
	</div>
</div>
<div class="row">
	<div class="file-field input-field col s12">
		<div class="btn">
			<span>File</span>
			<input type="file" id="files" name="files[]" multiple accept="image/*">
		</div>
		<div class="file-path-wrapper">
            <input class="file-path validate" type="text">
        </div>
	</div>
	<div id="selectedFiles"></div>
</div>
<?php if (count($value_news_image) > 0): ?>
	<div class="divider"></div>
	<div class="section">
		<div class="row">
			<div class="col s12">
				<?php foreach ($value_news_image as $row): ?>
					<img class="responsive-img" src="<?php echo site_url($row["newsimage_filepath"]); ?>">
				<?php endforeach ?>
			</div>
		</div>
	</div>
<?php endif ?>
<div class="divider"></div>
<div class="section">
	<div class="row">
		<div class="col s2">
			<input type="submit" onclick="return check_before_submit();" class="btn" value="บันทึก">
		</div>
		<div class="col s2 offset-s8 right-align"> 
			<a href="<?php echo site_url('admin/News') ?>" class="btn red lighten-1 right-align">ยกเลิก</a>
		</div>
	</div>
</div>
<?php echo form_close(); ?>
<div id="drag-and-drop-zone" class="uploader">
	<div>Drag &amp; Drop Images Here</div>
	<div class="or">-or-</div>
	<div class="browser">
		<label>
			<span>Click to open the file Browser</span>
			<input type="file" name="files[]" multiple="multiple" title="Click to add Files">
		</label>
	</div>
</div>
<div id="fileList">
        
        <!-- Files will be places here -->

      </div>
<style>
	#selectedFiles img {
		max-width: 300px;
		max-height: 300px;
		float: left;
		margin-bottom:10px;
	}
	.uploader
{
	border: 2px dotted #A5A5C7;
	width: 100%;
	color: #92AAB0;
	text-align: center;
	vertical-align: middle;
	padding: 30px 0px;
	margin-bottom: 10px;
	font-size: 200%;

	cursor: default;

	-webkit-touch-callout: none;
	-webkit-user-select: none;
	-khtml-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
}

.uploader div.or {
	font-size: 50%;
	font-weight: bold;
	color: #C0C0C0;
	padding: 10px;
}

.uploader div.browser label {
	background-color: #5a7bc2;
	padding: 5px 15px;
	color: white;
	padding: 6px 0px;
	font-size: 40%;
	font-weight: bold;
	cursor: pointer;
	border-radius: 2px;
	position: relative;
	overflow: hidden;
	display: block;
	width: 300px;
	margin: 20px auto 0px auto;

	box-shadow: 2px 2px 2px #888888;
}

.uploader div.browser span {
	cursor: pointer;
}


.uploader div.browser input {
	position: absolute;
	top: 0;
	right: 0;
	margin: 0;
	border: solid transparent;
	border-width: 0 0 100px 200px;
	opacity: .0;
	filter: alpha(opacity= 0);
	-o-transform: translate(250px,-50px) scale(1);
	-moz-transform: translate(-300px,0) scale(4);
	direction: ltr;
	cursor: pointer;
}

.uploader div.browser label:hover {
	background-color: #427fed;
}

</style>
<script type="text/javascript" src="<?php echo js_url() ?>fileuploader/dmuploader.js"></script>
<script type="text/javascript" src="<?php echo js_url() ?>ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo js_url() ?>ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" src="<?php echo js_url() ?>datetimepicker/jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="<?php echo js_url() ?>datetimepicker/jquery.datetimepicker.css" media="screen" charset="utf-8" />
<script>
	var selDiv = "";
		
	document.addEventListener("DOMContentLoaded", init, false);
	
	function init() 
	{
		document.querySelector('#files').addEventListener('change', handleFileSelect, false);
		selDiv = document.querySelector("#selectedFiles");
	}
		
	function handleFileSelect(e) 
	{
		if(!e.target.files || !window.FileReader) return;
		
		selDiv.innerHTML = "";
		
		var files = e.target.files;
		var filesArr = Array.prototype.slice.call(files);
		filesArr.forEach(function(f) {
			if(!f.type.match("image.*")) {
				return;
			}
	
			var reader = new FileReader();
			reader.onload = function (e) {
				var html = "<img src=\"" + e.target.result + "\">" + f.name + "<br clear=\"left\"/>";
				selDiv.innerHTML += html;				
			}
			reader.readAsDataURL(f); 
			
		});
		
		
	}
</script>
<script type="text/javascript">
      function add_file(id, file)
      {
        var template = '' +
          '<div class="file" id="uploadFile' + id + '">' +
            '<div class="info">' +
              '#1 - <span class="filename" title="Size: ' + file.size + 'bytes - Mimetype: ' + file.type + '">' + file.name + '</span><br /><small>Status: <span class="status">Waiting</span></small>' +
            '</div>' +
            '<div class="bar">' +
              '<div class="progress" style="width:0%"></div>' +
            '</div>' +
          '</div>';
          
          $('#fileList').prepend(template);
      }
      
      function update_file_status(id, status, message)
      {
        $('#uploadFile' + id).find('span.status').html(message).addClass(status);
      }
      
      function update_file_progress(id, percent)
      {
        $('#uploadFile' + id).find('div.progress').width(percent);
      }

      
    

	$(document).ready(function()
	{
      $('#drag-and-drop-zone').dmUploader({
        url: 'admin/News/uploader',
        dataType: 'json',
        allowedTypes: 'image/*',
        onInit: function(){
        },
        onBeforeUpload: function(id){
          update_file_status(id, 'uploading', 'Uploading...');
        },
        onNewFile: function(id, file){
          
          add_file(id, file);
        },
        onComplete: function(){
        },
        onUploadProgress: function(id, percent){
          var percentStr = percent + '%';

          update_file_progress(id, percentStr);
        },
        onUploadSuccess: function(id, data){
          
          
          update_file_status(id, 'success', 'Upload Complete');
          
          update_file_progress(id, '100%');
        },
        onUploadError: function(id, message){
          
          update_file_status(id, 'error', message);
        },
        onFileTypeError: function(file){
          
        },
        onFileSizeError: function(file){
        },
        onFallbackMode: function(message){
          alert('Browser not supported(do something else here!): ' + message);
        }
      });
    
		$('select').material_select();
		//show validate error
		var validation = $("#hd_validation_errors").val();
		if($.trim(validation) !== "")
		{
			swal
			({
				title: "กรุณากรอกข้อมูลให้ครบ",
				html: validation,
				type: "error"
			});
		}
		//set editor
		$('textarea.editor').ckeditor();
		//set datepicker
		$('#input_show_start_date, #input_show_end_date').datetimepicker({
			timepicker:false,
			format:'d/m/Y',
			lang:'th',
			closeOnDateSelect:true
		 });
	});
	function check_before_submit()
	{
		var newstype = parseInt($("#input_newstype").val());
		var topic    = $("#input_topic").val();
		var msg      = "";

		if(newstype === 0){ msg += "- เลือกประเภทข่าว<br/>"; }
		if($.trim(topic) === ""){ msg += "- กรอกหัวข้อข่าว<br/>"; }
		if(msg !== "")
		{
			swal
			({
				title: "กรุณากรอกข้อมูลให้ครบ",
				html: msg,
				type: "error"
			});
			return false;
		}
		return true;
	}
</script>