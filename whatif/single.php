<?php get_header(); ?>

<div id="mensaje" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<div class="vista-selector-mini">

	<div class="vista-img-mini">
		<a href="/vistas/mensajes/"><img alt="<?php _e('Mensajes','whatif'); ?>" src="<?php echo WHATIF_BLOGTHEME ?>/images/vista-mensajes-mini.png"></a>
	</div>
	
	<div class="vista-img-mini">
		<a href="/vistas/localizaciones/"><img alt="<?php _e('Localizaciones','whatif'); ?>" src="<?php echo WHATIF_BLOGTHEME ?>/images/vista-localiza-mini.png"></a>
	</div>
	
	<div class="vista-img-mini">
		<a href="/vistas/palabras-clave/"><img alt="<?php _e('Palabras clave','whatif'); ?>" src="<?php echo WHATIF_BLOGTHEME ?>/images/vista-tags-mini.png"></a>
	</div>
	
	<div class="vista-img-mini">
		<a href="/vistas/imagenes/"><img alt="<?php _e('Imágenes','whatif'); ?>" src="<?php echo WHATIF_BLOGTHEME ?>/images/vista-images-mini.png"></a>
	</div>
	</div>


	<?php if ( is_attachment() ) {
		if ( array_key_exists('ref', $_GET) ) { $ref = sanitize_text_field($_GET['ref']); } else { $ref = ""; }
		if ( $ref == 'mosaic' ) { $ref_text = " | " .__('Volver al mosaico','whatif'); $ref_out = "<a href='javascript:history.back()'>" .$ref_text. "</a>"; }
		elseif ( $ref == 'list' ) { $ref_text = " | " .__('Volver a la lista','whatif'); $ref_out = "<a href='javascript:history.back()'>" .$ref_text. "</a>"; }
		elseif ( $ref == 'user' ) { $ref_text = " | " .__('Volver a la página del usuario','whatif'); $ref_out = "<a href='javascript:history.back()'>" .$ref_text. "</a>"; }
		else { $ref_out = ""; }
	$parent_tit = get_the_title($post->post_parent);
	$tit = sprintf(__('Imagen del mensaje %s','whatif'), $parent_tit);
	$alt_attachment = get_post_meta( $post->ID, '_wp_attachment_image_alt', true );
	$imageurl = wp_get_attachment_image_src( $post->ID, 'large');
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
	} else { include('loop.single.php'); } ?>

<?php endwhile; // end of the loop. ?>

	

</div><!-- end id mensaje-->

<?php get_footer(); ?>
