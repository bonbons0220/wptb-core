<?php
/**
 * WPTB-Preface Class
 *
 * @package WPTB-Core Plugin
 * @since 1.0.0 
 */

/**
 * Singleton class for the Dashboard Preface page
 *
 */

class WPTB_Preface extends WPTB_Base {

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
		
		parent::__construct();	//setup and get_options
		
		//Add page(s) to the Admin Menu
		add_action( 'admin_menu' , array( $this , 'wptb_menu' ) );

	}
	
	/**
	 * Set Up variable defaults.
	 */
	public function setup() {
		
		parent::setup();
		$this->toString = 'wptb_preface';

		// Set up default options
		$this->default_options = array(
			'version'=>"1.0.0",
			'authors'=>array( 
				array(
					'name'=>'John Doe',
					'affiation'=>'Catatonic State University',
				),
			),
			'custom'=>array( 
			),
		);
		
		// How to show options in form
		$this->form_options = array(
			'version'=>'text',
			'authors'=>'text',
			'custom'=>'text',
		);
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

		// Preface Options
		add_submenu_page( 'wptb-options' , 'Preface' , 'Preface' , 'activate_plugins', 'wptb-preface-page', array( $this , 'wptb_show_page' ) );
 
	}

	/**
	 * Show Dashboard page 
	**/
	function wptb_show_page() {
		
		parent::wptb_show_page();
				
		// Debug thing
		$debug = '' ;
		//$debug .= ( WPTB_DEBUG ) ? wptb_html( "pre" , var_export( $this->options , true ) ) : '' ;
		
		$page_title = wptb_html( "h2" , "TextBook Preface" );
		
		// loop though options/form_options to create prefilled form .
		
		$version_row = wptb_html( "tr" , 
							wptb_html( "th" , 
								wptb_html( "label" , "Version" , array( "for"=>"version") ) .
								wptb_html( "td" ,
									wptb_html( "input" , "" , 
										array( 
											"type"=>"text" , 
											"name"=>"version" , 
											"value"=>$this->options[ 'version' ] 
										) , true 
									) 
								) 
							) 
						);
			
		$author_rows = wptb_html( "tr" , 
							wptb_html( "th" , 
								"Authors" ,
								array( 
									"class"=>"h3" 
								)
							)
						);
		$i = 1;
		foreach ( $this->options[ 'authors' ] as $key=>$value ) {


			foreach ( $value as $authorkey=>$authorvalue ) {
				//$debug .= ( WPTB_DEBUG ) ? wptb_html( "pre" , var_export( $authorvalue , true ) ) : '' ;
			
				$author_rows .= wptb_html( "tr" , 
								wptb_html( "td" , 
									wptb_html( "label" , 
										ucfirst( $authorkey ) , 
										array( "for"=>($authorkey.$i)) ) .
									wptb_html( "td" ,
										wptb_html( 
											"input" , 
											" " , 
											array( 
												"type"=>"text" , 
												"name"=>($authorkey.$i) ,
												"value"=>($authorvalue) ,
												"size"=>"60",
											) , 
											true )
										)
									)
								);
			}
			$i++;
		}
		
		$table_rows = wptb_html( "table" , $author_rows . $version_row );
		
		$submit_button = wptb_html( "button" , "Save" , array( "type"=>"submit" ) );
		
		$form_table = 	wptb_html( "form" , 
							$table_rows . $submit_button , 
							array( "class"=>"form-table" ) ) ;
		
		$result = 	wptb_html( "div" , 
						$debug .
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

}
