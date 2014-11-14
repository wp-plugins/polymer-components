<?php
if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once( plugin_dir_path( __FILE__ ) . 'conf.php' );
require_once( plugin_dir_path( __FILE__ ) . 'inc/ganon.php' );

class Polymer_Widget extends WP_Widget
{
	public function __construct()
	{
		$widget_ops = array( 'classname' => 'widget_poly', 'description' => __('Add Polymer elements.') );
		$control_ops = array();
		parent::__construct( 'polymer_widget', __('Polymer Components'), $widget_ops, $control_ops );
		//var_dump( is_active_sidebar( is_active_widget( FALSE, FALSE, $this->id_base ) ) );
	}

	public function widget( $args, $instance )
	{
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		echo $args['before_widget'];
		if( !empty( $title ) ) echo $args['before_title'], $title, $args['after_title'];
		if( !empty( $instance['content'] ) ) echo do_shortcode( $instance['content'] );
		echo $args['after_widget'], "\n";
	}

	public function form( $instance )
	{
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'content' => '' ) );
		$title = strip_tags( $instance['title'] );
		$content = esc_textarea( $instance['content'] );
?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<textarea class="widefat" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>" rows="16" cols="20"><?php echo $content; ?></textarea>
		</p>
<?php 
	}

	public function update( $new_instance, $old_instance )
	{
		global $polycomponents;
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		if( current_user_can( 'unfiltered_html' ) ) $instance['content'] = $new_instance['content'];
		else $instance['content'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['content'] ) ) );

		$meta = array();
		$dom = str_get_dom( do_shortcode( $new_instance['content'] ) );
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
		$instance['tags'] = serialize( array_keys( $meta ) );

		return $instance;
	}
}
