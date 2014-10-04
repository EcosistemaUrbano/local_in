<?php
/**
 * Template Name: Entrada formulario
 */

get_header();


query_posts("post_type=page&post_parent=$post->ID&orderby=menu_order&order=ASC");
if ( have_posts() ) :
	$elige_out = "
		<div id='paso16' class='paso'>1/6</div>
	<div class='unique-pages' style='margin-top: 60px;'>
	";

	while ( have_posts() ) : the_post();

	$valor = $post->post_name;
	$text = get_the_content();
	if ( $valor == 'positivo' ) { $bg = WHATIF_STYLE_POSITIVE_BG; $align = "mitadl"; }
	elseif ( $valor == 'negativo' ) { $bg = WHATIF_STYLE_NEGATIVE_BG; $align = "mitadr"; }

	$elige_out .= "
	<div class='mitad'>
		<div class='mitad-text $align'>
		<a class='$bg' href='" .WHATIF_BLOGURL. "/formulario?valor=$valor'>$text</a>
		</div>
	</div>
	";

	endwhile;

	$elige_out .= "
	</div>
	";


else:
endif;
wp_reset_query();

echo $elige_out;

get_footer(); ?>
