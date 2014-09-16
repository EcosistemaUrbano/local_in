<?php
/*
Template Name: Imágenes
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
	include "loop-img.php";

	// categories filters
	include "filters-img.php";

get_footer(); ?>
