<?php
	$tags_tit = get_the_title();
	$tags_id = $post->ID;
	if ( post_custom("Page Small Icon") ) { $pag_img = get_post_meta($post->ID, "Page Small Icon", $single = true); }
	
	$tit_out = "
	<div class='tit-peq'>
		<img src='" .WHATIF_BLOGTHEME. "/images/$pag_img' title='$tags_tit'  alt='$tags_tit' />
		<h2>$tags_tit</h2>
	</div>
	";
?>
