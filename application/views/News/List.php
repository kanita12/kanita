<div class="row right-align">
<a href="<?php echo site_url("hr/News/add"); ?>" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
</div>
<div class="row">
	<div class="input-field col s12">
		<div class="col s2 m1 l1 left-align">
			<a href="#!"><i class="medium material-icons">search</i></a>
		</div>
		<div class="input-field col s5 m4 l3">
			<input type="text" id="input_keyword" name="input_keyword" value="<?php echo $value_keyword ?>">
			<label for="input_keyword">คำค้นหา</label>
		</div>
		<div class="input-field col s3 m3 l3">
			<?php echo form_dropdown("select_newstype",$select_newstype,$value_newstype,"id='select_newstype'");?>
			<label for="select_newstype">ประเภท</label>
		</div>
		<div class="input-field col s12 m2 l2">
			<a href="javascript:void(0);" onclick="go_search();" class="btn" >ค้นหา</a>
		</div>
	</div>
</div>
<table class="striped">
	<thead>
		<tr>
			<th data-field="news_id">ID</th>
			<th data-field="newstype_name">ประเภทข่าว</th>
			<th data-field="news_topic">หัวข้อข่าว</th>
			<th data-field="news_show_date">วันที่แสดงข่าว</th>
			<th data-field="news_latest_update_date">แก้ไขล่าสุด</th>
			<th>จัดการ</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($query as $row): ?>
			<tr>
				<td><?php echo $row["news_id"] ?></td>
				<td><?php echo $row["newstype_name"] ?></td>
				<td><?php echo $row["news_topic"] ?></td>
				<td>
					<?php if ($row["news_show_start_date"] === "0000-00-00" || $row["news_show_end_date"] === "0000-00-00"): ?>
						แสดงตลอด
					<?php else: ?>
						<?php echo dateThaiFormatFromDB($row["news_show_start_date"]); ?> - <?php echo dateThaiFormatFromDB($row["news_show_end_date"]); ?>
					<?php endif ?>
				</td>
				<td><?php echo date_time_thai_format_from_db($row["news_latest_update_date"]) ?></td>
				<td>
					<a href="<?php echo site_url('News/detail/'.$row["news_id"]) ?>" 
						class="btn-floating btn-small waves-effect waves-light" target="_blank">
						<i class="material-icons">visibility</i>
					</a>
					<a href="<?php echo site_url('hr/News/edit/'.$row["news_id"]) ?>" 
						class="btn-floating btn-small waves-effect waves-light blue">
						<i class="material-icons">edit</i>
					</a>
					<a href="<?php echo site_url('hr/News/delete/') ?>"
						data-id="<?php echo $row["news_id"] ?>" 
						class="btn-floating btn-small waves-effect waves-light red"
						onclick="return delete_this(this);">
						<i class="material-icons">delete</i>
					</a>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<script type="text/javascript">
	function go_search()
	{
		var site_url = '<?php echo site_url(); ?>';
		var keyword = $("#input_keyword").val();
		if(keyword == ""){ keyword = "0";}
		var newstype_id = parseInt($("#select_newstype").val());
		var redirect_url = site_url+"hr/News/search/"+keyword+"/"+newstype_id;
		window.location.href = redirect_url;
		return false;
	}
</script>