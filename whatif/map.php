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

	echo $mess_out;

	// categories filters
	include "filters-map.php";

get_footer(); ?>
