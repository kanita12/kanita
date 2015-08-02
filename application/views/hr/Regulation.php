<h1>กฎเกณฑ์-ข้อบังคับ</h1>
<textarea name="txtContent" id="txtContent" ><?php echo $content ?></textarea>
<br/>
<a href="javascript:void(0);" class="btn btn-success btn-lg" onclick="saveThis();">บันทึก</a>
<script type="text/javascript" src="<?php echo js_url() ?>ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		CKEDITOR.replace('txtContent');
	});
	function saveThis()
	{
		var content = CKEDITOR.instances.txtContent.getData();
		$.ajax({
			type:'POST',
			url:'Regulation/save',
			data:{txtContent:content},
			success:function(data){
				swal('บันทึกเรียบร้อยแล้ว','','success');
			}
		})
	}
</script>