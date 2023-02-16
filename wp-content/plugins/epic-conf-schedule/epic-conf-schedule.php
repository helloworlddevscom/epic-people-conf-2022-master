<?php
/**
 * Plugin Name: EPIC Conference Schedule
 * Description: Creates a filterable schedule page for EPIC Conference.
 * Version: 1.0
 * Author: Ben Teegarden, Hello World.
 */

define( 'EPIC_CONF_SCHEDULE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// Custom post type Schedule Session.
require_once( EPIC_CONF_SCHEDULE_PLUGIN_DIR . 'schedule-event-cpt.php' );
// Custom post type Venue.
require_once( EPIC_CONF_SCHEDULE_PLUGIN_DIR . 'venue-cpt.php' );
// Custom taxonomy Schedule Session Type.
require_once( EPIC_CONF_SCHEDULE_PLUGIN_DIR . 'schedule-event-type-tax.php' );
// Custom taxonomy Schedule Region.
require_once( EPIC_CONF_SCHEDULE_PLUGIN_DIR . 'schedule-region-tax.php' );
// Custom taxonomy Schedule Program.
require_once( EPIC_CONF_SCHEDULE_PLUGIN_DIR . 'schedule-event-program-tax.php' );
// Include ConfSchedule class.
require_once( EPIC_CONF_SCHEDULE_PLUGIN_DIR . 'EpicConfSchedule.php' );


// Enqueue custom JS and AJAX.
function epic_conf_schedule_enqueue_scripts() {
  // @TODO EPIC_CONF_SCHEDULE_PLUGIN_DIR doesn't work here so we have to hardcode the path.
  wp_enqueue_script('epic-conf-schedule', '/wp-content/plugins/epic-conf-schedule/js/epic-conf-schedule.js', array('jquery'));
  wp_localize_script( 'epic-conf-schedule', 'ajax_object',    array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}

// Enqueue custom CSS.
function epic_conf_schedule_enqueue_style() {
  wp_enqueue_style('epic-conf-schedule', '/wp-content/plugins/epic-conf-schedule/css/epic-conf-schedule.css');
}


// Filter AJAX callback.
function schedule_filter() {
  echo EpicConfSchedule::buildScheduleMarkup($_POST['selected_options']);
  wp_die();
}


// Add actions.
add_action('wp_enqueue_scripts', 'epic_conf_schedule_enqueue_scripts');
add_action('wp_enqueue_scripts', 'epic_conf_schedule_enqueue_style', 12);
add_action('wp_ajax_schedule_filter', 'schedule_filter');
add_action('wp_ajax_nopriv_schedule_filter', 'schedule_filter');



// Make the content list edit screen more useful by displaying date and time of each event.
add_filter( 'manage_schedule_event_posts_columns', 'epic_conf_schedule_filter_posts_columns' );
function epic_conf_schedule_filter_posts_columns( $columns ) {
  $columns['event_date'] = __( 'Session Date' );
  $columns['event_time'] = __( 'Session Time' );
  $columns['event_region'] = __( 'Session Region' );
  return $columns;
}


add_action( 'manage_schedule_event_posts_custom_column', 'epic_conf_schedule_column', 10, 2);
function epic_conf_schedule_column( $column, $post_id ) {
  if ( $column == 'event_date' ) {
    $date_timestamp = get_post_meta( $post_id, 'schedule_event_date', true );
    $dateTime = DateTime::createFromFormat("Ymd", $date_timestamp);
    if ($dateTime !== false) {
      echo $dateTime->format('l, M. j');
    }
  }
  else if ( $column == 'event_time' ) {
    $time_start = get_post_meta( $post_id, 'schedule_event_time', true );
    $start_formatted = date('g:i', strtotime($time_start));
    $time_end = get_post_meta( $post_id, 'schedule_event_time_end', true );
    $end_formatted = date('g:i A', strtotime($time_end));
    echo $start_formatted . '-' . $end_formatted;
  }
  else if ( $column == 'event_region' ) {
    $schedule_region = get_post_meta( $post_id, 'schedule_region', true );
    $all_schedule_tags = get_tags(array(
      'taxonomy' => 'schedule_region',
      'orderby' => 'name',
      'hide_empty' => false
    ));

    foreach ($all_schedule_tags as $schedule_tag) {
      if ($schedule_tag->term_id == $schedule_region) {
        echo $schedule_tag->name;
      }
    }
  }
}


add_filter( 'manage_edit-schedule_event_sortable_columns', 'epic_conf_schedule_sortable_columns');
function epic_conf_schedule_sortable_columns( $columns ) {
  $columns['event_date'] = 'schedule_event_date';
  $columns['event_region'] = 'schedule_region';
  return $columns;
}


add_action( 'pre_get_posts', 'epic_conf_schedule_posts_orderby' );
function epic_conf_schedule_posts_orderby( $query ) {
  if ( ! is_admin() || ! $query->is_main_query() ) {
    return;
  }

  if ( 'schedule_event_date' === $query->get( 'orderby') ) {
    $query->set( 'orderby', 'meta_value' );
    $query->set( 'meta_key', 'schedule_event_date' );
    $query->set( 'meta_type', 'date' );
  }

  if ( 'schedule_region' === $query->get( 'orderby') ) {
    $query->set( 'orderby', 'meta_value' );
    $query->set( 'meta_key', 'schedule_region' );
    $query->set( 'meta_type', 'text' );
  }

}



// Functions to allow loading a plugin template from within a theme template.
// Taken from: https://gist.github.com/ashokmhrj/b5f6e28f15dc84601954

/**
 * The below function will help to load template file from plugin directory of wordpress
 * Extracted from : http://wordpress.stackexchange.com/questions/94343/get-template-part-from-plugin
 */
function ccm_get_template_part($slug, $name = null) {
  do_action("ccm_get_template_part_{$slug}", $slug, $name);
  $templates = array();
  if (isset($name))
    $templates[] = "{$slug}-{$name}.php";
  $templates[] = "{$slug}.php";
  ccm_get_template_path($templates, true, false);
}

/* Extend locate_template from WP Core
 * Define a location of your plugin file dir to a constant in this case = EPIC_CONF_SCHEDULE_PLUGIN_DIR
 * Note: EPIC_CONF_SCHEDULE_PLUGIN_DIR - can be any folder/subdirectory within your plugin files
 */
function ccm_get_template_path($template_names, $load = false, $require_once = true ) {
  $located = '';
  foreach ( (array) $template_names as $template_name ) {
    if ( !$template_name )
      continue;
    /* search file within the EPIC_CONF_SCHEDULE_PLUGIN_DIR only */
    if ( file_exists(EPIC_CONF_SCHEDULE_PLUGIN_DIR . '/templates/' . $template_name)) {
      $located = EPIC_CONF_SCHEDULE_PLUGIN_DIR . '/templates/' . $template_name;
      break;
    }
  }
  if ( $load && '' != $located )
    load_template( $located, $require_once );
  return $located;
}
