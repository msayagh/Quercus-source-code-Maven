<?php
/* wppa-searchwidget.php
* Package: wp-photo-album-plus
*
* display the search widget
* Version 6.3.11
*
*/

class SearchPhotos extends WP_Widget {
    /** constructor */
    function __construct() {
		$widget_ops = array('classname' => 'wppa_search_photos', 'description' => __( 'WPPA+ Search Photos', 'wp-photo-album-plus') );	//
		parent::__construct('wppa_search_photos', __('Search Photos', 'wp-photo-album-plus'), $widget_ops);															//
    }

	/** @see WP_Widget::widget */
    function widget($args, $instance) {
		global $widget_content;
		global $wpdb;

		require_once(dirname(__FILE__) . '/wppa-links.php');
		require_once(dirname(__FILE__) . '/wppa-styles.php');
		require_once(dirname(__FILE__) . '/wppa-functions.php');
		require_once(dirname(__FILE__) . '/wppa-thumbnails.php');
		require_once(dirname(__FILE__) . '/wppa-boxes-html.php');
		require_once(dirname(__FILE__) . '/wppa-slideshow.php');
		wppa_initialize_runtime();

		wppa( 'mocc', wppa( 'mocc' ) + 1 );
		wppa( 'in_widget', 'search' );

        extract( $args );

		$instance = wp_parse_args( (array) $instance, array( 'title' => __('Search Photos', 'wp-photo-album-plus'), 'label' => '', 'root' => false, 'sub' => false ) );

 		$widget_title = apply_filters('widget_title', $instance['title']);

		// Display the widget
		echo $before_widget;

		if ( ! empty( $widget_title ) ) { echo $before_title . $widget_title . $after_title; }

		echo wppa_get_search_html( $instance['label'], $instance['sub'], $instance['root'] );

		echo $after_widget;

		wppa( 'in_widget', false );
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['label'] = $new_instance['label'];
		$instance['root']  = $new_instance['root'];
		$instance['sub']   = $new_instance['sub'];

        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => __('Search Photos', 'wp-photo-album-plus'), 'label' => '', 'root' => false, 'sub' => false ) );
		$title = $instance['title'];
		$label = $instance['label'];
		$root  = $instance['root'];
		$sub   = $instance['sub'];
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">
				<?php _e('Title:', 'wp-photo-album-plus'); ?>
			</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('label'); ?>">
				<?php _e('Text:', 'wp-photo-album-plus');  ?>
			</label>
			<input class="widefat" id="<?php echo $this->get_field_id('label'); ?>" name="<?php echo $this->get_field_name('label'); ?>" type="text" value="<?php echo esc_attr($label) ?>" />
		</p>
		<small><?php _e('Enter optional text that will appear before the input box. This may contain HTML so you can change font size and color.', 'wp-photo-album-plus'); ?></small>
		<p>
			<input type="checkbox" <?php if ( $root ) echo 'checked="checked"' ?> id="<?php echo $this->get_field_id('root'); ?>" name="<?php echo $this->get_field_name('root'); ?>" />
			<label for="<?php echo $this->get_field_id('root'); ?>">
				<?php _e('Enable rootsearch', 'wp-photo-album-plus'); ?>
			</label>
		</p>
		<p>
			<input type="checkbox" <?php if ( $sub ) echo 'checked="checked"' ?> id="<?php echo $this->get_field_id('sub'); ?>" name="<?php echo $this->get_field_name('sub'); ?>" />
			<label for="<?php echo $this->get_field_id('sub'); ?>">
				<?php _e('Enable subsearch', 'wp-photo-album-plus'); ?>
			</label>
		</p>
<?php
    }

} // class SearchPhotos

// register SearchPhotos widget
add_action('widgets_init', 'wppa_register_SearchPhotos' );

function wppa_register_SearchPhotos() {
	register_widget("SearchPhotos");
}
