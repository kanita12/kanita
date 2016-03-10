	</div>
</div>
<script>
	$(document).ready(function(){
		//left menu for scroll bottom position fix
		var menu = $('#sub_menu');
		var menu_width = menu.width();
		$(document).scroll(function(){
      if ( $(this).scrollTop() >= $(window).height() - menu.height() ){
      	menu.css("position","fixed").css("top",50).css("width",menu_width);
      } else {
      	menu.css("position","relative").css("top",0);
      }
		});

		//active submenu
	});
</script>