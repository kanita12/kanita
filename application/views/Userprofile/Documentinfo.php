<h5 class="header">เอกสารการโอนเงินเดือน</h5>
<div class="divider"></div>
<div class="section">
	<div class="row">
		<div class="col s12">
			<div class="input-field col s6">
				<?php echo form_dropdown("ddlBank", $queryBank, $empBankID, "id='ddlBank' disabled");?>
				<label for="ddlBank" class="green-text">ธนาคาร</label>
			</div>
			<div class="input-field col s6">
				<input type="text" readonly="true" name="txtBankAccountBranch" id="txtBankAccountBranch" value="<?php echo $empBankBranch?>">
				<label for="txtBankAccountBranch" class="green-text">สาขา</label>
			</div>
			<div class="input-field col s6">
				<?php echo form_dropdown("ddlBankAccountType", $queryBankType, $empBankType, "id='ddlBankAccountType' disabled");?>
				<label for="ddlBankAccountType" class="green-text">ประเภทบัญชี</label>
			</div>
			<div class="input-field col s6">
				<input type="text" readonly="true" name="txtBankAccountNumber" id="txtBankAccountNumber" value="<?php echo $empBankBranch?>">
				<label for="txtBankAccountNumber" class="green-text">เลขที่บัญชี</label>
			</div>
			<div class="input-field col s12">
				<br><br><br>
				<img class="responsive-img materialboxed" id="copy_bookbank" src="<?php echo $empBankImg?>">
				<label for="copy_bookbank" class="green-text">สำเนาสมุดบัญชี</label>
			</div>
		</div>
	</div>
</div>
<h5 class="header">เอกสารอื่นๆ</h5>
<div class="divider"></div>
<div class="section">

</div>