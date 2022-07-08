<?php
/**
 * @package stgsuiteapp
 * 
 * */
namespace Inc\Base;
use Inc\Base\BaseController;

class EnqueueFrontendscripts extends BaseController
{
	public function register()
	{
		add_action( 'wp_enqueue_scripts', array($this, 'enqueue') );
	}		

	function enqueue()
	{
		wp_enqueue_style( 'stfrontstyle', $this->plugin_url. 'assets/frontend/fronstyle.css' );
		wp_enqueue_script( 'stfrontscript', $this->plugin_url. 'assets/frontend/frontscript.js' );
		
		
	}
}