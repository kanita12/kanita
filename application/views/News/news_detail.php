<?php echo $query["news_detail"] ?>
<div class="divider"></div>
<div class="section">
	<h5>รูปภาพ</h5>
	<div class="row">
	<?php foreach ($query_image as $row): ?>
	<div class="col s3">
		<img class="responsive-img materialboxed" width="250" src="<?php echo site_url($row["newsimage_filepath"]) ?>"></li>
	</div>
	<?php endforeach ?>
	</div>
</div>
<div class="divider"></div>
<div class="section">
	<div class="col s12 right-align">
		<a href="<?php echo site_url("news"); ?>" class="btn waves-effect waves-light red">ย้อนกลับ</a>
	</div>
</div>