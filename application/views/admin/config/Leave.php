<div class="row right-align">
  <a href="javascript:void(0);" class="btn-floating btn-large waves-effect waves-light red" onclick="toggle_add_section();"><i class="material-icons">add</i></a>
</div>
<!-- add & edit section -->
<div id="add_edit" class="card" style="display:none;">
  <div class="card-content">
    <div class="row">
      <input type="hidden" id="hd_cond_leave_id" value="0">
      <div class="col s12">
        <div class="input-field col s12">
          <?php echo form_dropdown('ddlLeaveType', $query_leave_type, 0,"id='ddlLeaveType'"); ?>
          <label for="ddlLeaveType">ประเภทการลา</label>
        </div>
        <div class="input-field col s12">
          <input type="number" id="txtWorkAge" value="0">
          <label for="txtWorkAge">อายุงาน/ปี</label>
        </div>
        <div class="input-field col s12">
          <input type="number" id="txtCanLeave" value="0">
          <label for="txtCanLeave">ลาได้/วัน</label>
        </div>
      </div>
    </div>
  </div>
  <div class="card-action right-align">
    <a href="javascript:void(0);" class="btn-flat waves-effect waves-teal green-text" onclick="save();">Save</a>
    <a href="javascript:void(0);" class="btn-flat waves-effect waves-red red-text" onclick="toggle_add_section();">Cancel</a>
  </div>
</div>
<!-- list section -->
<table id="listTable" class="bordered highlight">
  <thead>
  	<tr>
      <th>#</th>
  		<th>ประเภทการลา</th>
  		<th>อายุงาน (ปี)</th>
  		<th>ลาได้ (วัน)</th>
      <th></th>
  	</tr>
  </thead>
  <tbody>
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
  </tbody>
</table>

<script type='text/javascript'>
  function hide_add_section()
  {
    $("#add_edit").stop(true,true).animate({ height: "hide", opacity: "hide" }, 800);
    $("#ddlLeaveType option:selected").removeAttr('selected');
    $("#ddlLeaveType").material_select();
    $("#ddlLeaveType").closest('.input-field').children('span.caret').remove();
    $("#txtWorkAge").val(0);
    $("#txtCanLeave").val(0);
    $("#hd_cond_leave_id").val(0);
    return false;
  }
  function toggle_add_section()
  {
    var selected_ddl = $("#ddlLeaveType").val();
    if(selected_ddl != 0)
    {
      $("#add_edit").stop(true,true).animate({ height: "show", opacity: "show" }, 800);
    }
    else
    {
      $("#add_edit").stop(true,true).animate({ height: "toggle", opacity: "toggle" }, 800);
    }
    $("#ddlLeaveType option:selected").removeAttr('selected');
    $("#ddlLeaveType").material_select();
    $("#ddlLeaveType").closest('.input-field').children('span.caret').remove();
    $("#txtWorkAge").val(0);
    $("#txtCanLeave").val(0);
    $("#hd_cond_leave_id").val(0);
  }
  function save(edit)
  {
      var cond_leave_id = $("#hd_cond_leave_id").val();
      var newType = $('#ddlLeaveType').val();
      var newTypeName = $('#ddlLeaveType option:selected').text();
      var newAge = $('#txtWorkAge').val();
      var newCan = $('#txtCanLeave').val();
      var trNum = $('#listTable tr').length;
      if(cond_leave_id != 0) //edit
      {
        $.ajax({
            type: "POST",
            url: 'edit',
            data: { id:cond_leave_id,ddlLeaveType: newType,txtLeaveType:newTypeName,txtWorkAge:newAge,txtCanLeave:newCan },
            cache: false,async: false,timeout: 30000,
            success: function (data) {
              if(data == "duplicate")
              {
                swal({
                  title:'ข้อมูลนี้ซ้ำ มีข้อมูลอยู่แล้ว',
                  type:'error',
                  closeOnConfirm: false
                },function(){
                  editThis(cond_leave_id);
                });

              }
              else
              {
                $("#tdLeaveType_"+cond_leave_id).html(newTypeName);
                $("#tdWorkAge_"+cond_leave_id).html(newAge);
                $("#tdCanLeave_"+cond_leave_id).html(newCan);
                swal('เรียบร้อยแล้ว','','success');
                hide_add_section();
              }
            }
        });
      }
      else //add
      {
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
                $("#listTable tbody").append(data);
                swal('เรียบร้อยแล้ว','','success');
                hide_add_section();
              }
            }
        });
      }
    return false;
  }
	function editThis(ID)
	{
		var leaveType = $("#tdLeaveType_"+ID).html();
		var workAge = $("#tdWorkAge_"+ID).html();
		var canLeave = $("#tdCanLeave_"+ID).html();
    $("#ddlLeaveType option:selected").removeAttr('selected');
    $("#ddlLeaveType option:contains(" + leaveType + ")").attr('selected', 'selected');
    $("#ddlLeaveType").material_select();
    $("#ddlLeaveType").closest('.input-field').children('span.caret').remove();
    $("#txtWorkAge").val(workAge);
    $("#txtCanLeave").val(canLeave);
    $("#hd_cond_leave_id").val(ID);

    $("#add_edit").stop(true,true).animate({ height: "show", opacity: "show" }, 800);
	}
</script>
