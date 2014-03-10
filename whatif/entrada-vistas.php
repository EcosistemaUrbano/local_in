<?php
/**
 * Template Name: Entrada vistas
 */

get_header();
include "general-vars.php";

if ( have_posts() ) :
	while ( have_posts() ) : the_post();

	$vistas_tit = get_the_title();
	$vistas_id = $post->ID;
	$elige_out = "
	<div  class='unique'>
	<div class='tit'>
		<h2>$vistas_tit</h2>
	</div>
	";

	endwhile;
else:
endif;
wp_reset_query();


// vistas list (subpages)
query_posts("post_type=page&post_parent=$vistas_id&orderby=menu_order&order=ASC");
if ( have_posts() ) :
	$elige_out .= "
	<div class='vista-selector'>
	";
	while ( have_posts() ) : the_post();
	$pag_child_link = get_permalink();
	$pag_child_tit = get_the_title();
	if ( post_custom("Page Icon") ) { $pag_child_img = get_post_meta($post->ID, "Page Icon", $single = true); }
	$elige_out .= "
	<div class='vista-img'>
		<a href='$pag_child_link'><img src='$template_url/images/$pag_child_img' alt='$pag_child_tit' /></a>
		<div class='vista-tit'>$pag_child_tit</div>
	</div>
	";
	endwhile;
	$elige_out .= "</div><!-- end class vista-selector -->";
else:
endif;
wp_reset_query();

$elige_out .= "</div><!-- end class class unique -->";

echo $elige_out;


get_footer(); ?>
