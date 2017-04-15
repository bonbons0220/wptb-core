<?php
/**
 * WPTB-Options Class
 *
 * @package WPTB-Core Plugin
 * @since 1.0.0 
 */

/**
 * Singleton class for the Dashboard Options page
 *
 */

class WPTB_Options extends WPTB_Base {

	/********************************************************************************/
	/*	CLASS VARIABLES																*/
	/********************************************************************************/
	
	/********************************************************************************/
	/*	SETUP FUNCTIONS																*/
	/********************************************************************************/
	
	/**
	 * Constructor method.
	 */
	public function __construct() {
		
		parent::__construct();
		
		//Add page(s) to the Admin Menu
		add_action( 'admin_menu' , array( $this , 'wptb_menu' ) );

	}

	/**
	 * Set Up variable defaults.
	 */
	public function setup() {
		
		parent::setup();
		$this->toString = 'wptb_options';

	}
	
	/**
	 * Get Options for this Page
	 */
	public function get_options() {
		parent::get_options();
	}
	
	/********************************************************************************/
	/*	ADMIN DASHBOARD FUNCTIONS																*/
	/********************************************************************************/
	
	 /**
	 * Add menus and pages
	**/
	function wptb_menu() {

		// Add a main menu item and page Admin Menu
		add_menu_page( 'WP TextBook' , 'WP TextBook' , 'activate_plugins' , 'wptb-options' , array( $this , 'wptb_show_page' ) , 'dashicons-book-alt' );
		//add_menu_page( 'WP TextBook' , 'WP TextBook' , 'activate_plugins' , 'wptb-options' , array( $this , 'wptb_show_page' ) , $this->assets_uri . 'wptextbook-base64encode.svg' );
		
		// General Options
		add_submenu_page( 'wptb-options' , '' , '' , 'activate_plugins', 'wptb-options-page', array( $this , 'wptb_show_page' ) );
 
	}

	/**
	 * Show Dashboard page 
	**/
	function wptb_show_page() {
		
		parent::wptb_show_page();
		
		echo ( wptb_html( "h2" , "TextBook Settings" ) );
		echo ( wptb_html( "h3" , get_bloginfo( "name" ) ) );
		
	}
	
}
