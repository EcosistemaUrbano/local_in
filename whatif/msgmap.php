<?php
/*
Template Name: msgmap
*/
get_header();

if ( array_key_exists('filtro', $_GET) ) { $filtro = sanitize_text_field( $_GET['filtro'] ); } else { $filtro = ""; }
if ( array_key_exists('pn', $_GET) ) { $pn = sanitize_text_field( $_GET['pn'] ); } else { $pn = ""; }
if ( array_key_exists('pn2', $_GET) ) { $pn2 = sanitize_text_field( $_GET['pn2'] ); } else { $pn2 = ""; }

// this page title
if ( have_posts() ) :
	while ( have_posts() ) : the_post();
		$tags_tit = get_the_title();
	$tags_id = $post->ID;
	if ( post_custom("Page Small Icon") ) { $pag_img = get_post_meta($post->ID, "Page Small Icon", $single = true); }
	
	$tit_out = "
	<div class='tit-peq'>
		<img src='" .WHATIF_BLOGTHEME. "/images/vista-localiza-mini.png' alt='" . __('Localizaciones','whatif') . "' />
		<h2>" . __('Localización','whatif') . "</h2>
	</div>
	";
	
	endwhile;
else:
endif;
wp_reset_query();

// vistas list (subpages)
	include "vistas-list.php";

	echo $tit_out; //display header

	// list of messages
	$mess_out = "
	<div class='unique-pages-tit map'>
		<div id='map' align='center' style='width: 800px; height: 470px'></div> 
	</div><!-- end class unique mosac -->
	";

	echo $mess_out;

	// categories filters
//	include "filters-map.php";


get_footer();
?>
