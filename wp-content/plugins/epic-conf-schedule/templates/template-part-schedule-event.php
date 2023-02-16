<?php
/**
 * Template for each event (Schedule Event post) within a day.
 */

  $post_query = get_query_var('schedule_event_post');

  $image = get_field('schedule_event_image');

  $title_display = get_field('schedule_event_title_display');

  $title_link = get_field('schedule_event_title_link');
?>

<div class="event">
    <div class="event__time">
        <?php the_field('schedule_event_time'); ?>-<?php the_field('schedule_event_time_end'); ?>
    </div>
    <div class="event__description">
        <?php if ($image): ?>
            <div class="event__image"><?php print wp_get_attachment_image(get_field('schedule_event_image'), 'large'); ?></div>
        <?php endif; ?>
        <?php if (!empty(the_title('','', false))): ?>
            <h4 class="event__title title-display--<?php print $title_display; ?>">
                <?php if (!empty($title_link)): ?>
                    <a href="<?php print $title_link; ?>" target="blank" rel="noopener noreferrer">
                        <?php the_title(); ?>
                    </a>
                <?php else: ?>
                    <?php the_title(); ?>
                <?php endif;  ?>
            </h4>
        <?php endif; ?>
        <div class="event__content"><?php the_content(); ?></div>
    </div>
</div>
