<?php
/**
 * Template for each day within the schedule.
 */

  // Reorder these posts at the last minute based on the value of field schedule_event_weight.
  $schedule_day_query = EpicConfSchedule::orderEventsByWeight(get_query_var('schedule_day_query'));

  $schedule_date = get_query_var('schedule_day_date');
  $dateTime = DateTime::createFromFormat('Ymd', $schedule_date);
  $schedule_date_day = $dateTime->format('l, ');
  $schedule_date_month = $dateTime->format('F j');
?>

<?php if ($schedule_day_query->have_posts()) : ?>
  <a name="<?php print $dateTime->format('m-d-Y'); ?>" class="schedule-date-anchor"></a>
  <div class="schedule-content__day day--<?php print $schedule_date; ?>">
    <div class="day__date-venue">
      <div class="date-venue__inner">
        <div class="date-venue__date">
          <h2 class="date__day"><?php print $schedule_date_day; ?></h2>
          <h2 class="date__month"><?php print $schedule_date_month; ?></h2>
        </div>
        <div class="date-venue__venue">
            <?php $venue_query = EpicConfSchedule::getVenueByDate($dateTime->format('Y-m-d')); ?>
            <?php if ($venue_query->have_posts()) : ?>
                <?php while ($venue_query->have_posts()) : ?>
                    <?php $venue_query->the_post(); ?>
                    <span class="venue__link-label">Venue: </span><a class="venue__link" href="<?php the_field('venue_link'); ?>"><?php the_title(); ?></a>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="day__events">
      <?php while ($schedule_day_query->have_posts()) : ?>
        <?php $schedule_day_query->the_post(); ?>
        <?php
        // WP apparently doesn't have a good way to pass vars to a template. Wowee.
        set_query_var('schedule_event_post', $schedule_day_query);
        // Load template for each event of the day.
        ccm_get_template_part('template-part-schedule-event');
        ?>
      <?php endwhile; ?>
    </div>
  </div>
<?php endif; ?>
