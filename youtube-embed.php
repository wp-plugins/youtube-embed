<?php
/*
Plugin Name: YouTube Embed
Plugin URI: https://wordpress.org/plugins/youtube-embed/
Description: Embed YouTube Videos in WordPress
Version: 3.3.2
Author: David Artiss
Author URI: http://www.artiss.co.uk
*/

/**
* YouTube Embed
*
* Main code - include various functions
*
* @package	YouTube-Embed
* @since	2.0
*/

define( 'youtube_embed_version', '3.3.2' );

$functions_dir = WP_PLUGIN_DIR . '/youtube-embed/includes/';

// Include all the various functions

include_once( $functions_dir . 'add-scripts.php' );     				// Add various scripts

include_once( $functions_dir . 'shared-functions.php' );				// Shared routines

include_once( $functions_dir . 'set-defaults.php' );					// Set default options

include_once( $functions_dir . 'add-to-admin-bar.php' );				// Add link to the admin bar

include_once( $functions_dir . 'function-calls.php' );					// Function calls

include_once( $functions_dir . 'generate-embed-code.php' );				// Generate YouTube embed code

include_once( $functions_dir . 'generate-download-code.php' );			// Generate download URLs

include_once( $functions_dir . 'generate-shorturl-code.php' );			// Generate short URLs

include_once( $functions_dir . 'generate-thumbnail-code.php' );			// Generate thumbnail code

include_once( $functions_dir . 'generate-transcript-code.php' );		// Generate transcripts

if ( is_admin() && !( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {

	include_once( $functions_dir . 'admin-config.php' );				// Administration configuration

	include_once( $functions_dir . 'add-mce-button.php' );				// Editor button

} else {

	include_once( $functions_dir . 'generate-comments-code.php' );		// Generate video comments

	include_once( $functions_dir . 'update-post-content.php' );			// Process post content

	include_once( $functions_dir . 'shortcodes.php' );					// Shortcodes

}

include_once($functions_dir . 'generate-widgets.php');                  // Generate widgets

?>