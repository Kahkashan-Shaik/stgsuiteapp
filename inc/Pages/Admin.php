<?php
/**
 * @package stgsuiteapp
 * 
 * */
namespace Inc\Pages;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\ManagerCallbacks;

class Admin extends BaseController
{

    public $settings; 

    public $callbacks;

    public $callbacks_mgr;    

    public $pages = array();
    
    public function register()
    {

        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();

        $this->callbacks_mgr  = new ManagerCallbacks();

        $this->setDashbaordPage();

        // $this->setSettings();

        // $this->setSections();

        // $this->setFields();

        $this->settings->addPages( $this->pages )->withSubPage( 'Dashboard' )->register();

    }
    public function setDashbaordPage()
    {
        $this->pages = array(
            array(
            'page_title'=> 'ST Gsuite APP',
            'menu_title' => 'Gsuite APP',
            'capability' => 'manage_options',
            'menu_slug' => 'stgsuiteapp_mainpage',
            'callback' => array($this->callbacks, 'mainDashboard'),
            'icon_url' => 'dashicons-category',
            'position' => 80
            )
        );
    }

    

}