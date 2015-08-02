<a href="javascript:void(0);" onclick="addNew();">เพิ่ม</a>
<?php echo form_open('admin/institution') ?>
<div>
	คำค้นหา 
	<?php echo form_input('txtKeyword',$vKeyword,'id=txtKeyword'); ?>
	สถานะ
	<?php echo form_dropdown('ddlStatus',$queryStatus,$vStatus,'id=ddlStatus') ?>

	<?php echo form_submit('btnSubmit','ค้นหา') ?>
</div>
<?php echo form_close(); ?>
<table id='listInst'>
	<tr>
		<td>ชื่อหน่วยงาน</td>
		<td>คำอธิบายเพิ่มเติม</td>
		<td>จัดการ</td>
	</tr>
	<?php foreach ($query->result_array() as $row): ?>
		<tr id="trIns_<?php echo $row['INSID'];?>">
			<td id='tdInsName_<?php echo $row['INSID'];?>'><?php echo $row['INSName'] ?></td>
			<td id='tdInsDesc_<?php echo $row['INSID'];?>'><?php echo $row['INSDesc'] ?></td>
			<td id='tdInsStatus_<?php echo $row['INSID'];?>'><?php echo $row['INS_StatusName'] ?></td>
			<td>
				<a href="javascript:void(0);" onclick="editThis('<?php echo $row['INSID'] ?>');">แก้ไข</a>
				<a href="javascript:void(0);" onclick="deleteThis(this,'institution/delete','<?php echo $row['INSID'] ?>');">ลบ</a>
			</td>
		</tr>
	<?php endforeach ?>
</table>
<?php echo $links ?>
<script type='text/javascript'>

	function addNew()
	{
		var addHtml = '';
		addHtml += "<table>";
		addHtml += "<tr><td>ชื่อหน่วยงาน</td><td><input id='txtInstName' style='width:100%'></td></tr>";
		addHtml += "<tr><td>คำอธิบายเพิ่มเติม</td><td><textarea id='txtInstDesc' cols='50' rows='10'></textarea></td></tr>";
		addHtml += "<tr><td>สถานะ</td>";
		addHtml += "<td>";
		addHtml += "<select id='ddlInstStatus'><option value='1'>ใช้งาน</option><option value='0'>ปิดใช้งาน</otion></select>";
		addHtml += "</td></tr>";
		addHtml += "</table>";

		swal({   
			title: 'เพิ่มหน่วยงาน',   
			html: addHtml,   
			showCancelButton: true,   
			closeOnConfirm: false 
		},function() { 
			var newName = $('#txtInstName').val();
			var newDesc = $('#txtInstDesc').val(); 
			var newStatus = $('#ddlInstStatus').val(); 
			$.ajax({
		        type: "POST",
		        url: 'institution/addNew/',
		        data: { txtInstName: newName,txtInstDesc:newDesc,ddlStatus:newStatus },
		        cache: false,async: false,timeout: 30000,
		        success: function (data) {
		            $("#listInst").append(data);
		            swal('เรียบร้อยแล้ว','','success'); 
		        }
		    }); 
			
		});
	}

	function editThis(insID)
	{
		var object = $("trIns_"+insID);
		var name = $("#tdInsName_"+insID).html();
		var desc = $("#tdInsDesc_"+insID).html();
		var status = $("#tdInsStatus_"+insID).html();

		var addHtml = '';
		addHtml += "<table>";
		addHtml += "<tr><td>ชื่อแผนก</td><td><input id='txtInstName' style='width:100%' value='"+name+"'></td></tr>";
		addHtml += "<tr><td>คำอธิบายเพิ่มเติม</td><td><textarea id='txtInstDesc' cols='50' rows='10'>"+desc+"</textarea></td></tr>";
		addHtml += "<tr><td>สถานะ</td>";
		addHtml += "<td>";
		addHtml += "<select id='ddlInstStatus'>";
		if(status == "ใช้งาน")
		{
			addHtml += "<option value='1' selected='selected'>ใช้งาน</option>";
		}
		else
		{
			addHtml += "<option value='1' >ใช้งาน</option>";
		}
		if(status == "ปิดใช้งาน")
		{
			addHtml += "<option value='0' selected='selected'>ปิดใช้งาน</option>";
		}
		else
		{
			addHtml += "<option value='0' >ปิดใช้งาน</option>";
		}
		addHtml += "</td></tr>";
		addHtml += "</table>";
		swal({   
			title: 'แก้ไขหน่วยงาน',   
			html: addHtml,   
			showCancelButton: true,   
			closeOnConfirm: false 
		},function() {  
			var newName = $('#txtInstName').val();
			var newDesc = $('#txtInstDesc').val();
			var newStatus = $('#ddlInstStatus').val();
			alert(newStatus); 
			$.ajax({
		        type: "POST",
		        url: 'institution/edit/',
		        data: { id:insID,txtInstName: newName,txtInstDesc:newDesc,ddlStatus:newStatus},
		        cache: false,async: false,timeout: 30000,
		        success: function (data) {
		            $("#tdInsName_"+insID).html(newName);
		            $("#tdInsDesc_"+insID).html(newDesc);
		            $("#tdInsStatus_"+insID).html($('#ddlInstStatus option:selected').text());
		            swal('เรียบร้อยแล้ว','','success'); 
		        }
		    }); 
			
		});
	}
	
</script>