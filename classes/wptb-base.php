<?php
/**
 * WPTB-Base Class
 *
 * @package WPTB-Base Plugin
 * @since 1.0.0 
 */

/**
 * Base class for Dashboard Pages
 *
 */

class WPTB_Base {

	/********************************************************************************/
	/*	VARIABLES																	*/
	/********************************************************************************/
	public $options = array();
	public $default_options = array();
	public $form_options = array();
	public $toString = '';
	public $assets_uri = '';
	
	/********************************************************************************/
	/*	SETUP AND INITIALIZE														*/
	/********************************************************************************/
	
	/**
	 * Constructor method.
	 */
	public function __construct() {
		
		$this->setup();
		
		$this->get_options();

	}
	
	/**
	 * Set Up variable defaults.
	 */
	public function setup() {
		
		$this->toString = 'wptb_base';
		$this->assets_uri  = WPTB_DIR_URL . 'assets/';
		
	}
	
	/**
	 * Get Options for this Dashboard Page
	 */
	public function get_options() {
		$my_options = json_decode( get_option( $this->toString , '' ) );
		if ( empty( $my_options ) ) $my_options = array();
		
		// merge default and saved options into $options
		if ( count( $this->default_options ) > 0 ) {
			foreach ( $this->default_options as $key=>$value ) {
				if ( array_key_exists( $key , $my_options ) ) {
					$this->options[ $key ] = $my_options[ $key ];
				} else {
					$this->options[ $key ] = $value;
				}
			}
		}
	}
	
	/**
	 * Update Options for this Dashboard Page
	 */
	public function update_options() {
		
		update_options( get_option( $this->toString , json_encode( $this->options ) ) );
		
	}
	
	/********************************************************************************/
	/*	MAGIC FUNCTIONS																*/
	/********************************************************************************/

	/**
	 * Magic method to output a string if trying to use the object as a string.
	 */
	public function __toString() {
		return $this->toString;
	}
	
	/********************************************************************************/
	/*	CORE FUNCTIONS																*/
	/********************************************************************************/
	

	/**
	 * Show Dashboard page 
	**/
	function wptb_show_page() {
		
		if ( !current_user_can( 'activate_plugins' ) )  {
				wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		
		wptb_html( 'p' , $this->toString );
		
		return;
		
	}

}
