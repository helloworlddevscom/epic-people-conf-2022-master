<?php
/*
 * Template Name: Content-Right-Theme
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
    <div class="main-content__content container container--xl-padding <?php if (get_field('blue_box_right') != null) { echo 'layout--right-sidebar'; } ?>">
        <div class="row">
            <div class="pangaea">
                <h1 class="pangaea-heading"><a href="#pangaea">Pangaea</a></h1>
                <div class="main-images">
                    <div class="img">
                        <a href="/wodonga">
                        <img src="/wp-content/themes/devdmbootstrap3-child/img/Wodonga.png" alt="Wodonga"/>
                        <h1>Wodonga</h1></a>
                    </div>
                    <div class="img">
                        <a href="/geelong">
                        <img src="/wp-content/themes/devdmbootstrap3-child/img/Geelong.png" alt="Geelong" />
                        <h1>Geelong</h1></a>
                    </div>
                    <div class="img">
                        <a href="/parkes">
                        <img src="/wp-content/themes/devdmbootstrap3-child/img/Parkes.png" alt="Parkes" />
                            <h1>Parkes</h1></a>
                    </div>
                </div>
            </div>
            <?php
            if (get_field('background_image') != null) {
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
            if (get_field('background_image') != null) {
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
