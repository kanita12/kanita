<div class="row">
	<div class="col s10">
		<div class="row">
			<div class="input-field col s12">
				<div class="col s2 left-align">
					<a href="#!"><i class="medium material-icons">search</i></a>
				</div>
				<div class="input-field col s7">
					<input type="text" id="inputKeyword" name="inputKeyword" value="<?php echo $valueKeyword; ?>">
					<label for="inputKeyword">คำค้นหา</label>
				</div>
				<div class="input-field col s3">
					<a href="javascript:void(0);" id="submitSearch" onclick="goSearch();" class="btn" >ค้นหา</a>
				</div>
			</div>
		</div>
	</div>
	<div class="col s2">
		<div class="row right-align">
			<a href="<?php echo site_url("admin/Company/department/add"); ?>" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
		</div>
	</div>
</div>
<div class="divider"></div>

<ul>
<?php $departmentData = searchDepartment($dataList); ?>
<?php foreach ($departmentData as $data): ?>
		<li class="card" style="padding:2em;">
			<div class="col s12">
				<div class="col s6">
					<!-- ฝ่าย -->
					<?php echo $data["cdname"]; ?>
					&nbsp;
					<a href="<?php echo site_url("admin/Company/section/add/".$data["cdid"]) ?>" class="btn-flat waves-effect waves-teal"><i class="material-icons">add</i></a>
					<a href="<?php echo site_url('admin/Company/department/edit/'.$data["cdid"]) ?>" 
						class="btn-flat waves-effect waves-blue">
						<i class="material-icons">edit</i>
					</a>
					<a href="javascript:void(0);"
						data-id="<?php echo $data["cdid"] ?>" 
						class="btn-flat waves-effect waves-red"
						onclick="deleteThis(this,'department/delete','<?php echo $data['cdid'] ?>');">
						<i class="material-icons">delete</i>
					</a>
				</div>
			</div>
			<div>
				<?php $sectionData = searchArrayById($dataList,$data["cdid"],"cs_cdid","csid"); ?>
				<?php if(count($sectionData) > 0): ?>
					<ul style="padding-left:2em;">
						<?php foreach ($sectionData as $secData) : ?>
							<li style="padding-top:3em">
								<div class="col s12">
									<div class="col s6"> 
										<!-- แผนก -->
										<?php echo $secData["csname"]; ?>
									</div>
									<div class="col s6 right-align"> 
										<a href="<?php echo site_url("admin/Company/unit/add/".$secData["csid"]) ?>" class="btn-floating waves-effect waves-light red"><i class="material-icons">add</i></a>
										<a href="<?php echo site_url('admin/Company/section/edit/'.$secData["csid"]) ?>" 
											class="btn-floating waves-effect waves-light blue">
											<i class="material-icons">edit</i>
										</a>
										<a href="javascript:void(0);"
											data-id="<?php echo $secData["csid"] ?>" 
											class="btn-floating waves-effect waves-light red"
											onclick="deleteThis(this,'section/delete','<?php echo $secData['csid'] ?>');">
											<i class="material-icons">delete</i>
										</a>
									</div>
								</div>
								<div>			
							<?php $unitData = searchArrayById($dataList,$secData["csid"],"cu_csid","cuid"); ?>
							<?php if(count($unitData) > 0): ?>
								<ul style="padding-left:2em;">
									<?php foreach ($unitData as $unitData) : ?>
										<li style="padding-top:3em">
											<div class="col s12">
												<div class="col s6"> 
													<!-- หน่วยงาน -->
													<?php echo $unitData["cuname"]; ?>
												</div>
												<div class="col s6 right-align"> 
													<a href="<?php echo site_url("admin/Company/group/add/".$unitData["cuid"]) ?>" class="btn-floating waves-effect waves-light red"><i class="material-icons">add</i></a>
													<a href="<?php echo site_url('admin/Company/unit/edit/'.$unitData["cuid"]) ?>" 
														class="btn-floating waves-effect waves-light blue">
														<i class="material-icons">edit</i>
													</a>
													<a href="javascript:void(0);"
														data-id="<?php echo $unitData["cuid"] ?>" 
														class="btn-floating waves-effect waves-light red"
														onclick="deleteThis(this,'unit/delete','<?php echo $unitData['cuid'] ?>');">
														<i class="material-icons">delete</i>
													</a>
												</div>
											</div>
											<div>
												<?php $groupData = searchArrayById($dataList,$unitData["cuid"],"cg_cuid","cgid"); ?>
												<?php if(count($groupData) > 0): ?>
													<ul style="padding-left:2em;">
														<?php foreach ($groupData as $groupData) : ?>
															<li style="padding-top:3em">
																<div class="col s12">
																	<div class="col s6"> 
																		<?php echo $groupData["cgname"]; ?>
																	</div>
																	<div class="col s6 right-align"> 
																		<a href="<?php echo site_url('admin/Company/department/edit/'.$groupData["cgid"]) ?>" 
																			class="btn-floating waves-effect waves-light blue">
																			<i class="material-icons">edit</i>
																		</a>
																		<a href="javascript:void(0);"
																			data-id="<?php echo $groupData["cgid"] ?>" 
																			class="btn-floating waves-effect waves-light red"
																			onclick="deleteThis(this,'department/delete','<?php echo $groupData['cgid'] ?>');">
																			<i class="material-icons">delete</i>
																		</a>
																	</div>
																</div>
															</li>
														<?php endforeach; ?>
													</ul>
												<?php endif; ?>
											</div>
										</li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</li>
<?php endforeach ?>
</ul>
<?php echo $paging; ?>

<?php
	function searchDepartment($array)
	{
		$returnArray = array();
		$i = 0;
		foreach ($array as $data) 
		{
			if(!in_array_r($data["cdid"],$returnArray))
			{
				$returnArray[$i] =  $data;
				$i++;
			}
		}
		return $returnArray;
	}
?>
<script type="text/javascript">
	function goSearch()
	{
		var site_url = '<?php echo site_url(); ?>';
		var keyword = $("#inputKeyword").val();
		if(keyword === ""){ keyword = 0; }
		var redirect_url = site_url+"admin/Company/department/list/"+keyword+"/";
		window.location.href = redirect_url;
		return false;
	}
</script>