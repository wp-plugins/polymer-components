<?php
/**
 * Plugin Name: Polymer Components
 * Plugin URI: http://blocknot.es/
 * Description: Add Polymer support to your website!
 * Version: 1.0.2
 * Author: Mattia Roccoberton
 * Author URI: http://blocknot.es
 * License: GPL3
 *
 * Note: polymer with bower; removed: core-scroll-header-panel/demos, google-code-prettify, polymer-test-tools, web-animations-js/test, web-animations-js/tools, web-animations-js/tutorial
 */
class polymer_components
{
	var $tags = array(
	// core
		'core-a11y-keys'           => 'core-a11y-keys/core-a11y-keys.html',
		'core-ajax'                => 'core-ajax/core-ajax.html',
		'core-xhr'                 => 'core-ajax/core-xhr.html',
		'core-animated-pages'      => 'core-animated-pages/core-animated-pages.html',
		'core-transition-pages'    => 'core-animated-pages/transitions/core-transition-pages.html',
		'core-animation-group'     => 'core-animation/core-animation-group.html',
		'core-animation'           => 'core-animation/core-animation.html',
		'core-animation-keyframe'  => 'core-animation/core-animation.html',
		'core-animation-prop'      => 'core-animation/core-animation.html',
		'core-collapse'            => 'core-collapse/core-collapse.html',
		'core-drag-drop'           => 'core-drag-drop/core-drag-drop.html',
		'core-drawer-panel'        => 'core-drawer-panel/core-drawer-panel.html',
		'core-dropdown-overlay'    => 'core-dropdown/core-dropdown-overlay.html',
		'core-dropdown'            => 'core-dropdown/core-dropdown.html',
		'core-dropdown-menu'       => 'core-dropdown-menu/core-dropdown-menu.html',
		'core-field'               => 'core-field/core-field.html',
		'core-header-panel'        => 'core-header-panel/core-header-panel.html',
		'core-icon'                => 'core-icon/core-icon.html',
		'core-icon-button'         => 'core-icon-button/core-icon-button.html',
		'core-iconset'             => 'core-iconset/core-iconset.html',
		'core-iconset-svg'         => 'core-iconset-svg/core-iconset-svg.html',
		'core-input'               => 'core-input/core-input.html',
		'core-item'                => 'core-item/core-item.html',
		'core-list'                => 'core-list/core-list.html',
		'core-localstorage'        => 'core-localstorage/core-localstorage.html',
		'core-media-query'         => 'core-media-query/core-media-query.html',
		'core-menu'                => 'core-menu/core-menu.html',
		'core-submenu'             => 'core-menu/core-submenu.html',
		'core-menu-button'         => 'core-menu-button/core-menu-button.html',
		'core-meta'                => 'core-meta/core-meta.html',
		'core-overlay'             => 'core-overlay/core-overlay.html',
		'core-pages'               => 'core-pages/core-pages.html',
		'core-range'               => 'core-range/core-range.html',
		'core-scaffold'            => 'core-scaffold/core-scaffold.html',
		'core-scroll-header-panel' => 'core-scroll-header-panel/core-scroll-header-panel.html',
		'core-selection'           => 'core-selection/core-selection.html',
		'core-selector'            => 'core-selector/core-selector.html',
		'core-shared-lib'          => 'core-shared-lib/core-shared-lib.html',
		'core-signals'             => 'core-signals/core-signals.html',
		'core-splitter'            => 'core-splitter/core-splitter.html',
		'core-style'               => 'core-style/core-style.html',
		'core-toolbar'             => 'core-toolbar/core-toolbar.html',
		'core-tooltip'             => 'core-tooltip/core-tooltip.html',
		'core-transition'          => 'core-transition/core-transition.html',
	// paper
		'paper-button-base'        => 'paper-button/paper-button-base.html',
		'paper-button'             => 'paper-button/paper-button.html',
		'paper-checkbox'           => 'paper-checkbox/paper-checkbox.html',
		'paper-dialog-transition'  => 'paper-dialog/paper-dialog-transition.html',
		'paper-dialog'             => 'paper-dialog/paper-dialog.html',
		'paper-dropdown-menu'      => 'paper-dropdown-menu/paper-dropdown-menu.html',
		'paper-fab'                => 'paper-fab/paper-fab.html',
		'paper-focusable'          => 'paper-focusable/paper-focusable.html',
		'paper-icon-button'        => 'paper-icon-button/paper-icon-button.html',
		'paper-input'              => 'paper-input/paper-input.html',
		'paper-item'               => 'paper-item/paper-item.html',
		'paper-menu-button'        => 'paper-menu-button/paper-menu-button.html',
		'paper-progress'           => 'paper-progress/paper-progress.html',
		'paper-radio-button'       => 'paper-radio-button/paper-radio-button.html',
		'paper-radio-group'        => 'paper-radio-group/paper-radio-group.html',
		'paper-ripple'             => 'paper-ripple/paper-ripple.html',
		'paper-shadow'             => 'paper-shadow/paper-shadow.html',
		'paper-slider'             => 'paper-slider/paper-slider.html',
		'paper-tab'                => 'paper-tabs/paper-tab.html',
		'paper-tabs'               => 'paper-tabs/paper-tabs.html',
		'paper-toast'              => 'paper-toast/paper-toast.html',
		'paper-toggle-button'      => 'paper-toggle-button/paper-toggle-button.html',
	);
	var $requirements = array(
		'paper-dialog' => 'paper-dialog-transition',
		'core-icon'    => 'core-icons',
	);
	var $extra = array(
		'core-icons' => 'core-icons/core-icons.html',
	);
	var $iconsets = array(
		'av-icons'            => 'core-icons/av-icons.html',
		'communication-icons' => 'core-icons/communication-icons.html',
		'device-icons'        => 'core-icons/device-icons.html',
		'editor-icons'        => 'core-icons/editor-icons.html',
		'hardware-icons'      => 'core-icons/hardware-icons.html',
		'image-icons'         => 'core-icons/image-icons.html',
		'maps-icons'          => 'core-icons/maps-icons.html',
		'notification-icons'  => 'core-icons/notification-icons.html',
		'png-icons'           => 'core-icons/png-icons.html',
		'social-icons'        => 'core-icons/social-icons.html',
	);

	function __construct()
	{
		if( !is_admin() )
		{
			add_action( 'wp_enqueue_scripts', array( &$this, 'wp_enqueue_scripts' ) );
			add_action( 'wp_head', array( &$this, 'wp_head' ) );
		}
		//add_action( 'after_setup_theme', array( &$this, 'after_setup_theme' ) );
		add_action( 'init', array( &$this, 'init' ) );
		add_filter( 'is_protected_meta', array( &$this, 'is_protected_meta' ), 10, 2 );              // Hide internal meta
		remove_filter( 'the_content', 'wpautop' );                                                   // >>> Disable automatic formatting inside WordPress shortcodes
		add_filter( 'the_content', 'wpautop' , 99 );
		add_filter( 'the_content', 'shortcode_unautop', 100 );                                    
		//add_filter( 'no_texturize_shortcodes', array( &$this, 'no_texturize_shortcodes' ), 10, 4 );  // <<<
	}

	function after_setup_theme()
	{	// action
		//remove_filter( 'the_content', 'wp_strip_all_tags' );
		//remove_filter( 'the_excerpt', 'wp_strip_all_tags' );
		//global $allowedposttags;
		//$allowedposttags['ccc'] = array();
		//var_dump( $allowedposttags['ccc'] );
	}

	function init()
	{	// action
		//remove_filter('the_content', 'wpautop');
		//remove_filter('the_content', 'wptexturize');
		//remove_filter('pre_user_description', 'wp_filter_kses');
		//kses_remove_filters();
	}
	/*function init()
	{	// action
		global $allowedposttags, $allowedtags;

		$allowedposttags['paper-button'] = array();
		$allowedtags['paper-button'] = array();
	} */

	function is_protected_meta( $protected, $meta_key )
	{	// filter
		// hide some meta key from custom fields of the editor
		return $meta_key == 'poly_tags' ? TRUE : $protected;
	}

	//function no_texturize_shortcodes()
	//{	// filter
	//	$shortcodes[] = 'paper-button-base';
	//	$shortcodes[] = 'paper-button';
	//	return $shortcodes;
	//}

	function wp_enqueue_scripts()
	{	// action
		wp_enqueue_script( 'polymer-platform-script', plugin_dir_url( __FILE__ ) . 'components/platform/platform.js', array() );
	}

	function wp_head()
	{	// action
		global $post;
		if( is_singular() )
		{
			$poly_tags = get_post_meta( $post->ID, 'poly_tags', TRUE );
			if( !empty( $poly_tags ) )
			{
				$tags = unserialize( $poly_tags );
				foreach( $tags as $tag )
				{
					if(      isset( $this->tags[$tag]  ) ) echo '<link rel="import" href="', plugin_dir_url( __FILE__ ), 'components/', $this->tags[$tag],  "\" />\n";
					else if( isset( $this->extra[$tag] ) ) echo '<link rel="import" href="', plugin_dir_url( __FILE__ ), 'components/', $this->extra[$tag], "\" />\n";
				}
			}
			$poly_iconsets = get_post_meta( $post->ID, 'poly_iconsets', TRUE );
			if( !empty( $poly_iconsets ) )
			{
				$iconsets = unserialize( $poly_iconsets );
				foreach( $iconsets as $iconset ) if( isset( $this->iconsets[$iconset] ) ) echo '<link rel="import" href="', plugin_dir_url( __FILE__ ), 'components/', $this->iconsets[$iconset], "\" />\n";
			}
		}
	}
}

$polycomponents = new polymer_components();

require plugin_dir_path( __FILE__ ) . 'polymer-shortcodes.php';

if( is_admin() ) require plugin_dir_path( __FILE__ ) . 'polymer-admin.php';
