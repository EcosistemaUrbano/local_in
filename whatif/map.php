<?php
/*
Template Name: Localizaciones
*/
get_header();

// this page title
if ( have_posts() ) :
	while ( have_posts() ) : the_post();
	include "vistas-tit.php";
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

if ( array_key_exists('filtro', $_GET) ) { $filtro = sanitize_text_field( $_GET['filtro'] ); } else { $filtro = ""; }
if ( array_key_exists('pn', $_GET) ) { $pn = sanitize_text_field( $_GET['pn'] ); } else { $pn = ""; }


	echo $mess_out;

	// categories filters
	include "filters.php";

get_footer(); ?>
