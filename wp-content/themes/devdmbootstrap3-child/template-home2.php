<?php
/*
 * Template Name: Home - Basic
 */
?>
<?php get_header(); ?>


<!-- big background image -->

<div class="container--fluid home-banner">
    <img src="/wp-content/themes/devdmbootstrap3-child/img/HeroTitle.png"  alt="Scale" class = "hero">
</div>

<!-- start content container -->
<div class="main-content">
    <div class="container main-content__content">
        <div class="row">

            <!-- start desktop -->
            <div class="home-show-desktop">
                <div class="home-show-desktop__sidebar">
                    <div class="home__section dates background--white">
                      <?php the_field('sidebar_left_1'); ?>
                    </div>
                    <div class="home__section quote background--creme">
                      <?php the_field('sidebar_left_quote'); ?>
                    </div>
                    <div class="home__section venue background--white">
                      <?php the_field('sidebar_left_2'); ?>
                    </div>
                    <div class="home__section resources background--white">
                      <?php the_field('sidebar_left_3'); ?>
                    </div>
                </div>

                <div class="home-show-desktop__main-content home__main-content background--white">
                    <div class="home__intro">
                      <?php the_field('leading_text_top'); ?>
                        <hr>
                    </div>

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
              <?php get_sidebar('left'); ?>
            </div>
            <!--end desktop-->

            <!-- start tablet -->
            <div class="home-show-tablet">
                <div class="home__section dates background--white">
                  <?php the_field('sidebar_left_1'); ?>
                </div>
                <div class="home__section quote background--creme">
                  <?php the_field('sidebar_left_quote'); ?>
                </div>
                <div class="home-show-tablet__main-content home__main-content background--white">
                    <div class="home__intro">
                      <?php the_field('leading_text_top'); ?>
                        <hr>
                    </div>

                  <?php // theloop
                  if (have_posts()) : while (have_posts()) : the_post(); ?>

                    <?php the_content(); ?>
                    <?php wp_link_pages(); ?>
                    <?php comments_template(); ?>

                  <?php endwhile; ?>
                  <?php else: ?>

                    <?php get_404_template(); ?>

                  <?php endif; ?>

                    <hr>
                </div>
                <div class="home__section venue background--white">
                  <?php the_field('sidebar_left_2'); ?>
                </div>
                <div class="home__section resources background--white">
                  <?php the_field('sidebar_left_3'); ?>
                </div>
              <?php get_sidebar('left'); ?>
            </div>
            <!--end tablet-->

            <!-- start phone -->
            <div class="home-show-phone">
                <div class="home__intro home__section background--white">
                  <?php the_field('leading_text_top'); ?>
                    <hr>
                </div>
                <div class="home__section dates background--white">
                  <?php the_field('sidebar_left_1'); ?>
                </div>
                <div class="home__section quote background--creme">
                  <?php the_field('sidebar_left_quote'); ?>
                </div>
                <div class="home-show-phone__main-content home__main-content background--white">
                  <?php // theloop
                  if (have_posts()) : while (have_posts()) : the_post(); ?>

                    <?php the_content(); ?>
                    <?php wp_link_pages(); ?>
                    <?php comments_template(); ?>

                  <?php endwhile; ?>
                  <?php else: ?>

                    <?php get_404_template(); ?>

                  <?php endif; ?>
                    <hr>
                </div>
                <div class="home__section venue background--white">
                  <?php the_field('sidebar_left_2'); ?>
                </div>
                <div class="home__section resources background--white">
                  <?php the_field('sidebar_left_3'); ?>
                </div>
              <?php get_sidebar('left'); ?>
            </div>
            <!--end phone-->
        </div>
    </div><!--container-->
</div>

<!-- end content container -->

<?php get_footer(); ?>




