<?php

// enqueue all themes/scripts, use 15 for the proper order
add_action( 'wp_enqueue_scripts', 'onepress_child_enqueue_styles', 15 );
function onepress_child_enqueue_styles() {
    wp_enqueue_style( 'onepress-child-style', get_stylesheet_directory_uri() . '/style.css' );
}

// hide parent theme templates
function tfc_remove_page_templates( $templates ) {
    unset( $templates['template-left-sidebar.php'] );
    unset( $templates['template-frontpage.php'] );
    unset( $templates['template-fullwidth.php'] );
    return $templates;
}
add_filter( 'theme_page_templates', 'tfc_remove_page_templates' );

/**
 * Creates Hero widget.
 */
class Hero_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'hero_widget', // Base ID
			esc_html__( 'Hero Widget', 'text_domain' ), // Name
			array( 'description' => esc_html__( 'Add a hero image', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
// 		echo $args['before_widget'];

		if ( ! empty( $instance['image'] ) ) {
			echo "<div id='hero_widget' style='background-image : url(\"" . $instance['image'] . "\") ; '>
			
			     <div id='hero_text'>
			" ;
			
			if ( ! empty( $instance['title'] ) ) {
				echo "<h3>" . apply_filters( 'widget_title', $instance['title'] ) . "</h3>";
			}
			
			echo "</div></div>" ; 
			
		}
// 		echo esc_html__( 'Hello, World!', 'text_domain' );
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'My Hero Widget', 'text_domain' );
		$image = ! empty( $instance['image'] ) ? $instance['image'] : esc_html__( 'My Hero Image', 'text_domain' );
		?>
		<p>
		
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
		    <?php esc_attr_e( 'Hero Title:', 'text_domain' ); ?>
		</label> 
		
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		
		</p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>">
		    <?php esc_attr_e( 'Image URL:', 'text_domain' ); ?>
		</label> 
		
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" type="text" value="<?php echo $image; ?>">
		
		</p>
		
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['image'] = ( ! empty( $new_instance['image'] ) ) ?  : '';


		return $instance;
	}

} // class Foo_Widget

// register Foo_Widget widget
function register_hero_widget() {
    register_widget( 'Hero_Widget' );
}
add_action( 'widgets_init', 'register_hero_widget' );

/* End hero widget */

/**
 * Register our sidebars and widgetized areas.
 *
 */
function arphabet_widgets_init() {

	register_sidebar( array(
		'name'          => 'Hero Image',
		'id'            => 'hero_image',
		'before_widget' => '<div id="hero_image">',
		'after_widget'  => '</div>',
	) );

}
add_action( 'widgets_init', 'arphabet_widgets_init' );



?>



