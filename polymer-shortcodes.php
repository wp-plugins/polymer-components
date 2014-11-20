<?php
if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class polymer_shortcodes
{
	function __construct()
	{
		add_shortcode( 'poly', array( &$this, 'poly' ) );
		//add_shortcode( 'block', array( &$this, 'block' ) );	// DISABLED: I can't directly include a block because the import list could change if the block is modified
		add_shortcode( 'block-url', array( &$this, 'block_url' ) );
	}

	/* function block( $atts )
	{
		$ret = '';
		if( isset( $atts['id'] ) )
		{
			$id = intval( $atts['id'] );
			if( $id > 0 )
			{
				$block = get_post( $id );
				$ret .= do_shortcode( $block->post_content );
			}
		}
		return $ret;
	} */

	function block_url( $atts )
	{
		$ret = '';
		if( isset( $atts['name'] ) ) $ret = esc_url( get_home_url() . '?block=' . $atts['name'] );
		return $ret;
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
