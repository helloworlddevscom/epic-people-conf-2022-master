<?php
/*  Custom Post Type for Venue content.
*/

// let's create the function for the custom type
function custom_post_venue() {
  // creating (registering) the custom type
  register_post_type( 'venue', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
    // let's now add all the options for this post type
    array('labels' => array(
      'name' => __('Venues', 'jointswp'), /* This is the Title of the Group */
      'singular_name' => __('Venue', 'jointswp'), /* This is the individual type */
      'all_items' => __('All Venues', 'jointswp'), /* the all items menu item */
      'add_new' => __('Add New', 'jointswp'), /* The add new menu item */
      'add_new_item' => __('Add New Venue', 'jointswp'), /* Add New Display Title */
      'edit' => __( 'Edit', 'jointswp' ), /* Edit Dialog */
      'edit_item' => __('Edit Venue', 'jointswp'), /* Edit Display Title */
      'new_item' => __('New Venue', 'jointswp'), /* New Display Title */
      'view_item' => __('View Venue', 'jointswp'), /* View Display Title */
      'search_items' => __('Search Venues', 'jointswp'), /* Search Custom Type Title */
      'not_found' =>  __('Nothing found in the Database.', 'jointswp'), /* This displays if there are no entries yet */
      'not_found_in_trash' => __('Nothing found in Trash', 'jointswp'), /* This displays if there is nothing in the trash */
      'parent_item_colon' => ''
    ), /* end of arrays */
      'description' => __( 'Venue', 'jointswp' ), /* Custom Type Description */
      'show_in_rest' => true,
      'public' => false,
      'publicly_queryable' => true,
      'exclude_from_search' => true,
      'show_ui' => true,
      'query_var' => true,
      'menu_position' => 4, /* this is what order you want it to appear in on the left hand side menu */
      'menu_icon' => 'dashicons-building', /* the icon for the custom post type menu. uses built-in dashicons (CSS class name) */
      'rewrite'	=> array( 'slug' => 'venues', 'with_front' => false ), /* you can specify its url slug */
      'has_archive' => false, /* you can rename the slug here */
      'capability_type' => 'post',
      'hierarchical' => false,
      /* the next one is important, it tells what's enabled in the post editor */
      'supports' => array( 'title', 'revisions', 'sticky', 'editor' )
    ) /* end of options */
  ); /* end of register post type */

//  flush_rewrite_rules();
}

// adding the function to the Wordpress init
add_action( 'init', 'custom_post_venue');
