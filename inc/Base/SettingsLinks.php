<?php
/**
 * @package stgsuiteapp
 * 
 * */

namespace Inc\Base;
use Inc\Base\BaseController;

class SettingsLinks extends BaseController
{

    public function register()
    {
        add_action( "plugin_action_links_$this->plugin" , array( $this, 'settings_link' ) );
    }
    public function settings_link( $links )
    {
        $settings_link = '<a href="admin.php?page=stgsuiteapp_dashbaord">Settings</a>';
        array_push( $links, $settings_link );
        return $links;
    }

}