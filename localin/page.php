<?php get_header(); ?>

<div class="tit-peq-page"><h2><?php the_title(); ?></h2></div>

<div class="unique-pages">
	<div class="unique-text bg-n">
	

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	<?php the_content(); ?>

<?php endwhile; // end of the loop. ?>

	
	</div>
</div>

<?php get_footer(); ?>


