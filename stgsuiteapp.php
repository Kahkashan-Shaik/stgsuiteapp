<?php 
/**
 * @package stgsuiteapp
 */
/*
Plugin Name: ST Gsuite App
Plugin URI: https://standardtouch.com
Description: This Plugin help you to manage your gsuite domains.
Version: 1.0.0
Author: StandardTouch
Author URI: https://standardtouch.com
License: GPLv2 or later
Text Domain: st-gsuite-app
*/

defined( 'ABSPATH' ) or die( 'Hey Your are not allowed here contact site adminstrator' );


// Load the autoload.php file 
if( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) )
{
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}


// Activate plugin
function activate_stgsuiteapp_plugin()
{
	Inc\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'activate_stgsuiteapp_plugin' );

// Deactivate Plugin
function deactivate_stgsuiteapp_plugin()
{
	Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_stgsuiteapp_plugin' );

/**
 * Initialize all the core classes of the plugin
 */
if( class_exists( 'Inc\\Init' ) )
{
	Inc\Init::register_services();
}

add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );


function wpdocs_theme_name_scripts() {
	wp_register_script( 'script-name-js', get_template_directory_uri() . '/assets/frontscript.js', '', null,''  );
    wp_enqueue_script( 'script-name-js' );
}