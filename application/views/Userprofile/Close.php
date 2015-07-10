	</div>
</div>
<script type="text/javascript">
	$(document).ready(function()
	{
		var url = window.location.href;
		$("ul#userprofile_menu > li > a").each(function()
		{
			if($(this).attr("href") === url)
			{
				$(this).parent().addClass("active");
			}
		});
	});
</script>