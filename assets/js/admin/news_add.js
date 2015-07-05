function initUploader()
{
	$('#drag-and-drop-zone').dmUploader({
		url: '/hrsystem/admin/News/uploader',
		dataType: 'json',
		allowedTypes: 'image/*',
		extraData: {news_id:$("#hd_news_id").val()},
		onBeforeUpload: function(id)
		{
			update_file_status(id, 'uploading', 'Uploading...');
		},
		onNewFile: function(id, file)
		{
			add_file(id, file);
		},
		onComplete: function(id,data)
		{
			//show picture upload
			clear_file();
		},
		onUploadProgress: function(id, percent)
		{
			var percentStr = percent + '%';
			update_file_progress(id, percentStr);
		},
		onUploadSuccess: function(id, data)
		{
			var news_id = data.news_id;
			var filepath = data.filepath;
			var filename = data.filename;

			update_file_status(id, 'success', 'Upload Complete'); 
			update_file_progress(id, '100%');

			$("#hd_news_id").val(news_id);
			var text = "<img class='responsive-img' src='"+window.location.protocol+"//"+window.location.hostname+"/hrsystem/"+filepath+"' style='width:200px;'>";
			$("#file_pic").append(text);
		},
		onUploadError: function(id, message)
		{
			update_file_status(id, 'error', message);
		},
		onFileTypeError: function(file)
		{
			alert("File type error.");
		},
		onFileSizeError: function(file)
		{
			alert("File size error.");
		},
		onFallbackMode: function(message){
		  alert('Browser not supported(do something else here!): ' + message);
		}
	});
}
function add_file(id, file)
{
	var template = '' +
		'<div class="file" id="uploadFile' + id + '">' +
		'<div class="info">' +
		'<span class="filename" title="Size: ' + file.size + 'bytes - Mimetype: ' + file.type + '">' + file.name + '</span><br /><small>Status: <span class="status">Waiting</span></small>' +
		'</div>' +
		'<div class="bar">' +
		'<div class="progress" style="width:0%"></div>' +
		'</div>' +
		'</div>';
  
	$('#fileList').prepend(template);
}
function clear_file()
{
	$('#fileList').html("");
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
	initUploader();
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