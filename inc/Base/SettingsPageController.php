<?php
/**
 * @package stgsuiteapp
 * 
 * */
namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\SettingsCallbacks;


class SettingsPageController extends BaseController
{
     public $settings; 

    public $callbacks;

    public $callbacks_domain;    

    public $settings_subpage = array();
    
    public function register()
    {

        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();

        $this->callbacks_settings  = new SettingsCallbacks();

        $this->setSettingsPage();

        $checksettings = ( ( get_option('stgsuiteapp_settings') != null ) ? get_option('stgsuiteapp_settings')['status'] : '' );

        if( ! $checksettings )
        {
            $this->setSettings();

            $this->setSections();

            $this->setFields();
        }

        $this->settings->addSubPages( $this->settings_subpage )->register();

    }
    
    public function setSettingsPage()
    {
        $this->settings_subpage = array(
            array(
            'parent_slug' => 'stgsuiteapp_mainpage',
            'page_title' => 'Gsuite App Settings', 
            'menu_title' => 'Settings',
            'capability' => 'manage_options',
            'menu_slug' => 'stgsuiteapp_settings',
            'callback' => array($this->callbacks, 'settingsDashboard'),
            )
        );
    }

    public function setSettings()
    {
        $args = array();
        $args[] = array(
            'option_group' => 'st_gsuite_app_settings',
            'option_name' => 'stgsuiteapp_settings',
            'callback' => array( $this->callbacks_settings, 'inputsanitizations' )
        );

        $this->settings->setSettings( $args );
    }

    public function setSections()
    {
        $args = array(
            array(
                'id' => 'st_gsuite_app_settings_section',
                'title' => 'Manage Gsuite App Settings',
                'callback' => array( $this->callbacks_settings, 'adminSectionManager' ),
                'page' => 'stgsuiteapp_settings'
            )
        );   

        $this->settings->setSections( $args );
    }

    public function setFields()
    {   
        $args = array(
            // array(
            //     'id' => 'gsuiteapp_zipfile',
            //     'title' => 'Upload gsuite App file',
            //     'callback' => array( $this->callbacks_settings, 'fileUpload' ),
            //     'page' => 'stgsuiteapp_settings',
            //     'section' => 'st_gsuite_app_settings_section',
            //     'args' => array(
            //         'option_name' => 'stgsuiteapp_settings',
            //         'label_for' => 'gsuiteapp_zipfile',
            //         'extentions'=> '.zip'

            //     )
            // ),
            // array(
            //     'id' => 'gsuiteapp_status',
            //     'title' => '',
            //     'callback' => array( $this->callbacks_settings, 'textField' ),
            //     'page' => 'stgsuiteapp_settings',
            //     'section' => 'st_gsuite_app_settings_section',
            //     'args' => array(
            //         'option_name' => 'stgsuiteapp_settings',
            //         'label_for' => 'gsuiteapp_status',
            //     )
            // ),
            array(
                'id' => 'unzip_gsuiteapp',
                'title' => 'URL Gsuite App',
                'callback' => array( $this->callbacks_settings, 'textField' ),
                'page' => 'stgsuiteapp_settings',
                'section' => 'st_gsuite_app_settings_section',
                'args' => array(
                    'option_name' => 'stgsuiteapp_settings',
                    'label_for' => 'unzip_gsuiteapp',
                    'extentions' => '.zip',
                    'placeholder' => 'Paste URL of Gsuite App .zip file'
                )
            ),
        ); 
        $this->settings->setFields( $args ); 
    }

    
}