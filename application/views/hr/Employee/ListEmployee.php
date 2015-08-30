<div class="container">
	<div class="row right-align">
		<div class="col s12">
			<a href="<?php echo site_url("hr/Employees/register"); ?>" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
		</div>
	</div>
</div>
<div class="row">
	<div class=" col s12">
		<div class="input-field col s2 m2 l1 left-align">
			<a href="#!"><i class="medium material-icons">search</i></a>
		</div>
		<div class="input-field col s10 m10 l3">
			<input type="text" name="inputKeyword" id="inputKeyword" value="<?php echo $valueKeyword; ?>" />
			<label for="inputKeyword">คำค้นหา</label>
		</div>
		<div class="input-field col s12 m5 l3">
			<?php echo form_dropdown("ddlDepartment",$dataDepartment,$valueDepartment,"id='ddlDepartment'");?>
			<label for="ddlDepartment">ฝ่าย</label>
		</div>
		<div class="input-field col s6 m5 l3">
			<?php echo form_dropdown("ddlSection",$dataSection,$valueSection,"id='ddlSection'");?>
			<label for="ddlSection">แผนก</label>
		</div>
		<div class="input-field col s6 m5 offset-m2 l3">
			<?php echo form_dropdown("ddlUnit",$dataUnit,$valueUnit,"id='ddlUnit'");?>
			<label for="ddlUnit">หน่วยงาน</label>
		</div>
		<div class="input-field col s6 m5 l3">
			<?php echo form_dropdown("ddlGroup",$dataGroup,$valueGroup,"id='ddlGroup'");?>
			<label for="ddlGroup">กลุ่ม</label>
		</div>
		<div class="input-field col s6 m5 offset-m2 l3">
			<?php echo form_dropdown("ddlPosition",$dataPosition,$valuePosition,"id='ddlPosition'");?>
			<label for="ddlPosition">ตำแหน่ง</label>
		</div>
		<div class="input-field col s12 m2 l2 offset-l1">
			<a href="javascript:void(0);" id="submitSearch" onclick="go_search();" class="btn" >ค้นหา</a>
		</div>
	</div>
</div>
<table class="responsive-table bordered highlight">
	<thead>
		<tr>
			<th width="12%">รหัสพนักงาน</th>
			<th>ชื่อ-นามสกุล</th>
			<th>ฝ่าย</th>
			<th>แผนก</th>
			<th>ตำแหน่ง</th>
			<th width="11%"></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($query as $row): ?>
			<tr>
				<td><?php echo $row['EmpID']; ?></td>
				<td><?php echo $row['EmpFullnameThai'] ?></td>
				<td><?php echo $row['DepartmentName']; ?></td>
				<td><?php echo $row['SectionName']; ?></td>
				<td><?php echo $row['PositionName']; ?></td>
				<td>
					<?php if ($this->acl->hasPermission("manage_employee")): ?>
						<a href="<?php echo site_url("hr/Employees/Detail/".$row['EmpID']); ?>" 
							class="btn-floating btn-small waves-effect waves-light tooltipped"
							data-position="bottom" data-tooltip="แก้ไข">
							<i class="material-icons">edit</i>
						</a>
					<?php endif ?>
					<a href="<?php  echo site_url("Worktime/show/".$row['EmpID']); ?>" 
						class="btn-floating btn-small waves-effect waves-light orange tooltipped" onclick="backupValue();" target="_blank" data-position="bottom" data-tooltip="ตรวจสอบเวลาเข้า-ออก">
						<i class="material-icons">query_builder</i>
					</a>
					<a href="<?php echo site_url('hr/Employees/increasesalary/'.$row['EmpID']); ?>" 
						class="btn-floating btn-small waves-effect waves-light green tooltipped"
						data-position="bottom" data-tooltip="ปรับเงินเดือน">
						<i class="material-icons">trending_up</i>
					</a>
					<?php if (!$this->acl->hasPermission("promote_position")): ?>
						<a href="<?php echo site_url('hr/Employees/promoteposition/'.$row['EmpID']); ?>" 
							class="btn-floating btn-small waves-effect waves-light purple tooltipped"
							data-position="bottom" data-tooltip="ปรับตำแหน่ง">
							<i class="material-icons">event_seat</i>
						</a>
					<?php endif ?>
					<?php if ($this->acl->hasPermission("manage_role")): ?>
						<a href="<?php echo site_url('hr/Employees/userroles/'.$row['EmpID']); ?>" 
							class="btn-floating btn-small waves-effect waves-light pink tooltipped"
							data-position="bottom" data-tooltip="สิทธิ์การเข้าใช้งาน">
							<i class="material-icons">security</i>
						</a>
					<?php endif ?>
					<a href="<?php echo site_url('hr/Employees/specialmoney/'.$row['EmpID']); ?>" 
						class="btn-floating btn-small waves-effect waves-light lime tooltipped"
						data-position="bottom" data-tooltip="เงินพิเศษประจำเดือน">
						<i class="material-icons">assessment</i>
					</a>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>

<script type="text/javascript">
	$(document).ready(function(){
		checkValue();
	});
	function checkValue(){
		if(localStorage['setvalue'] == "true"){
			var form_data = {
				txtKeyword: localStorage['search_keyword'],
				ddlDepartment: localStorage['search_department'],
				ddlPosition: localStorage['search_position']
			};
			submitDataAjax('<?php echo site_url("hr/Employee/ajaxEmployee");?>',form_data,function (data){$("[id$='b-container']").html(data);
				scrollToID("[id$='b-container']");});

			localStorage.clear();
		}

	}
	function go_search(){
		var keyword = $("[id$='inputKeyword']").val();
		if(keyword == ""){keyword = "0";}
		var department = $("[id$='ddlDepartment']").val();
		var section = $("#ddlSection").val();
		var unit = $("#ddlUnit").val();
		var group = $("#ddlGroup").val();
		var position = $("[id$='ddlPosition']").val();
		var site_url = '<?php echo site_url();?>hr/Employees/search/'+department+'/'+section+'/'+unit+'/'+group+'/'+position+'/'+keyword+'/';
		window.location.href = site_url;
		return false;
	}
	function backupValue(){
		localStorage['setvalue'] = "true";
		localStorage['search_keyword'] = $("[id$='txtKeyword']").val();
		localStorage['search_department'] = $("[id$='ddlDepartment']").val();
		localStorage['search_position'] = $("[id$='ddlPosition']").val();
	}
</script>