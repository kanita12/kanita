<script type="text/javascript">
      function checkBeforeSubmit(){
            var data1 = $("[id$='ddlMonth']");
            var data2 = $("[id$='ddlYear']");
            var empID = $("#hdEmpID").val();
             var form_data = {

                    ddlMonth: data1.val(),
                    ddlYear: data2.val()
                };
                submitDataAjax('../ajaxShowTime/'+empID,form_data,function (data){$("[id$='b-container']").html(data);
            scrollToID("[id$='b-container']");});
      }
     </script>
     <input type="hidden" id="hdEmpID" value="<?php echo $empID?>"/>
     <?php if ($returner !== ""): ?>
       <a href="<?php echo $returner?>" class="btn waves-effect waves-light">ย้อนกลับ</a>
     <?php endif?>
      <?php echo form_dropdown("ddlMonth", $ddlMonth, $vddlMonth, "id='ddlMonth'");?>
      &nbsp;
      <?php echo form_dropdown("ddlYear", $ddlYear, $vddlYear, "id='ddlYear'");?>
      &nbsp;
      <button class="btn btn-default" onclick="checkBeforeSubmit()">ค้นหา</button>

      <br/><br/>

      <div class="CSSTableGenerator">
      	<table>
      		<tbody>
      			<tr>
      				<td>
      					วัน-เดือน-ปี
      				</td>
      				<td>
      					เวลาเข้างาน
      				</td>
      				<td>
      					เวลาเลิกงาน
      				</td>
      			</tr>
      			<?php foreach ($query->result_array() as $row) {?>
      			<tr>
      				<td>
      					<?php echo $row['WTDate'];?>
      				</td>
      				<td>
      					<?php echo $row['WTTimeStart'];?>
      				</td>
      				<td>
      					<?php echo $row['WTTimeEnd'];?>
      				</td>
      			</tr>
      			<?php }
?>
      		</tbody>
      	</table>
