<?php
/**
 * Create custom taxonomy Schedule Event/Session Type.
 */

function schedule_event_type_init() {
  register_taxonomy(
    'schedule_event_type',
    'post',
    array(
      'label' => __( 'Schedule Session Types' ),
      'rewrite' => array( 'slug' => 'schedule-event-type' ),
      'show_in_rest' => true,
      'rest_base' => 'schedule-event-types',
      'labels' => array(
        'all_items' => __( 'All Schedule Session Types' ),
        'edit_item' => __( 'Edit Schedule Session Type' ),
        'view_item' => __( 'View Schedule Session Type' ),
        'update_item' => __( 'Update Schedule Session Type' ),
        'add_new_item' => __( 'Add New Schedule Session Type' ),
        'new_item_name' => __( 'New Schedule Session Type Name' ),
      ),
    )
  );
}
add_action( 'init', 'schedule_event_type_init' );
