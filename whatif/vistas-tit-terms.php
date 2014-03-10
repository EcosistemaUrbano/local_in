<?php
	$tags_tit = get_the_title();
	$tags_id = $post->ID;
	if ( post_custom("Page Small Icon") ) { $pag_img = get_post_meta($post->ID, "Page Small Icon", $single = true); }
	
	$tit_out = "
<div class='tit-peq'>
		<img alt='Mensajes' title='" . __('Mensajes','whatif') . "' src='http://whatifcities.com/wp-content/themes/wic/images/vista-mensajes-mini.png'>
		<h2>" . __('Mensajes','whatif') . "</h2>
	</div>
	";
?>
