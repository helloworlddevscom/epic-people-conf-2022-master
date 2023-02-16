<?php
/*
 * Template Name: Basic Content Page
 */
?>
<?php get_header(); ?>

<!-- start content container -->
<div class="page-title">
    <div class="container container--xl-padding">
        <h1 class="page-title__title"><?php the_title(); ?></h1>
    </div>
</div>

<div class="main-content">
    <div class="main-content__content container container--xl-padding">
        <div class="row">
            <div class="col-md-12">
                <div class="content__page-content">

                  <?php // theloop
                  if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php the_content(); ?>
                    <?php wp_link_pages(); ?>
                    <?php comments_template(); ?>

                  <?php endwhile; ?>
                  <?php else: ?>

                    <?php get_404_template(); ?>

                  <?php endif; ?>
                </div>
            </div><!--col-->
        </div>
    </div>
</div>

<?php get_footer(); ?>
