jQuery(document).ready(function($){
	$("#arquitectura-urbanismo").bind('click', function(){
		$(this).children("img").attr("src","<?php bloginfo("template_directory"); echo "/images/"; ?>a-cat-arq.urb.png");
	});
});
