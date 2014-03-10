<?php get_header(); ?>

  <?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ?>
  <div id="container">
    <div id="content" role="main">

      <h1 class="page-title"><?php echo $term->name; _e('Archivos','whatif'); ?></h1>

      <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>

          <div class="post type-post hentry">
            <h2 class="entry-title">
              <a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark">
                <?php the_title(); ?>
              </a>
            </h2>

            <div class="entry-meta">
              <span class="meta-prep meta-prep-author"><?php _e('Publicado a las','whatif'); ?></span>
              <a href="<?php echo get_permalink(); ?>" title="<?php the_time( 'g:i a' ); ?>" rel="bookmark">
              <span class="entry-date"><?php the_time( 'F j, Y' ); ?></span></a>
            </div><!-- .entry-meta -->

            <div class="entry-summary">
              <?php the_excerpt(); ?>
            </div><!-- .entry-summary -->
          </div>

        <?php endwhile; ?>
      <?php endif; ?>

    </div><!-- #content -->
  </div><!-- #container -->

  <?php get_sidebar(); ?>
<?php get_footer(); ?>
