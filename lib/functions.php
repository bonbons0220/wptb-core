<?php
/**
 * WPTB Utility Functions
 *
 * @package WPTB-Core Plugin
 * @since 1.0.0 
 */

/**
 * Wrap HTML elements as tags with elements.
**/
function wptb_html( $tag="" , $content="", $atr=array() , $self=false ) {
	if ( empty( $tag ) ) return $content;
	
	$atts = "";
	foreach ( $atr as $key=>$value ) {
		$atts .= "$key='$value' ";
	}
	$content = ( $self ) ? "<$tag $atts/>" : "<$tag $atts>$content</$tag>" ;
	return $content;
}
/**
 * Add custom URL query arguments
**/
// THIS DOES NOT SEEM TO WORK ON THE ADMIN SIDE
function wptb_add_query_vars_filter( $vars ){
  // set_query_vars does not work in dashboard. use $_POST instead
  //$vars[] = "wptb-action";
  return $vars;
}
