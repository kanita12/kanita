<a href="javascript:void(0);" onclick="addNew();">เพิ่ม</a>

<table id='listTable'>
	<tr>
    <td>#</td>
		<td>ประเภทการลา</td>
		<td>อายุงาน (ปี)</td>
		<td>ลาได้ (วัน)</td>
    <td></td>
	</tr>
  <?php
  $i = 1;
  foreach ($queryLeaveCondition->result_array() as $row): ?>
    <tr>
      <td><?php echo $i ?></td>
      <td id='tdLeaveType_<?php echo $row['LCID'];?>'><?php echo $row['LTName'] ?></td>
      <td id='tdWorkAge_<?php echo $row['LCID'];?>'><?php echo $row['LCWorkAge'] ?></td>
      <td id='tdCanLeave_<?php echo $row['LCID'];?>'><?php echo $row['LCCanLeave'] ?></td>
      <td>
        <a href="javascript:void(0);" onclick="editThis('<?php echo $row['LCID'] ?>');">แก้ไข</a>
        <a href="javascript:void(0);" onclick="deleteThis(this,'delete','<?php echo $row['LCID'] ?>');">ลบ</a>
      </td>
    </tr>
  <?php
  $i++;
  endforeach ?>
</table>

<script type='text/javascript'>

	function addNew()
	{
		var addHtml = '';
		addHtml += "<table>";
		addHtml += "<tr><td style='width:50%;text-align:right;'>ประเภทการลา&nbsp;&nbsp; </td><td>";
    addHtml += "<select id='ddlLeaveType'>";
    $.ajax({
          type: "POST",
          url: 'ajaxGetLeaveType',
          data: {leaveType:null},
          cache: false,async: false,timeout: 30000,
          success: function (data) {
              addHtml += data;
          }
    });
    addHtml += "</select>";
    addHtml += "</td></tr>";
		addHtml += "<tr><td style='text-align:right;'>อายุงาน&nbsp;&nbsp;</td><td><input id='txtWorkAge' > ปี</td></tr>";
    addHtml += "<tr><td style='text-align:right;'>ลาได้&nbsp;&nbsp;</td><td><input id='txtCanLeave' > วัน</td></tr>";
		addHtml += "</table>";

		swal({
			title: 'เพิ่มเงื่อนไขการลา',
			html: addHtml,
			showCancelButton: true,
			closeOnConfirm: false
		},function() {
			var newType = $('#ddlLeaveType').val();
      var newTypeName = $('#ddlLeaveType option:selected').text();
			var newAge = $('#txtWorkAge').val();
			var newCan = $('#txtCanLeave').val();
      var trNum = $('#listTable tr').length;
			$.ajax({
		        type: "POST",
		        url: 'addNew/',
		        data: { ddlLeaveType: newType,txtLeaveType:newTypeName,txtWorkAge:newAge,txtCanLeave:newCan,trNum:trNum },
		        cache: false,async: false,timeout: 30000,
		        success: function (data) {
              if(data == "duplicate")
              {
                swal('ข้อมูลนี้ซ้ำ มีข้อมูลอยู่แล้ว','','error');
              }
              else
              {
                $("#listTable").append(data);
                swal('เรียบร้อยแล้ว','','success');
              }

		        }
		    });

		});
	}

	function editThis(ID)
	{
    //tdLeaveType
    //tdWorkAge
    //tdCanLeave
		var leaveType = $("#tdLeaveType_"+ID).html();
		var workAge = $("#tdWorkAge_"+ID).html();
		var canLeave = $("#tdCanLeave_"+ID).html();

    var addHtml = '';
		addHtml += "<table>";
		addHtml += "<tr><td style='width:50%;text-align:right;'>ประเภทการลา&nbsp;&nbsp; </td><td>";
    addHtml += "<select id='ddlLeaveType'>";
    $.ajax({
          type: "POST",
          url: 'ajaxGetLeaveType',
          cache: false,async: false,timeout: 30000,
          data:{leaveType:leaveType},
          success: function (data) {
              addHtml += data;
          }
    });
    addHtml += "</select>";
    addHtml += "</td></tr>";
		addHtml += "<tr><td style='text-align:right;'>อายุงาน&nbsp;&nbsp;</td><td><input id='txtWorkAge' value='"+workAge+"' > ปี</td></tr>";
    addHtml += "<tr><td style='text-align:right;'>ลาได้&nbsp;&nbsp;</td><td><input id='txtCanLeave' value='"+canLeave+"' > วัน</td></tr>";
		addHtml += "</table>";

		swal({
			title: 'แก้ไขเงื่อนไขการลา',
			html: addHtml,
			showCancelButton: true,
			closeOnConfirm: false
		},function() {
      var newType = $('#ddlLeaveType').val();
      var newTypeName = $('#ddlLeaveType option:selected').text();
			var newAge = $('#txtWorkAge').val();
			var newCan = $('#txtCanLeave').val();

			$.ajax({
		        type: "POST",
		        url: 'edit',
            data: { id:ID,ddlLeaveType: newType,txtLeaveType:newTypeName,txtWorkAge:newAge,txtCanLeave:newCan },
		        cache: false,async: false,timeout: 30000,
		        success: function (data) {
              if(data == "duplicate")
              {
                swal({
                  title:'ข้อมูลนี้ซ้ำ มีข้อมูลอยู่แล้ว',
                  type:'error',
                  closeOnConfirm: false
                },function(){
                  editThis(ID);
                });

              }
              else
              {
                $("#tdLeaveType_"+ID).html(newTypeName);
                $("#tdWorkAge_"+ID).html(newAge);
                $("#tdCanLeave_"+ID).html(newCan);
                swal('เรียบร้อยแล้ว','','success');
              }


		        }
		    });

		});
	}

</script>
