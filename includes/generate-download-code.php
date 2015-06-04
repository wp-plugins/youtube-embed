<?php
/**
* Generate Download Code
*
* Create code to allow a YouTube video to be downloaded
*
* @package	YouTube-Embed
* @since	2.0
*
* @uses		vye_extract_id				Extract an ID from a string
* @uses		vye_validate_id				Confirm the type of video
* @uses		vye_error					Display an error
*
* @param    string	$id					YouTube video ID
* @return	string						Download HTML
*/

function vye_generate_download_code( $id ) {
	
	if ( $id == '' ) { return vye_error( __ ( 'No YouTube ID was found.', 'youtube-embed' ) ); }

	// Extract the ID if a full URL has been specified

	$id = vye_extract_id( $id );

	// Check what type of video it is and whether it's valid

	$embed_type = vye_validate_id( $id );
	if ( $embed_type != 'v' ) {
		if ( strlen( $embed_type ) > 1 ) {
			return vye_error( $embed_type );
		} else {
			return vye_error( sprintf( __( 'The YouTube ID of %s is invalid.', 'youtube-embed' ), $id ) );
		}
	}

	// Create the link

	return 'http://www.videodownloadx.com/?video=' . $id;

}
?>