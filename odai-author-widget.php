<?php
;/*
Plugin Name: Odai Author Widget
Plugin URI: http://odai.me/author-widget/
Description: Widget that displays the current post author's Gravatar photo, name, website, and biography. 
Version: 1.1.0
Author: Odai
Author URI: http://odai.me
License: GPLv2
*/

//establish the widget
add_action( 'widgets_init', 'odai_author_widget_register' );

function odai_author_widget_register() {
	return register_widget( 'OdaiAuthorWidget' );
	}
	
//adding options to the database
register_activation_hook( __FILE__, 'odai_aw_add_options' );
register_deactivation_hook( __FILE__, 'odai_aw_remove_options' );

function odai_aw_add_options () {
		update_option('odai_aw_title', 'About the Author');
	}
	
function odai_aw_remove_options () {
		delete_option('odai_aw_title');
	}

//the actual widget

class OdaiAuthorWidget extends WP_Widget {

	function __construct() {
		parent::__construct('odai_author_widget_', 'Odai Author Widget', array('description' => __( "Displays post author's Gravatar photo and biographical info", 'text_domain' ),) );
	}

	function widget ( $args, $instance ) {
		extract( $args );
		$title = $before_title . $instance['title'] . $after_title;
		$pic_size = $instance['pic_size'];
		/*$name = $instance['aw_name'];*/
		
		if(is_single()) {
		?>
		<aside id="odai-author-widget" class="widget">
		<?php echo $before_title ?>
		<h3 class="widget-title"><?php echo $title; ?></h3>
		<?php echo $after_title ?>
		<?php echo get_avatar(get_the_author_meta('user_email'), $pic_size); ?>
		<p><a href="<?php the_author_meta('user_url'); ?>"><?php the_author_meta('display_name'); ?></a></p>
		<p><?php the_author_meta('description'); ?></p>
		<p><a href="<?php echo get_author_posts_url( get_the_author_meta('id')); ?>">More posts by <?php the_author_meta('display_name'); ?>&nbsp;&rarr;</a></p>
		</aside>
		<?php
		}
	}
	
	//updates widget options
	function update($new_instance,$old_instance) {
		$instance = array( 'aw_name' => 0 );
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['pic_size'] = strip_tags( $new_instance['pic_size'] );
		/*$instance['aw_name'] = $new_instance['aw_name'] ;*/

		return $instance;
	}
	
	//controls widget options form
	function form ($config) {
		?>
    		<label for='<?php echo $this->get_field_id("title"); ?>'>
    		<p>Title: <input type="text"  value="<?php echo $config['title']; ?>" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title') ?>" /></p>
    		</label>
    		<label for='<?php echo $this->get_field_id("pic_size"); ?>'>
    		<p>Photo Size: <input type="text"  value="<?php echo $config['pic_size']; ?>" name="<?php echo $this->get_field_name('pic_size'); ?>" id="<?php echo $this->get_field_id('pic_size') ?>" size="3" />pixels</p>
    		</label>	
		<?php   
	}
}