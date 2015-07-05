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
      function checkBeforeSubmit(){
            var keyword = $("[id$='txtKeyword']");
            var department = $("[id$='ddlDepartment']");
            var position = $("[id$='ddlPosition']");
             var form_data = {
                    txtKeyword: keyword.val(),
                    ddlDepartment: department.val(),
                    ddlPosition: position.val()
                };
                submitDataAjax('<?php echo site_url("hr/Employee/ajaxEmployee");?>',form_data,function (data){$("[id$='b-container']").html(data);
            scrollToID("[id$='b-container']");});
      }
      function backupValue(){
          localStorage['setvalue'] = "true";
          localStorage['search_keyword'] = $("[id$='txtKeyword']").val();
          localStorage['search_department'] = $("[id$='ddlDepartment']").val();
          localStorage['search_position'] = $("[id$='ddlPosition']").val();
      }
     </script>


      <div class="w-row">
        <?php foreach ($query->result_array() as $row): ?>
          <div class="w-col w-col-3">
           <div class="form__width80 alert alert-dismissible alert-success">
                <span><?php echo $row['PositionName'] ?></span>
                <br/>
                <img src="<?php echo $row['EmpIDCardImg'] ?>" alt="<?php echo $row['EmpFullnameEnglish'] ?>">
                <br/>
                <span>ชื่อ <?php echo $row['EmpFullnameThai'] ?></span>
                <br/>
                <span>อีเมลล์ <?php echo $row['EmpEmail'] ?></span>
                <br/>
                <span>เบอร์โทร <?php echo $row['EmpMobilePhone'] ?></span>
                <br>
                <a href="<?php echo site_url("headman/Yourteam/Detail/".$row['EmpID']); ?>" target="_self">
                  ดูรายละเอียด
                </a>

                <a href="javascript:void(0);" onclick="backupValue();gotoURL('<?php  echo site_url("headman/Yourteam/showTime/".$row['EmpID']); ?>');">
                  ตรวจสอบเวลาเข้า-ออก
                </a>
            </div>
          </div>
        <?php endforeach ?>
      </div>

      			
      		