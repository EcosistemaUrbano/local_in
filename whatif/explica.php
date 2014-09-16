<?php
/*
Template Name: Presentación
*/

get_header();

$atras = WHATIF_BLOGURL;
if ( is_page("presentacion-consulta") ) { $alante = WHATIF_BLOGURL.'/vistas'; $bg = WHATIF_STYLE_VIEW_BG; }
elseif ( is_page("presentacion-participa") ) { $alante = WHATIF_BLOGURL.'/entrada-formulario'; $bg = WHATIF_STYLE_FORM_BG; }

$presenta_out_1 = "

	<div class='control' id='controll'>
		<a href='$atras'>" . __('Atrás','whatif') . "</a>
	</div>

	<div class='unique'>
	<div class='unique-text $bg'>
";
echo $presenta_out_1;

if ( have_posts() ) :
	while ( have_posts() ) : the_post();
	the_content();
	endwhile;
else:
endif;
wp_reset_query();

$presenta_out_2 = "

	</div>
	</div>

	<div class='control' id='controlr'>
		<a href='$alante'>" . __('Adelante','whatif') . "</a>
	</div>
";

echo $presenta_out_2;

get_footer(); ?>
