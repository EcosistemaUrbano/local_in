<?php
/*
Template Name: Tags
*/

get_header();

include "general-vars.php";

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

	$cloud_out = "<div class='unique'>";

$taxs = array('positivo','negativo');
foreach ( $taxs as $tax ) {
	if ( $tax == 'positivo' ) { $bg = $bg_pl; $color = $color_pl; $chover = $chover_pl; $cloud_class = "cloudl"; }
	elseif ( $tax == 'negativo' ) { $bg = $bg_mn; $color = $color_mn; $chover = $chover_mn; $cloud_class = "cloudr"; }
	$args = array(
		'smallest' => '1.5',
		'largest' => '4',
		'unit' => 'em',
		'number' => '26',
		'format' => 'array',
		'separator' => '',
		'orderby' => 'count',
		'order' => 'RAND',
		'link' => 'view',
		'taxonomy' => $tax,
		'echo' => false
	);
	$terms = wp_tag_cloud( $args );

	$cloud_out .= "
	<ul class='$cloud_class cloud'>
	";
	

	
	
	foreach ( $terms as $term ) {
	
     

	
	    
		$cloud_out .= "<li class='$color'>$term</</li>";
	}
//	$cloud_out .= print_r($terms);
	$cloud_out .= "</ul>";
}
	$cloud_out .= "</div>";

echo $cloud_out;

	// categories filters
	//include "filters.php";


get_footer(); ?>
