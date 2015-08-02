<?php foreach ($query->result_array() as $row): ?>
	<h1><?php echo $row["NSTopic"]; ?></h1>
	<div class="reg__content__detail">
		<?php echo $row["NSContent"]; ?>
	</div>
	<br/>
	<div>
		สร้างโดย : <?php echo $row["NSCreatedBy"] ?> เมื่อ : <?php echo $row["NSCreatedDate"] ?>
	</div>
<?php endforeach ?>
