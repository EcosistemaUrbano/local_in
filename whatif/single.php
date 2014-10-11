<?php get_header();

// the referrer:
if ( array_key_exists('ref', $_GET) ) { $ref = sanitize_text_field($_GET['ref']); } else { $ref = ""; }
if ( array_key_exists('vista', $_GET) ) { $view = sanitize_text_field($_GET['vista']); } else { $view = ""; } ?>

<div id="mensaje" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post();

	include "vistas-list.php";
?>



	<?php // if is image single page
	if ( is_attachment() ) {
		if ( $ref == 'mosaic' ) { $ref_text = " | " .__('Volver al mosaico','whatif'); $ref_out = "<a href='javascript:history.back()'>" .$ref_text. "</a>"; }
		elseif ( $ref == 'list' ) { $ref_text = " | " .__('Volver a la lista','whatif'); $ref_out = "<a href='javascript:history.back()'>" .$ref_text. "</a>"; }
		elseif ( $ref == 'map' ) { $ref_text = " | " .__('Volver al mapa','whatif'); $ref_out = "<a href='javascript:history.back()'>" .$ref_text. "</a>"; }
		elseif ( $ref == 'user' ) { $ref_text = " | " .__('Volver a la página del usuario','whatif'); $ref_out = "<a href='javascript:history.back()'>" .$ref_text. "</a>"; }
		else { $ref_out = ""; }
	$parent_tit = get_the_title($post->post_parent);
	$tit = sprintf(__('Imagen del mensaje %s','whatif'), $parent_tit);
	$alt_attachment = get_post_meta( $post->ID, '_wp_attachment_image_alt', true );
	$imageurl = wp_get_attachment_image_src( $post->ID, 'medium');
	$imageurlfull = wp_get_attachment_image_src( $post->ID, 'full');
	echo "
  	<div class='tit-peq'>
		<h2>" .$tit. "</h2>
		<div class='subtit'>
			<a href='".get_permalink($post->post_parent). "' title='".__('Ver el mensaje','whatif'). " " .get_the_title($post->post_parent)."'>
			". __("Ver el mensaje","whatif"). "
			</a>" . $ref_out. "
		</div>
	</div>

	<div class='unique lista'>
		<a href='" .$imageurlfull[0]. "'><img src='" .$imageurl[0]. "' alt='" .$alt_attachment. "' ></a>
	</div>
	";
	} elseif ( $ref == 'form' && is_user_logged_in() ) {
		$tit = get_the_title();
		echo "
	  	<div class='tit-peq'>
			<h2>" .$tit. "</h2>
		</div>
		";

		include('loop.single.php');
		$author_name = get_the_author_meta('user_login',$user_ID);
		echo "
		<div class='form-published'>
			" .sprintf(__('Éste es el mensaje que has publicado. Gracias por participar %s.','whatif'),$author_name). "
		</div>
		";

	} elseif ( $view == 'map' ) {
	// localize this single message in the map
		$tit = get_the_title();

		echo "
	  	<div class='tit-peq'>
			<h2>" .$tit. "</h2>
			<div class='subtit'>
				<a href='".get_permalink(). "' title='".__('Ver el mensaje','whatif'). " " .get_the_title()."'>
				". __("Ver el mensaje","whatif"). "
				</a>
			</div>
		</div>

		<div class='unique-pages-tit map'>
			<div id='map' align='center' style='width: 800px; height: 470px'></div> 
		</div><!-- end class unique mosac -->
		";

	} else {
		$tit = get_the_title();

		echo "
	  	<div class='tit-peq'>
			<h2>" .$tit. "</h2>
		</div>
		";
		include('loop.single.php');
	} ?>

<?php endwhile; // end of the loop. ?>

	

</div><!-- end id mensaje-->

<?php get_footer(); ?>
