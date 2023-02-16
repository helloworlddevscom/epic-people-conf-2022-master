<?php
/**
 * Create custom taxonomy Schedule Event Program Type.
 */

function schedule_event_program_type_init() {
    register_taxonomy(
        'schedule_event_program_type',
        'post',
        array(
            'label' => __( 'Schedule Program Types' ),
            'rewrite' => array( 'slug' => 'schedule-event-program-type' ),
            'show_in_rest' => true,
            'rest_base' => 'schedule-event-program-types',
            'labels' => array(
                'all_items' => __( 'All Schedule Program Types' ),
                'edit_item' => __( 'Edit Schedule Program Type' ),
                'view_item' => __( 'View Schedule Program Type' ),
                'update_item' => __( 'Update Schedule Program Type' ),
                'add_new_item' => __( 'Add New Schedule Program Type' ),
                'new_item_name' => __( 'New Schedule Program Type Name' ),
            ),
        )
    );
}
add_action( 'init', 'schedule_event_program_type_init' );
