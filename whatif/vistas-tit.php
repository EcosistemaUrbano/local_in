<?php
	if ( is_tax() ) {
		$term =	$wp_query->queried_object->name;
		$tags_tit = sprintf( __('Mensajes con la etiqueta %s','whatif'),$term );
	} else {
		$tags_tit = get_the_title();
	}
	$tags_id = $post->ID;
	if ( post_custom("Page Small Icon") ) {
		$pag_img = get_post_meta($post->ID, "Page Small Icon", $single = true);
		$pag_img_out = "<img src='" .WHATIF_BLOGTHEME. "/images/$pag_img' title='$tags_tit'  alt='$tags_tit' />";
	} else { $pag_img_out = ""; }
	$tit_out = "
	<div class='tit-peq'>
		$pag_img_out
		<h2>$tags_tit</h2>
	</div>
	";
?>
