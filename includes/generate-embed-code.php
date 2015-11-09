<?php
/**
* Generate embed code
*
* Functions calls to generate the required YouTube code
*
* @package	YouTube-Embed
*/

/**
* Generate embed code
*
* Generate XHTML compatible YouTube embed code
*
* @since	2.0
*
* @uses		vye_add_links				Add links under video
* @uses		vye_error				    Display an error
* @uses		vye_extract_id			    Get the video ID
* @uses		vye_validate_list		    Get the requested listr
* @uses		vye_validate_id			    Validate the video ID
* @uses		vye_validate_profile		Get the requested profile
* @uses		vye_set_general_defaults	Get general options
* @uses		vye_set_profile_defaults	Set default profile options
*
* @param	string		$id				Video ID
* @param	string		$width			Video width
* @param	string		$height			Video height
* @param	string		$fullscreen		Fullscreen button
* @param	string		$related		Show related info.
* @param	string		$autoplay		Start video automatically
* @param	string		$loop			Loop video to start
* @param	string		$start			Start in seconds
* @param	string		$info			Show video info.
* @param	string		$annotation		Annotations
* @param	string		$cc				Closed captions
* @param	string		$style			Stylesheet information
* @param	string		$stop			Stop in seconds
* @param	string		$disablekb		Disable keyboard controls
* @param	string		$ratio			Video size ratio
* @param	string		$autohide		Autohide controls
* @param	string		$controls		Display controls
* @param	string		$profile		Which profile to use
* @param	string		$list_style		How to use a list, if used
* @param	string		$template		Display template
* @param	string		$color		 	Progress bar color
* @param	string		$theme			Use dark or light theme
* @param	string		$https			Use HTTPS for links
* @param    string      $dynamic        Show dynamic output
* @param    string      $search         Perform a search
* @param    string      $user           Look up user videos
* @param    string      $modest         Modest browsing
* @return	string						Code output
*/

function vye_generate_youtube_code( $id = '', $width = '', $height = '', $fullscreen = '', $related = '', $autoplay = '', $loop = '', $start = '', $info = '', $annotation = '', $cc = '', $style = '', $stop = '', $disablekb = '', $ratio = '', $autohide = '', $controls = '', $profile = '', $list_style = '', $template = '', $color = '', $theme = '', $https = '', $dynamic = '', $search = '', $user = '', $modest = '' )  {

	// Ensure an ID is passed

	if ( $id == '' ) { return vye_error( __( 'No video/playlist ID has been supplied', 'youtube-embed' ) ); }

    $newline = "\n";
    $tab = "\t";

	// Get general options

	$general = vye_set_general_defaults();

	// Find the profile, if one is specified

	$profile = vye_validate_profile( $profile, $general[ 'profile_no' ] );

	// Get default values if no values are supplied

	$options = vye_set_profile_defaults( $profile );

	// If a user look-up or search has been requested, miss out looking up list details and
	// simple assign it as an IFRAME video

	$playlist_ids = '';
	$embed_type = '';

	if ( ( $user == 0 ) && ( $search == 0 ) ) {

		// Check it's not a list

		$list = vye_validate_list( $id, $general[ 'list_no' ] );
		if ( !is_array( $list ) ) {

			// Check if certain parameters are included in the URL

			$width = vye_get_url_para( $id, 'w', $width );
			$height = vye_get_url_para( $id, 'h', $height );

			// Extract the ID if a full URL has been specified

			$id = vye_extract_id( $id );

			// Check what type of video it is and whether it's valid

			$embed_type = vye_validate_id( $id );

			// If the video is invalid, output an error

			if ( ( $embed_type == '' ) or ( strlen ( $embed_type ) != 1 ) ) {
				$result = $newline . '<!-- YouTube Embed v' . youtube_embed_version . ' -->' . $newline;
				$result .= sprintf( __( 'The YouTube ID of %s is invalid.', 'youtube-embed' ), $id ) . $newline . '<!-- End of YouTube Embed code -->' . $newline;
				return $result;
			}

		} else {

			$return = '';
			$embed_type = 'v';

			// Randomize the video

			if ( $list_style == 'random' ) { shuffle( $list ); }

			// Extract one video randomly

			if ( $list_style == 'single' ) {
				$id = $list[ array_rand( $list, 1 ) ];

			// Build the playlist

			} else {

				$id = $list [ 0 ];

				// Build the playlist

				if ( count( $list ) > 1 ) {
					$loop = 1;
					while ( $loop < count( $list ) ) {
						if ( $playlist_ids != '' ) { $playlist_ids .= ','; }
						$list_id = vye_extract_id( $list[ $loop ] );
						$playlist_ids .= $list_id;
						$loop ++;
					}
				}
			}
		}
	}

	// Generate a cache key for the above passed parameters

	$hash_key = $id . $width . $height . $fullscreen . $related . $autoplay . $loop . $start . $info . $annotation . $cc . $style . $stop . $disablekb . $ratio . $autohide . $controls . $profile . $list_style . $template . $color . $theme . $https . $dynamic . $search . $user . serialize( $general ) . serialize( $options );
	if ( isset( $list ) ) { $hash_key .= serialize( $list ); }
	if ( isset( $return ) ) { $hash_key .= serialize( $return ); }

	$cache_key = 'vye_video_' . md5( $hash_key );

	// Try and get the output from cache. If it exists, return the code

	if ( ( $general[ 'embed_cache' ] != 0 ) && ( !is_feed() ) && ( $list_style != 'random' ) ) {
        echo 'Getting cache...';
		$result = get_transient( $cache_key );
		if ( $result !== false) { return $result; }
	}

	$metadata = $general[ 'metadata' ];

    // Correct the ID if a playlist
    if ( strtolower( substr( $id, 0, 2 ) ) == 'pl') {
        $id = substr( $id, 2 );
    }

	// Work out correct protocol to use - HTTP or HTTPS

	if ( $https == '' ) { $https = $options[ 'https' ]; }
	if ( $https == 1 ) { $https = 's'; } else { $https = ''; }

	// If this is a feed then display a thumbnail and/or text link to the original video

	if ( is_feed () ) {
		$result = '';
		if ( $playlist_ids != '' ) {
			$result .= '<p>'.__( 'A video list cannot be viewed within this feed - please view the original content', 'youtube-embed' ) . '.</p>' . $newline;
		} else {
			$youtube_url = 'http' . $https . '://www.youtube.com/watch?' . $embed_type . '=' . $id;
			if ( ( $embed_type == 'v' ) && ( $general[ 'feed' ] != 't' ) ) { $result .= '<p><a href="' . $youtube_url . '"><img src="http://img.youtube.com/vi/' . $id . '/' . $general[ 'thumbnail' ] . '.jpg"></a></p>' . $newline; }
			if ( ( $general ['feed'] != 'v' ) or ( $embed_type != 'v' ) ) { $result .= '<p><a href="' . $youtube_url . '">' . __( 'Click here to view the video on YouTube', 'youtube-embed' ) . '</a>.</p>' . $newline; }
		}
		return $result;
	}

	// If a dynamic size has been requested, check whether the width should be fixed

	$fixed = 0;
	if ( $dynamic == '' ) {
		$dynamic = $options[ 'dynamic' ];
		$fixed = $options[ 'fixed' ];
	} else {
		if ( $width != '' ) { $fixed = 1; }
	}

	// Only set width and height from defaults if both are missing

	if ( ( $width == '' ) && ( $height == '' ) ) {

		$width = $options[ 'width' ];
		$height = $options[ 'height' ];
	}

	// If controls parameter is not numeric then convert to 0 or 1
	// This is to maintain backwards compatibility after version 2.6

	if ( ( !is_numeric( $controls ) ) && ( $controls != '' ) ) {
		$controls = vye_convert( $controls );
	}

	// If values have not been pressed, use the default values

	if ( $fullscreen == '' ) { $fullscreen = $options[ 'fullscreen' ]; }
	if ( $related == '' ) { $related = $options[ 'related' ]; }
	if ( $autoplay == '' ) { $autoplay = $options[ 'autoplay' ]; }
	if ( $loop == '' ) { $loop = $options[ 'loop' ]; }
	if ( $info == '' ) { $info = $options[ 'info' ]; }
	if ( $annotation == '' ) { $annotation = $options[ 'annotation' ]; }
	if ( $cc == '' ) { $cc = $options[ 'cc' ]; }
	if ( $disablekb == '' ) { $disablekb = $options[ 'disablekb' ]; }
	if ( $autohide == '' ) { $autohide = $options[ 'autohide' ]; }
	if ( $controls == '' ) { $controls = $options[ 'controls' ]; }
	if ( $style == '' ) { $style = $options[ 'style' ]; }
	if ( $color == '' ) { $color = $options[ 'color' ]; }
	if ( $theme == '' ) { $theme = $options[ 'theme' ]; }
    if ( $modest == '' ) { $modest = $options[ 'modest' ]; }

	$wmode = $options[ 'wmode' ];

	if ( $theme == '' ) { $theme = $options[ 'theme' ]; }

	// Build the required template

	if ( $template == '' ) { $template = $options[ 'template' ]; } else { $template = vye_decode( $template ); }
	if ( strpos( $template, '%video%' ) === false ) { $template = '%video%'; }

	// If looping and no playlist has been generated, add the current ID
	// This is a workaround for the AS3 player which won't otherwise loop

	if ( ( $loop == 1 ) && ( $embed_type != 'p' ) && ( $playlist_ids == '' ) ) { $playlist_ids = $id; }

	// Set parameters without default values

	if ( $start == '' ) { $start = '0'; }
	if ( $stop == '' ) { $stop = '0'; }

	// If height or width is missing, calculate missing parameter using ratio

	if ( ( ( $width == '' ) or ( $height == '' ) ) && ( ( $width != '' ) or ( $height != '' ) ) ) {
		$ratio_to_use = '';
		if ( $ratio != '' ) {

			// Extract the ratio from the provided string

			$pos = strpos( $ratio, ':', 0 );
			if ( $pos !== false ) {
				$ratio_l = substr( $ratio, 0, $pos );
				$ratio_r = substr( $ratio, $pos + 1 );
				if ( ( is_numeric( $ratio_l ) ) && ( is_numeric( $ratio_r ) ) ) { $ratio_to_use = $ratio_l / $ratio_r; }
			}
		}

		// If no, or invalid, ratio supplied, calculate from the default video dimensions

		if ( $ratio_to_use == '' ) { $ratio_to_use = $options[ 'width' ] / $options[ 'height' ]; }

		// Complete the missing width or height using the ratio

		if ( $width == '' ) { $width = round( $height * $ratio_to_use, 0); }
		if ( $height == '' ) { $height = round( $width / $ratio_to_use, 0); }
	}

	// Set Frameborder output

	$frameborder = '';
	if ( isset( $general[ 'frameborder' ] ) ) { if ( $general[ 'frameborder' ] == 1 ) { $frameborder = 'frameborder="0" '; } }

	// Set up embed types

	$class = 'youtube-player';
	$paras = '?enablejsapi=1';

	// Generate parameters to add to URL

	if ( $modest == 1 ) { $paras .= '&modestbranding=1'; }
	if ( $fullscreen != 1 ) { $paras .= '&fs=0'; }
	if ( $related != 1 ) { $paras .= '&rel=0'; }
	if ( $autoplay == 1 ) { $paras .= '&autoplay=1'; }
	if ( $loop == 1 ) { $paras .= '&loop=1'; }
	if ( $info != 1 ) { $paras .= '&showinfo=0'; }
	if ( $annotation != 1 ) { $paras .= '&iv_load_policy=3'; }
	$paras .= '&cc_load_policy=';
	if ( $cc == 1 ) { $paras .= '1'; } else { $paras .= '0'; }
	if ( $disablekb == 1 ) { $paras .= '&disablekb=1'; }
	if ( $autohide != 2 ) { $paras .= '&autohide=' . $autohide; }
	if ( $controls != 1 ) { $paras .= '&controls=' . $controls; }
	if ( strtolower( $color ) != 'red' ) { $paras .= '&color=' . strtolower( $color ); }
	if ( strtolower( $theme ) != 'dark' ) { $paras .= '&theme=' . strtolower( $theme ); }

	// If not a playlist, add the playlist parameter

	if ( ( $playlist_ids != '' ) && ( $playlist_ids != $id ) ) { $paras .= '&playlist=' . $playlist_ids; }

	// Add start & stop parameters

	if ( $start != 0 ) { $paras .= '&start=' . $start; }
	if ( $stop != 0 ) { $paras .= '&end=' . $stop; }

	// Generate DIVs to wrap around video

	if ( ( $dynamic == 1) or ( $metadata != 0 ) ) {

        $ttab = $tab;
		$result = '<div';
        if ( $dynamic == 1 ) { $result .= ' class="ye-container"'; }
        if ( $metadata != 0 ) { $result .= ' itemprop="video" itemscope itemtype="http://schema.org/VideoObject"'; }
        $result .= '>' . $newline;
		if ( ( $dynamic == 1 ) && ( $fixed == 1) ) {
            $result = '<div style="width: ' . $width . 'px; max-width: 100%">' . $newline . $tab . $result;
            $ttab .= $tab;
        }
    } else {
        $ttab = '';
	}

    // Add Metadata

    if ( $metadata != 0 ) {

        $result .= $ttab . '<meta itemprop="url" content="http' . $https . '://www.youtube.com/' . $embed_type . '/' . $id . '" />' . $newline;
        $result .= $ttab . '<meta itemprop="name" content="' . get_the_title() . '" />' . $newline;
        $result .= $ttab . '<meta itemprop="description" content="' . htmlentities( get_the_excerpt() ). '" />' . $newline;
        $result .= $ttab . '<meta itemprop="uploadDate" content="' . get_the_date( 'c' ) . '" />' . $newline;
        $result .= $ttab . '<meta itemprop="thumbnailUrl" content="http://i.ytimg.com/vi/' . $id . '/hqdefault.jpg" />' . $newline;
        $result .= $ttab . '<meta itemprop="embedUrl" content="http' . $https . '://www.youtube.com/embed/' . $id . '" />' . $newline;
        $result .= $ttab . '<meta itemprop="height" content="' . $height . '" />' . $newline;
        $result .= $ttab . '<meta itemprop="width" content="' . $width . '" />' . $newline;
    }

	// Work out, depending on privacy settings, the main address to use

	$privacy = $general[ 'privacy' ];

	if ( $privacy  == 2 ) {
		$do_not_track = vye_do_not_track();
		if ( $do_not_track ) { $privacy = 1; } else { $privacy = 0; }
	}

	if ( $privacy == 1 )  { $url_privacy = 'youtube-nocookie.com'; } else { $url_privacy = 'youtube.com'; }

	// Generate the first part of the embed URL along with the ID section

	$embed_url = 'http' . $https . '://www.' . $url_privacy . '/embed';
    $id_paras = '/' . $id;

	// If a playlist, user or download build the ID appropriately

	if ( ( $embed_type == 'p' ) or ( $user != 0 ) or ( $search != 0 ) ) {

		$list_type = '';
		if ( $embed_type == 'p' ) { $list_type = 'playlist'; }
		if ( $user != 0 ) { $list_type = 'user_uploads'; }
		if ( $search != 0 ) { $list_type = 'search'; $id = urlencode( $id ); }

		$id_paras = '?listType=' . $list_type . '&list=';
		if ( ( $embed_type == 'p' ) && ( strtolower( substr ( $id, 0, 2 ) ) != 'pl' ) ) { $id_paras .= 'PL'; }
		$id_paras .= $id;
	}

	// Combine URL parts together

	$embed_url .= $id_paras;
	if ( strpos( $embed_url, '?' ) > 0 ) { $paras = '&' . substr( $paras, 1 ); }
	$embed_url .= $paras . '&wmode=' . $wmode;

	// Check length of URL to ensure it doesn't exceed 2000 characters

	if ( strlen( $embed_url ) > 2000 ) { return vye_error( __( 'The maximum URL length has been exceeded. Please reduce your parameter and/or playlist.', 'youtube-embed' ) ); }

	// Add IFRAME embed code

	if ( $embed_type == "p" ) { $playlist_para = "p/"; } else { $playlist_para = ''; }
	$result .= $ttab . '<iframe ' . $frameborder . 'style="border: 0;' . $style . '" class="' . $class . '" width="' . $width . '" height="' . $height . '" src="' . $embed_url . '"';
	if ( $fullscreen == 1 ) { $result .= ' allowfullscreen="allowfullscreen"'; }
	$result .= ' ></iframe>' . $newline;

	// Now apply the template to the result

	$end_tag = '';
	if ( ( $dynamic == 1 ) or ( $metadata != 0 ) ) {
		if ( ( $dynamic == 1 ) && ( $fixed == 1 ) ) {
            $end_tag .= $tab . '</div>' . $newline . '</div>' . $newline;
        } else {
            $end_tag .= '</div>' . $newline;
        }
	}
	$result = str_replace( '%video%', $result . $end_tag, $template );

	// Add the download link, if required

	if ( $options[ 'download' ] == 1 ) { $result .= '<div style="' . $options[ 'download_style' ] . '" class="aye_download">' . $newline . $tab . '<a href="' . vye_generate_download_code( $id ) . "\">" . $options[ 'download_text' ] . '</a>' . $newline . '</div>' . $newline; }

	// Now add a commented header and trailer

	$result = $newline . '<!-- YouTube Embed v' . youtube_embed_version . ' -->' . $newline . $result;
	$result .= '<!-- End of YouTube Embed code -->';

	// Cache the output

	if ( $general[ 'embed_cache' ] != 0 ) { set_transient( $cache_key, $result, 3600 * $general[ 'embed_cache' ] );	}

	return $result;
}

/**
* Validate a supplied profile name
*
* Returns a profile number for a supplied name
*
* @since	2.0
*
* @param	string		$name		The name of the profile to find
* @param	string		$number		The number of profiles available
* @return	string					The profile number (defaults to 0)
*/

function vye_validate_profile( $name, $number ) {

	$profile = 0;
	$name = strtolower( $name );

	if ( ( $name != '' ) && ( $name != 'default' ) ) {

		// Loop around, fetching in profile names

		$loop = 1;
		while ( ( $loop <= $number ) && ( $profile == 0 ) ) {
			if ( ( $name == $loop ) or ( $name == 'Profile ' . $loop ) ) {
				$profile = $loop;
			} else {
				$profiles = get_option( 'youtube_embed_profile' . $loop );
				$profname = strtolower( $profiles[ 'name' ] );
				if ( $profname == $name ) { $profile = $loop; }
			}
			$loop ++;
		}
	}
	return $profile;
}

/**
* Validate a supplied list name
*
* Returns a list for a supplied list number or name name - blank if not a valid list
*
* @since	2.0
*
* @param	string		$name		The name of the list to find
* @param	string		$number		The number of lists available
* @return	string					The list (defaults to blank)
*/

function vye_validate_list( $name, $number ) {

	$list = '';

	// If the parameter contains commas, assume to be a comma seperated list and move into an array

	if ( strpos( $name, ',' ) !== false ) {
		$list = explode( ',', $name );
	} else {

		// No comma, so check if this is a named list

		$name = strtolower( $name );

		if ( $name != '' ) {

			// Loop around, fetching in profile names

			$loop = 1;
			while ( ( $loop <= $number ) && ( $list == '' ) ) {
				$listfiles = get_option( 'youtube_embed_list' . $loop );
				if ( ( $name == strval( $loop ) ) or ( $name == 'List ' . $loop ) ) {
					$list = $listfiles[ 'list' ];
				} else {
					$listname = strtolower( $listfiles[ 'name' ] );
					if ( $listname == $name ) { $list = $listfiles[ 'list' ]; }
				}
				$loop ++;
			}
		}
		if ( $list != '' ) { $list = explode( "\n", $list ); }
	}
	return $list;
}

/**
* Get URL parameters
*
* Extract a requested parameter from a URL
*
* @since	2.0
*
* @param	string		$id			The ID of the video
* @param	string		$para		The parameter to extract
* @param	string		$current	The current parameter value
* @return	string					The parameter value
*/

function vye_get_url_para( $id, $para, $current ) {

	// Look for an ampersand

	$start_pos = false;
	if ( strpos( $id, '&' . $para . '=' ) !== false ) {	$start_pos = strpos( $id, '&' . $para . '=' ) + 6 + strlen( $para ); }

	// If a parameter was found, look for the end of it

	if ( $start_pos !== false ) {
		$end_pos = strpos( $id, '&', $start_pos + 1 );
		if ( !$end_pos ) { $end_pos = strlen( $id ); }

		// Extract the parameter and return it

		$current = substr( $id, $start_pos, $end_pos - $start_pos );
	}

	return $current;
}

/**
* Decode a string
*
* Decode an HTML encoded string. I'm not using htmlspecialchars_decode to maintain
* PHP 4 compatibility.
*
* @since	2.0.3
*
* @param	string		$encoded	The encoded string
* @return	string					The decoded string
*/

function vye_decode( $encoded ) {

	$find = array( '&amp;', '&quot;', '&#039;', '&lt;', '&gt;' );
	$replace = array( '&', '"', "'", '<', '>' );

	$decoded = str_replace( $find, $replace, $encoded );

	return $decoded;
}
?>
