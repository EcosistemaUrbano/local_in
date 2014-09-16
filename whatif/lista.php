<?php
/*
Template Name: Lista
*/

get_header();

include "general-vars.php";

if ( array_key_exists('filtro', $_GET) ) { $filtro = sanitize_text_field( $_GET['filtro'] ); } else { $filtro = ""; }

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
	include "loop.php";

	// categories filters
	include "filters.php";
	
	if(function_exists('wp_pagenavi')) { wp_pagenavi(); }  

get_footer(); ?>
