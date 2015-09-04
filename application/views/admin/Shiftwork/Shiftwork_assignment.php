<?php echo form_open(); ?>
<input type="hidden" name="hdId" value="<?php echo $valueId; ?>">
<div class="row" id="selectedUser">
	<div class="col s12">
		<table class="bordered highlight" id="tableSelectedUser">
			<tbody>
				<?php foreach ($dataEmpShiftworkList as $row): ?>
					<tr>
						<input type="hidden" name="hdUserId[]" value="<?php echo $row["UserID"];?>">
						<td id="userId_<?php echo $row["UserID"]; ?>"><?php echo $row["EmpID"]; ?></td>
						<td id="empFullnameThai_<?php echo $row["UserID"]; ?>"><?php echo $row["EmpFullnameThai"]; ?></td>
						<td id="empSection_<?php echo $row["UserID"]; ?>"><?php echo $row["SectionName"]; ?></td>
						<td id="empPosition_<?php echo $row["UserID"]; ?>"><?php echo $row["PositionName"]; ?></td>
						<td><a href="javascript:void(0);" class="btn red" onclick="removeUser('<?php echo $row["UserID"]; ?>');">ลบ</a></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>

<a href="javascript:void(0);" class="btn" onclick="$('#allUser').toggleClass('hide');">เพิ่ม</a>
<div class="row hide" id="allUser">
	<div class="col s12">
		<div class="col s12 input-field">
			<input type="text" id="instantFilter">
			<label for="instantFilter">กรองรายชื่อ</label>
		</div>
		<table class="bordered highlight" id="tableAllUser">
			<tbody>
				<?php foreach ($dataEmpList as $row): ?>
					<tr>
						<td id="userID_<?php echo $row["UserID"]; ?>"><?php echo $row["EmpID"]; ?></td>
						<td id="empFullnameThai_<?php echo $row["UserID"]; ?>"><?php echo $row["EmpFullnameThai"]; ?></td>
						<td id="empSection_<?php echo $row["UserID"]; ?>"><?php echo $row["SectionName"]; ?></td>
						<td id="empPosition_<?php echo $row["UserID"]; ?>"><?php echo $row["PositionName"]; ?></td>
						<td><a href="javascript:void(0);" class="btn" onclick="selectUser('<?php echo $row["UserID"]; ?>');">เลือก</a></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>
<br><br>
<div class="divider"></div>
<div class="section">
    <div class="row">
        <div class="col s2">
            <input type="submit" onclick="return checkBeforeSubmit();" class="btn" value="บันทึก">
        </div>
        <div class="col s2 offset-s6 m2 offset-m8 right-align"> 
            <a href="<?php echo site_url('admin/Shiftwork') ?>" class="btn red lighten-1 right-align">ยกเลิก</a>
        </div>
    </div>
</div>
<?php echo form_close(); ?>
<script type="text/javascript">
	$(document).ready(function()
	{
		$("#instantFilter").change(function()
		{
			var keyword  = $(this).val();
			if(keyword)
			{
				$("#tableAllUser").find("td:not(:Contains('"+keyword+"'))").parent("tr").hide();
				$("#tableAllUser").find("td:Contains('"+keyword+"')").parent("tr").show();
			}
			else
			{
				$("#tableAllUser").find("td").parent("tr").show();
			}
		}).keyup(function(){$(this).change()});
	});
	function selectUser(userId)
	{
		var empId = $("#tableAllUser #userId_"+userId).html();
		var fullname = $("#tableAllUser #empFullnameThai_"+userId).html();
		var section = $("#tableAllUser #empSection_"+userId).html();
		var position = $("#tableAllUser #empPosition_"+userId).html();

		var tr = "<tr>";
		tr += "<input type=\"hidden\" name=\"hdUserId[]\" value=\""+userId+"\">";
		tr += "<td id=\"userId_"+userId+"\">"+empId+"</td>";
		tr += "<td id=\"empFullnameThai_"+userId+"\">"+fullname+"</td>";
		tr += "<td id=\"empSection_"+userId+"\">"+section+"</td>";
		tr += "<td id=\"empPosition_"+userId+"\">"+position+"</td>";
		tr += "<td><a href=\"javascript:void(0);\" class=\"btn red\" onclick=\"removeUser('"+userId+"');\">ลบ</a></td>";
		tr += "</tr>";

		$("#tableSelectedUser").append(tr);

		//ซ่อนรายชื่อนี้จากรายการ
		$("#tableAllUser #userId_"+userId).parent().addClass("hide");
	}
	function removeUser(userId)
	{
		var tr = $("#tableSelectedUser #empFullnameThai_"+userId).parent();
		tr.remove();

		//คืนรายชื่อนี้ไปสู่รายการ
		$("#tableAllUser #userId_"+userId).parent().removeClass("hide");
	}
	function checkBeforeSubmit()
	{
		return true;
	}
</script>