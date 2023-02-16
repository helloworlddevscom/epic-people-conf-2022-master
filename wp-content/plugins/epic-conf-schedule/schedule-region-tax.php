<?php
/**
 * Create custom taxonomy Schedule Region.
 */

function schedule_region_init() {
  register_taxonomy(
    'schedule_region',
    'post',
    array(
      'label' => __( 'Schedule Regions' ),
      'rewrite' => array( 'slug' => 'schedule-region' ),
      'show_in_rest' => true,
      'rest_base' => 'schedule-regions',
      'labels' => array(
        'all_items' => __( 'All Schedule Regions' ),
        'edit_item' => __( 'Edit Schedule Region' ),
        'view_item' => __( 'View Schedule Region' ),
        'update_item' => __( 'Update Schedule Region' ),
        'add_new_item' => __( 'Add New Schedule Region' ),
        'new_item_name' => __( 'New Schedule Region Name' ),
      ),
    )
  );
}
add_action( 'init', 'schedule_region_init' );
