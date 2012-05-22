<?php
/**
* Generate Thumbnail Code
*
* Generate XHTML compatible YouTube video thumbnail
*
* @package	Artiss-YouTube-Embed
* @since	2.0
*
* @uses		aye_extract_id				Extract an ID from a string
* @uses		aye_validate_id				Confirm the type of video
* @uses		aye_error					Display an error
*
* @param    string	$id					YouTube video ID
* @param 	string	$style				Link STYLE
* @param 	string	$class				Link CLASS
* @param 	string	$rel				Link REL
* @param 	string	$target				Link target
* @param 	string	$width				Width
* @param 	string	$height				Height
* @param 	string	$alt				ALT text
* @return	string	$youtube_code		Code
*/

function aye_generate_thumbnail_code( $id, $style, $class, $rel, $target, $width, $height, $alt, $version ) {

	// Extract the ID if a full URL has been specified
	$id = aye_extract_id( $id );

	// Check what type of video it is and whether it's valid
	$embed_type = aye_validate_id( $id );

	if ( $embed_type != 'v' ) {
		if ( strlen( $embed_type ) > 1 ) {
			return aye_error( $embed_type );
		} else {
			return aye_error( sprintf( __( 'The YouTube ID of %s is invalid.' ), $id ) );
		}
	}

	$version = strtolower( $version );
	if ( ( $version != 'default' ) && ( $version != 'hq' ) && ( $version != 'start' ) && ( $version != 'middle' ) && ( $version != 'end' ) ) { $version = 'default'; }
	if ( $version == 'hq' ) { $version = 'hqdefault'; }
	if ( $version == 'start' ) { $version = 1; }
	if ( $version == 'middle' ) { $version = 2; }
	if ( $version == 'end' ) { $version = 3; }

	// Now create the required code
	if ( $alt == '' ) { $alt = 'YouTube Video ' . $id; }
	$youtube_code = '<a href="http://www.youtube.com/watch?v=' . $id . '"';
	if ( $style != '' ) { $youtube_code .= ' style="' . $style . '"'; }
	if ( $class != '' ) { $youtube_code .= ' class="' . $class . '"'; }
	if ( $rel != '' ) { $youtube_code .= ' rel="' . $rel . '"'; }
	if ( $target != '' ) { $youtube_code .= ' target="' . $target . '"'; }
	$youtube_code .= '><img src="http://img.youtube.com/vi/' . $id . '/' . $version . '.jpg"';
	if ( $width != '' ) { $youtube_code .= ' width="' . $width . 'px"'; }
	if ( $height != '' ) { $youtube_code .= ' height="' . $height . 'px"'; }
	$youtube_code .= ' alt="' . $alt . '"/></a>';

	return $youtube_code;
}
?>