<?php
if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class polymer_shortcodes
{
	function __construct()
	{
		add_shortcode( 'poly', array( &$this, 'poly' ) );
	}

	function poly( $atts, $content = '' )
	{
		global $polycomponents;
		if( isset( $atts[0] ) && strpos( $atts[0], '-' ) > 0 )
		{
			$tag = $atts[0];
			if( isset( $polycomponents->tags[$tag] ) )
			{
				$ret = '<' . $tag;
				foreach( $atts as $key => $value )
				{
					if( is_numeric( $key ) ) $ret .= ' ' . esc_attr( $value );
					else $ret .= ' ' . esc_attr( $key ) . '="' . esc_attr( $value ) . '"';
				}
				$ret .= '>' . do_shortcode( $content ) . '</' . $tag . '>';
				return $ret;
			}
		}
		return $content;
	}
}

new polymer_shortcodes();
