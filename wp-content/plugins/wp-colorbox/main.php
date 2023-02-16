<?php
/*
Plugin Name: WP Colorbox
Version: 1.1.2
Plugin URI: https://noorsplugin.com/wordpress-colorbox-plugin/
Author: naa986
Author URI: https://noorsplugin.com/
Description: Colorbox Lightbox to pop up media files from your WordPress site
Text Domain: wp-colorbox
Domain Path: /languages
*/

if(!defined('ABSPATH')) exit;
if(!class_exists('WP_COLORBOX'))
{
    class WP_COLORBOX
    {
        var $plugin_version = '1.1.2';
        var $plugin_url;
        var $plugin_path;
        function __construct()
        {
            define('WP_COLORBOX_VERSION', $this->plugin_version);
            define('WP_COLORBOX_SITE_URL',site_url());
            define('WP_COLORBOX_URL', $this->plugin_url());
            define('WP_COLORBOX_PATH', $this->plugin_path());
            define('WP_COLORBOX_LIBRARY_VERSION', '1.6.4');
            $this->plugin_includes();
            add_action( 'wp_enqueue_scripts', array( &$this, 'plugin_scripts' ), 0 );
        }
        function plugin_includes()
        {
            if(is_admin( ) )
            {
                add_filter('plugin_action_links', array($this,'add_plugin_action_links'), 10, 2 );
            }
            add_action('plugins_loaded', array($this, 'plugins_loaded_handler'));
            add_action('admin_menu', array($this, 'add_options_menu' ));
            add_shortcode('wp_colorbox_media','wp_colorbox_media_handler');
            //allows shortcode execution in the widget, excerpt and content
            add_filter('widget_text', 'do_shortcode');
            add_filter('the_excerpt', 'do_shortcode', 11);
            add_filter('the_content', 'do_shortcode', 11);
        }
        function plugin_scripts()
        {
            if (!is_admin()) 
            {
                wp_enqueue_script('jquery');
                wp_register_script('colorbox', WP_COLORBOX_URL.'/jquery.colorbox-min.js', array('jquery'), WP_COLORBOX_VERSION);
                wp_enqueue_script('colorbox');
                wp_register_script('wp-colorbox', WP_COLORBOX_URL.'/wp-colorbox.js', array('colorbox'), WP_COLORBOX_VERSION);
                wp_enqueue_script('wp-colorbox');
                wp_register_style('colorbox', WP_COLORBOX_URL.'/example5/colorbox.css');
                wp_enqueue_style('colorbox');
            }
        }
        function plugin_url()
        {
            if($this->plugin_url) return $this->plugin_url;
            return $this->plugin_url = plugins_url( basename( plugin_dir_path(__FILE__) ), basename( __FILE__ ) );
        }
        function plugin_path(){ 	
            if ( $this->plugin_path ) return $this->plugin_path;		
            return $this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );
        }
        function add_plugin_action_links($links, $file)
        {
            if ( $file == plugin_basename( dirname( __FILE__ ) . '/main.php' ) )
            {
                $links[] = '<a href="options-general.php?page=wp-colorbox-settings">'.__('Settings', 'wp-colorbox').'</a>';
            }
            return $links;
        }
        
        function plugins_loaded_handler()
        {
            load_plugin_textdomain('wp-colorbox', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/'); 
        }

        function add_options_menu()
        {
            if(is_admin())
            {
                add_options_page(__('WP Colorbox', 'wp-colorbox'), __('WP Colorbox', 'wp-colorbox'), 'manage_options', 'wp-colorbox-settings', array(&$this, 'display_options_page'));
            }
        }
        
        function display_options_page()
        {           
            $url = "https://noorsplugin.com/wordpress-colorbox-plugin/";
            $link_text = sprintf(wp_kses(__('Please visit the <a target="_blank" href="%s">WP Colorbox</a> documentation page for usage instructions.', 'wp-colorbox'), array('a' => array('href' => array(), 'target' => array()))), esc_url($url));          
            echo '<div class="wrap">';               
            echo '<h2>WP Colorbox - v'.$this->plugin_version.'</h2>';
            echo '<div class="update-nag">'.$link_text.'</div>';
            echo '</div>';   
        }
    }
    $GLOBALS['wp_colorbox'] = new WP_COLORBOX();
}

function wp_colorbox_media_handler($atts)
{
    extract(shortcode_atts(array(
        'url' => '',
        'title' => '',
        'type' => '',
        'hyperlink' => 'Click Here',
        'alt' => '',
        'class' => '',
    ), $atts));
    if(empty($url)){
        return __('Please specify the URL of your media file that you wish to pop up in lightbox', 'wp-colorbox');
    }
    if(empty($type)){
        return __('Please specify the type of media file you wish to pop up in lightbox', 'wp-colorbox');
    }
    if (strpos($hyperlink, 'http') !== false)
    {
        if(isset($alt) && !empty($alt)){
            $alt = ' alt="'.$alt.'"';
        }
        $hyperlink = '<img src="'.$hyperlink.'"'.$alt.'>';
    }
    $popup_class = "";
    if($type=="image"){
        $popup_class = "wp-colorbox-image";
    }
    if($type=="youtube"){
        $popup_class = "wp-colorbox-youtube";
    }
    if($type=="vimeo"){
        $popup_class = "wp-colorbox-vimeo";
    }
    if($type=="iframe"){
        $popup_class = "wp-colorbox-iframe";
    }
    if($type=="inline"){
        $popup_class = "wp-colorbox-inline";
    }
    //
    if(!empty($class)){
        $class = $popup_class." ".$class;
    }
    else{
        $class = $popup_class;
    }
    //
    if(!empty($title)){
        $title = ' title="'.$title.'"';
    }
    $output = <<<EOT
    <a class="$class" href="$url"{$title}>$hyperlink</a>
EOT;
    return $output;
}
