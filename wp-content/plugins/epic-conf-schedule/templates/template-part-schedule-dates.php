<?php
/**
 * Template for schedule date links.
 */

  $schedule_region_id = EpicConfSchedule::getCurrentPageScheduleRegion();
  $dates = EpicConfSchedule::getScheduleEventDates($schedule_region_id);
  $schedule_sections = EpicConfSchedule::getScheduleEventSectionDates($schedule_region_id, $dates);

?>

<?php if (!empty($dates)) : ?>
  <div class="schedule__dates">
      <?php foreach ($schedule_sections as $section) : ?>
          <div class="schedule__dates__program <?php print($section['class']); ?>">
              <div class="container container--xl-padding">
                  <h4><?php print($section['section_name']); ?></h4>
                  <?php foreach ($section['dates'] as $key => $date) : ?>
                      <?php
                      $dateTime = DateTime::createFromFormat("Ymd", $date);
                      $schedule_date = $dateTime->format('F j');
                      ?>
                      <a id="date-link--<?php print $dateTime->format('m-d-Y'); ?>" class="dates__date <?php (count($section['dates']) > 4 ? print 'dates__date_shrink' : print ''); ?> <?php ($key == 0 ? print 'active' : print ''); ?>" href="#<?php print $dateTime->format('m-d-Y'); ?>">
                          <?php print $schedule_date; ?>
                      </a>
                  <?php endforeach; ?>
              </div>
          </div>
      <?php endforeach; ?>
  </div>
<?php endif; ?>
