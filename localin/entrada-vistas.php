<?php
/**
 * Template Name: Entrada vistas
 */

get_header();

if ( have_posts() ) :
while ( have_posts() ) : the_post();

	// vistas list (subpages)
	$args = array(
		'post_type' => 'page',
		'post_parent' => $post->ID,
		'order_by' => 'menu_order',
		'order' => 'ASC'
	);
	$children = get_posts($args);
		$elige_out = "
		<div class='unique-pages-tit'>
		<div class='vista-selector'>
	";
	
	foreach ( $children as $child ) {
		$pag_child_link = get_permalink($child->ID);
		$pag_child_tit = get_the_title($child->ID);
		if ( has_post_thumbnail($child->ID) ) { $pag_child_img = get_the_post_thumbnail( $child->ID, "thumbnail"); }
		else { $pag_child_img = "<img src='" .WHATIF_BLOGTHEME. "/images/default-vista.png' alt='" .$pag_child_tit. "' />"; }
		$elige_out .= "
		<div class='vista-img'>
			<a href='$pag_child_link'>$pag_child_img</a>
			<div class='vista-tit'>$pag_child_tit</div>
		</div>
		";
	}
	$elige_out .= "
		</div><!-- end class vista-selector -->
		</div><!-- end class class unique -->
	";
?>


	<div class='tit'>
		<h2><?php the_title(); ?></h2>
	</div>
	
	<?php echo $elige_out;

	endwhile;
else:
endif;

get_footer(); ?>
