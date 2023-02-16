<?php
/**
 * Template for schedule filters.
 */

$options = EpicConfSchedule::buildEventTypeFilterOptions();
$schedule_region_id = EpicConfSchedule::getCurrentPageScheduleRegion();
$schedule_region_data = EpicConfSchedule::getAllScheduleRegions();
?>



<!-- Change Region "filter" -->
<div class="event-region-filter dropdown-filter">
  <div class="event-region-filter__trigger dropdown-filter__trigger">
          <span class="event-region-filter__label dropdown-filter__label"><span class="label__text">Change Region</span><span class="caret"></span>
  </div>
  <div class="event-region-filter__dropdown dropdown-filter__dropdown">
    <div class="dropdown-filter__label event-region-filter__checkbox-label">
      <?php foreach ($schedule_region_data as $data) : ?>
        <div>
          <a href="/<?php print $data["slug"] ?>" class="region-filter-text"><?php print $data["location"] ?></a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<!-- Session Type Filter -->
<?php if (!empty($options)) : ?>
  <div class="event-type-filter dropdown-filter">
    <div class="event-type-filter__trigger dropdown-filter__trigger">
      <span class="event-type-filter__label dropdown-filter__label"><span class="label__text">Session Filter</span><span class="caret"></span>
    </div>
    <div class="event-type-filter__dropdown dropdown-filter__dropdown">
      <?php foreach ($options as $option) : ?>
        <?php if ($option->value == 'all') : ?>
          <?php $checked = ' checked'; ?>
        <?php else : ?>
          <?php $checked = ''; ?>
        <?php endif; ?>
        <div class="event-type-filter__input-group">
          <input type="checkbox" value="<?php print $option->value; ?>" name="<?php print $option->name; ?>" id="<?php print $option->name; ?>-checkbox" class="event-type-filter__checkbox"<?php print $checked; ?>>
          <label for="<?php print $option->name; ?>" class="event-type-filter__checkbox-label"><?php print $option->name; ?></label>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
<?php endif; ?>

