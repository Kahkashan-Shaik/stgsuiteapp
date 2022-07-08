<?php 
/**
 * @package stgsuiteapp
*/
namespace Inc\Base;

class Activate 
{
    public $load_scripts; 
    public static function activate()
    {
        flush_rewrite_rules();

        $default = array();

        if( ! get_option('stgsuiteapp_dashbaord') )
        {
            update_option( 'stgsuiteapp_dashbaord', $default );
        }
        if( ! get_option('stgsuiteapp_settings') )
        {
            $status = ( is_dir(get_stylesheet_directory().'/vendor') ) ? true : false;
            update_option( 'stgsuiteapp_settings', array( 'status' => $status ) );
        }

    }
}