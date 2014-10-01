<?php

get_header();

if ( array_key_exists('filtro', $_GET) ) { $filtro= sanitize_text_field($_GET['filtro']); } else { $filtro = ""; }

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
	include "loopTerm.php";

	// categories filters
	include "filters.php";

get_footer(); ?>
