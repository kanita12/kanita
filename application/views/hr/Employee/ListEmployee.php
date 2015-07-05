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
      <h2><?php echo $topic; ?></h2>
      <br/><br/>
      <div>
      	<a href="<?php echo $addButtonLink; ?>" class="addButton" target="_blank"><?php echo $addButtonText; ?></a>
      </div>
      <br/>

      ค้นหารายชื่อพนักงาน
      <br/>

      <input type="text" name="txtKeyword" id="txtKeyword" placeholder="Keyword" value="<?php echo $vtxtKeyword; ?>" />
      <?php echo form_dropdown("ddlDepartment",$ddlDepartment,$vddlDepartment,"id='ddlDepartment'");?>
      &nbsp;
      <?php echo form_dropdown("ddlPosition",$ddlPosition,$vddlPosition,"id='ddlPosition'");?>
      &nbsp;
      <button class="btn btn-default" onclick="checkBeforeSubmit();">ค้นหา</button>

      <br/><br/>

      <div class="CSSTableGenerator">
      	<table>
      		<tbody>
      			<tr>
      				<td>
      					รหัสพนักงาน
      				</td>
      				<td>
      					Username
      				</td>
      				<td>
      					ชื่อ-นามสกุล
      				</td>
      				<td>
      					แผนก
      				</td>
      				<td>
      					ตำแหน่ง
      				</td>
      				<td>&nbsp;</td>
      			</tr>
      			<?php foreach($query->result_array() as $row){ ?>
      			<tr>
      				<td>
      					<?php echo $row['EmpID']; ?>
      				</td>
      				<td>
      					<?php echo $row['Username']; ?>
      				</td>
      				<td>
      					<?php echo $row['EmpFirstnameThai']." ".$row['EmpLastnameThai']; ?>
      				</td>
      				<td>
      					<?php echo $row['DName']; ?>
      				</td>
      				<td>
      					<?php echo $row['PName']; ?>
      				</td>
      				<td>
      					<a href="<?php echo site_url("hr/Employee/Detail/".$row['EmpID']); ?>" target="_self">
      						แก้ไข
      					</a>
                <br>
                <a href="javascript:void(0);" onclick="backupValue();gotoURL('<?php  echo site_url("hr/WorkTime/showTime/".$row['EmpID']); ?>');">
                  ตรวจสอบเวลาเข้า-ออก
                </a>
                <br>
                <a href="<?php echo site_url('hr/Employee/increase_salary/'.$row['EmpID']); ?>" >
                  ปรับเงินเดือน
                </a>
                <br>
                <a href="<?php echo site_url('hr/Employee/user_roles/'.$row['UserID']); ?>" >
                  สิทธิ์การเข้าใช้งาน
                </a>
      				</td>
      			</tr>
      			<?php } ?>

      			<?php echo $links; ?>
      		</tbody>
      	</table>
