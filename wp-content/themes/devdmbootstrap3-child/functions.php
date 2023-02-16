<?php

/*
 * Deregister parent theme bootstrap.css. This is because
 * we have changed the .container widths in our child theme bootstrap.css
 * and do not need another version of bootstrap.css interfering.
 */
function devdmbootstrap3_child_remove_scripts() {
  wp_dequeue_style( 'bootstrap.css' );
  wp_deregister_style( 'bootstrap.css' );
}
add_action('wp_enqueue_scripts', 'devdmbootstrap3_child_remove_scripts', 20);

/**
 * Enqueue styles.
 */
function admin_style() {
  // Styling overrides of admin theme.
  wp_enqueue_style('admin-styles', get_stylesheet_directory_uri().'/css/admin-theme.css');
}
add_action('admin_enqueue_scripts', 'admin_style');

/**
 * Enqueue scripts.
 */
function devdmbootstrap3_child_enqueue_scripts() {
  // jQuery.
  wp_enqueue_script('jquery');
  // Global JS.
  wp_enqueue_script('global', get_stylesheet_directory_uri().'/js/global.js');
}
add_action('wp_enqueue_scripts', 'devdmbootstrap3_child_enqueue_scripts');

/**
 * Add hr to TinyMCE WYWSIWYG editor.
 */
function add_editor_buttons($buttons) {
  $buttons[] = 'hr';

  return $buttons;
}
add_filter('mce_buttons', 'add_editor_buttons');

/** 
* Disable comments on media attachments
*/
function filter_media_comment_status( $open, $post_id ) {
    $post = get_post( $post_id );
    if( $post->post_type == 'attachment' ) {
        return false;
    }
    return $open;
}
add_filter( 'comments_open', 'filter_media_comment_status', 10 , 2 );

?>
