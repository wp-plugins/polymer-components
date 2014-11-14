<?php
if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once( plugin_dir_path( __FILE__ ) . 'conf.php' );
require_once( plugin_dir_path( __FILE__ ) . 'inc/ganon.php' );

class polymer_admin
{
	private $options;

	function __construct()
	{
	// --- Actions ---
		add_action( 'add_meta_boxes', array( &$this, 'add_meta_boxes' ) );
		add_action( 'admin_init', array( &$this, 'admin_init' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'save_post', array( &$this, 'save_post' ) );
	// --- Filters ---
		add_filter( 'plugin_action_links_' . POLYMER_COMPONENTS_MAIN, array( &$this, 'plugin_action_links' ), 10, 1 );
	}

	function add_meta_boxes()
	{	// action
		add_meta_box( 'polymer_meta', __( 'Polymer Components', 'liquid-theme' ), array( &$this, 'polymer_meta' ), 'post', 'normal', 'high' );
		add_meta_box( 'polymer_meta', __( 'Polymer Components', 'liquid-theme' ), array( &$this, 'polymer_meta' ), 'page', 'normal', 'high' );
	}

	function admin_init()
	{	// action
		$this->options = get_option( 'polymer-options' );
		if( $this->options === FALSE )
		{	// default values
			$this->options = unserialize( POLYMER_OPTIONS );
		}
	// Styles and scripts
		wp_enqueue_style( 'poly-admin-style', plugin_dir_url( __FILE__ ) . 'polymer-admin.css' );
		wp_enqueue_style( 'poly-admin-codemirror-style', plugin_dir_url( __FILE__ ) . 'codemirror/codemirror.css' );
		wp_register_script( 'poly-admin-scripts', plugin_dir_url( __FILE__ ) . 'polymer-admin.js', array() );
		wp_register_script( 'poly-admin-codemirror', plugin_dir_url( __FILE__ ) . 'codemirror/codemirror.min.js', array() );
		wp_register_script( 'poly-admin-codemirror-js', plugin_dir_url( __FILE__ ) . 'codemirror/javascript.js', array() );
		wp_enqueue_script( 'poly-admin-scripts' );
		wp_enqueue_script( 'poly-admin-codemirror' );
		wp_enqueue_script( 'poly-admin-codemirror-js' );
	// Settings
		register_setting(
			'polymer-settings-general',
			'polymer-options'
			//, array( $this, 'sanitize' ) // Sanitize
		);
		add_settings_section(
			'polymer-section-general', // ID
			'General settings', // Title
			array( $this, 'print_section_info' ), // Callback
			'polymer-settings' // Page
		);
		add_settings_field(
			'polymer-js-posts', // ID
			'JS in posts', // Title 
			array( $this, 'field_js_posts' ), // Callback
			'polymer-settings', // Page
			'polymer-section-general' // Section           
		);
		add_settings_field(
			'polymer-js-pages', // ID
			'JS in pages', // Title 
			array( $this, 'field_js_pages' ), // Callback
			'polymer-settings', // Page
			'polymer-section-general' // Section           
		);
	}

	function admin_menu()
	{	// action
		add_options_page(
			'Settings Admin', 
			'Polymer Components', 
			'manage_options', 
			'polymer-settings', 
			array( $this, 'create_admin_page' )
		);
	}

	function create_admin_page()
	{	// callback
?>
	<div id="polymer-settings" class="wrap">
		<?php screen_icon(); ?>
		<h2>Polymer Components</h2>
		<hr/>
		<form method="post" action="options.php">
		<?php
			settings_fields( 'polymer-settings-general' );
			do_settings_sections( 'polymer-settings' );
			submit_button();
		?>
		</form>
	</div>
<?php
	}

	function field_js_pages()
	{
		echo '<input type="checkbox" id="polymer-js-pages" name="polymer-options[polymer-js-pages]"', !empty( $this->options['polymer-js-pages'] ) ? ' checked="checked"' : '', '/> <label for="polymer-js-pages">', __('Javascript editor in pages'), '</label>';
	}

	function field_js_posts()
	{
		echo '<input type="checkbox" id="polymer-js-posts" name="polymer-options[polymer-js-posts]"', !empty( $this->options['polymer-js-posts'] ) ? ' checked="checked"' : '', '/> <label for="polymer-js-posts">', __('Javascript editor in posts'), '</label>';
	}

	function plugin_action_links( $links )
	{
		array_unshift( $links, '<a href="' . admin_url( 'options-general.php?page=polymer-settings' ) . '">'. __('Settings') . '</a>' );
		return $links;
	}

	function polymer_meta( $post )
	{
		global $polycomponents;
		$val = get_post_meta( $post->ID, 'poly_iconsets', TRUE );
		$iconsets = !empty( $val ) ? unserialize( $val ) : array();
		$groups = array();
		foreach( $polycomponents->tags as $tag => $file )
		{
			$pos = strpos( $tag, '-' );
			if( $pos > 0 ) $groups[substr( $tag, 0, $pos )][] = $tag;
		}
		echo '<div id="poly_page_options">', "\n";
		echo '<div><b>Iconsets</b>:&nbsp; <span style="font-size: 9pt">';
		foreach( $polycomponents->iconsets as $iconset => $file )
		{
			echo '<span style="padding-right: 18px"><input type="checkbox" id="chk_', $iconset, '" name="', $iconset, '"', in_array( $iconset, $iconsets ) ? ' checked="checked"' : '',' />';
			echo '<label for="chk_', $iconset, '">', $iconset, '</label></span> ';
		}
		$sep = '';
		echo "</span></div>\n<div style=\"padding-top: 10px; padding-bottom: 10px\">\n";
		foreach( $groups as $group => $tags )
		{
			$url = 'http://www.polymer-project.org/';
			if( $group == 'core' ) $url = 'http://www.polymer-project.org/docs/elements/core-elements.html';
			else if( $group == 'paper' ) $url = 'http://www.polymer-project.org/docs/elements/paper-elements.html';
			else if( $group == 'polymer' ) continue;
			//echo '<h4 style="margin: 10px 0 5px 0">', $group, ':</h4>';
			echo $sep, '<b>', $group, '</b>:&nbsp; ';
			echo '<select id="sel_', $group, '" onchange="Javascript: polyDocs( \'', $url, '\', \'', $group, '\' );" style="font-size: 9pt">';
			echo '<option>-</option>';
			foreach( $tags as $tag ) echo '<option>', $tag, '</option>';
			echo "</select>\n ";
			echo '&laquo; <a href="', $url, '" id="docs_', $group, '" target="_blank">open docs</a>';
			if( $sep == '' ) $sep = ' &nbsp;&ndash;&nbsp; ';
		}
		echo "</div>\n";
		if(      $post->post_type == 'post' ) $poly_javascript = isset( $this->options['polymer-js-posts'] ) && !empty( $this->options['polymer-js-posts'] );
		else if( $post->post_type == 'page' ) $poly_javascript = isset( $this->options['polymer-js-pages'] ) && !empty( $this->options['polymer-js-pages'] );
		else $poly_javascript = FALSE;
		if( $poly_javascript )
		{
			echo '<div style="border-bottom: 1px solid #aaa; padding-bottom: 5px"><b>Javascript code</b>:</div>';
			$val = get_post_meta( $post->ID, 'poly_javascript', TRUE );
			echo '<textarea name="poly_javascript" id="poly_javascript" style="width: 100%" cols="80" rows="6">', stripslashes( $val ), '</textarea>', "\n";
		}
		echo "</div>\n";
	}

	public function print_section_info() { }

	function save_post( $post_id )
	{	// action
		global $polycomponents;
		if( wp_is_post_revision( $post_id ) ) return;
		$post = get_post( $post_id );
		$content = apply_filters( 'the_content', $post->post_content );
		///$content = do_shortcode( $post->post_content );

		$meta = array();
		$dom = str_get_dom( $content );
		foreach( $dom( '*' ) as $element )
		{
			$tag = $element->tag;
			if( isset( $polycomponents->tags[$tag] ) )
			{
				$meta[$tag] = TRUE;
				if( isset( $polycomponents->requirements[$tag] ) ) $meta[$polycomponents->requirements[$tag]] = TRUE;
				if( $element->icon !== NULL ) $meta[POLYMER_CORE_ICONS] = TRUE;
			}
		}
		update_post_meta( $post_id, 'poly_tags', serialize( array_keys( $meta ) ) );
		//update_post_meta( $post_id, 'poly_tags', sanitize_text_field( array_keys( $meta ) ) );

		$iconsets = array();
		foreach( $polycomponents->iconsets as $iconset => $file )
		{
			if( isset( $_POST[$iconset] ) && !empty( $_POST[$iconset] ) ) $iconsets[] = $iconset;
		}
		update_post_meta( $post_id, 'poly_iconsets', serialize( $iconsets ) );

		update_post_meta( $post_id, 'poly_javascript', addslashes( $_POST['poly_javascript'] ) );
	}
}

if( is_admin() ) new polymer_admin();
