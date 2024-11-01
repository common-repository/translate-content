<?php

/*
  Plugin Name: Translate content
  Plugin URI: http://www.devtech.cz/
  Description: Help users to use google translate APIs for translate content, in basic version uses to translate Javscript API, Google Widget or metabox in post/page edit for server side translation, what is better for your seo.
  Version: 1.0.1
  Author: Juraj Puchký
  Author URI: http://www.devtech.cz/
 */


if (!isset($TRANSLATECONTENT_locale))
    $TRANSLATECONTENT_locale = '';

// Pre-2.6 compatibility
if (!defined('WP_CONTENT_URL'))
    define('WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
if (!defined('WP_PLUGIN_URL'))
    define('WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins');

$TRANSLATECONTENT_plugin_basename = plugin_basename(dirname(__FILE__));


if (basename(dirname(__FILE__)) == "mu-plugins") {
    $TRANSLATECONTENT_plugin_url_path = WPMU_PLUGIN_URL . '/translate-content';
    $TRANSLATECONTENT_plugin_dir = WPMU_PLUGIN_DIR . '/translate-content';
} else {
    $TRANSLATECONTENT_plugin_url_path = WP_PLUGIN_URL . '/' . $TRANSLATECONTENT_plugin_basename;
    $TRANSLATECONTENT_plugin_dir = WP_PLUGIN_DIR . '/' . $TRANSLATECONTENT_plugin_basename;
}

load_plugin_textdomain('translate-content', false, $TRANSLATECONTENT_plugin_basename . '/languages');

// Fix SSL
if (is_ssl())
    $TRANSLATECONTENT_plugin_url_path = str_replace('http:', 'https:', $TRANSLATECONTENT_plugin_url_path);

function TRANSLATECONTENT_widget_init() {
    global $TRANSLATECONTENT_plugin_dir;

    include_once($TRANSLATECONTENT_plugin_dir . '/include/translate-contentWidget.php');
    register_widget('TRANSLATECONTENT_Widget');
}

function TRANSLATECONTENT_metabox_init() {
    global $TRANSLATECONTENT_plugin_dir;

    include_once($TRANSLATECONTENT_plugin_dir . '/include/translate-contentSimpleMetabox.php');
    add_action('add_meta_boxes', 'TRANSLATECONTENTSimpleMetabox_addMetabox');
    add_action('save_post', 'TRANSLATECONTENTSimpleMetabox_savePostdata');   
}

function TRANSLATECONTENT_dashboard() {
    global $TRANSLATECONTENT_plugin_dir;

    require_once($TRANSLATECONTENT_plugin_dir . '/include/admin-ui/dashboard.php');
}

function TRANSLATECONTENT_simple_translate() {
    global $TRANSLATECONTENT_plugin_dir;

    require_once($TRANSLATECONTENT_plugin_dir . '/include/admin-ui/simple-translate.php');
}

function TRANSLATECONTENT_google_api() {
    global $TRANSLATECONTENT_plugin_dir;

    require_once($TRANSLATECONTENT_plugin_dir . '/include/admin-ui/google-translate-api-v2.php');
}

function TRANSLATECONTENT_create_menu() {
    global $TRANSLATECONTENT_plugin_url_path;

    add_menu_page(
            __('Translate content', "translate-content"), __('Translate content', "translate-content"), 'manage_options', 'TRANSLATECONTENT_dashboard', 'TRANSLATECONTENT_dashboard', $TRANSLATECONTENT_plugin_url_path . '/images/translate-content-16x16.png');
    
    add_submenu_page(
            'TRANSLATECONTENT_dashboard', __("Simple translate", "translate-content"), __("Simple translate", "translate-content"), 'manage_options', 'TRANSLATECONTENT_simple_translate', 'TRANSLATECONTENT_simple_translate'
    );

    add_submenu_page(
            'TRANSLATECONTENT_dashboard', __("Google API", "translate-content"), __("Google API", "translate-content"), 'manage_options', 'TRANSLATECONTENT_google_api', 'TRANSLATECONTENT_google_api'
    );
    
    global $submenu;
    if (isset($submenu['TRANSLATECONTENT_dashboard']))
        $submenu['TRANSLATECONTENT_dashboard'][0][0] = __('Dashboard', 'translate-content');
}

function TRANSLATECONTENT_hideLogo() {
    $hide = get_option("hide-translate-content-logo");
    if ($hide) {
        echo "<style>
            .goog-te-gadget-simple {background-color:#F5F5F5;border:none;font-size:11px;}
            .goog-te-gadget-simple img{display:none;}
            .goog-te-gadget-vertical {background-color:#F5F5F5;border:none;font-size:11px;}
            .goog-te-gadget-vertical img{display:none;}
            .goog-te-gadget-horizontal {background-color:#F5F5F5;border:none;font-size:11px;}
            .goog-te-gadget-horizontal img{display:none;}            
         </style>";
    }
}

 
function TRANSLATECONTENT_init() {
    add_action('wp_print_styles', 'TRANSLATECONTENT_hideLogo');
    TRANSLATECONTENT_metabox_init();
    // create custom plugin settings menu
    add_action('admin_menu', 'TRANSLATECONTENT_create_menu');    
}

add_filter('init', 'TRANSLATECONTENT_init');

// Register widgets
add_action('widgets_init', 'TRANSLATECONTENT_widget_init');
?>