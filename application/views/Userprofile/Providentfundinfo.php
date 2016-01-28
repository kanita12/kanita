<div class="row">
	<div class=" col s12">
		<div class="input-field col s12">
			<?php echo form_dropdown("ddlProvidentFund",$dataProvidentFund,$valueProvidentFund,"id='ddlProvidentFund'");?>
			<label for="ddlProvidentFund">กองทุนสำรองเลี้ยงชีพ</label>
		</div>
	</div>
</div>
<?php if ($isChoose === FALSE): ?>
	<div class="divider"></div>
	<div class="section">
		<div class="row">
			<div class="col s4">
				<button class="btn waves-effect waves-light" type="submit" name="action" onclick="return check_before_submit();">บันทึก</button>
			</div>
			<div class="col s4 offset-s4 right-align">
				<a href="<?php echo site_url("admin/Position") ?>" class="btn waves-effect waves-light red">ยกเลิก</a>
			</div>
		</div>
	</div>
<?php endif ?>
