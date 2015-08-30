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
			<a href="<?php echo site_url("admin/Company/position/add"); ?>" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
		</div>
	</div>
</div>
<div class="divider"></div>
<?php $mainList = searchArrayById($dataList,"0","cpheadmancpid","cpid"); ?>
<table class="bordered highlight" >
<?php foreach ($mainList as $data): ?>
		<tr>
			<td><?php echo $data["cpname"] ?></td>
			<td class="right-align">
				<a href="<?php echo site_url('admin/Company/position/edit/'.$data["cpid"]) ?>" 
					class="btn-floating btn-small waves-effect waves-light blue">
					<i class="material-icons">edit</i>
				</a>
				<a href="javascript:void(0);"
					data-id="<?php echo $data["cpid"] ?>" 
					class="btn-floating btn-small waves-effect waves-light red"
					onclick="deleteThis(this,'position/delete','<?php echo $data['cpid'] ?>');">
					<i class="material-icons">delete</i>
				</a>
			</td>
		</tr>
		<?php echo getSubPosition($dataList,$data["cpid"]); ?>
	
<?php endforeach ?>
</table>
<?php

function getSubPosition($array,$position_id,$sub_level = 1)
{
	$sub_position =  searchArrayById($array,$position_id,"cpheadmancpid","cpid");;
	$padding_left = (2*intval($sub_level));
	$text = "";
	foreach($sub_position as $row){
		$text .= "<tr>
					<td style='padding-left:".$padding_left."em;'>".$row["cpname"]."</td>
					<td class='right-align'>
						<a href='".site_url('admin/Company/position/edit/'.$row["cpid"])."' 
						class='btn-floating btn-small waves-effect waves-light blue'>
							<i class='material-icons'>edit</i>
						</a>
						<a href='javascript:void(0);'
						data-id='".$row["cpid"]."' 
						class='btn-floating btn-small waves-effect waves-light red'
						onclick=\"deleteThis(this,'position/delete','".$row['cpid']."');\">
							<i class='material-icons'>delete</i>
						</a>
					</td>
				</tr>";
		$text .= getSubPosition($array,$row["cpid"],($sub_level+1));
	}
	
	return $text;
}
?>
<script type="text/javascript">
	function goSearch()
	{
		var site_url = '<?php echo site_url(); ?>';
		var keyword = $("#inputKeyword").val();
		if(keyword === ""){ keyword = 0; }
		var redirect_url = site_url+"admin/Company/position/list/"+keyword+"/";
		window.location.href = redirect_url;
		return false;
	}
</script>