				</div>
			</div>
		</div>
		<?php if (isset($query_news_alert)): ?>
			<div class="row">
				<div class="col s12" style="background-color: #C8F2EB; padding: 2% 5% 2% 5%;">
					<h3>ประกาศข่าวด่วน</h3>
					<div class="row">
						<?php foreach ($query_news_alert as $row): ?>
							<div class="col s12 m6 l4">
								<div class="card hoverable tiny" style="background-color:#0ECEAB;">
									<div class="card-content white-text">
										<p><?php echo $row["news_topic"]; ?></p>
									</div>
									<div class="card-action right-align">
										<div class="left">
											<?php echo date_thai_format_no_time_from_db($row["news_create_date"]); ?>
										</div>
										<div class="right">
											<a href="<?php echo site_url("Newsalert/detail/".$row["news_id"]); ?>" class="black-text right-align">อ่านต่อ</a>
										</div>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>
						<?php endforeach ?>
					</div>
				</div>
			</div>
		<?php endif ?>
		<?php if (isset($query_new_emp)): ?>
			<div class="row">
				<div class="col s12" style="background-color: #FCFCFC; padding: 2% 5% 2% 5%;">
					<h3 style="color:#087D68;">พนักงานใหม่</h3>
					<div class="row">
						<?php $i = 0;foreach ($query_new_emp as $row): ?>
							<?php if (!$this->acl->is_user_in_role($row["UserID"],"Administrators") && trim($row["EmpFullnameThai"]) != "" && $i < 4 ): ?>
								<div class="col s12 m6 l3">
									<div class="card-panel center-align" style="padding: 25px 30px 10px 30px;margin:2%;">
										<img id="new_emp_<?php echo $i; ?>" class="circle responsive" src="<?php echo base_url().$row["EmpPictureImg"] ?>" style="max-height:235px;max-width:100%;" alt="" onerror="this.onerror=null;this.src='<?php echo base_url()."assets/images/no_image.jpg" ?>'">
										<p class="truncate center-align">
											<b>
												<?php echo $row["EmpFullnameThai"] ?>
												<?php if ($row["EmpCallname"] !== ""): ?>
													<br>(<?php echo $row["EmpCallname"] ?>)
												<?php else: ?>
													<br><br>
												<?php endif ?>
											</b>
										</p>
										หน่วยงาน <?php echo $row["INSName"] ?><br>
										แผนก <?php echo $row["DName"] ?><br>
										ตำแหน่ง <?php echo $row["PName"] ?>
									</div>
								</div>
							<?php $i++;endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif ?>
		<footer class="page-footer white-text">
			Made by <a class="orange-text text-lighten-3" href="http://www.catyard.net">KanexKane</a> & 
			<a class="orange-text text-lighten-3" href="http://www.kanory.com">Yongyee</a>
		</footer>
		<script type="text/javascript">
			$(document).ready(function(){
				$("[id^='new_emp_']").each(function(){
					var outline_height = $(this).parent().parent().parent().height();
					var my_height = $(this).parent().parent().height();

					if(outline_height !== my_height)
					{
						$(this).css("height",outline_height - 196);
					}
				});
			});
		</script>
	</body>
</html>