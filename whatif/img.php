<?php
/*
Template Name: Imágenes
*/

get_header();

// this page title
if ( have_posts() ) :
	while ( have_posts() ) : the_post();
	include "vistas-list.php";
	endwhile;
else:
endif;
wp_reset_query();


// list of messages
if ( array_key_exists('filtro', $_GET) ) { $filtro = sanitize_text_field( $_GET['filtro'] ); } else { $filtro = ""; }
if ( array_key_exists('pn', $_GET) ) { $pn = sanitize_text_field( $_GET['pn'] ); } else { $pn = ""; }
if ( array_key_exists('pn2', $_GET) ) { $pn2 = sanitize_text_field( $_GET['pn2'] ); } else { $pn2 = ""; }

$valor=$pn;
$valor_query = "";
$valor_terms = get_terms($valor);
$count2 = 0;
foreach ( $valor_terms as $term ) {
$count2++;
if ( $count2 == 1) { $valor_query .= "$term->slug"; }
else { $valor_query .= ",$term->slug"; }
}

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
query_posts( "posts_per_page=45&paged=$paged&$valor=$valor_query&cat=$filtro&key=_wp_attached_file" );

if ( have_posts() ) :
$mess_out = "<div class='unique mosac'>";
while ( have_posts() ) : the_post();
	// the image
	$args = array( 'post_type' => 'attachment', 'numberposts' => 1, 'post_status' => null, 'post_parent' => $post->ID ); 
	$attachments = get_posts($args);
	if ( $attachments ) {
		foreach ( $attachments as $attachment ) {
			//$imagenLink = wp_get_attachment_link($attachment->ID, 'thumbnail',true);
			$image_link = get_attachment_link($attachment->ID). "?ref=mosaic";
			$alt_attachment = get_post_meta( $post->ID, '_wp_attachment_image_alt', true );
			$imageurl = wp_get_attachment_image_src( $attachment->ID, 'thumbnail');
			$mess_out .= "<div class='mosac-img'><a href='" .$image_link. "'><img src='" .$imageurl[0]. "' alt='" .$alt_attachment. "' ></a></div>";
		}
	}
	
endwhile;

$mess_out .= "</div><!-- end class unique mosac -->"; ?>

	<div class="navigation navigation-left alignleft"><?php previous_posts_link(__('Previous message','whatif'),'') ?></div>
	<?php echo $mess_out; ?>
	<div class="navigation navigation-right alignright"><?php next_posts_link(__('Next message','whatif'),'') ?></div>

<?php else:
endif;
wp_reset_query();


	// categories filters
	include "filters.php";

get_footer(); ?>
