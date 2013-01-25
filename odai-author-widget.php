<?php
/*
Plugin Name: Odai Author Widget
Plugin URI: http://odai.me/author-widget/
Description: Widget that displays the current post author's Gravatar photo, name, website, and biography. 
Version: 1.0.0
Author: Odai
Author URI: http://odai.me
License: GPLv2
*/

class OdaiAuthorWidget extends WP_Widget {

	function __construct() {
		parent::__construct('odai_author_widget_', 'Odai Author Widget', array('description' => __( 'A Foo Widget', 'text_domain' ),) );
	}

	function widget () {
		if(is_single()) {
		//declare the aside
		echo '<aside id="odai-author-widget" class="widget">';
		//title of the widget
		echo '<h3 class="widget-title">About the Author</h3>';
		//get author's picture
		echo get_avatar(get_the_author_meta('user_email'), '96');
		//show author's name and link to website
		echo '<br />Name:&nbsp;', get_the_author_meta('display_name');
		echo '<br />Website:&nbsp;<a href="', get_the_author_meta('user_url'), '">', get_the_author_meta('user_url'), '</a>';
		//show author biography, close aside
		echo '<p>', get_the_author_meta('description'), '</p>';
		echo '</aside>';
		}
	}
}

function odai_author_widget_register() {
	return register_widget( 'OdaiAuthorWidget' );
}

add_action( 'widgets_init', 'odai_author_widget_register' );
?>