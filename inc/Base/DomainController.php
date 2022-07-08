<?php
/**
 * @package stgsuiteapp
 * 
 * */
namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\DomainCallbacks;


class DomainController extends BaseController
{
     public $settings; 

    public $callbacks;

    public $callbacks_domain;    

    public $dashboard_subpage = array();
    
    public function register()
    {

        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();

        $this->callbacks_domain  = new domainCallbacks();

        $this->setDashbaordPage();

        $this->setSettings();

        $this->setSections();

        $this->setFields();


        $this->settings->addSubPages( $this->dashboard_subpage )->register();


    }
    public function setDashbaordPage()
    {
        $this->dashboard_subpage = array(
            array(
            'parent_slug' => 'stgsuiteapp_mainpage',
            'page_title' => 'Add Gsuite Domains', 
            'menu_title' => 'Gsuite APP',
            'capability' => 'manage_options',
            'menu_slug' => 'stgsuiteapp_dashbaord',
            'callback' => array($this->callbacks, 'adminDashboard'),
            )
        );
    }

    public function setSettings()
    {
        $args = array();
        $args[] = array(
                'option_group' => 'st_gsuite_app_dashboard_settings',
                'option_name' =>  'stgsuiteapp_dashbaord',
                'callback' => array( $this->callbacks_domain, 'inputsanitizations' )
            );

        $this->settings->setSettings( $args );
    }

    public function setSections()
    {
        $args = array(
            array(
                'id' => 'st_gsuite_app_section',
                'title' => 'Manage Gsuite Domain',
                'callback' => array( $this->callbacks_domain, 'adminSectionManager' ),
                'page' => 'stgsuiteapp_dashbaord'
            )
        );

        $this->settings->setSections( $args );
    }

    public function setFields()
    {

        $args = array(
                    array(
                        'id' => 'domain_name',
                        'title' => 'Gsuite Domain Name',
                        'callback' => array( $this->callbacks_domain, 'textField' ),
                        'page' => 'stgsuiteapp_dashbaord',
                        'section' => 'st_gsuite_app_section',
                        'args' => array(
                            'option_name' => 'stgsuiteapp_dashbaord',
                            'label_for' => 'domain_name',
                            'placeholder' => 'eg. standardtouch.com'
                        )
                    ),
                    array(
                        'id' => 'quickstart_file',
                        'title' => 'Upload Quickstart file',
                        'callback' => array( $this->callbacks_domain, 'fileUpload' ),
                        'page' => 'stgsuiteapp_dashbaord',
                        'section' => 'st_gsuite_app_section',
                        'args' => array(
                            'option_name' => 'stgsuiteapp_dashbaord',
                            'label_for' => 'quickstart_file',
                            'extentions'=> '.php'

                        )
                    ),
                    array(
                        'id' => 'credentailsjson_file',
                        'title' => 'Upload Crendetails file',
                        'callback' => array( $this->callbacks_domain, 'fileUpload' ),
                        'page' => 'stgsuiteapp_dashbaord',
                        'section' => 'st_gsuite_app_section',
                        'args' => array(
                            'option_name' => 'stgsuiteapp_dashbaord',
                            'label_for' => 'credentailsjson_file',
                            'extentions'=> '.json'
                        )
                    ),
                ); 

        $this->settings->setFields( $args );
    }
}