<?php 
	$last_edu_id = "0";
	$not_equal = FALSE;
?>

<?php for ($i=0; $i < $row_count_history_study ; $i++) : ?> 
	<?php if ($last_edu_id != $query_history_study[$i]["ehs_education_level_id"]): ?>
		<?php $last_edu_id = $query_history_study[$i]["ehs_education_level_id"]; ?>
		<div class="row">
			<div class="col s12">
				<?php echo $query_history_study[$i]["edulvl_name"]; ?>
				<div class="divider0"></div>
				<div class="section">
	<?php endif ?>
					<div>
						<h5><a class="modal-trigger" href="#modal<?php echo $i; ?>"><?php echo $query_history_study[$i]["ehs_academy"]; ?></a></h5>
						<p>
							ปีการศึกษา <?php echo year_thai($query_history_study[$i]["ehs_year_start"]); ?> - <?php echo year_thai($query_history_study[$i]["ehs_year_end"]); ?>
							&nbsp;| สาขา<?php echo $query_history_study[$i]["ehs_major"]; ?>
						</p>
					</div>
					<div id="modal<?php echo $i; ?>" class="modal bottom-sheet history-study">
						<div class="modal-content">
							<h4><?php echo $query_history_study[$i]["ehs_academy"]; ?></h4>
							<p>
								ปีการศึกษา <?php echo year_thai($query_history_study[$i]["ehs_year_start"]); ?> - <?php echo year_thai($query_history_study[$i]["ehs_year_end"]); ?>
								&nbsp;| สาขา<?php echo $query_history_study[$i]["ehs_major"]; ?>
							</p>
							<p>วุฒิการศึกษา : <?php echo $query_history_study[$i]["ehs_degree"]; ?></p>
							<p>คณะ : <?php echo $query_history_study[$i]["ehs_bachelor"]; ?></p>
							<p>เกรดเฉลี่ย : <?php echo $query_history_study[$i]["ehs_grade_avg"]; ?></p>
							<p>คำอธิบายเพิ่มเติม : <?php echo $query_history_study[$i]["ehs_desc"]; ?></p>
						</div>
						<div class="modal-footer">
							<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">ปิด</a>
						</div>
					</div>
	<?php if (!empty($query_history_study[$i+1]["ehs_education_level_id"]) && $last_edu_id != $query_history_study[$i+1]["ehs_education_level_id"]): ?>
				</div>
			</div>
		</div>
		<br><br>
	<?php elseif(empty($query_history_study[$i+1]["ehs_education_level_id"])): ?>
				</div>
			</div>
		</div>
	<?php else: ?>
		<div class="divider"></div>
	<?php endif ?>
<?php endfor ?>
