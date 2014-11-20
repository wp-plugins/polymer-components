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
		add_action( 'admin_head', array( &$this, 'admin_head' ) );
		add_action( 'admin_init', array( &$this, 'admin_init' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'save_post', array( &$this, 'save_post' ) );
	// --- Filters ---
		add_filter( 'plugin_action_links_' . POLYMER_COMPONENTS_MAIN, array( &$this, 'plugin_action_links' ), 10, 1 );
		add_filter( 'user_can_richedit', array( &$this, 'user_can_richedit' ) );
	}

	function add_meta_boxes()
	{	// action
		add_meta_box( 'polymer_meta', __( 'Polymer Components', 'liquid-theme' ), array( &$this, 'polymer_meta' ), 'post', 'normal', 'high' );
		add_meta_box( 'polymer_meta', __( 'Polymer Components', 'liquid-theme' ), array( &$this, 'polymer_meta' ), 'page', 'normal', 'high' );
	}

	function admin_head()
	{
		global $post;
		if( get_post_type( $post ) === 'block' ) remove_action( 'media_buttons', 'media_buttons' );
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
	// --- Blocks ---
		$blocks = array( 0 => '-' );
		$args = array( 'post_type' => 'block', 'order' => 'ASC', 'orderby' => 'title' );
		$query1 = new WP_Query( $args );
		while( $query1->have_posts() )
		{
			$query1->the_post();
			$blocks[get_the_ID()] = get_the_title();
		}
		wp_reset_postdata();
	// ---
//		$val = get_post_meta( $post->ID, 'poly_iconsets', TRUE );
//		$iconsets = !empty( $val ) ? unserialize( $val ) : array();
		$poly_autop = get_post_meta( $post->ID, 'poly_autop', TRUE );
		$poly_template = get_post_meta( $post->ID, 'poly_template', TRUE );
		$poly_blocks = get_post_meta( $post->ID, 'poly_blocks', TRUE );
		if( empty( $poly_blocks ) ) $poly_blocks = array();
		$poly_iconsets = get_post_meta( $post->ID, 'poly_iconsets', TRUE );
		if( empty( $poly_iconsets ) ) $poly_iconsets = array();
		$groups = array();
		foreach( $polycomponents->tags as $tag => $file )
		{
			$pos = strpos( $tag, '-' );
			if( $pos > 0 ) $groups[substr( $tag, 0, $pos )][] = $tag;
		}
		wp_nonce_field( 'polymer_meta', 'polymer_meta_nonce' );
		echo '<div id="poly-page-options">', "\n";
	// --- Docs ---
		$sep = '';
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
	// --- Imports & options ---
		echo '<div class="grp"><label for="poly_blocks">Import blocks:</label><br/><select id="poly_blocks" name="poly_blocks[]" multiple>';
		foreach( $blocks as $id => $block ) echo '<option value="', $id, '"', in_array( $id, $poly_blocks ) ? ' selected="selected"' : '', '>', $block, '</option>';
		echo "</select></div>\n";
		echo '<div class="grp"><label for="poly_iconsets">Import iconsets:</label><br/><select id="poly_iconsets" name="poly_iconsets[]" multiple><option value="">-</option>';
		foreach( $polycomponents->iconsets as $iconset => $file ) echo '<option value="', $iconset, '"', in_array( $iconset, $poly_iconsets ) ? ' selected="selected"' : '', '>', $iconset, '</option>';
		echo "</select></div>\n";
		echo '<div class="grp"><b>Options:</b><br/>';
		echo '<input type="checkbox" id="poly_autop" name="poly_autop"', empty( $poly_autop ) ? '' : ' checked="checked"', '/> <label for="poly_autop">Enable autop</label><br/>';
		echo '<input type="checkbox" id="poly_template" name="poly_template"', empty( $poly_template ) ? '' : ' checked="checked"', '/> <label for="poly_template">Override template</label>';
		echo "</div>\n"; 
		echo "<div style=\"clear:both\"></div>\n";

		/* echo '<div style="padding-top: 10px"><b>Import iconsets</b>:&nbsp; <span style="font-size: 9pt">';
		foreach( $polycomponents->iconsets as $iconset => $file )
		{
			echo '<span style="padding-right: 18px"><input type="checkbox" id="chk_', $iconset, '" name="', $iconset, '"', in_array( $iconset, $iconsets ) ? ' checked="checked"' : '',' />';
			echo '<label for="chk_', $iconset, '">', $iconset, '</label></span> ';
		}
		echo "</span></div>\n"; */

	// --- JS editor ---
		if(      $post->post_type == 'post' ) $poly_javascript = isset( $this->options['polymer-js-posts'] ) && !empty( $this->options['polymer-js-posts'] );
		else if( $post->post_type == 'page' ) $poly_javascript = isset( $this->options['polymer-js-pages'] ) && !empty( $this->options['polymer-js-pages'] );
		else $poly_javascript = FALSE;
		if( $poly_javascript )
		{
			echo '<div style="border-bottom: 1px solid #aaa; padding-top: 10px; padding-bottom: 5px"><b>Javascript code (in head)</b>:</div>';
			$val = get_post_meta( $post->ID, 'poly_javascript', TRUE );
			echo '<textarea name="poly_javascript" id="poly_javascript" style="width: 100%" cols="80" rows="6">', stripslashes( $val ), '</textarea>', "\n";
		}
	// --- CSS editor ---
		if(      $post->post_type == 'post' ) $poly_styles = isset( $this->options['polymer-css-posts'] ) && !empty( $this->options['polymer-css-posts'] );
		else if( $post->post_type == 'page' ) $poly_styles = isset( $this->options['polymer-css-pages'] ) && !empty( $this->options['polymer-css-pages'] );
		else $poly_styles = FALSE;
		if( $poly_styles )
		{
			echo '<div style="border-bottom: 1px solid #aaa; padding-top: 10px; padding-bottom: 5px"><b>Styles (in head)</b>:</div>';
			$val = get_post_meta( $post->ID, 'poly_styles', TRUE );
			echo '<textarea name="poly_styles" id="poly_styles" style="width: 100%" cols="80" rows="6">', stripslashes( $val ), '</textarea>', "\n";
		}
	// ---
		echo "</div>\n";
	}

	public function print_section_info() { }

	function save_post( $post_id )
	{	// action
		global $polycomponents;
		if( !isset( $_POST['polymer_meta_nonce'] ) ) return;                              // --- Return if nonce is not set
		if( !wp_verify_nonce( $_POST['polymer_meta_nonce'], 'polymer_meta' ) ) return;    // --- Return if nonce is not valid
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;                       // --- Return if this is an autosave
		if( isset( $_POST['post_type'] ) && $_POST['post_type'] == 'page' )               // --- Check the user's permissions
		{
			if( !current_user_can( 'edit_page', $post_id ) ) return;
		}
		else
		{
			if( !current_user_can( 'edit_post', $post_id ) ) return;
		}
		if( wp_is_post_revision( $post_id ) ) return;
	// --- //
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
		//update_post_meta( $post_id, 'poly_tags', sanitize_text_field( array_keys( $meta ) ) );
		update_post_meta( $post_id, 'poly_tags', serialize( array_keys( $meta ) ) );
		update_post_meta( $post_id, 'poly_blocks', isset( $_POST['poly_blocks'] ) ? $_POST['poly_blocks'] : array() );
		update_post_meta( $post_id, 'poly_iconsets', isset( $_POST['poly_iconsets'] ) ? $_POST['poly_iconsets'] : array() );
		update_post_meta( $post_id, 'poly_autop', isset( $_POST['poly_autop'] ) && !empty( $_POST['poly_autop'] ) );
		update_post_meta( $post_id, 'poly_template', isset( $_POST['poly_template'] ) && !empty( $_POST['poly_template'] ) );
		update_post_meta( $post_id, 'poly_javascript', ( isset( $_POST['poly_javascript'] ) && !empty( $_POST['poly_javascript'] ) ) ? addslashes( $_POST['poly_javascript'] ) : '' );
		update_post_meta( $post_id, 'poly_styles', ( isset( $_POST['poly_styles'] ) && !empty( $_POST['poly_styles'] ) ) ? addslashes( $_POST['poly_styles'] ) : '' );
	}

	function user_can_richedit( $default )
	{	// filter
		global $post;
		return ( ( get_post_type( $post ) !== 'block' ) ? $default : FALSE );
	}
}

if( is_admin() ) new polymer_admin();
