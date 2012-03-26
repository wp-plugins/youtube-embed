<?php
/**
* Add Scripts
*
* Add JS and CSS to the main theme and to admin
*
* @package	YouTubeEmbed
*/

/**
* Add scripts to theme
*
* Add styles and scripts to the main theme
*
* @since		2.4
*/

function ye_main_scripts() {

    wp_enqueue_script( 'ye_ga_js', plugins_url( '/youtube-embed/js/ye-gatracker.js' ) );

    wp_register_style( 'ye_dynamic', plugins_url( '/youtube-embed/css/ye-dynamic.css' ) );

    wp_enqueue_style( 'ye_dynamic' );

}

add_action( 'wp_enqueue_scripts', 'ye_main_scripts' );

/**
* Add CSS to admin
*
* Add stylesheets to the admin screens
*
* @since	2.0
*/

function ye_admin_css() {

	wp_enqueue_style( 'ye_admin', plugins_url() . '/youtube-embed/css/ye-admin.css' );

	wp_enqueue_style( 'ye_dynamic', plugins_url() . '/youtube-embed/css/ye-dynamic.css' );

	global $wp_version;
	if ( ( float ) $wp_version >= 3.2 ) { $version = ''; } else { $version = '-3.1'; }

	wp_enqueue_style( 'tinymce_button', plugins_url() . '/youtube-embed/css/ye-tinymce-button' . $version . '.css' );

}

add_action( 'admin_print_styles', 'ye_admin_css' );
?>