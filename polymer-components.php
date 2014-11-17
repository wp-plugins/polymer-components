<?php
/**
 * Plugin Name: Polymer for WordPress
 * Plugin URI: http://blocknot.es/
 * Description: Add Polymer elements to your website!
 * Version: 1.3.0
 * Author: Mattia Roccoberton
 * Author URI: http://blocknot.es
 * License: GPL3
 *
 * Polymer from bower; removed: core-list/demos core-scroll-header-panel/demos google-code-prettify marked/test polymer-test-tools web-animations-next/test
 *
 * ToDo:
 * - area to manage custom elements
 */
require_once( plugin_dir_path( __FILE__ ) . 'conf.php' );

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
		'core-image'               => 'core-image/core-image.html',
		'core-input'               => 'core-input/core-input.html',
		'core-item'                => 'core-item/core-item.html',
		'core-label'               => 'core-label/core-label.html',
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
		'paper-dropdown'           => 'paper-dropdown/paper-dropdown.html',
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
		'paper-spinner'            => 'paper-spinner/paper-spinner.html',
		'paper-tab'                => 'paper-tabs/paper-tab.html',
		'paper-tabs'               => 'paper-tabs/paper-tabs.html',
		'paper-toast'              => 'paper-toast/paper-toast.html',
		'paper-toggle-button'      => 'paper-toggle-button/paper-toggle-button.html',
	// misc
		'polymer-element'          => 'polymer/polymer.html',
	);
	var $requirements = array(
		'core-scaffold' => 'core-drawer-panel',         // + core-header-panel
		'paper-dialog'  => 'paper-dialog-transition',
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
	var $hide_keys = array( 'poly_autop', 'poly_iconsets', 'poly_javascript', 'poly_styles', 'poly_tags', 'poly_template' );
	var $options;
	var $import = array();

	function __construct()
	{
		$this->options = get_option( 'polymer-options' );
		if( $this->options === FALSE )
		{	// default values
			$this->options = unserialize( POLYMER_OPTIONS );
		}
		if( !is_admin() )
		{
			add_filter( 'template_include', array( &$this, 'template_include' ), 99, 1 );
			add_action( 'wp_enqueue_scripts', array( &$this, 'wp_enqueue_scripts' ) );
			add_action( 'wp_head', array( &$this, 'wp_head' ) );
		}
		add_filter( 'is_protected_meta', array( &$this, 'is_protected_meta' ), 10, 2 );              // Hide internal meta
		remove_filter( 'the_content', 'wpautop' );                                                   // >>> Disable automatic formatting inside WordPress shortcodes
		add_filter( 'the_content', 'shortcode_unautop', 100 );
		//add_filter( 'no_texturize_shortcodes', array( &$this, 'no_texturize_shortcodes' ), 10, 4 );  // <<<
		add_action( 'widgets_init', array( &$this, 'widgets_init' ) );
	}

	function is_protected_meta( $protected, $meta_key )
	{	// filter
		// hide some meta key from custom fields of the editor
		return ( in_array( $meta_key, $this->hide_keys ) ? TRUE : $protected );
	}

	//function no_texturize_shortcodes()
	//{	// filter
	//	$shortcodes[] = 'paper-button-base';
	//	$shortcodes[] = 'paper-button';
	//	return $shortcodes;
	//}

	function template_include( $template )
	{
		global $post;
		if( is_singular() )
		{
			$poly_template = get_post_meta( $post->ID, 'poly_template', TRUE );
			if( !empty( $poly_template ) ) return plugin_dir_path( __FILE__ ) . 'polymer-template.php';
		}
		return $template;
	}

	function widgets_init()
	{
		register_widget( 'Polymer_Widget' );
	}

	function wp_enqueue_scripts()
	{	// action
		global $post;
		wp_enqueue_script( 'polymer-webcomponentsjs', plugin_dir_url( __FILE__ ) . 'components/webcomponentsjs/webcomponents.js', array() );
		if( is_singular() )
		{	// Single posts and pages
		// --- autop ---
			$poly_autop = get_post_meta( $post->ID, 'poly_autop', TRUE );
			if( !empty( $poly_autop ) ) add_filter( 'the_content', 'wpautop' , 99 );
		// --- Poly import ---
			$poly_tags = get_post_meta( $post->ID, 'poly_tags', TRUE );
			if( !empty( $poly_tags ) )
			{
				$tags = unserialize( $poly_tags );
				foreach( $tags as $tag )
				{
					if(      isset( $this->tags[$tag]  ) ) $this->import[$tag] = $this->tags[$tag];
					else if( isset( $this->extra[$tag] ) ) $this->import[$tag] = $this->extra[$tag];
				}
			}
		// --- Poly iconsets ---
			$poly_iconsets = get_post_meta( $post->ID, 'poly_iconsets', TRUE );
			if( !empty( $poly_iconsets ) )
			{
				$iconsets = unserialize( $poly_iconsets );
				foreach( $iconsets as $iconset ) if( isset( $this->iconsets[$iconset] ) ) $this->import[$iconset] = $this->iconsets[$iconset];
			}
			$this->javascript = get_post_meta( $post->ID, 'poly_javascript', TRUE );
			$this->styles = get_post_meta( $post->ID, 'poly_styles', TRUE );
		}
		//var_dump( is_active_sidebar( is_active_widget( FALSE, FALSE, 'polymer_widget' ) ) );
		$polymer_widget = is_active_widget( FALSE, FALSE, 'polymer_widget' );
		if( !empty( $polymer_widget ) )
		{	// Polymer widgets
			$widget_polymer_widget = get_option( 'widget_polymer_widget' );
			foreach( $widget_polymer_widget as $widget )
			{
				if( isset( $widget['tags'] ) )
				{
					$tags = unserialize( $widget['tags'] );
					foreach( $tags as $tag )
					{
						if(      isset( $this->tags[$tag]  ) ) $this->import[$tag] = $this->tags[$tag];
						else if( isset( $this->extra[$tag] ) ) $this->import[$tag] = $this->extra[$tag];
					}
				}
			}
		}
	}

	function wp_head()
	{
		foreach( $this->import as $tag => $import ) echo '<link rel="import" href="', plugin_dir_url( __FILE__ ), 'components/', $import,  "\" />\n";
		if( isset( $this->javascript ) && !empty( $this->javascript ) ) echo "<script type=\"text/javascript\">\n", stripslashes( $this->javascript ), "\n</script>\n";
		if( isset( $this->styles ) && !empty( $this->styles ) ) echo "<style type=\"text/css\">\n", stripslashes( $this->styles ), "\n</style>\n";
	}
}

$polycomponents = new polymer_components();

require( plugin_dir_path( __FILE__ ) . 'polymer-shortcodes.php' );
require( plugin_dir_path( __FILE__ ) . 'polymer-widgets.php' );

if( is_admin() ) require( plugin_dir_path( __FILE__ ) . 'polymer-admin.php' );
