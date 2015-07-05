<input type="hidden" id="hd_validation_errors" value="<?php echo validation_errors(); ?>">
<?php echo form_open_multipart(); ?>
<input type="hidden" id="hd_news_id" name="hd_news_id" value="<?php echo $value_news_id ?>">
<div class="row">
	<div class="input-field col s12">
		<?php echo form_dropdown('input_newstype', $dropdownlist_newstype, set_value('input_newstype',$value_newstype), "id='input_newstype'"); ?>
		<label for="input_newstype">ประเภทข่าว</label>
	</div>
	<div class="input-field col s12">
		<input type="text" id="input_topic" name="input_topic" class="validate" value="<?php echo set_value('input_topic',$value_topic); ?>">
		<label for="input_topic">หัวข้อข่าว</label>
	</div>
	<div class="input-field col s12">
		<br/><br/>
		<textarea name="input_detail" class="materialize-textarea editor"><?php echo $value_detail; ?></textarea>
		<label for="input_detail">เนื้อข่าว</label>
	</div>
</div>
<div class="row">
	<div class="input-field col s3">
		<input type="text" id="input_show_start_date" name="input_show_start_date" class="validate" value="<?php echo $value_show_start_date; ?>">
		<label for="input_show_start_date">วันที่เริ่มแสดงข่าว</label>
	</div>
	<div class="input-field col s3 offset-s1">
		<input type="text" id="input_show_end_date" name="input_show_end_date" class="validate" value="<?php echo $value_show_end_date; ?>">
		<label for="input_show_end_date">วันสิ้นสุดแสดงข่าว</label>
	</div>
</div>
<div class="row">
	<div class="col s12">
		<div id="drag-and-drop-zone" class="uploader">
			<div>Drag &amp; Drop Images Here</div>
			<div class="or">-or-</div>
			<div class="browser">
				<label>
					<span>Click to open the file Browser</span>
					<input type="file" name="files[]" multiple="multiple" title="Click to add Files">
				</label>
			</div>
		</div>
		<div id="fileList"><!-- Files will be places here --></div>
		<div id="file_pic">
			<?php if (count($value_news_image) > 0): ?>
				<?php foreach ($value_news_image as $row): ?>
					<img class="responsive-img" src="<?php echo site_url($row["newsimage_filepath"]); ?>" style="width:200px;">
				<?php endforeach ?>
			<?php endif ?>
		</div>
	</div>
</div>
<div class="divider"></div>
<div class="section">
	<div class="row">
		<div class="col s2">
			<input type="submit" onclick="return check_before_submit();" class="btn" value="บันทึก">
		</div>
		<div class="col s2 offset-s8 right-align"> 
			<a href="<?php echo site_url('admin/News') ?>" class="btn red lighten-1 right-align">ยกเลิก</a>
		</div>
	</div>
</div>
<?php echo form_close(); ?>

<script type="text/javascript" src="<?php echo js_url() ?>fileuploader/dmuploader.js"></script>
<script type="text/javascript" src="<?php echo js_url() ?>ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo js_url() ?>ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" src="<?php echo js_url() ?>datetimepicker/jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="<?php echo js_url() ?>datetimepicker/jquery.datetimepicker.css" media="screen" charset="utf-8" />
<script type="text/javascript" src="<?php echo js_url() ?>admin/news_add.js"></script>
<link rel="stylesheet" href="<?php echo css_url() ?>admin/news_add.css" media="screen" charset="utf-8" />