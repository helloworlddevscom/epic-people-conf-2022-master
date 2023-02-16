<?php
/*
 * Template Name: Content-Right-Rail
 */
?>
<?php get_header(); ?>

<!-- start content container -->
<div class="page-title <?php print $pagename;?>">
    <div class="container container--xl-padding">
        <h1 class="page-title__title"><?php the_title(); ?></h1>
    </div>
</div>

<div class="main-content">
    <div class="main-content__content container container--xl-padding <?php if (get_field('blue_box_right') != null) { echo 'layout--right-sidebar'; } ?>">
        <div class="row">

          <?php
          if (get_field('blue_box_right') != null) {
            echo '<div class="col-sm-12 col-md-8"><div class="content__page-content">';
          }
          else {
            echo '<div class="col-sm-12"><div class="content__page-content">';
          }
          ?>

          <?php // theloop
          if (have_posts()) : while (have_posts()) : the_post(); ?>


            <?php the_content(); ?>
            <?php wp_link_pages(); ?>
            <?php comments_template(); ?>

          <?php endwhile; ?>
          <?php else: ?>

            <?php get_404_template(); ?>

          <?php endif; ?>

          <?php
          if (get_field('blue_box_right') != null) {
            echo '</div></div><div class="col-md-4 hidden-sm hidden-xs"><div class="content__page-sidebar">';
            the_field('blue_box_right');
            echo '</div></div>';
          }
          else {
              echo '</div>';
          }
          ?>

        </div>
    </div>
</div>

<?php get_footer(); ?>
