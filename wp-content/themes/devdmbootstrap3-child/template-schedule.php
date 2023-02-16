<?php
/*
 * Template Name: Schedule Page
 */
?>
<?php
    get_header();
    $schedule_region_id = EpicConfSchedule::getCurrentPageScheduleRegion();
    $schedule_region_data = EpicConfSchedule::getSingleScheduleRegion($schedule_region_id);
?>

<!-- start content container -->
<div class="page-title page-title--schedule">
    <div class="container container--xl-padding">
        <div class="row">
            <div class="col-md-9">
                <h1 class="page-title__title"><?php the_title(); ?></h1>
                <?php if (!empty($schedule_region_data["timezone"])) : ?>
                    <p class="page-title__timezone">
                        <?php print $schedule_region_data["timezone"] ?>
                    </p>
                <?php endif ?>
                <?php if (!empty($schedule_region_data["location"])) : ?>
                    <p class="page-title__location">
                        <?php print $schedule_region_data["location"] ?>
                    </p>
                <?php endif ?>
            </div>
            <div class="col-md-3 schedule__filters--desktop">
                <?php ccm_get_template_part('template-part-schedule-region-filter'); ?>
                <?php ccm_get_template_part('template-part-schedule-filters'); ?>
            </div>
        </div>
    </div>
</div>
<div class="schedule__header">
        <div class="row">
            <div class="col-md-12">
                <div class="schedule__header__inner">
                  <?php ccm_get_template_part('template-part-schedule-dates'); ?>

                  <form id="schedule__filters" class="schedule__filters schedule__filters--mobile">
                    <div class="schedule__filters__top">
                      <div class="container container--xl-padding">
                        <?php ccm_get_template_part('template-part-schedule-filters'); ?>
                      </div>
                    </div>
                    <div class="schedule__filters__bottom">
                      <div class="container container--xl-padding">
                        <?php ccm_get_template_part('template-part-schedule-mobile-dates'); ?>
                      </div>
                    </div>
                  </form>
                </div>
            </div>
        </div>
</div>

<div class="main-content">
    <div class="main-content__content container">
      <?php ccm_get_template_part('template-part-schedule-content'); ?>
    </div><!--container-->
</div><!--white-background-two-->
<!-- end content container -->

<?php get_footer(); ?>
