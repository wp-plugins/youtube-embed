<?php
/**
* Content
*
* Process the post/page content for embed requests
*
* @package	YouTubeEmbed
* @since	2.0
*/

/**
* Search content for alternative embed methods
*
* Look through post/page content for various alternative methods of embedding - replace with
* embed code.
*
* @since	2.0
*
* @uses		ye_convert_content			Convert a URL to the embed code
* @uses		ye_generate_youtube_code	Generate the YouTube embed code
* @uses		ye_set_general_defaults		Get general defaults
* @uses		ye_validate_id				Validate the video ID
*
* @param	string		$content		Post/page content
* @return   string						Resulting post/page content
*/

function ye_content_search( $content ) {

	$options = ye_set_general_defaults();

	// The following are URL modifications

	if ( $options[ 'alt' ] == 1 ) {

		$changed = true;
		while ( $changed ) {

			$changed = false;

			// Search for httpv URL
			$identifier = 'httpv://www.youtube.com/watch?v=';
			$search = strpos( $content, $identifier );
			if ( $search !== false ) { $content = ye_convert_content( $content, $identifier, substr( $content, $search + strlen( $identifier ), 11 ), '', '', $options[ 'other_profile' ] ); $changed = true; }

			// Search for httpa URL
			$identifier = 'httpa://www.youtube.com/watch?v=';
			$search = strpos( $content, $identifier );
			if ( $search !== false ) { $content = ye_convert_content( $content, $identifier, substr( $content, $search + strlen( $identifier ), 11 ), 1, '', $options[ 'other_profile' ] ); $changed = true; }

			// Search for httpvh URL
			$identifier = 'httpvh://www.youtube.com/watch?v=';
			$search = strpos( $content, $identifier );
			if ( $search !== false ) { $content = ye_convert_content( $content, $identifier, substr( $content, $search + strlen( $identifier ), 11 ), '', '', $options[ 'other_profile' ] ); $changed = true; }

			// Search for httpvp playlist URL
			$identifier = 'httpvp://www.youtube.com/watch?p=';
			$search = strpos( $content, $identifier );
			if ( $search !== false ) { $content = ye_convert_content( $content, $identifier, substr( $content, $search + strlen( $identifier ), 16 ), '', '', $options[ 'other_profile' ] ); $changed = true; }

			// Search for youtube:: URL
			$identifier = 'youtube::';
			$search = strpos( $content, $identifier );
			if ( $search !== false ) {
				$suffix = substr( $content, $search + strlen( $identifier ) + 11, 2 );
				if ( $suffix == '::' ) { $content = ye_convert_content( $content, $identifier, substr( $content, $search + strlen( $identifier ), 11 ), '', '::', $options[ 'other_profile' ] ); $changed = true; }
			}
		}

	}

	// The following are embedding URLs that are within brackets but are not shortcodes

	if ( $options[ 'bracket' ] == 1 ) {

		// Loop around content, looking for brackets - possible YouTube URL within!
		$current_pos = 0;
		$bracket_found = true;

		while ( $bracket_found ) {
			$open_bracket = strpos( $content, '[', $current_pos );

			if ($open_bracket !== false) {
				$close_bracket = strpos( $content, ']', $open_bracket );

				if ( $close_bracket !== false ) {
					$code = substr( $content, $open_bracket + 1, $close_bracket - $open_bracket - 1 );
					$code_found = false;
					$id = $code;

					// Maybe a video ID - validate first
					if ( ( strlen( $code ) == 11 ) && ( !strpos( $code, ' ' ) ) ) {
						$type = ye_validate_id( $code );
						if ( $type == 'v' ) { $code_found = true; }
					}

					// Video URL
					if ( ( strpos ($code, 'youtube.com/watch?v=' ) !== false ) && ( !$code_found ) ) { $code_found = true; }

					// Other URLs
					if ( ( substr( $code, 0, 8 ) == 'watch?v=' ) && ( !$code_found ) ) {
						$id = substr( $code, 8 );
						$code_found = true;
					}
					if ( ( substr( $code, 0, 2 ) == 'v=' ) && ( !$code_found ) ) {
						$id = substr( $code, 2 );
						$code_found = true;
					}

					// If an ID was found, update the code
					if ( $code_found ) {
						$ye_code = ye_generate_youtube_code( $id, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', $options[ 'other_profile' ], '', '' );
						$content = str_replace( '[' . $code . ']', $ye_code, $content );
					}
				}
				$current_pos = $close_bracket;
			} else {
				$bracket_found = false;
			}
		}
	}

	return $content;
}
add_filter( 'the_content', 'ye_content_search' );

/**
* Embed Handler
*
* Override the WP embed handler. Allows address and embed URLS types as well as playlists.
*
* @since	2.0
*
* @uses		ye_set_general_defaults		Fetch default profile option
* @uses		ye_generate_youtube_code	Generate the embed code
*
* @param	array		$matches	The regex matches from the provided regex when calling
* @param	array		$attr		Embed attributes
* @param	string		$url		The original URL that was matched by the regex
* @param	array		$rawattr	The original unmodified attributes
* @return	string					The embed HTML
*/

function ye_embed_handler( $matches, $attr, $url, $rawattr ) {

	$options = ye_set_general_defaults();
	$code = ye_generate_youtube_code( $matches[ 1 ], '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', $options[ 'url_profile' ], '', '' );

    return $code;
}

$url = ye_set_url_option();
if ( $url != '' ) {
    //$ye_regex = '/http:\/\/(?:www\.)?youtube.*watch\?[pv]=([a-zA-Z0-9\-_]+)/';
    // http://stackoverflow.com/questions/7654542/youtube-url-regex
    $ye_regex = '\s*(https?:\/\/www.youtube(?:-nocookie)?.com\/(?:v|embed)\/([a-zA-Z0-9-]+)).*';
	wp_embed_register_handler( 'youtube', $ye_regex, 'ye_embed_handler' );
	wp_embed_register_handler( 'youtube_embed', $ye_regex, 'ye_embed_handler' );
}

/**
* Convert the Content
*
* Convert the URL to the embed code
*
* @since	2.0
*
* @uses		ye_generate_youtube_code	Generate the embed code
*
* @param    string		$content		The post content
* @param	string		$identifier		The text that identifies the embed
* @param	string		$id				The video ID
* @param	string		$audio			Audio only?
* @param	string		$suffix			Characters that appear after the video ID
* @param	string		$profile		The current profile
* @return   string						Content to return
*/

function ye_convert_content( $content, $identifier, $id, $audio = '', $suffix = '', $profile = '' ) {

	$code = ye_generate_youtube_code( $id, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', $profile, '', $audio );
	$content = str_replace( $identifier.$id.$suffix, $code, $content);

	return $content;
}

/**
* Filter comments
*
* Filter comments and add YouTube embeds
*
* @since	2.0
*
* @uses		ye_set_general_defaults		Get the general defaults
* @uses		ye_generate_youtube_code	Generate the YouTube embed code
*
* @param    string		$content		The comments content
* @return   string						Content to return
*/

function ye_filter_comments( $content ) {

	$options = ye_set_general_defaults();

	if ( $options[ 'comments' ] == 1 ) {

		$identifier = 'http://www.youtube.com/watch?v=';
		$search_pos = 0;
		$search = strpos( $content, $identifier, $search_pos );

		while ( $search !== false ) {
			$prefix = substr( $content, $search - 1, 1 );
			if ( ( $prefix != ']' ) && ( $prefix != '"' ) && ( $prefix != "'" ) ) {

				// Check if link around video. If so, work out how much more needs stripping out
				$anchor_start = 0;
				$anchor_end = 0;
				if ( $prefix == ">" ) {
					$anchor_pos = strrpos( substr( $content, 0, $search ), '<a' );
					if ( $anchor_pos !== false ) {
						$anchor_start = $search - $anchor_pos;
						$anchor_end = strpos(substr($content,$search),'</a>') - strlen($identifier) - 11;
					}
				}

				// Work out video ID and generate code
				$id = substr( $content, $search + strlen( $identifier ), 11 );
				$code = ye_generate_youtube_code( $id, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', $options[ 'comments_profile' ], '', '' );

				// Now replace the URL with the resultant code
				$first_section = $search - 1 - $anchor_start;
				if ( $first_section < 1 ) {
					$content = $code . substr( $content, $search + strlen( $identifier ) + 11 + $anchor_end );
				} else {
					$content = substr( $content, 0, $first_section ) . $code . substr( $content, $search + strlen( $identifier ) + 11 + $anchor_end );
				}

				$search_pos = $search + strlen( $code ) - $anchor_start;
			} else {
				$search_pos = $search + strlen( $identifier ) + 11;
			}
			$search = strpos( $content, $identifier, $search_pos - 1);
		}
	}
	return $content;
}
add_filter( 'comment_text', 'ye_filter_comments' );
?>