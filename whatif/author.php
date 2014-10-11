<?php
get_header();

$ref_url = "user";

// FILTERS
if ( array_key_exists('tagpn', $_GET) ) { $tagpn = sanitize_text_field( $_GET['tagpn'] ); } else { $tagpn = ""; }
if ( array_key_exists('tag2', $_GET) ) { $tag2 = sanitize_text_field( $_GET['tag2'] ); } else { $tag2 = ""; }

if ( array_key_exists('filtro', $_GET) ) { $filtro = sanitize_text_field( $_GET['filtro'] ); } else { $filtro = ""; }
if ( array_key_exists('pn', $_GET) ) { $pn = sanitize_text_field( $_GET['pn'] ); } else { $pn = ""; }

$valor=$pn;
$valor_query = "";
$valor_terms = get_terms($valor);
$count2 = 0;
foreach ( $valor_terms as $term ) {
	$count2++;
	if ( $count2 == 1) { $valor_query .= "$term->slug"; }
	else { $valor_query .= ",$term->slug"; }
}

if ($tagpn!="") {
   $valor = $tagpn;
   $valor_query = $tag2;
}
// END FILTERS

include "vistas-list.php";
?>

	<div id='dosificador'>
<div class="navigation navigation-left alignleft"><?php previous_posts_link(__('Entradas anteriores','whatif'),'') ?></div>
	<div id='deslizante'>
<?php
$mess_out = "";
if ( have_posts() ) {

	while ( have_posts() ) : the_post();

		$mess_ID = get_the_ID();
		$user_ID = get_current_user_id();
		$mess_author_ID = $post->post_author;

		include "loop.php";

	endwhile;

	echo $mess_out; ?>
</div>
<div class="navigation navigation-right alignright"><?php next_posts_link(__('Entradas posteriores','whatif'),'') ?></div>
</div>

<?php } else { echo __('Este usuario no ha publicado nada aún.','whatif'); }

get_footer(); ?>
