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

