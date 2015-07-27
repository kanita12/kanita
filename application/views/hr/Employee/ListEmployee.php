<div class="row right-align">
  <a href="<?php echo site_url("hr/Employees/register"); ?>" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
</div>
<div class="row">
  <div class=" col s12">
    <div class="input-field col s2 m2 l1 left-align">
      <a href="#!"><i class="medium material-icons">search</i></a>
    </div>
    <div class="input-field col s10 m10 l3">
      <input type="text" name="txtKeyword" id="txtKeyword" value="<?php echo $vtxtKeyword; ?>" />
      <label for="txtKeyword">คำค้นหา</label>
    </div>
    <div class="input-field col s12 m5 l3">
      <?php echo form_dropdown("ddlDepartment",$ddlDepartment,$vddlDepartment,"id='ddlDepartment'");?>
      <label for="ddlDepartment">แผนก</label>
    </div>
    <div class="input-field col s12 m5 l3">
      <?php echo form_dropdown("ddlPosition",$ddlPosition,$vddlPosition,"id='ddlPosition'");?>
      <label for="ddlPosition">ตำแหน่ง</label>
    </div>
    <div class="input-field col s12 m2 offset-m2 l2">
      <a href="javascript:void(0);" onclick="go_search();" class="btn" >ค้นหา</a>
    </div>
  </div>
</div>
<table class="responsive-table bordered highlight">
	<thead>
		<tr>
			<th>รหัสพนักงาน	</th>
			<th>Username</th>
			<th>ชื่อ-นามสกุล</th>
			<th>แผนก</th>
			<th>ตำแหน่ง</th>
			<th></th>
		</tr>
  </thead>
  <tbody>
		<?php foreach($query->result_array() as $row): ?>
		<tr>
			<td><?php echo $row['EmpID']; ?></td>
			<td><?php echo $row['Username']; ?></td>
			<td><?php echo $row['EmpFullnameThai'] ?></td>
			<td><?php echo $row['DName']; ?></td>
			<td><?php echo $row['PName']; ?></td>
			<td>
				<a href="<?php echo site_url("hr/Employees/Detail/".$row['EmpID']); ?>" target="_self">
					แก้ไข
				</a>
        <br>
        <a href="<?php  echo site_url("Worktime/show/".$row['EmpID']); ?>" onclick="backupValue();" target="_blank">
            ตรวจสอบเวลาเข้า-ออก
          </a> 
        <br>
        <a href="<?php echo site_url('hr/Employees/increasesalary/'.$row['EmpID']); ?>" >
          ปรับเงินเดือน
        </a>
        <br>
        <a href="<?php echo site_url('hr/Employees/userroles/'.$row['UserID']); ?>" >
          สิทธิ์การเข้าใช้งาน
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
        var keyword = $("[id$='txtKeyword']").val();
        var department = $("[id$='ddlDepartment']").val();
        var position = $("[id$='ddlPosition']").val();
        var site_url = '<?php echo site_url();?>hr/Employees/search/'+keyword+'/'+department+'/'+position;
        window.location.href = site_url;
        return false;
        //  var form_data = {
        //         txtKeyword: keyword.val(),
        //         ddlDepartment: department.val(),
        //         ddlPosition: position.val()
        //     };
        //     submitDataAjax('<?php echo site_url("hr/Employee/ajaxEmployee");?>',form_data,function (data){$("[id$='b-container']").html(data);
        // scrollToID("[id$='b-container']");});
  }
  function backupValue(){
      localStorage['setvalue'] = "true";
      localStorage['search_keyword'] = $("[id$='txtKeyword']").val();
      localStorage['search_department'] = $("[id$='ddlDepartment']").val();
      localStorage['search_position'] = $("[id$='ddlPosition']").val();
  }
</script>