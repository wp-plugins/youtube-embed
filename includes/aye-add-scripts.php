<?php
/**
* Add Scripts
*
* Add JS and CSS to the main theme and to admin
*
* @package	Artiss-YouTube-Embed
*/

/**
* Add scripts to theme
*
* Add styles and scripts to the main theme
*
* @since		2.4
*/

function aye_main_scripts() {

    wp_enqueue_script( 'aye_ga_js', plugins_url( '/youtube-embed/js/aye-ga-tracker.js' ) );

    wp_register_style( 'aye_dynamic', plugins_url( '/youtube-embed/css/aye-dynamic.css' ) );

    wp_enqueue_style( 'aye_dynamic' );

}

add_action( 'wp_enqueue_scripts', 'aye_main_scripts' );

/**
* Add CSS to admin
*
* Add stylesheets to the admin screens
*
* @since	2.0
*/

function aye_admin_css() {

	wp_enqueue_style( 'aye_admin', plugins_url() . '/youtube-embed/css/aye-admin.css' );

	wp_enqueue_style( 'aye_dynamic', plugins_url() . '/youtube-embed/css/aye-dynamic.css' );

	global $wp_version;
	if ( ( float ) $wp_version >= 3.2 ) { $version = ''; } else { $version = '-3.1'; }

	wp_enqueue_style( 'tinymce_button', plugins_url() . '/youtube-embed/css/aye-tinymce-button' . $version . '.css' );

}

add_action( 'admin_print_styles', 'aye_admin_css' );
?>