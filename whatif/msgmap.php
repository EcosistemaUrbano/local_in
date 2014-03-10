<?php
/*
Template Name: msgmap
*/

get_header();
include "general-vars.php";


$filtro=$_GET['filtro'];
$pn=$_GET['pn'];
$pn2="";
$pn2=$_GET['pn2'];


if($pn=="positivo"){$textoposinega= " - " . __('Positivo','whatif');}
if($pn=="negativo"){$textoposinega=" - " . __('Negativo','whatif');}
if($filtro=="7"){$textoextra=" - " . __('Arquitectura urbanismo','whatif');}
if($filtro=="4"){$textoextra=" - " . __('Comunidad ciudadana','whatif');}
if($filtro=="5"){$textoextra=" - " . __('Espacio público medioambiente','whatif');}
if($filtro=="8"){$textoextra=" - " . __('Movilidad','whatif');}
if($filtro=="9"){$textoextra=" - " . __('Otros','whatif');}


// this page title
if ( have_posts() ) :
	while ( have_posts() ) : the_post();
		$tags_tit = get_the_title();
	$tags_id = $post->ID;
	if ( post_custom("Page Small Icon") ) { $pag_img = get_post_meta($post->ID, "Page Small Icon", $single = true); }
	
	$tit_out = "
	<div class='tit-peq'>
		<img src='$template_url/images/vista-localiza-mini.png' alt='" . __('Localizaciones','whatif') . "' />
		<h2>" . __('Localización','whatif') . "</h2>
	</div>
	";
	
	echo "<div id='titextra'><span>".$textoposinega."</span><span>".$textoextra."</span></div>";
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






get_footer();



?>
