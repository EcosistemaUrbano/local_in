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
	include "loop-map.php";

	// categories filters
	include "filters-map.php";

get_footer(); ?>
