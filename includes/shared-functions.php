<?php
/**
* Shared Functions
*
* Small utilities shared by a number of other functions
*
* @package	YouTube-Embed
*/

/**
* Is Do Not Track active?
*
* Function to return whether Do Not Track is active in the current
* browser
*
* @since	2.6
*
* @return			    string	True or false
*/

function vye_do_not_track() {    // 1.0

	if ( isset( $_SERVER[ 'HTTP_DNT' ] ) ) {
		if ( $_SERVER[ 'HTTP_DNT' ] == 1 ) { return true; }
	} else {
		if ( function_exists( 'getallheaders' ) ) {
			foreach ( getallheaders() as $key => $value ) {
				if ( ( strtolower( $key ) === 'dnt' ) && ( $value == 1 ) ) { return true; }
			}
		}
	}
	return false;
}

/**
* Get the cookie path
*
* Work out the path for the current installation to add cookies for
*
* @since	2.6
*
* @return	string				Cookie path
*/

function vye_get_cookie_path() {

	// Remove the http:// from the beginning of the site URL

	$path = str_replace( 'http://', '', site_url( '/', 'http' ) );

	// Find the first slash in the results

	$pos = strpos( $path, '/' );

	// Strip all before the first slash

	$path = substr( $path, $pos ) . 'wp-content/';

	return $path;
}

/**
* Extract parameters (1.0)
*
* Function to extract parameters from an input string
*
* @since	2.0
*
* @param	string	$input		Input string to search through
* @param	string	$para		Parameter to look for
* @return	string				Parameter value (if found)
*/

function vye_get_parameters( $input, $para ) {

	$start = strpos( strtolower( $input ), $para . '=' );
	$content = '';

	if ( $start !== false ) {
		$start = $start + strlen( $para ) + 1;
		$end=strpos( strtolower( $input ), '&', $start );
		if ( $end !== false ) { $end = $end - 1; } else { $end = strlen( $input ); }
		$content = substr( $input, $start, $end - $start + 1 );
	}

	return $content;
}

/**
* Extract a video ID
*
* Function to extract an ID if a full URL has been supplied
*
* @since	2.0
*
* @param	string	$id		Video ID
* @return	string			Extracted ID
*/

function vye_extract_id( $id ) {

	// Convert and trim video ID characters

	$id = trim( str_replace( '&#8211;', '--', str_replace( '&#215;', 'x', strip_tags( $id ) ) ) );

	// Check if it's the full URL, as found in address bar

	$video_pos = strpos( $id, 'youtube.com/watch?', 0 );

	if ( $video_pos !== false ) {

		$video_pos = strpos( $id, 'v=', $video_pos + 18 );
		if ( $video_pos === false ) { $video_pos = strpos( $id, 'p=', $video_pos + 18 ); }

		if ( $video_pos !== false ) {

			$video_pos = $video_pos + 2;
			$ampersand_pos = strpos( $id, '&', $video_pos );
			if ( !$ampersand_pos ) {
				$id = substr( $id, $video_pos );
			} else {
				$id = substr( $id, $video_pos, $ampersand_pos - $video_pos );
			}
		}

	} else {

		// Now check to see if it's a full URL, as used in the embed code
		// Need to check both video and playlist formats

		$video_pos = strpos( $id, 'youtube.com/v/' );
		if ($video_pos === false) { $video_pos = strpos( $id, 'youtube.com/p/' ); }

		if ( $video_pos !== false ) {
			$video_pos = $video_pos + 14;
			$qmark_pos = strpos( $id, '?', $video_pos );
			if ( !$qmark_pos ) {
				$id = substr( $id, $video_pos );
			} else {
				$id = substr( $id, $video_pos, $qmark_pos - $video_pos );
			}

		} else {

			// Check if it's a shortened URL

			$video_pos = strpos( $id, 'youtu.be/', 0 );

			if ( $video_pos !== false ) {
				$video_pos = $video_pos + 9;
				$ampersand_pos = strpos( $id, '&', $video_pos );
				if ( !$ampersand_pos ) {
					$id = substr( $id, $video_pos );
				} else {
					$id = substr( $id, $video_pos, $ampersand_pos - $video_pos );
				}
			}
		}
	}

	return $id;
}

/**
* Validate video type
*
* Function to work out what type of video has been requested.
*
* @since	2.0
*
* @param	string	$id				Video ID
* @return	string					Array containing file details
*/

function vye_validate_id( $id ) {

	$type = '';
	if ( strtolower( substr( $id, 0, 2 ) ) == 'pl') {
		$type = 'p';
	} else {
		if ( strlen( $id ) == 11 ) {
			$type = 'v';
		} else {
			if ( strlen( $id ) == 16 ) {
				$type = 'p';
			}
		}
	}

	return $type;
}

/**
* Function to report an error
*
* Display an error message in a standard format
*
* @since	2.0
*
* @param	string	$errorin	Error message
* @return	string				Error output
*/

function vye_error( $errorin ) {

	return '<p style="color: #f00; font-weight: bold;">Artiss YouTube Embed: ' . $errorin . "</p>\n";

}

/**
* Convert input to a 1 or 0 equivalent
*
* Function to convert a Yes or No input to an equivalent 1 or 0 output
*
* @since	2.0
*
* @uses		vye_yes_or_no		Convert input to a true or false equivalent
*
* @param	string	$input		Input, usually Yes or No
* @return	string				1, 0 or blank, depending on input
*/

function vye_convert( $input ) {

	$input = vye_yes_or_no( $input );
	$output = '';
	if ( $input === true ) { $output = '1'; }
	if ( $input === false ) { $output = '0'; }

	return $output;
}

/**
* Convert input to a 1 or 3 equivalent
*
* Function to convert a Yes or No input to an equivalent 1 or 3 output
*
* @since	2.0
*
* @uses		vye_yes_or_no		Convert input to a true or false equivalent
*
* @param	string	$input		Input, usually Yes or No
* @return   string				1, 3 or blank, depending on input
*/

function vye_convert_3( $input ) {

	$input = vye_yes_or_no( $input );
	$output = '';
	if ( $input === true ) { $output = '1'; }
	if ( $input === false ) { $output = '3'; }

	return $output;
}

/**
* Convert input to True or False (1.0)
*
* Return true or false, depending on the input. Possible inputs are Yes, No, 0, 1, True,
* False, On, Off
*
* @since	2.0
*
* @param	string	$input		Value passed for checking
* @return	string				Blank string or boolean true, false
*/

function vye_yes_or_no( $input = '' ) {

	$input = strtolower( $input );
	if ( ( $input === true ) or ( $input == 'true' ) or ( $input == '1' ) or ( $input == 'yes' ) or ( $input == 'on' ) ) { return true; }
	if ( ( $input === false ) or ( $input == 'false' ) or ( $input == '0' ) or ( $input == 'no' ) or ( $input == 'off' ) ) { return false; }

	return;
}

/**
* Fetch a file (1.6)
*
* Use WordPress API to fetch a file and check results
* RC is 0 to indicate success, -1 a failure
*
* @since	2.0
*
* @param	string	$filein		File name to fetch
* @param	string	$header		Only get headers?
* @return	string				Array containing file contents and response
*/

function vye_get_file( $filein, $header = false ) {

	$rc = 0;
	$error = '';
	if ( $header ) {
		$fileout = wp_remote_head( $filein );
		if ( is_wp_error( $fileout ) ) {
			$error = 'Header: '.$fileout->get_error_message();
			$rc = -1;
		}
	} else {
		$fileout = wp_remote_get( $filein );
		if ( is_wp_error( $fileout ) ) {
			$error = 'Body: '.$fileout->get_error_message();
			$rc = -1;
		} else {
			if ( isset( $fileout[ 'body' ] ) ) {
				$file_return[ 'file' ] = $fileout[ 'body' ];
			}
		}
	}

	$file_return[ 'error' ] = $error;
	$file_return[ 'rc' ] = $rc;
	if ( !is_wp_error( $fileout ) ) {
		if ( isset( $fileout[ 'response' ][ 'code' ] ) ) {
			$file_return[ 'response' ] = $fileout[ 'response' ][ 'code' ];
		}
	}

	return $file_return;
}

/**
* Convert autohide parameter
*
* Convert autohide text value to a numeric equivalent
*
* @since	2.0
*
* @param	string	$autohide	Autohide parameter value
* @return	string				Autohide numeric equivalent
*/

function vye_set_autohide( $autohide ) {

	$autohide = strtolower( $autohide );
	if ( $autohide == 'no' )	{ $autohide = '0'; }
	if ( $autohide == 'yes' )	{ $autohide = '1'; }
	if ( $autohide == 'fade' )	{ $autohide = '2'; }

	return $autohide;
}

/**
* Generate a profile list
*
* Generate FORM options for the current profiles
*
* @since	2.0
*
* @param	string	$current	The current profile number
* @param	string	$total		The total number of profiles
*/

function vye_generate_profile_list( $current, $total ) {

	echo '<option value="0"';
	if ( $current == "0" ) { echo " selected='selected'"; }
	echo ' >' . __( 'Default' ) . '</option>';
	$loop = 1;
	while ( $loop <= $total ) {

		$profiles = get_option( 'youtube_embed_profile' . $loop );
		$profname = $profiles[ 'name' ];

		if ( $profname == '' ) { $profname = __( 'Profile' ) . ' ' . $loop; }
		if ( strlen( $profname ) > 30 ) { $profname = substr( $profname, 0, 30 ) . '&#8230;'; }
		echo '<option value="' . $loop . '"';

		if ( $current == $loop ) { echo " selected='selected'"; }
		echo '>' . __( $profname ) . "</option>\n";

		$loop ++;
	}

	return;
}

/**
* Extract XML (2.0)
*
* Function to extract from an XML compatible file
*
* @since
*
* @param	string	$input	The XML file
* @param	string	$tag	The tag to search for
* @return	string			The tag contents
*/

function vye_extract_xml( $input, $tag ) {

	$field = '';
	$tag = trim( $tag );

	// Find start tag

	$start_tag = strpos( $input, '<' . $tag . ' ' );
	if ( !$start_tag ) { $start_tag = strpos( $input, '<' . $tag . '>' ); }

	if ( $start_tag !== false ) {

		// Find the end of the start field

		$field_start = strpos( $input, '>', $start_tag );

		// Find the end tag

		$field_end = strpos( $input, '</' . $tag . '>' );

		// Now extract the field

		if ( ( $field_start !== false ) && ( $field_start !== false ) ) {
			$field = substr( $input, $field_start + 1, $field_end - $field_start - 1 );
		}
	}

	return $field;
}

/**
* Function to set Shortcode option
*
* Looks up shortcode option - if it's not set, assign a default
*
* @since	2.0
*
* @return   string		Alternative Shortcode
*/

function vye_set_shortcode_option() {

	$shortcode = get_option( 'youtube_embed_shortcode' );

	// If an array, transform to new format

	if ( is_array( $shortcode ) ) {
		$shortcode = $shortcode[ 1 ];
		update_option( 'youtube_embed_shortcode', $shortcode );
	}

	// If setting doesn't exist, set defaults

	if ( $shortcode == '' ) {
		$shortcode = 'youtube_video';
		update_option( 'youtube_embed_shortcode', $shortcode );
	}

	return $shortcode;
}

/**
* Function to set general YouTube options
*
* Looks up options. If none exist, or some are missing, set default values
*
* @since	2.0
*
* @return   strings		Options array
*/

function vye_set_general_defaults() {

	$options = get_option( 'youtube_embed_general' );
	$changed = false;
	$default_error = '<p>' . __( 'The video cannot be shown at the moment. Please try again later.', 'youtube-embed' ) . '</p>';

	// If the old options exist, import them and then delete them

	if ( !is_array( $options ) ) {
		if ( get_option( 'youtube_embed_editor' ) ) {
			$old_opts = get_option( 'youtube_embed_editor' );
			$options[ 'editor_button' ] = $old_opts[ 'youtube' ];
			delete_option( 'youtube_embed_editor' );
			$changed = true;
		} else {
			$options = array();
		}
	}

	// Because of upgrading, check each option - if not set, apply default

	if ( !array_key_exists( 'editor_button', $options ) ) { $options[ 'editor_button' ] = 1; $changed = true; }
	if ( !array_key_exists( 'admin_bar', $options ) ) { $options[ 'admin_bar' ] = 1; $changed = true; }
	if ( !array_key_exists( 'profile_no', $options ) ) { $options[ 'profile_no' ] = 5; $changed = true; }
	if ( !array_key_exists( 'list_no', $options ) ) { $options[ 'list_no' ] = 5; $changed = true; }
	if ( !array_key_exists( 'embed_cache', $options ) ) { $options[ 'embed_cache' ] = 24; $changed = true; }
	if ( !array_key_exists( 'alt_profile', $options ) ) { $options[ 'alt_profile' ] = 0; $changed = true; }
	if ( !array_key_exists( 'metadata', $options ) ) { $options[ 'metadata' ] = 1; $changed = true; }
	if ( !array_key_exists( 'feed', $options ) ) { $options[ 'feed' ] = 'b'; $changed = true; }
	if ( !array_key_exists( 'thumbnail', $options ) ) { $options[ 'thumbnail' ] = 2; $changed = true; }
	if ( !array_key_exists( 'privacy', $options ) ) { $options[ 'privacy' ] = 0; $changed = true; }
	if ( !array_key_exists( 'frameborder', $options ) ) { $options[ 'frameborder' ] = 1; $changed = true; }
	if ( !array_key_exists( 'widgets', $options ) ) { $options[ 'widgets' ] = 0; $changed = true; }
	if ( !array_key_exists( 'menu_access', $options ) ) { $options[ 'menu_access' ] = 'list_users'; $changed = true; }

	// Update the options, if changed, and return the result

	if ( $changed ) { update_option( 'youtube_embed_general', $options ); }
	return $options;
}

/**
* Function to set YouTube profile options
*
* Looks up profile options, based on passed profile numer.
* If none exist, or some are missing, set default values
*
* @since	2.0
*
* @param    string	$profile	Profile number
* @return   string				Options array
*/

function vye_set_profile_defaults( $profile ) {

	if ( $profile == 0 ) {
		$profname = 'Default';
	} else {
		$profname = 'Profile ' . $profile;
	}
	$options = get_option( 'youtube_embed_profile' . $profile );

	$changed = false;
	$new_user = false;

	// Work out default dimensions

	$width = 0;
	if ( isset( $content_width ) ) { $width = $content_width; }
	if ( ( $width == 0 ) or ( $width == '' ) ) { $width = 560; }
	$height = 25 + round( ( $width / 16 ) * 9, 0 );

	// If the old options exist, import them and then delete them

	if ( !is_array( $options ) ) {
		if ( ( $profile == 0 ) && ( get_option( 'youtube_embed' ) ) ) {
			$old_opts = get_option( 'youtube_embed' );
			$options = $old_opts;
			delete_option( 'youtube_embed' );
			$changed = true;
		} else {
			$options = array();
		}
	}

	// Because of upgrading, check each option - if not set, apply default

	if ( !array_key_exists( 'name', $options ) ) { $options[ 'name' ] = $profname; $changed = true; }

	if ( !array_key_exists( 'width', $options ) ) {
		$options[ 'width' ] = $width;
		$options[ 'height' ] = $height;
		$changed = true;
	}
	if ( !array_key_exists( 'height', $options ) ) { $options[ 'height' ] = 340; $changed = true; }
	if ( !array_key_exists( 'fullscreen', $options ) ) { $options[ 'fullscreen' ] = ''; $changed = true; }
	if ( !array_key_exists( 'template', $options ) ) { $options[ 'template' ] = '%video%'; $changed = true; }
	if ( !array_key_exists( 'autoplay', $options ) ) { $options[ 'autoplay' ] = ''; $changed = true; }
	if ( !array_key_exists( 'start', $options ) ) { $options[ 'start' ] = 0; $changed = true; }
	if ( !array_key_exists( 'loop', $options ) ) { $options[ 'loop' ] = ''; $changed = true; }
	if ( !array_key_exists( 'cc', $options ) ) { $options[ 'cc' ] = ''; $changed = true; }
	if ( !array_key_exists( 'annotation', $options ) ) { $options[ 'annotation' ] = 1; $changed = true; }
	if ( !array_key_exists( 'related', $options ) ) { $options[ 'related' ] = ''; $changed = true; }
	if ( !array_key_exists( 'info', $options ) ) { $options[ 'info' ] = 1; $changed = true; }
	if ( !array_key_exists( 'stop', $options ) ) { $options[ 'stop' ] = 0; $changed = true; }
	if ( !array_key_exists( 'type', $options ) ) { $options[ 'type' ] = 'v'; $changed = true; }
	if ( !array_key_exists( 'disablekb', $options ) ) { $options[ 'disablekb' ] = ''; $changed = true; }
	if ( !array_key_exists( 'autohide', $options ) ) { $options[ 'autohide' ] = 2; $changed = true; }
	if ( !array_key_exists( 'controls', $options ) ) { $options[ 'controls' ] = 1; $changed = true; }
	if ( !array_key_exists( 'wmode', $options ) ) { $options[ 'wmode' ] = 'window'; $changed = true; }
	if ( !array_key_exists( 'style', $options ) ) { $options[ 'style' ] = ''; $changed = true; }
	if ( !array_key_exists( 'color', $options ) ) { $options[ 'color' ] = 'red'; $changed = true; }
	if ( !array_key_exists( 'theme', $options ) ) { $options[ 'theme' ] = 'dark'; $changed = true; }
	if ( !array_key_exists( 'https', $options ) ) { $options[ 'https' ] = 0; $changed = true; }
	if ( !array_key_exists( 'modest', $options ) ) { $options[ 'modest' ] = 1; $changed = true; }
	if ( !array_key_exists( 'dynamic', $options ) ) { $options[ 'dynamic' ] = ''; $changed = true; }
	if ( !array_key_exists( 'fixed', $options ) ) { $options[ 'fixed' ] = ''; $changed = true; }
	if ( !array_key_exists( 'download', $options ) ) { $options[ 'download' ] = ''; $changed = true; }
	if ( !array_key_exists( 'download_style', $options ) ) { $options[ 'download_style' ] = ''; $changed = true; }
	if ( !array_key_exists( 'download_text', $options ) ) { $options[ 'download_text' ] = 'Click here to download the video'; $changed = true; }

	// Update the options, if changed, and return the result

	if ( $changed ) { update_option( 'youtube_embed_profile' . $profile, $options ); }

	// Remove added slashes from template XHTML

	$options[ 'template' ] = stripslashes( $options[ 'template' ] );

	return $options;
}

/**
* Function to set default list options
*
* Looks up list options, based on passed list number.
* If none exist, or some are missing, set default values
*
* @since	2.0
*
* @param    string	$list		List number
* @return   string				Options array
*/

function vye_set_list_defaults( $list ) {
	$options = get_option( 'youtube_embed_list' . $list );
	$changed = false;

	// If array doesn't exist create an empty one

	if ( !is_array( $options ) ) { $options = array(); }

	// Because of upgrading, check each option - if not set, apply default

	if ( !array_key_exists( 'name',$options ) ) { $options[ 'name' ] = 'List ' . $list; $changed = true; }
	if ( !array_key_exists( 'list',$options ) ) { $options[ 'list' ] = ''; $changed = true; }

	// Update the options, if changed, and return the result

	if ( $changed ) { update_option( 'youtube_embed_list' . $list, $options ); }
	return $options;
}
?>