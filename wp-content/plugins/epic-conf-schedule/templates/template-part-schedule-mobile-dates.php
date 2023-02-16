<?php
/**
 * Template for mobile date filters.
 */

$schedule_region_id = EpicConfSchedule::getCurrentPageScheduleRegion();
$dates = EpicConfSchedule::getScheduleEventDates($schedule_region_id);
$first_date = reset($dates);
$first_dateTime = DateTime::createFromFormat('Ymd', $first_date);
$first_schedule_date = $first_dateTime->format('l, M. j');
$schedule_sections = EpicConfSchedule::getScheduleEventSectionDates($schedule_region_id, $dates);

?>

<div class="date-filter dropdown-filter">
    <div class="date-filter__trigger dropdown-filter__trigger">
        <span class="date-filter__label dropdown-filter__label"><span class="label__text"><?php print $first_schedule_date; ?></span><span class="caret"></span></span>
    </div>
    <div class="date-filter__dropdown dropdown-filter__dropdown">
        <?php foreach ($schedule_sections as $section) : ?>
            <div class="schedule__dates__program <?php print($section['class']); ?>">
                <h4><?php print($section['section_name']); ?></h4>
                <?php foreach ($section['dates'] as $key => $date) : ?>
                    <?php
                    $dateTime = DateTime::createFromFormat('Ymd', $date);
                    $schedule_date = $dateTime->format('l, M. j');
                    ?>
                    <a id="date-link--<?php print $dateTime->format('m-d-Y'); ?>" class="date-filter__date <?php ($key == 0 ? print 'active' : print ''); ?>" href="#<?php print $dateTime->format('m-d-Y'); ?>">
                        <?php print $schedule_date; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
