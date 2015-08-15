<div class="row">
	<div class="col s10">
		<div class="row">
			<div class="input-field col s12">
				<div class="col s2 m1 l1 left-align">
					<a href="#!"><i class="medium material-icons">search</i></a>
				</div>
				<div class="input-field col s9 offset-s1 m4 offset-m1 l4 offset-l1">
					<?php echo form_dropdown('select_institution', $dropdown_institution, $value_institution,"id='select_institution'"); ?>
					<label for="select_institution">หน่วยงาน</label>
				</div>
				<div class="input-field col s11 offset-s1 m4 l4">
					<?php echo form_dropdown('select_department', $dropdown_department, $value_department,"id='select_department'"); ?>
					<label for="select_department">แผนก</label>
				</div>
				<div class="input-field col s12 m2 l2">
					<a href="javascript:void(0);" onclick="go_search();" class="btn" >ค้นหา</a>
				</div>
			</div>
		</div>
	</div>
	<div class="col s2">
		<div class="row right-align">
			<a href="<?php echo site_url("admin/Position/add"); ?>" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
		</div>
	</div>
</div>

<?php
	$last_institution_id 	= 0;
	$last_department_id 	= 0;
?>

<?php for ($i=0; $i < $rowcount_query; $i++) : ?>
	<?php if ($last_institution_id != $query[$i]["D_INSID"]): $last_institution_id = $query[$i]["D_INSID"]; ?>
		<h4 class="header">หน่วยงาน<?php echo $query[$i]["INSName"]; ?></h4>
	<?php endif ?>
	<?php if ($last_department_id != $query[$i]["P_DID"]): $last_department_id = $query[$i]["P_DID"]; ?>
		<h5 class="header" style="padding-left:2em;">แผนก<?php echo $query[$i]["DName"]; ?></h5>
		<div style="padding-left:6em;">
			<table class="bordered highlight" >
	<?php endif ?>
		<tr>
			<td><?php echo $query[$i]["PName"] ?></td>
			<td class="right-align">
				<a href="<?php echo site_url('admin/Position/edit/'.$query[$i]["PID"]) ?>" 
					class="btn-floating btn-small waves-effect waves-light blue">
					<i class="material-icons">edit</i>
				</a>
				<a href="javascript:void(0);"
					data-id="<?php echo $query[$i]["PID"] ?>" 
					class="btn-floating btn-small waves-effect waves-light red"
					onclick="deleteThis(this,'Position/delete','<?php echo $query[$i]['PID'] ?>');">
					<i class="material-icons">delete</i>
				</a>
			</td>
		</tr>
	<?php if (empty($query[$i+1]["P_DID"]) || $last_department_id != $query[$i+1]["P_DID"]):  ?>
			</table>
		</div>
		<br/>
	<?php endif ?>
	
<?php endfor ?>
<script type="text/javascript">
	function go_search()
	{
		var site_url = '<?php echo site_url(); ?>';
		var inst = $("#select_institution").val();
		var department = $("#select_department").val();
		var redirect_url = site_url+"admin/Position/search/"+inst+"/"+department+"/";
		window.location.href = redirect_url;
		return false;
	}
</script>