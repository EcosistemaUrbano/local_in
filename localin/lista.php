<?php
/*
Template Name: Lista
*/

get_header();

$ref_url = "list";

// GET vars
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

// this page title
if ( have_posts() ) :
	while ( have_posts() ) : the_post();
		include "vistas-list.php";
	endwhile;
else:
endif;
wp_reset_query(); ?>


<div id="dosificador">
<?php // list of messages
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

if ($tagpn!="") {
   $valor = $tagpn;
   $valor_query = $tag2;
	query_posts( "posts_per_page=3&paged=$paged&$valor=$valor_query&cat=$filtro&orderby=meta_value_num&order=DESC" );

} else {
	query_posts( "posts_per_page=3&paged=$paged&$valor=$valor_query&cat=$filtro&orderby=meta_value_num&order=DESC" );

}

$count_posts = wp_count_posts();
$published_posts = $count_posts->publish;

$mess_out = "";
if ( have_posts() ) : ?>
	<div class="navigation navigation-left alignleft"><?php previous_posts_link(__('Previous messages','whatif'),'') ?></div>
	<div id='deslizante'>

	<?php while ( have_posts() ) : the_post();

		$mess_ID = get_the_ID();
		$user_ID = get_current_user_id();
		$mess_author_ID = $post->post_author;

		include "loop.php";
	endwhile;
	echo $mess_out; ?>
	</div><!-- #deslizante -->
	<div class="navigation navigation-right alignright"><?php next_posts_link(__('Next messages','whatif'),'') ?></div>
<?php endif;
wp_reset_query(); ?>
</div><!-- #dosificador -->


<?php // categories filters
include "filters.php";
	
get_footer(); ?>
