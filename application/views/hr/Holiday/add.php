<?php echo form_open($formURL);?>
<?php echo form_hidden("hdHID",$HID); ?>
<table>
<tr>
	<td>
		ชื่อวันหยุด
	</td>
	<td>
		<?php echo form_input(array("name"=>"txtHName","id"=>"txtHName","value"=>$vHName));?>
	</td>
</tr>
<tr>
	<td>
		คำอธิบาย
	</td>
	<td>
		<?php echo form_textarea(array("name"=>"txtHDesc","id"=>"txtHDesc","value"=>$vHDesc));?>
	</td>
</tr>
<tr>
	<td>
		วันที่
	</td>
	<td>
		<?php echo form_input(array("name"=>"txtHDate","id"=>"txtHDate","class"=>"datepicker","value"=>$vHDate));?>
	</td>
</tr>
<tr>
	<td>
	</td>
	<td>
		<button class="btn btn-default" onclick="checkBeforeSubmit();">ส่งข้อความ</button>
	</td>
</table>

<?php echo form_close(); ?>
<script type="text/javascript" src="<?php echo bootstrap_url()."js/bootstrap-datepicker.js";?>"></script>
		<script type="text/javascript">
		$(document).ready(function(){

			$(".datepicker").datepicker({
	            format: "yyyy-mm-dd"
	        })
	        .on('changeDate', function(ev){
	            //window.location.href = "?day=" + ev.format();
	            $.ajax({
			        url: "<?php echo site_url("Holiday/ajaxHoliday")?>",
			        type: 'POST',
			        data: {"date":$(this).val()}, // $(this).serialize(); you can use this too
			        success: function(data){
			        	if(data=="false"){
			        		alert("วันหยุดนี้มีการเพิ่มแล้วกรุณาเลือกวันอื่น");
			        		$(".datepicker").val("");
			        	}
			        }

			    });
	        });
			
		});
		function checkBeforeSubmit(){
			var hName = $("[id$='txtHName']");
			var hDate = $("[id$='txtHDate']");
			if(hName.val()==""){
				alert("กรุณากรอกชื่อวันหยุด");
				hName.focus();
			}
			else if(hDate.val()==""){
				alert("กรุณาเลือกวันหยุด");
				hDate.focus();
			}
			else{
				hName.parents("form").submit();
			}
		}
		</script>
