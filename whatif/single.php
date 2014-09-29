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


	<?php include('loop.single.php'); ?>

<?php endwhile; // end of the loop. ?>

	

</div><!-- end id mensaje-->

<?php get_footer(); ?>
