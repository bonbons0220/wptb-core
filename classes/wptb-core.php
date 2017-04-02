<?php
/**
 * WPTB-Core Plugin Class
 *
 * @link git@github.com:bonbons0220/wptb-core.git
 *
 * @package WPTB-Core Plugin
 * @since 1.0.0 
 */

/**
 * Singleton class for setting up the plugin.
 *
 */
final class WPTB_Core_Plugin {

	public $admin_dir = '';
	public $classes_dir = '';
	public $templates_dir = '';
	public $css_uri = '';
	public $js_uri = '';

	public $options = array();

	/********************************************************************************/
	/*	SETUP AND ACTIVATION FUNCTIONS												*/
	/********************************************************************************/
	
	/**
	 * Returns the instance.
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new WPTB_Core_Plugin;
			$instance->setup();
			$instance->includes();
			$instance->setup_actions();
		}

		return $instance;
	}
	
	/**
	 * Constructor method.
	 */
	private function __construct() {

	}
	
	/**
	 * Sets up globals.
	 */
	private function setup() {

		// Plugin directory paths.
		$this->classes_dir   = WPTB_DIR_PATH . 'classes/';

		// Plugin directory URIs.
		$this->css_uri = WPTB_DIR_URL . 'css/';
		$this->js_uri  = WPTB_DIR_URL . 'js/';
	}

	 /**
	 * Get WPTB_Core Options
	**/
	function get_options(){
		
		// Get Options
		$my_options = get_option( 'wptb_options', "" );
		
	}
	
	/**
	 * Loads files needed by the plugin.
	 */
	private function includes() {

		// Load admin/backend files.
		if ( is_admin() ) {

			//Add page(s) to the Admin Menu
			add_action( 'admin_menu' , array( $this , 'wptb_menu' ) );
			
			$this->get_options();
			
		}
	}

	/**
	 * Sets up main plugin actions and filters.
	 */
	private function setup_actions() {

		// Register activation hook.
		register_activation_hook( __FILE__, array( $this, 'activation' ) );

	}

	/**
	 * Method that runs only when the plugin is activated.
	 */
	public function activation() {

	}

	/********************************************************************************/
	/*	CORE FUNCTIONS												*/
	/********************************************************************************/
	
	 /**
	 * Add menus and pages
	**/
	function wptb_menu() {


		// Add a main menu item and page Admin Menu
		add_menu_page( 'WP TextBook' , 'WP TextBook' , 'activate_plugins' , 'wptb-options' , array( $this , 'wptb_options_page' ) , 'dashicons-book-alt' );
		
		// General Options
		add_submenu_page( 'wptb-options' , '' , '' , 'activate_plugins', 'wptb-options-page', array( $this , 'wptb_options_page' ) );

		// Preface Options
		add_submenu_page( 'wptb-options' , 'Preface' , 'Preface' , 'activate_plugins', 'wptb-preface-page', array( $this , 'wptb_preface_page' ) );
 
	}

	/**
	 * Show Dashboard page 
	**/
	function wptb_options_page() {
		
		if ( !current_user_can( 'activate_plugins' ) ) {
				wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

		echo ($this->wptb_html( "h2" , "TextBook Settings" ) );
		echo ($this->wptb_html( "h3" , get_bloginfo( "name" ) ) );
		echo ( $this->wptb_html( "pre" , WPTB_DIR_PATH ) );
		echo ( $this->wptb_html( "pre" , WPTB_DIR_URL ) );
		
	}

	/**
	 * Show Dashboard page 
	**/
	function wptb_preface_page() {
		
		if ( !current_user_can( 'activate_plugins' ) )  {
				wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		require_once( $this->classes_dir . "wptb-preface.php" );
		

		$page_title = 	$this->wptb_html( "h2" , "TextBook Preface" );
		
		$author_rows = $this->wptb_html( "tr" , 
							$this->wptb_html( "th" , 
								$this->wptb_html( "label" , "Author" , array( "for"=>"author1") ) .
							$this->wptb_html( "td" ,
								$this->wptb_html( "input" , "" , array( "type"=>"text" , "name"=>"author1" , "size"=>"60" ) , true ) ) ) );
		
		$table_rows = $this->wptb_html( "table" , $author_rows );
		$submit_button = $this->wptb_html( "button" , "Save" , array( "type"=>"submit" ) );
		
		$form_table = 	$this->wptb_html( "form" , 
							$table_rows . $submit_button , 
							array( "class"=>"form-table" ) ) ;
		
		$result = 	$this->wptb_html( "div" , 
						$page_title . 
						$form_table , 
						array( 
							"class"=>"wrap" , 
							"action"=>"/" ,
							"method"=>"POST" ,
						)
					);
		
		echo $result;
	}

	//
	function register_wptb_core_script() {
		
		//Scripts to be Registered, but not enqueued
		//This example requires jquery 
		//wp_register_script( 'wptb-script', $this->js_uri . "wptb-core.js", array( 'jquery' ), '1.0.0', true );
		
		//Styles to be Registered, but not enqueued
		//wp_register_style( 'wptb-style', $this->css_uri . "wptb-core.css" );
		
		//Scripts and Styles to be Enqueued on every page.
		//wp_enqueue_script( 'wptb-script' );
		//wp_enqueue_style( 'wptb-style' );

	}

	public function wptb_core_shortcode( $atts, $content = null, $tagname = null ) {

		//Shortcode loads scripts and styles
		//wp_enqueue_script( 'wptb-script' );
		//wp_enqueue_style( 'wptb-style' );
		
		//Content is unchanged
		
		return '';
	}
	
	/********************************************************************************/
	/*	UTILITY FUNCTIONS																*/
	/********************************************************************************/

	/**
	 * Wrap HTML elements as tags with elements.
	**/
	function wptb_html( $tag="" , $content="", $atr=array() , $self=false ) {
		if ( empty( $tag ) ) return $content;
		
		$atts = "";
		foreach ( $atr as $key=>$value ) {
			$atts = "$key='$value' ";
		}
		$content = ( $self ) ? "<$tag $atts/>" : "<$tag $atts>$content</$tag>" ;
		return $content;
	}

	/********************************************************************************/
	/*	MAGIC FUNCTIONS																*/
	/********************************************************************************/

	/**
	 * Magic method to output a string if trying to use the object as a string.
	 */
	public function __toString() {
		return 'wptb_core';
	}

	/**
	 * Magic method to keep the object from being cloned.
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Sorry, no can do.', 'wptb_core' ), '1.0' );
	}

	/**
	 * Magic method to keep the object from being unserialized.
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Sorry, no can do.', 'wptb_core' ), '1.0' );
	}

	/**
	 * Magic method to prevent a fatal error when calling a method that doesn't exist.
	 */
	public function __call( $method = '', $args = array() ) {
		_doing_it_wrong( "WPTB_Core_Plugin::{$method}", esc_html__( 'Method does not exist.', 'wptb_core' ), '1.0' );
		unset( $method, $args );
		return null;
	}

}
