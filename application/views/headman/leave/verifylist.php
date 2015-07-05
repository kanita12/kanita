<div class="alert alert-dismissible alert-danger">          
    <label class="control-label"><b>ค้นหารายชื่อลูกทีม</b></label>
    <!-- ค้นหาลูกทีม -->
    <div class="w-row">
        <b class="form-group w-col w-col-2" style=" text-align: right; padding:1%;">ค้นหา :</b>
        <div class="form-group w-col w-col-3">
            <div>
                <input class="form-control" type="text" id='input_keyword' value="คำค้นหา">
            </div>
        </div>
        <div class="form-group w-col w-col-2">
            <div>
                <a href="#" class="btn btn-primary" >ค้นหา</a>
            </div>
        </div>
    </div>
</div>

<table>
	<tr>
		<td>
			เลขที่ใบลา
		</td>
		<td>
			ประเภทการลา
		</td>
		<td>
			วันลา
		</td>
		<td>
			ผู้ลา
		</td>
		<td>
			สถานะ
		</td>
		<td>
			จัดการ
		</td>
	</tr>
<?php foreach ($query->result_array() as $row): ?>
	<tr>
		<td>
			<?php echo $row["LID"] ?>
		</td>
		<td>
			<?php echo $row["LTName"] ?>
		</td>
		<td>
			<?php echo $row["LStartDate"]." ".$row["LStartTime"] ?>
			<?php echo $row["LEndDate"]." ".$row["LEndTime"] ?>
		</td>
		<td>
			<?php echo $row["EmpFirstnameThai"]." ".$row["EmpLastnameThai"] ?>
		</td>
		<td>
			<?php echo $row["WFName"] ?>
		</td>
		<td>
			<a href="<?php echo site_url('Leave/detail/'.$row['LID']) ?>">
			ดูรายละเอียด
			</a> อนุมัติ ไม่อนุมัติ
		</td>
	</tr>
<?php endforeach ?>
</table>