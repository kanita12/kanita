
<div class="csscontent2">
	<div class="w-embed cssfrom1">
		<?php echo form_open("headman/Requestemployee/saveAdd","",array("class"=>"form-horizontal")) ?>
			<fieldset>
				<legend>แบบฟอร์มส่งคำขอเพิ่มบุคลากร</legend>
				<div class="form-group">
					<label class="col-lg-2 control-label">ตำแหน่ง</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" name="inputPositionName" id="inputPositionName" placeholder="ตำแหน่ง">
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">จำนวน</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" name="inputAmount" id="inputAmount" placeholder="จำนวน">
                
			        </div>
			    </div>
			      <div class="form-group">
			      	<label class="col-lg-2 control-label">คุณสมบัติ</label>
			      	<div class="col-lg-10">
			      		<textarea class="form-control" rows="3" name="inputAttribute" id="inputAttribute"></textarea>
			      	</div>
			      </div>

			      <div class="form-group">
			      	<label class="col-lg-2 control-label">หมายเหตุเพิ่มเติม</label>
			      	<div class="col-lg-10">
			      		<textarea class="form-control" rows="3" name="inputRequestRemark" id="inputRequestRemark"></textarea>
			      	</div>
			      </div>

			      <div class="form-group">
			      	<div class="col-lg-10 col-lg-offset-2">
			      		<button type="submit" class="btn btn-primary">ส่งคำขอ</button>
			      		<button type="reset" class="btn btn-danger">Cancel</button>

			      	</div>
			      </div>
			</fieldset>
		<?php echo form_close(); ?>
	</div>
</div>
<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title">รายการร้องขอ</h3>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover ">
			<thead>
				<tr>
					<th>รหัสคำร้อง</th>
					<th>ตำแหน่ง</th>
					<th>จำนวน</th>
					<th>ส่งคำขอเมื่อ</th>
					<th>สถานะ</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($query->result_array() as $row): ?>
				<tr>
					<td>
						<?php echo $row["REID"] ?>
					</td>
					<td>
						<a href="<?php echo site_url('headman/Requestemployee/detail/'.$row["REID"]) ?>" target="_blank">
							<?php echo $row["REPositionName"] ?>
						</a>
					</td>
					<td>
						<?php echo $row["REAmount"] ?>
					</td>
					<td>
						<?php echo $row["RERequestDate"] ?>
					</td>
				</tr>
			<?php endforeach ?>
			</tbody>
		</table> 
	</div>
</div>
