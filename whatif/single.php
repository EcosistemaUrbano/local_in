<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage mensajes
 */

 ?>
 
 <?php get_header(); ?>

<?php include ("general-vars.php");?> 

<div id="mensaje" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<div class="vista-selector-mini">
	
	<div class="vista-img-mini">
		<a href="<?php echo $wic ?>/<?php echo $citymin ?>/vistas/localizaciones/"><img alt="<?php _e('Localizaciones','whatif'); ?>" src="<?php echo $template_url ?>/images/vista-localiza-mini.png"></a>
	</div>
	
	<div class="vista-img-mini">
		<a href="<?php echo $wic ?>/<?php echo $citymin ?>/vistas/palabras-clave/"><img alt="<?php _e('Palabras clave','whatif'); ?>" src="<?php echo $template_url ?>/images/vista-tags-mini.png"></a>
	</div>
	
	<div class="vista-img-mini">
		<a href="<?php echo $wic ?>/<?php echo $citymin ?>/vistas/imagenes/"><img alt="<?php _e('Imágenes','whatif'); ?>" src="<?php echo $template_url ?>/images/vista-images-mini.png"></a>
	</div>
	</div>


	<?php include('loop.single.php'); ?>

<?php endwhile; // end of the loop. ?>

	

</div><!-- end id mensaje-->

<?php get_footer(); ?>
