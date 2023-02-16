<?php


class EpicConfSchedule {

  /**
   * Configures queries using WP_Query to return Schedule Session posts that are tagged with
   * Schedule Session Type taxonomy and grouped by days. Each day will have it's own query.
   *
   * @param array $filter_args Taxonomy term ids. Schedule Session posts that are not
   * tagged with these term ids will be excluded from the query.
   * @return array An array of WP_Query objects keyed with date for which it will return events.
   */
  public static function eventsQueries(array $filter_args ) {
    // Get value of field Schedule Region for current page.
    $schedule_region_id = self::getCurrentPageScheduleRegion();

    // Get all dates for events.
    $dates = self::getScheduleEventDates($schedule_region_id);

    // Create an array of queries that get events for each date.
    $queries = [];
    foreach ($dates as $date) {

      // Create meta_query to select based on value of schedule_region field.
      if (!empty($schedule_region_id)) {
        $region_meta_query = array(
          'key' => 'schedule_region',
          'value' => $schedule_region_id,
          'compare' => 'LIKE',
          'nopaging' => true,
        );
      }

      // Create meta_query to select based on value of schedule_event_date field.
      $date_meta_query = array(
        'key' => 'schedule_event_date',
        'value' => $date,
        'compare' => 'LIKE',
        'nopaging' => true,
      );

      // Create meta_query to order based on value of schedule_event_time field.
      $time_meta_query = array(
        'key' => 'schedule_event_time',
        'compare' => 'EXISTS',
        'nopaging' => true,
      );

      $meta_queries = array(
        'date_meta_query' => $date_meta_query,
        'time_meta_query' => $time_meta_query,
      );

      if (isset($region_meta_query)) {
        $meta_queries['region_meta_query'] = $region_meta_query;
      }

      // If not all results should be displayed, query only Schedule Session posts
      // tagged with terms in $filter_args via schedule_event_type field.
      // Create meta_query to select based on value of schedule_event_type field.
      if (!in_array('all', $filter_args)) {
        $type_meta_query = array('relation' => 'OR');

        foreach ($filter_args as $filter_arg) {
          $type_meta_query[] = array(
            'key' => 'schedule_event_type',
            'value' => serialize(strval($filter_arg)),
            'compare' => 'LIKE',
            'nopaging' => true,
          );
        }
      }

      if (isset($type_meta_query)) {
        $meta_queries['type_meta_query'] = $type_meta_query;
      }

      $args = array(
        'post_type' => 'schedule_event',
        'nopaging' => true,
        'meta_query' => $meta_queries,
        'orderby' => array(
          'time_meta_query' => 'ASC',
        ),
      );

      $queries[$date] = new WP_Query($args);
    }

    return $queries;
  }

  /**
   * @return array Terms in Schedule Session Type taxonomy.
   */
  public static function getScheduleEventTypeTerms() {
    return get_terms(
      array(
        'taxonomy' => 'schedule_event_type',
        'hide_empty' => 0,
      )
    );
  }

  /**
   * Gets Schedule Region taxonomy term id selected for current Page via Schedule Region field.
   *
   * @return int|null Schedule Region taxonomy term id selected for current Page via Schedule Region field.
   * Returns null if not found.
   */
  public static function getCurrentPageScheduleRegion() {
    global $wpdb;
    global $post;

    $schedule_region_id = null;

    if (!empty($post)) {
      if ($post->post_type == 'page') {
        $page_id = $post->ID;
      }
    }
    // If request was initiated by AJAX, $post is null so we need to get more creative.
    elseif (isset($_SERVER['HTTP_ORIGIN']) && isset($_SERVER['HTTP_REFERER'])) {
      $slug = str_replace($_SERVER['HTTP_ORIGIN'] . '/', '', $_SERVER['HTTP_REFERER']);
      $slug = explode('/?', $slug);
      $slug = rtrim($slug[0], '/');

      if (!empty($slug)) {
        $page_id_results = $wpdb->get_results("SELECT `ID` FROM `wp_posts` WHERE `post_name` = '$slug'", OBJECT);
        if (!empty($page_id_results)) {
          $page_id = $page_id_results[0]->ID;
        }
      }
    }

    if (isset($page_id)) {
      $results = $wpdb->get_results("SELECT `meta_value` FROM `wp_postmeta` WHERE `post_id` LIKE $page_id AND `meta_key` = 'schedule_region'", OBJECT);

      if (!empty($results[0])) {
        $schedule_region_id = $results[0]->meta_value;
      }
    }

    return $schedule_region_id;
  }

  /**
   * Gets all dates on which a Schedule Session post occurs sorted by date.
   *
   * @return array All dates on which a Schedule Session post occurs sorted by date.
   * Each date will be a timestamp string and will need to be formatted for display.
   */
  public static function getScheduleEventDates($schedule_region_id = null) {
    global $wpdb;

    // Because data is not deleted from wp_postmeta table when corresponding Schedule Session post is deleted,
    // we have to do some messy stuff.
    $all_post_ids = $wpdb->get_results("SELECT `post_id` FROM `wp_postmeta` WHERE `meta_key` = 'schedule_event_date'");

    $published_events = array();
    foreach($all_post_ids as $post_id) {
      $post_status = $wpdb->get_results("SELECT `post_status` FROM `wp_posts` WHERE `ID` = " . $post_id->post_id);

      $add_event = false;
      if ($post_status[0]->post_status !== 'inherit' && $post_status[0]->post_status !== 'trash') {
        // Check that post Schedule Region field value matches Schedule Region field value of current page.
        if (!empty($schedule_region_id)) {
          $post_in_region = $wpdb->get_results("SELECT `meta_value` FROM `wp_postmeta` WHERE `post_id` LIKE ". $post_id->post_id . " AND `meta_value` = $schedule_region_id AND `meta_key` = 'schedule_region'");

          if (!empty($post_in_region)) {
            $add_event = true;
          }
        }
        else {
          $add_event = true;
        }
      }

      if ($add_event) {
        array_push($published_events, $post_id->post_id);
      }
    }

    $published_dates = $wpdb->get_results("SELECT DISTINCT `meta_value` FROM `wp_postmeta` WHERE `meta_key` = 'schedule_event_date' AND `post_id` IN ( '" . implode( "', '" , $published_events ) . "' )");

    $dates = array();
    foreach($published_dates as $published_date) {
      array_push($dates, $published_date->meta_value);
    }

    sort($dates);

    return $dates;
  }

  /**
   * Gets all dates on which a Schedule Session post occurs sorted by date and sorted by section.
   * @TODO: Refactor this so the dates are not not hardcoded into sections based on array positions.
   * See ECS-18 for guidance. When we refactor we'll need to actually use the $schedule_region_id param we're
   * not using now, to ensure we're only including dates from the current schedule region.
   *
   * @return array All dates on which a Schedule Session post occurs sorted by date and sorted by section.
   * Each date will be a timestamp string and will need to be formatted for display.
   */
  public static function getScheduleEventSectionDates($schedule_region_id = null, $dates) {
    global $wpdb;

    $all_program_types = $wpdb->get_results("SELECT `term_taxonomy_id` FROM `wp_term_taxonomy` WHERE `taxonomy` = 'schedule_event_program_type'");

    $program_term_list = [];

    foreach ($all_program_types as $programs) {
      $program_terms = $wpdb->get_results("SELECT * FROM `wp_terms` WHERE `term_id` = " . $programs->term_taxonomy_id);
      array_push($program_term_list, $program_terms);
    }

    $section_dates = [
      [
        'section_name' => $program_term_list[0][0]->name,
        'class' => $program_term_list[0][0]->slug,
        'start_date' => $dates[0],
        'end_date' => (int)$schedule_region_id == 14 ? '20221007':'20221006',
        'dates' => []
      ],
      [
        'section_name' => $program_term_list[1][0]->name,
        'class' => $program_term_list[1][0]->slug,
        'start_date' => '20221009',
        'end_date' => $dates[count($dates) -1],
        'dates' => []
      ]
    ];

    // Store dates into $section_dates 'dates' array
    foreach ($dates as $date) {
      if ($date >= $section_dates[0]['start_date'] && $date <= $section_dates[0]['end_date']) {
        array_push($section_dates[0]['dates'], $date);
      } else {
        array_push($section_dates[1]['dates'], $date);
      }
    }

    return $section_dates;
  }

  /**
   * @param string $date Date formatted as Y-m-d for which
   * to retrieve the most recent venue.
   * @return WP_Query.
   */
  public static function getVenueByDate(string $date) {
    $args = array(
      'post_type' => 'venue',
      'posts_per_page' => 1,
      'orderby' => 'date',
      'order'   => 'DESC',
      'meta_query' => array(
        'date_meta_query' => array(
          'key' => 'venue_dates',
          'value' => $date,
          'compare' => 'LIKE',
        ),
      ),
    );

    return new WP_Query($args);
  }

  /**
   * Builds markup for the Schedule page results.
   * Loads template for schedule days, which in turn loads template for schedule events.
   *
   * @param array $filter_args Taxonomy term ids. Schedule Session posts that are not
   * tagged with these term ids will be excluded from the markup.
   */
  public static function buildScheduleMarkup(array $filter_args) {
    // Will return array of queries for each day of events.
    $queries = self::eventsQueries($filter_args);

    // Loop over each query.
    foreach ($queries as $key => $query) {
      // WP apparently doesn't have a good way to pass vars to a template. Wowee.
      set_query_var('schedule_day_query', $query);
      set_query_var('schedule_day_date', $key);
      // Load template for each day of the schedule.
      ccm_get_template_part('template-part-schedule-day');
    }
  }

  /**
   * Gets options for the Event Type filter.
   *
   * @return array Options for Event Type filter.
   */
  public static function buildEventTypeFilterOptions() {
    $terms = self::getScheduleEventTypeTerms();

    // Create "All" option.
    $options = array();
    $all_option = new stdClass();
    $all_option->value = 'all';
    $all_option->name = 'All';
    array_push($options, $all_option);
    foreach ($terms as $term) {
      $option_obj = new stdClass();
      $option_obj->value = $term->term_id;
      $option_obj->name = $term->name;
      array_push($options, $option_obj);
    }

    return $options;
  }

  /**
   * Orders events on the same day at the same start time by the value of field schedule_event_weight.
   * This allows the client to fine tune the order of events.
   *
   * @param WP_Query $schedule_day_query A query for all events on one day.
   * @return WP_Query A WP_Query object for all events on one day, where events that have the same start time are
   * ordered by the value of field schedule_event_weight.
   */
  public static function orderEventsByWeight(WP_Query $schedule_day_query) {
    if (empty($schedule_day_query->posts)) {
      return $schedule_day_query;
    }

    $schedule_event_posts = $schedule_day_query->posts;

    // Group events by start time.
    $schedule_events_by_times = array();
    foreach ($schedule_event_posts as $schedule_event_post) {
      global $wpdb;

      // Get value of schedule_event_weight field and schedule_event_time field.
      $field_values = $wpdb->get_results("SELECT meta_value, meta_key FROM `wp_postmeta` WHERE meta_key = 'schedule_event_weight' AND post_id = " . $schedule_event_post->ID . " OR meta_key = 'schedule_event_time' AND post_id = " . $schedule_event_post->ID);

      foreach ($field_values as $field_value) {
        switch ($field_value->meta_key) {
          case 'schedule_event_time':
            $time = $field_value->meta_value;

            break;

          case 'schedule_event_weight':
            $weight = $field_value->meta_value;

            if (empty($weight)) {
              $weight = 0;
            }
            else {
              $weight = $weight[0]->meta_value;
            }

            break;
        }
      }

      $schedule_event_post->schedule_event_post_weight = $weight;

      if (!array_key_exists($time, $schedule_events_by_times)) {
        $schedule_events_by_times[$time] = array();
      }

      array_push($schedule_events_by_times[$time], $schedule_event_post);
    }

    // Sort events grouped by time by weight.
    foreach ($schedule_events_by_times as $key => $time_group) {
      usort($time_group, function($a, $b) {
        return $a->schedule_event_post_weight > $b->schedule_event_post_weight;
      });

      $schedule_events_by_times[$key] = $time_group;
    }

    $ordered_schedule_event_posts = array();
    foreach ($schedule_events_by_times as $time_group) {
      foreach ($time_group as $schedule_event_post) {
        array_push($ordered_schedule_event_posts, $schedule_event_post);
      }
    }

    $schedule_day_query->posts = $ordered_schedule_event_posts;

    return $schedule_day_query;
  }

  /**
   * Gets all the current schedule region taxonomy terms
   * and related data like timezone, location, slug.
   */
  public static function getAllScheduleRegions() {
    // @TODO: Cache data and retrieve it if cache exists.

    global $wpdb;

    $schedule_region_ids = $wpdb->get_results("SELECT `term_id` FROM `wp_term_taxonomy` WHERE `taxonomy` = 'schedule_region'");

    $region_data = [];

    foreach ($schedule_region_ids as $region_id) {
      $region_id = $region_id->term_id;

      // Get field values.
      $field_values = $wpdb->get_results("SELECT meta_value, meta_key FROM `wp_termmeta` WHERE meta_key = 'schedule_region_timezone_display' AND term_id = " . $region_id . " OR meta_key = 'schedule_region_geographical_location' AND term_id = " . $region_id);
      foreach ($field_values as $field_value) {
        switch ($field_value->meta_key) {
          case 'schedule_region_timezone_display':
            $region_timezone = $field_value->meta_value;

            break;

          case 'schedule_region_geographical_location':
            $region_location = $field_value->meta_value;

            break;
        }
      }

      $region_slug = $wpdb->get_results("SELECT `slug` FROM `wp_terms` WHERE `term_id` = " . $region_id);

      array_push($region_data,
        [
          "region_id" => $region_id,
          "timezone" => $region_timezone,
          "location" => $region_location,
          "slug" => $region_slug[0]->slug
        ]);
    }

    return $region_data;
  }

  /**
   * Gets single schedule region taxonomy term
   * and related data like timezone, location, slug.
   *
   * @param string $schedule_region_id An id of a schedule region taxonomy term.
   * @param boolean $slug Whether to include the slug to the schedule region page in the results.
   */
  public static function getSingleScheduleRegion(string $schedule_region_id, $slug = false) {
    global $wpdb;

    // Get field values.
    $field_values = $wpdb->get_results("SELECT meta_value, meta_key FROM `wp_termmeta` WHERE meta_key = 'schedule_region_timezone_display' AND term_id = " . $schedule_region_id . " OR meta_key = 'schedule_region_geographical_location' AND term_id = " . $schedule_region_id);
    foreach ($field_values as $field_value) {
      switch ($field_value->meta_key) {
        case 'schedule_region_timezone_display':
          $region_timezone = $field_value->meta_value;

          break;

        case 'schedule_region_geographical_location':
          $region_location = $field_value->meta_value;

          break;
      }
    }

    $region_data = [
      "region_id" => $schedule_region_id,
      "timezone" => $region_timezone,
      "location" => $region_location,
    ];

    if ($slug) {
      $region_slug = $wpdb->get_results("SELECT `slug` FROM `wp_terms` WHERE `term_id` = " . $schedule_region_id);
      $region_data['slug'] = $region_slug[0]->slug;
    }

    return $region_data;
  }
}

