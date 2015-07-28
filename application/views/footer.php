	 			</div>
	 		</div>
	 	</div>
	 	<?php if (isset($query_news_alert)): ?>
		 	<div class="row">
	 			<div class="col s12" style="background-color: #C8F2EB; padding: 2% 5% 2% 5%;">
	  				<h3>ประกาศข่าวด่วน</h3>
	  				<div class="row">
				 		<?php foreach ($query_news_alert as $row): ?>
					 		<div class="col s12 m4 l4">
					 			<div class="card hoverable tiny" style="background-color:#0ECEAB;">
						        	<div class="card-content white-text">
						            	<p><?php echo $row["news_topic"]; ?></p>
						          	</div>
						          	<div class="card-action right-align">
						            	<a href="<?php echo site_url("news/detail/".$row["news_id"]); ?>" class="black-text">อ่านต่อ</a>
						          	</div>
						        </div>
						    </div>
				 		<?php endforeach ?>
					</div>
				</div>
			</div>
	 	<?php endif ?>	
	 	<footer class="page-footer white-text">
	      Made by <a class="orange-text text-lighten-3" href="http://www.catyard.net">KanexKane</a> & 
	      <a class="orange-text text-lighten-3" href="http://www.kanory.com">Yongyee</a>
	  </footer>
	</body>
</html>