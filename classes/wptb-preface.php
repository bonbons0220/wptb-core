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
	public $possible_actions = array();
	public $message = '';
	
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
		$this->slug = 'wptb-preface-page';
		$this->possible_actions = array(
			'save'
		);

		// Set up default options
		$this->default_options = array(
			'version'=>"1.0",
			'authors'=>array( 
				array(
					'name'=>'',
					'affiation'=>'',
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
		add_submenu_page( 'wptb-options' , 'Preface' , 'Preface' , $this->capability, $this->slug, array( $this , 'wptb_show_page' ) );
 
	}

	/**
	 * Show Dashboard page 
	**/
	function wptb_show_page() {
		
		/*****     
		$this->message .= wptb_html( "div" , 'message_here' , array('class'=>'wp-ui-notification' ) );
		*****/

		parent::wptb_show_page();
				
		/*****     CHECK ACTION==SAVE     *****/

		$action = ( isset( $_POST['wptb-action'] ) && ( in_array( $_POST['wptb-action'] , $this->possible_actions ) ) ) ? 
			$_POST['wptb-action'] : 
			false ;
		if ( $action ) {
			check_admin_referer( $this->toString , '_wpnonce' );
			$this->do_action( $action );
		}
		
		/*****     SHOW THE PREFACE OPTIONS PAGE     *****/
		$page_title = wptb_html( "h2" , "TextBook Preface" );
		
		// loop though options/form_options to display prefilled form .
		
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
							wptb_html(
								"input" , 
								" " , 
								array( 
									"type"=>"hidden" , 
									"name"=>('page') ,
									"value"=>( $this->slug ) ,
								) , 
								true ) .
							wptb_html(
								"input" , 
								" " , 
								array( 
									"type"=>"hidden" , 
									"name"=>('wptb-action') ,
									"value"=>( 'save' ) ,
								) , 
								true ) .
							$table_rows . 
							wp_nonce_field( $this->toString , '_wpnonce' , false , false ) . 
							$submit_button , 
							array( 
								"class"=>"form-table" ,
								"action"=>"" ,
								"method"=>"post" ,
							)
						);
		
		$result = 	wptb_html( "div" , 
						$this->message .
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
	
	/********************************************************************************/
	/*	UTILITY FUNCTIONS															*/
	/********************************************************************************/
	
	/**
	 * Deal with action
	**/
	function do_action( $action = false ) {
		switch ( $action ) :
			case ( 'save' ):
				//foreach (  )
				
				break;
			default:
				break;
	}
