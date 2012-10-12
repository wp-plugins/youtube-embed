<?php
/**
* Uninstaller
*
* Uninstall the plugin by removing any options from the database
*
* @package	Artiss-YouTube-Embed
* @since	2.0
*/

// If the uninstall was not called by WordPress, exit

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) { exit(); }

// Read the general options (will tell us how many profile and list options there should be

$options = get_option( 'youtube_embed_general' );

// If the general options existed, delete it!

if ( is_array( $options ) ) {
	delete_option( 'youtube_embed_general' );

	// If the number of profiles field exists, delete each one in turn

	if ( array_key_exists( 'profile_no', $options ) ) {
		$loop = 0;
		while ( $loop <= $options[ 'profile_no' ] ) {
			delete_option( 'youtube_embed_profile' . $loop );
			$loop ++;
		}
	}

	// If the number of lists field exists, delete each one in turn

	if ( !array_key_exists( 'list_no', $options ) ) {
		$loop = 1;
		while ( $loop <= $options[ 'list_no' ] ) {
			delete_option( 'youtube_embed_list' . $loop );
			$loop ++;
		}
	}
}

// Delete all other options

delete_option( 'widget_youtube_embed_widget' );

delete_option( 'youtube_embed_general' );
delete_option( 'youtube_embed_shortcode' );
delete_option( 'youtube_embed_url' );
delete_option( 'youtube_embed_editor_sc' );
delete_option( 'youtube_embed_activated' );

// Delete cookie

setcookie ( 'aye_mce_shortcode', '', time() - 3600, aye_get_cookie_path() );
?>