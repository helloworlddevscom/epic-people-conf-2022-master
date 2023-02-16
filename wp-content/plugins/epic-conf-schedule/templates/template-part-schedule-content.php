<?php
/**
 * Template for schedule content/results.
 */
?>

<div id="schedule__content" class="schedule__content">
  <?php
  echo EpicConfSchedule::buildScheduleMarkup(array('all'));
  ?>
</div>
