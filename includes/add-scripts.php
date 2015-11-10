<?php
/**
* Add Scripts
*
* Add JS and CSS to the main theme and to admin
*
* @package	YouTube-Embed
*/

// Switch on shortcodes in widgets, if requested

if ( !is_admin() ) {
	$options = get_option( 'youtube_embed_general' );
	if ( $options[ 'widgets' ] == 1 ) { add_filter( 'widget_text', 'do_shortcode' ); }
}

/**
* Plugin initialisation
*
* Loads the plugin's translated strings and the plugins' JavaScript
*
* @since	2.5.5
*/

function vye_plugin_init() {

	$language_dir = plugin_basename( dirname( __FILE__ ) ) . '/languages/';

	load_plugin_textdomain( 'youtube-embed', false, $language_dir );

}

add_action( 'init', 'vye_plugin_init' );

/**
* Add scripts to theme
*
* Add styles and scripts to the main theme
*
* @since		2.4
*/

function vye_main_scripts() {

	wp_register_style( 'vye_dynamic', plugins_url( '/youtube-embed/css/main.min.css' ) );

	wp_enqueue_style( 'vye_dynamic' );

}

add_action( 'wp_enqueue_scripts', 'vye_main_scripts' );

/**
* Add CSS to admin
*
* Add stylesheets to the admin screens
*
* @since	2.0
*/

function vye_admin_css() {

	wp_enqueue_style( 'tinymce_button', plugins_url() . '/youtube-embed/css/admin.min.css' );

}

add_action( 'admin_print_styles', 'vye_admin_css' );

/**
* Add option to Admin Bar
*
* Add link to YouTube Embed profile options to Admin Bar.
* With help from http://technerdia.com/1140_wordpress-admin-bar.html
*
* @uses     vye_set_general_default     Set default options
*
* @since	2.5
*/

function vye_admin_bar_render( $meta = TRUE ) {

	$options = vye_set_general_defaults();

	if ( $options[ 'admin_bar' ] != '' ) {

		global $wp_admin_bar;

		if ( !is_user_logged_in() ) { return; }
		if ( !is_admin_bar_showing() ) { return; }
		if ( !current_user_can( $options[ 'menu_access' ] ) ) { return; }

		$wp_admin_bar -> add_menu( array(
			'id' => 'aye-menu',
			'title' => __( 'YouTube Embed', 'youtube-embed' ) ) );

		$wp_admin_bar -> add_menu( array(
			'parent' => 'aye-menu',
			'id' => 'aye-options',
			'title' => __( 'Options', 'youtube-embed' ),
			'href' => admin_url( 'admin.php?page=ye-general-options' ),
			'meta' => array( 'target' => '_blank' ) ) );

		$wp_admin_bar -> add_menu( array(
			'parent' => 'aye-menu',
			'id' => 'aye-profile',
			'title' => __( 'Profiles', 'youtube-embed' ),
			'href' => admin_url( 'admin.php?page=ye-profile-options' ),
			'meta' => array( 'target' => '_blank' ) ) );

		$wp_admin_bar -> add_menu( array(
			'parent' => 'aye-menu',
			'id' => 'aye-lists',
			'title' => __( 'Lists', 'youtube-embed' ),
			'href' => admin_url( 'admin.php?page=ye-list-options' ),
			'meta' => array( 'target' => '_blank' ) ) );
	}
}

add_action( 'admin_bar_menu', 'vye_admin_bar_render', 99 );
?>