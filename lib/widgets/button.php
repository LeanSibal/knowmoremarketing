<?php
 
// Creating the widget 
class KMM_Button extends WP_Widget {
	 
	function __construct() {
		parent::__construct(
			'kmm_button', 
			'KMM Button', 'wpb_widget_domain',
			[ 'description' => 'Simple Button for KMM' ]
		);
	}
	// Creating widget front-end
	public function widget( $args, $instance ) {
		ob_start();
		$title = !empty( $instance['title'] ) ? apply_filters( 'kmm_button_widget_title', $instance['title'] ) : '';
		$link = !empty( $instance['link'] ) ? apply_filters( 'kmm_button_widget_link', $instance['link'] ) : '#';
		echo $args['before_widget'];
		?>
		<a href="<?php echo $link; ?>" class="btn gradient"><?php echo $title; ?></a>
		<?php
		echo $args['after_widget'];
		echo ob_get_clean();
	}
		 
	// Widget Backend 
	public function form( $instance ) {
		$title = !empty( $instance['title'] ) ? $instance['title'] : '';
		$link = !empty( $instance['link'] ) ? $instance['link'] : '';
		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" placeholder="Button Text"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'URL:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>" placeholder="Button Link"/>
		</p>
		<?php 
	}
	     
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
} // Class wpb_widget ends here

add_action( 'widgets_init', function(){
    register_widget( 'KMM_Button' );
});
