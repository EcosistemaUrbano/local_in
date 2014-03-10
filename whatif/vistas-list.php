<?php
$vistas_id = get_page_id("vistas");
query_posts("post_type=page&post_parent=$vistas_id&orderby=menu_order&order=ASC");
if ( have_posts() ) :

	$tit_out .= "
	<div class='vista-selector-mini'>
	";
	while ( have_posts() ) : the_post();

	if ( $post->ID != $tags_id ) { // don't show current page
	$pag_child_link = get_permalink();
	$pag_child_tit = get_the_title();

	if ( post_custom("Page Small Icon") ) { $pag_child_img = get_post_meta($post->ID, "Page Small Icon", $single = true); }
	$tit_out .= "
	<div class='vista-img-mini'>
		<a href='$pag_child_link'><img src='$template_url/images/$pag_child_img' alt='$pag_child_tit' title='$pag_child_tit' /></a>
	</div>
	";
	}
	endwhile;
	$tit_out .= "</div><!-- end class vista-selector-mini -->";

else:
endif;
wp_reset_query();

?>
