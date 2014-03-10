<?php
/**
 * Template Name: Entrada formulario
 */

get_header();
include "general-vars.php";


query_posts("post_type=page&post_parent=$post->ID&orderby=menu_order&order=ASC");
if ( have_posts() ) :
	$elige_out = "
	<div id='centro'>
	<div class='unique' style='height: 420px;'>
	";

	while ( have_posts() ) : the_post();

	$valor = $post->post_name;
	$text = get_the_content();
	if ( $valor == 'positivo' ) { $bg = $bg_pl; $align = "mitadl"; }
	elseif ( $valor == 'negativo' ) { $bg = $bg_mn; $align = "mitadr"; }

	$elige_out .= "
	<div class='mitad'>
		<div class='mitad-text $align'>
		<a class='$bg' href='$home/formulario?valor=$valor'>$text</a>
		</div>
	</div>
	";

	endwhile;

	$elige_out .= "
		<div style=' left: -23px;       position: relative;    top: -441px;' class='pasoE'>1/6</div>
	</div>
	</div>
	";


else:
endif;
wp_reset_query();

echo $elige_out;

get_footer(); ?>
