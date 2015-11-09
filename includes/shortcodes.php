<?php
/**
* Shortcodes
*
* Define the various shortcodes
*
* @package	YouTube-Embed
* @since	2.0
*/

/**
* Default Video shortcode
*
* Main [youtube] shortcode to display video
*
* @since	2.0
*
* @uses		vye_video_shortcode			Action the shortcode parameters
*
* @param    string		$paras			Shortcode parameters
* @param	string		$content		Shortcode content
* @return   string						YouTube embed code
*/

function vye_video_shortcode_default( $paras = '', $content = '' ) {
	return do_shortcode( vye_video_shortcode( $paras, $content ) );
}

add_shortcode( 'youtube', 'vye_video_shortcode_default' );

/**
* Alternative Video shortcode 1
*
* 1st alternative shortcode to display video
*
* @since	2.0
*
* @uses		vye_video_shortcode			Action the shortcode parameters
*
* @param    string		$paras			Shortcode parameters
* @param	string		$content		Shortcode content
* @return   string						YouTube embed code
*/

function vye_video_shortcode_alt( $paras = '', $content = '' ) {
	return do_shortcode( vye_video_shortcode( $paras, $content, '', true ) );
}
$shortcode = vye_set_shortcode_option();
if ( isset( $shortcode ) && $shortcode != '' ) { add_shortcode( $shortcode, 'vye_video_shortcode_alt' ); }

/**
* Video shortcode
*
* Use shortcode parameters to embed a YouTube video or playlist
*
* @since	2.0
*
* @uses		vye_get_embed_type			Get the embed type
* @uses		vye_set_autohide			Get the autohide parameter
* @uses     vye_set_general_defaults    Set default options
* @uses		vye_generate_youtube_code	Generate the embed code
*
* @param    string		$paras			Shortcode parameters
* @param	string		$content		Shortcode content
* @param	string		$alt_shortcode	The number of the alternative shortcode used
* @return   string						YouTube embed code
*/

function vye_video_shortcode( $paras = '', $content = '', $callback = '', $alt_shortcode = false ) {

	extract( shortcode_atts( array( 'width' => '', 'height' => '', 'fullscreen' => '', 'related' => '', 'autoplay' => '', 'loop' => '', 'start' => '', 'info' => '', 'annotation' => '', 'cc' => '', 'style' => '', 'stop' => '', 'disablekb' => '', 'ratio' => '', 'autohide' => '', 'controls' => '', 'profile' => '', 'id' => '', 'url' => '', 'rel' => '', 'fs' => '', 	'cc_load_policy' => '', 'iv_load_policy' => '', 'showinfo' => '', 'youtubeurl' => '', 'template' => '', 'list' => '', 'color' => '', 'theme' => '', 'ssl' => '', 'height' => '', 'width' => '', 'dynamic' => '', 'h' => '', 'w' => '', 'search' => '', 'user' => '', 'modest' => '' ), $paras ) );

	// If no profile specified and an alternative shortcode used, get that shortcodes default profile

	if ( ( $profile == '' ) && ( $alt_shortcode ) ) {

		// Get general options

		$options = vye_set_general_defaults();
		$profile = $options[ 'alt_profile' ];
	}

	// If an alternative field is set, use it

	if ( ( $id != '' ) && ( $content == '' ) ) { $content = $id; }
	if ( ( $url != '' ) && ( $content == '' ) ) { $content = $url; }
	if ( ( $youtubeurl != '' ) && ( $content == '' ) ) { $content = $youtubeurl; }

	if ( ( $h != '' ) && ( $height == '' ) ) { $height = $h; }
	if ( ( $w != '' ) && ( $width == '' ) ) { $width = $w; }

	if ( ( $rel != '' ) && ( $related == '' ) ) { $related = $rel;}
	if ( ( $fs != '' ) && ( $fullscreen == '' ) ) { $fullscreen = $fs;}
	if ( ( $cc_load_policy != '' ) && ( $cc == '' ) ) { $cc = $cc_load_policy;}
	if ( ( $iv_load_policy != '' ) && ( $annotation == '' ) ) { $annotation = $iv_load_policy;}
	if ( ( $showinfo != '' ) && ( $info == '' ) ) { $info = $showinfo;}

	// If ID was not passed in the content and the first parameter is set, assume that to be the ID

	if ( ( $content == '' ) && ( $paras[ 0 ] != '' ) ) {
		$content = $paras[ 0 ];
		if  ( (substr( $content, 0, 1 ) == ":" ) or ( substr( $content, 0, 1 ) == "=" ) ) { $content = substr( $content, 1 ); }

		if ( array_key_exists( 1, $paras ) ) {
			if ( $paras[ 1 ] != '' ) { $width = $paras[ 1 ]; }
		}
		if ( array_key_exists( 2, $paras ) ) {
			if ( $paras[ 2 ] != '' ) { $height = $paras[ 2 ]; }
		}
	}

	// Set up Autohide parameter

	$autohide = vye_set_autohide( $autohide );

	// Create YouTube code

	$youtube_code = vye_generate_youtube_code( $content, $width, $height, vye_convert( $fullscreen ), vye_convert( $related ), vye_convert( $autoplay ), vye_convert( $loop ), $start, vye_convert( $info ), vye_convert_3( $annotation ), vye_convert( $cc ), $style, $stop, vye_convert( $disablekb ), $ratio, $autohide, $controls, $profile, $list, $template, $color, $theme, vye_convert( $ssl ), vye_convert( $dynamic ), vye_convert( $search ), vye_convert( $user ), vye_convert( $modest ) );

	return do_shortcode( $youtube_code );
}

/**
* Return a thumbnail URL
*
* Shortcode to return the URL for a thumbnail
*
* @since	2.0
*
* @uses		vye_generate_thumbnail_code	Generate the thumbnail code
*
* @param    string		$paras			Shortcode parameters
* @param	string		$content		Shortcode content
* @return   string						YouTube thumbnail code
*/

function vye_thumbnail_sc( $paras = '', $content = '' ) {
	extract( shortcode_atts( array( 'style' => '', 'class' => '', 'rel' => '', 'target' => '', 'width' => '', 'height' => '', 'alt' => '', 'version' => '', 'nolink' => '' ), $paras ) );
	return do_shortcode( vye_generate_thumbnail_code( $content, $style, $class, $rel, $target, $width, $height, $alt, $version, $nolink ) );
}

add_shortcode( 'youtube_thumb', 'vye_thumbnail_sc' );

/**
* Short URL shortcode
*
* Generate a short URL for a YouTube video
*
* @since	2.0
*
* @uses		vye_generate_shorturl_code   Generate the code
*
* @param    string		$paras			Shortcode parameters
* @param	string		$content		Shortcode content
* @return   string						YouTube short URL code
*/

function vye_shorturl_sc( $paras = '', $content = '' ) {
	extract( shortcode_atts( array( 'id' => '' ), $paras ) );
	return do_shortcode( vye_generate_shorturl_code( $id ) );
}

add_shortcode( 'youtube_url', 'vye_shorturl_sc' );

/**
* Download shortcode
*
* Generate a short URL for a YouTube video
*
* @since	2.0
*
* @uses		vye_generate_download_code	Generate the download code
*
* @param    string		$paras			Shortcode parameters
* @param	string		$content		Shortcode content
* @return   string						YouTube download link
*/

function vye_video_download( $paras = '', $content = '' ) {

	extract( shortcode_atts( array( 'id' => '' ), $paras ) );

	// Get the download code

	$link = vye_generate_download_code( $id );

	// Now return the HTML

	return do_shortcode( $link );
}

add_shortcode( 'download_video', 'vye_video_download' );
?>