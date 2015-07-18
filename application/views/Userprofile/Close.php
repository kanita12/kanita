		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function()
	{
		var url = window.location.href;
		$("#userprofile_menu > a").each(function()
		{
			if($(this).attr("href") === url)
			{
				$(this).addClass("active");
			}
		});
	});
</script>