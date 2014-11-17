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
		wp_register_script( 'poly-admin-codemirror-css', plugin_dir_url( __FILE__ ) . 'codemirror/css.js', array() );
		wp_enqueue_script( 'poly-admin-scripts' );
		wp_enqueue_script( 'poly-admin-codemirror' );
		wp_enqueue_script( 'poly-admin-codemirror-js' );
		wp_enqueue_script( 'poly-admin-codemirror-css' );
	// Settings
		register_setting(
			'polymer-settings-general',
			'polymer-options'
			//, array( $this, 'sanitize' ) // Sanitize
		);
		add_settings_section(
			'polymer-section-general',
			'General settings',
			array( $this, 'print_section_info' ),
			'polymer-settings'
		);
		add_settings_field(
			'polymer-css-posts',
			'CSS in posts',
			array( $this, 'field_css_posts' ),
			'polymer-settings',
			'polymer-section-general'
		);
		add_settings_field(
			'polymer-css-pages',
			'CSS in pages',
			array( $this, 'field_css_pages' ),
			'polymer-settings',
			'polymer-section-general'
		);
		add_settings_field(
			'polymer-js-posts',
			'JS in posts',
			array( $this, 'field_js_posts' ),
			'polymer-settings',
			'polymer-section-general'
		);
		add_settings_field(
			'polymer-js-pages',
			'JS in pages',
			array( $this, 'field_js_pages' ),
			'polymer-settings',
			'polymer-section-general'
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
		<div>Polymer version provided: <b><?php echo POLYMER_VERSION; ?></b></div>
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

	function field_css_pages()
	{
		echo '<input type="checkbox" id="polymer-css-pages" name="polymer-options[polymer-css-pages]"', !empty( $this->options['polymer-css-pages'] ) ? ' checked="checked"' : '', '/> <label for="polymer-css-pages">', __('Styles editor in pages'), '</label>';
	}

	function field_css_posts()
	{
		echo '<input type="checkbox" id="polymer-css-posts" name="polymer-options[polymer-css-posts]"', !empty( $this->options['polymer-css-posts'] ) ? ' checked="checked"' : '', '/> <label for="polymer-css-posts">', __('Styles editor in posts'), '</label>';
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
		$autop = get_post_meta( $post->ID, 'poly_autop', TRUE );
		$template = get_post_meta( $post->ID, 'poly_template', TRUE );
		$groups = array();
		foreach( $polycomponents->tags as $tag => $file )
		{
			$pos = strpos( $tag, '-' );
			if( $pos > 0 ) $groups[substr( $tag, 0, $pos )][] = $tag;
		}
	// --- Docs ---
		echo '<div style="padding-top: 10px">';
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
	// --- Options ---
		echo '<div id="poly_page_options">', "\n";
		echo '<div style="padding-top: 10px">';
		echo '<label for="poly_autop"><b>Enable autop</b>:</label> <input type="checkbox" id="poly_autop" name="poly_autop"', empty( $autop ) ? '' : ' checked="checked"', '/> &ndash; ';
		echo '<label for="poly_template"><b>Override template</b>:</label> <input type="checkbox" id="poly_template" name="poly_template"', empty( $template ) ? '' : ' checked="checked"', '/>';
		echo '</div><div style="padding-top: 10px"><b>Import iconsets</b>:&nbsp; <span style="font-size: 9pt">';
		foreach( $polycomponents->iconsets as $iconset => $file )
		{
			echo '<span style="padding-right: 18px"><input type="checkbox" id="chk_', $iconset, '" name="', $iconset, '"', in_array( $iconset, $iconsets ) ? ' checked="checked"' : '',' />';
			echo '<label for="chk_', $iconset, '">', $iconset, '</label></span> ';
		}
		$sep = '';
		echo "</span></div>\n";
	// --- JS editor ---
		if(      $post->post_type == 'post' ) $poly_javascript = isset( $this->options['polymer-js-posts'] ) && !empty( $this->options['polymer-js-posts'] );
		else if( $post->post_type == 'page' ) $poly_javascript = isset( $this->options['polymer-js-pages'] ) && !empty( $this->options['polymer-js-pages'] );
		else $poly_javascript = FALSE;
		if( $poly_javascript )
		{
			echo '<div style="border-bottom: 1px solid #aaa; padding-top: 10px; padding-bottom: 5px"><b>Javascript code</b>:</div>';
			$val = get_post_meta( $post->ID, 'poly_javascript', TRUE );
			echo '<textarea name="poly_javascript" id="poly_javascript" style="width: 100%" cols="80" rows="6">', stripslashes( $val ), '</textarea>', "\n";
		}
	// --- CSS editor ---
		if(      $post->post_type == 'post' ) $poly_styles = isset( $this->options['polymer-css-posts'] ) && !empty( $this->options['polymer-css-posts'] );
		else if( $post->post_type == 'page' ) $poly_styles = isset( $this->options['polymer-css-pages'] ) && !empty( $this->options['polymer-css-pages'] );
		else $poly_styles = FALSE;
		if( $poly_styles )
		{
			echo '<div style="border-bottom: 1px solid #aaa; padding-top: 10px; padding-bottom: 5px"><b>Styles</b>:</div>';
			$val = get_post_meta( $post->ID, 'poly_styles', TRUE );
			echo '<textarea name="poly_styles" id="poly_styles" style="width: 100%" cols="80" rows="6">', stripslashes( $val ), '</textarea>', "\n";
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

		update_post_meta( $post_id, 'poly_autop', isset( $_POST['poly_autop'] ) && !empty( $_POST['poly_autop'] ) );
		update_post_meta( $post_id, 'poly_template', isset( $_POST['poly_template'] ) && !empty( $_POST['poly_template'] ) );

		$iconsets = array();
		foreach( $polycomponents->iconsets as $iconset => $file )
		{
			if( isset( $_POST[$iconset] ) && !empty( $_POST[$iconset] ) ) $iconsets[] = $iconset;
		}
		update_post_meta( $post_id, 'poly_iconsets', serialize( $iconsets ) );
		update_post_meta( $post_id, 'poly_javascript', ( isset( $_POST['poly_javascript'] ) && !empty( $_POST['poly_javascript'] ) ) ? addslashes( $_POST['poly_javascript'] ) : '' );
		update_post_meta( $post_id, 'poly_styles', ( isset( $_POST['poly_styles'] ) && !empty( $_POST['poly_styles'] ) ) ? addslashes( $_POST['poly_styles'] ) : '' );
	}
}

if( is_admin() ) new polymer_admin();
