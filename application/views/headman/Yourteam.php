<div class="row">
  <div class="input-field col s12">
    <div class="col s2 m1 l1 left-align">
      <a href="#!"><i class="medium material-icons">search</i></a>
    </div>
    <div class="input-field col s8">
      <input type="text" name="input_keyword" id="input_keyword" value="<?php echo $value_keyword ?>">
      <label for="input_keyword">คำค้นหา</label>
    </div>
    <div class="input-field col s3">
      <button class="btn waves-effect waves-light blue" onclick="go_search();">ค้นหา</button>
    </div>
  </div>
</div>

<table class="responsive-table bordered highlight">
  <thead>
    <tr>
      <th>รหัสพนักงาน</th>
      <th>ตำแหน่ง</th>
      <th>ชื่อ</th>
      <th>E-mail</th>
      <th>เบอร์โทร</th>
      <th>รายละเอียด</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($query->result_array() as $row): ?>
      <tr>
        <td><?php echo $row["EmpID"] ?></td>
        <td><?php echo $row["PositionName"] ?></td>
        <td><?php echo $row["EmpFullnameThai"] ?></td>
        <td><?php echo $row["EmpEmail"] ?></td>
        <td><?php echo $row["EmpMobilePhone"] ?></td>
        <td>
          <a href="<?php echo site_url("headman/Yourteam/Detail/".$row['EmpID']); ?>" target="_self">
            ดูรายละเอียด
          </a>
          <a href="javascript:void(0);" onclick="backupValue();gotoURL('<?php  echo site_url("Worktime/showTime/".$row['EmpID']); ?>');">
            ตรวจสอบเวลาเข้า-ออก
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
              txtKeyword: localStorage['search_keyword']
          };
          submitDataAjax('<?php echo site_url("hr/Employee/ajaxEmployee");?>',form_data,function (data){$("[id$='b-container']").html(data);
      scrollToID("[id$='b-container']");});

          localStorage.clear();
  }

}
function checkBeforeSubmit(){
      var keyword = $("[id$='txtKeyword']");
      var department = $("[id$='ddlDepartment']");
      var position = $("[id$='ddlPosition']");
       var form_data = {
              txtKeyword: keyword.val()
          };
          submitDataAjax('<?php echo site_url("hr/Employee/ajaxEmployee");?>',form_data,function (data){$("[id$='b-container']").html(data);
      scrollToID("[id$='b-container']");});
}
function backupValue(){
    localStorage['setvalue'] = "true";
    localStorage['search_keyword'] = $("[id$='txtKeyword']").val();
}

function go_search()
{
  var keyword = $("#input_keyword").val();
  var now_url = window.location.href;
  var controller_url = now_url.toLowerCase().split("yourteam");
  var to_url = controller_url[0]+"yourteam/search/"+keyword;
  window.location.href = to_url;
  return false;
}
</script>