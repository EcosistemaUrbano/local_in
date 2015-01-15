<?php

get_header();

$ref_url = "list";
if ( array_key_exists('filtro', $_GET) ) { $filtro= sanitize_text_field($_GET['filtro']); } else { $filtro = ""; }
if ( array_key_exists('pn', $_GET) ) { $pn = sanitize_text_field( $_GET['pn'] ); } else { $pn = ""; }

include "vistas-list.php";

$mess_out = "";
if ( have_posts() ) : ?>

<div id="dosificador">
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

<?php else:
endif;
wp_reset_query(); ?>
</div><!-- #dosificador -->

<?php get_footer(); ?>
