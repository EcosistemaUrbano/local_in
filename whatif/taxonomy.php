<?php

get_header();

include "general-vars.php";

$filtro=$_GET['filtro'];

// this page title
if ( have_posts() ) :
	while ( have_posts() ) : the_post();
	include "vistas-tit-terms.php";
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
