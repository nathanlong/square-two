<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package s2
 */

get_header(); ?>

<main id="main" class="site-main" role="main">

  <section class="error-404 not-found">
    <header class="page-header">
      <h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 's2' ); ?></h1>
    </header><!-- .page-header -->

    <div class="page-content">
      <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 's2' ); ?></p>

      <?php get_search_form(); ?>

      <?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

      <?php
        /* translators: %1$s: smiley */
        $archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 's2' ), convert_smilies( ':)' ) ) . '</p>';
        the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
      ?>

      <?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>

    </div><!-- .page-content -->
  </section><!-- .error-404 -->

</main><!-- #main -->

<?php if (s2_display_sidebar()) : ?>
  <?php get_sidebar(); ?>
<?php endif; ?>

<?php get_footer(); ?>
