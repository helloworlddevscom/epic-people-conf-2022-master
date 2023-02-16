<?php
/**
 * Custom Post Type for Schedule Event/Session content.
 */

function custom_post_schedule_event() {
  register_post_type( 'schedule_event', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
    array('labels' => array(
      'name' => __('Schedule Sessions', 'jointswp'), /* This is the Title of the Group */
      'singular_name' => __('Schedule Session', 'jointswp'), /* This is the individual type */
      'all_items' => __('All Schedule Sessions', 'jointswp'), /* the all items menu item */
      'add_new' => __('Add New', 'jointswp'), /* The add new menu item */
      'add_new_item' => __('Add New Schedule Session', 'jointswp'), /* Add New Display Title */
      'edit' => __( 'Edit', 'jointswp' ), /* Edit Dialog */
      'edit_item' => __('Edit Schedule Session', 'jointswp'), /* Edit Display Title */
      'new_item' => __('New Schedule Session', 'jointswp'), /* New Display Title */
      'view_item' => __('View Schedule Session', 'jointswp'), /* View Display Title */
      'search_items' => __('Search Schedule Sessions', 'jointswp'), /* Search Custom Type Title */
      'not_found' =>  __('Nothing found in the Database.', 'jointswp'), /* This displays if there are no entries yet */
      'not_found_in_trash' => __('Nothing found in Trash', 'jointswp'), /* This displays if there is nothing in the trash */
      'parent_item_colon' => ''
    ), /* end of arrays */
      'description' => __( 'Schedule Session', 'jointswp' ), /* Custom Type Description */
      'show_in_rest' => true,
      'public' => false,
      'publicly_queryable' => true,
      'exclude_from_search' => true,
      'show_ui' => true,
      'query_var' => true,
      'menu_position' => 4, /* this is what order you want it to appear in on the left hand side menu */
      'menu_icon' => 'dashicons-calendar', /* the icon for the custom post type menu. uses built-in dashicons (CSS class name) */
      'rewrite'	=> array( 'slug' => 'schedule-events', 'with_front' => false ), /* you can specify its url slug */
      'has_archive' => false, /* you can rename the slug here */
      'capability_type' => 'post',
      'hierarchical' => false,
      /* the next one is important, it tells what's enabled in the post editor */
      'supports' => array( 'title', 'revisions', 'sticky', 'editor' )
    )
  );

//  flush_rewrite_rules();
}

add_action( 'init', 'custom_post_schedule_event');
