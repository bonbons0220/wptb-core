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

	public $classes_dir = '';
	public $lib_dir = '';
	public $css_uri = '';
	public $js_uri = '';
	public $assets_uri = '';
	
	private $wptb_options;
	private $wptb_preface;
	

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
		$this->lib_dir   = WPTB_DIR_PATH . 'lib/';

		// Plugin directory URIs.
		$this->css_uri = WPTB_DIR_URL . 'css/';
		$this->js_uri  = WPTB_DIR_URL . 'js/';
		$this->assets_uri  = WPTB_DIR_URL . 'assets/';
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

		// Load frontend files.
		require_once( $this->lib_dir . "functions.php" );
		
		// Load admin/backend files.
		if ( is_admin() ) {

			require_once( $this->classes_dir . "wptb-base.php" );
			
			require_once( $this->classes_dir . "wptb-options.php" );
			$this->wptb_options = new WPTB_Options;
			
			require_once( $this->classes_dir . "wptb-preface.php" );
			$this->wptb_preface = new WPTB_Preface;
					
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
	/*	CORE FUNCTIONS																*/
	/********************************************************************************/
	
	//
	function register_wptb_core_script() {
		
		//Scripts to be Registered, but not enqueued
		//wp_register_script( 'wptb-script', $this->js_uri . "wptb-core.js", array( 'jquery' ), '1.0.0', true );
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
