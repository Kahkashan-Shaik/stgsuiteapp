<?php
/**
 * @package stgsuiteapp
 * 
 * */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;


class AdminCallbacks extends BaseController
{
    
    public function mainDashboard()
    {
        require_once("$this->plugin_path/templates/admin.php");
    }

    public function adminDashboard()
    {
        require_once("$this->plugin_path/templates/domain.php");
    }

    public function settingsDashboard()
    {
        require_once("$this->plugin_path/templates/settings.php");
    }
}