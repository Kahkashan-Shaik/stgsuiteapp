<?php
/**
 * @package stgsuiteapp
 * 
 * */
namespace Inc\Base;
use Inc\Base\BaseController;

class Enqueue extends BaseController
{
	public function register()
	{
		add_action( 'admin_enqueue_scripts', array($this, 'enqueue') );
	}		

	function enqueue()
	{
		wp_enqueue_style( 'stpluginstyle', $this->plugin_url. 'assets/ststyle.css' );
		wp_enqueue_script( 'stpluginscript', $this->plugin_url. 'assets/stscript.js' );
		
		
	}
}