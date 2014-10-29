<?php
class polymer_admin
{
	function __construct()
	{
	// --- Actions ---
		add_action( 'add_meta_boxes', array( &$this, 'add_meta_boxes' ) );
		add_action( 'admin_init', array( &$this, 'admin_init' ) );
		add_action( 'save_post', array( &$this, 'save_post' ) );
	}

	function add_meta_boxes()
	{	// action
		add_meta_box( 'polymer_meta', __( 'Polymer components', 'liquid-theme' ), array( &$this, 'polymer_meta' ), 'post', 'normal', 'high' );
		add_meta_box( 'polymer_meta', __( 'Polymer components', 'liquid-theme' ), array( &$this, 'polymer_meta' ), 'page', 'normal', 'high' );
	}

	function admin_init()
	{
		wp_register_script( 'poly-admin-scripts', plugin_dir_url( __FILE__ ) . 'polymer-components-admin.js', array() );
		wp_enqueue_script( 'poly-admin-scripts' );
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
		echo '<h4 style="margin: 10px 0 5px 0">Iconsets:</h4><div style="font-size: 9pt">';
		foreach( $polycomponents->iconsets as $iconset => $file )
		{
			echo '<span style="padding-right: 18px"><input type="checkbox" id="chk_', $iconset, '" name="', $iconset, '"', in_array( $iconset, $iconsets ) ? ' checked="checked"' : '',' />';
			echo '<label for="chk_', $iconset, '">', $iconset, '</label></span> ';
		}
		echo "</div><hr/>\n";
		foreach( $groups as $group => $tags )
		{
			$url = 'http://www.polymer-project.org/';
			if( $group == 'core' ) $url = 'http://www.polymer-project.org/docs/elements/core-elements.html';
			else if( $group == 'paper' ) $url = 'http://www.polymer-project.org/docs/elements/paper-elements.html';
			echo '<h4 style="margin: 10px 0 5px 0">', $group, ':</h4><select id="sel_', $group, '" onchange="Javascript: polyDocs( \'', $url, '\', \'', $group, '\' );" style="font-size: 9pt">';
			echo '<option>-</option>';
			foreach( $tags as $tag ) echo '<option>', $tag, '</option>';
			echo "</select>\n ";
			echo '&laquo; <a href="', $url, '" id="docs_', $group, '" target="_blank">docs</a>';
		}
		echo "</div>\n";
	}

	function save_post( $post_id )
	{	// action
		global $polycomponents;
		if( wp_is_post_revision( $post_id ) ) return;
		$post = get_post( $post_id );
		$content = do_shortcode( $post->post_content );
		$meta = array();
		foreach( $polycomponents->tags as $tag => $include )
		{
			if( strpos( $content, '<' . $tag ) !== FALSE )
			{
				$meta[$tag] = TRUE;
				if( isset( $polycomponents->requirements[$tag] ) ) $meta[$polycomponents->requirements[$tag]] = TRUE;
			}
		}
		update_post_meta( $post_id, 'poly_tags', serialize( array_keys( $meta ) ) );
		//update_post_meta( $post_id, 'poly_tags', sanitize_text_field( $_REQUEST['book_author'] ) );

		$iconsets = array();
		foreach( $polycomponents->iconsets as $iconset => $file )
		{
			if( isset( $_POST[$iconset] ) && !empty( $_POST[$iconset] ) ) $iconsets[] = $iconset;
		}
		update_post_meta( $post_id, 'poly_iconsets', serialize( $iconsets ) );

		//var_dump( $_POST ); exit;
		/* if( isset( $_POST['lq_body_padding_top'] ) )
		{
			$val = intval( $_POST['lq_body_padding_top'] );
			if( $val < 0 ) $val = -1;
			update_post_meta( $post_id, 'lq_body_padding_top', $val );
		} */
	}
}

if( is_admin() ) new polymer_admin();
