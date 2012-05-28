<?php
/**
* Profiles Options Page
*
* Screen for specifying different profiles and settings the options for each
*
* @package	Artiss-YouTube-Embed
* @since	2.0
*/
?>
<div class="wrap" style="width: 1010px;">

<div class="icon32"><img src="<?php echo plugins_url(); ?>/youtube-embed/images/screen_icon.png" alt="" title="" height="32px" width="32px"/><br /></div>

<h2><?php _e( 'Artiss YouTube Embed Profiles' ); ?></h2><br/>

<div style="width: 990px; height: 220px; border: 1px solid #ddd; padding: 10px;">
<a href="http://themefuse.com/wp-themes-shop/?plugin=youtube-embed" target="_blank"><img src="<?php echo plugins_url(); ?>/youtube-embed/images/themefuse_banner.jpg" alt="ThemeFuse.com - Premium WordPress Themes" title="ThemeFuse.com - Premium WordPress Themes" style="float: left; padding-right: 10px;"></a>
<h3>Donate</h3>
<p>If you like this plugin and appreciate the effort being put into it, <a href="http://www.artiss.co.uk/donate">please consider donating</a>. You can donate via PayPal or purchase something from my Amazon Wish List.</p>
<h3>Follow Me</h3>
<p>Please stay in touch with the latest news via one of the following social streams...</p>
<p align="center">
<a href="http://www.twitter.com/artiss_tech"><img src="<?php echo plugins_url(); ?>/youtube-embed/images/Twitter.png" alt="<?php _e( 'Follow Artiss.co.uk on Twitter' ); ?>" title="<?php _e( 'Follow Artiss.co.uk on Twitter' ); ?>" style="margin-right: 20px;"></a>
<a href="http://www.facebook.com/artiss.co.uk"><img src="<?php echo plugins_url(); ?>/youtube-embed/images/Facebook.png" alt="<?php _e( 'Follow Artiss.co.uk on Facebook' ); ?>" title="<?php _e( 'Follow Artiss.co.uk on Facebook' ); ?>" style="margin-right: 20px;"></a>
<a href="https://plus.google.com/108446415028687420620?rel=author"><img src="<?php echo plugins_url(); ?>/youtube-embed/images/Google+.png" alt="<?php _e( 'Follow Artiss.co.uk on Google+' ); ?>" title="<?php _e( 'Follow Artiss.co.uk on Google+' ); ?>" style="margin-right: 20px;"></a>
<a href="http://www.artiss.co.uk/feed"><img src="<?php echo plugins_url(); ?>/youtube-embed/images/RSS.png" alt="<?php _e( 'Follow Artiss.co.uk on RSS feed' ); ?>" title="<?php _e( 'Follow Artiss.co.uk on RSS feed' ); ?>"></a>
</p>
</div><br/>

<?php
// Set current profile number
if ( isset( $_POST[ 'youtube_embed_profile_no' ] ) ) { $profile_no = $_POST[ 'youtube_embed_profile_no' ]; } else { $profile_no = 0; }
if ( $profile_no == '' ) { $profile_no = 0; }

// If options have been updated on screen, update the database
if ( ( !empty( $_POST[ 'Submit' ] ) ) && ( check_admin_referer( 'youtube-embed-profile' , 'youtube_embed_profile_nonce' ) ) ) {

	$options[ 'name' ] = $_POST[ 'youtube_embed_name' ];
    $options[ 'type' ] = $_POST[ 'youtube_embed_type' ];
    $options[ 'playlist' ] = $_POST[ 'youtube_embed_playlist' ];
	$options[ 'width' ] = $_POST[ 'youtube_embed_width' ];
    $options[ 'height' ] = $_POST[ 'youtube_embed_height' ];

    $options[ 'template' ] = htmlspecialchars_decode( $_POST[ 'youtube_embed_template' ] );
	if ( strpos( $options[ 'template' ], '%video%' ) === false ) { $options[ 'template' ] = '%video%'; }

    $options[ 'style' ] = $_POST[ 'youtube_embed_style' ];
    $options[ 'fullscreen' ] = $_POST[ 'youtube_embed_fullscreen' ];
    $options[ 'autoplay'] = $_POST[ 'youtube_embed_autoplay' ];
    $options[ 'loop'] = $_POST[ 'youtube_embed_loop' ];
    $options[ 'cc'] = $_POST[ 'youtube_embed_cc' ];
    $options[ 'annotation'] = $_POST[ 'youtube_embed_annotation' ];
    $options[ 'related'] = $_POST[ 'youtube_embed_related' ];
    $options[ 'info'] = $_POST[ 'youtube_embed_info' ];
    $options[ 'link'] = $_POST[ 'youtube_embed_link' ];
    $options[ 'react'] = $_POST[ 'youtube_embed_react' ];
    $options[ 'sweetspot'] = $_POST[ 'youtube_embed_sweetspot' ];
    $options[ 'disablekb'] = $_POST[ 'youtube_embed_disablekb' ];
    $options[ 'autohide'] = $_POST[ 'youtube_embed_autohide' ];
    $options[ 'controls'] = $_POST[ 'youtube_embed_controls' ];
    $options[ 'fallback'] = $_POST[ 'youtube_embed_fallback' ];
    $options[ 'wmode'] = $_POST[ 'youtube_embed_wmode' ];
    $options[ 'audio'] = $_POST[ 'youtube_embed_audio' ];
    $options[ 'hd'] = $_POST[ 'youtube_embed_hd' ];
    $options[ 'color' ] = $_POST[ 'youtube_embed_color' ];
    $options[ 'theme' ] = $_POST[ 'youtube_embed_theme' ];
    $options[ 'https' ] = $_POST[ 'youtube_embed_https' ];
    $options[ 'modest' ] = $_POST[ 'youtube_embed_modest' ];
    $options[ 'dynamic' ] = $_POST[ 'youtube_embed_dynamic' ];
    $options[ 'fixed' ] = $_POST[ 'youtube_embed_fixed' ];

    $default_size = $_POST[ 'youtube_embed_size' ];

	if ( $default_size !== '' ) {
		$options[ 'width' ] = ltrim( substr( $default_size, 0, 4 ), '0' );
		$options[ 'height'] = ltrim( substr( $default_size, -4, 4 ), '0' );
	}

    // Set width or height, if missing

    if ( ( $options[ 'width' ] == '' ) && ( $options[ 'height' ] == '' ) ) {
        if ( isset( $GLOBALS[ 'content_width' ] ) ) {
            $options[ 'width' ] = $GLOBALS[ 'content_width' ];
        } else {
            $options[ 'width' ] = 560;
        }
        $options[ 'height' ] = 27 + round( ( $options[ 'width' ] / 16 ) * 9, 0 );
    }
    if ( ( $options[ 'width' ] == '' ) && ( $options[ 'height' ] != '' ) ) {
        	$options[ 'width' ] = round( ( $options[ 'height' ] / 9 ) * 16, 0 );
    }
    if ( ( $options[ 'width' ] != '' ) && ( $options[ 'height' ] == '' ) ) {
        	$options[ 'height' ] = 27 + round( ( $options[ 'width' ] / 16 ) * 9, 0 );
    }

	update_option( 'youtube_embed_profile' . $profile_no, $options );
	echo '<div class="updated fade"><p><strong>' . __( $options[ 'name' ].' Profile Saved.' ) . "</strong></p></div>\n";
} else {
	$default_size = '';
}

// Video option button has been pressed
if ( !empty( $_POST[ 'Video' ] ) ) { $video_type = $_POST[ 'youtube_embed_video_type' ]; } else { $video_type = 'd'; }

// Fetch options into an array
$options = aye_set_profile_defaults( $profile_no );
$general = aye_set_general_defaults();
?>

<form method="post" action="<?php echo get_bloginfo( 'wpurl' ) . '/wp-admin/admin.php?page=aye-profile-options' ?>">

<span class="alignright">
<select name="youtube_embed_profile_no">
<?php aye_generate_profile_list( $profile_no, $general[ 'profile_no' ] ) ?>
</select>
<input type="submit" name="Profile" class="button-secondary" value="<?php _e('Change profile'); ?>"/>
</span><br/>

<?php
if ( $profile_no == '0' ) {
    _e( 'These are the options for the default profile.' );
} else {
    sprintf( _e( 'These are the options for profile %s.' ), $profile_no );
}
echo ' ' . __( 'Use the drop-down on the right hand side to swap between profiles.' );
?>

<table class="form-table">

<tr>
<th scope="row"><?php _e( 'Profile name' ); ?></th><td>
<input type="text" size="20" name="youtube_embed_name" value="<?php echo $options[ 'name' ]; ?>"<?php if ( $profile_no == 0 ) { echo ' readonly="readonly"'; } ?>/>
<?php if ( $profile_no != 0 ) { echo '&nbsp;<span class="description">' . __( 'The name you wish to give this profile' ) . '</span>'; } ?>
</td></tr>

<tr valign="top">
<th scope="row"><?php _e( 'Video Embed Type' ); ?></th>
<td><span class="description"><?php _e( 'The type of player to use for videos.' ); ?></span><br/>
<input type="radio" name="youtube_embed_type" value="v"<?php if ( $options[ 'type' ] == "v" ) { echo ' checked="checked"'; } ?>/><?php echo '&nbsp;' . __( 'IFRAME' ); ?><span class="description"><?php echo '&nbsp;' . __( 'Uses HTML5, if available. Alternatively, uses AS3 Flash player. This is the current YouTube default..' ); ?></span><br/>
<input type="radio" name="youtube_embed_type" value="p"<?php if ( $options[ 'type' ] == "p" ) { echo ' checked="checked"'; } ?>/><?php echo '&nbsp;' . __( 'OBJECT' ); ?><span class="description"><?php echo '&nbsp;' . __( 'Use the AS3 Flash player.' ); ?></span><br/>
<input type="radio" name="youtube_embed_type" value="c"<?php if ( $options[ 'type' ] == "c" ) { echo ' checked="checked"'; } ?>/><?php echo '&nbsp;' . __( 'Chromeless' ); ?><span class="description"><?php echo '&nbsp;' . __( 'Use the <a href="http://www.artiss.co.uk/artiss-youtube-embed/further-help#ye-chromeless">Chromeless</a> version of the AS3 Flash Player.' ); ?></span><br/>
<input type="radio" name="youtube_embed_type" value="m"<?php if ( $options[ 'type' ] == "m" ) { echo ' checked="checked"'; } ?>/><?php echo '&nbsp;' . __( 'EmbedPlus' ); ?><span class="description"><?php echo '&nbsp;' . __( 'Use <a href="http://www.artiss.co.uk/artiss-youtube-embed/further-help#ye-embedplus">EmbedPlus</a>, if Flash is available.' ); ?></span>
</td>
</tr>

<tr valign="top">
<th scope="row"><?php _e( 'Playlist Embed Type' ); ?></th>
<td><span class="description"><?php _e( 'The type of player to use when showing playlists.' ); ?></span><br/>
<input type="radio" name="youtube_embed_playlist" value="v"<?php if ( $options[ 'playlist' ] == "v" ) { echo ' checked="checked"'; } ?>/><?php echo '&nbsp;' . __( 'IFRAME' ); ?><br/>
<input type="radio" name="youtube_embed_playlist" value="o"<?php if ( $options[ 'playlist' ] == "o" ) { echo ' checked="checked"'; } ?>/><?php echo '&nbsp;' . __( 'OBJECT' ); ?><br/>
</td>
</tr>
</table>

<br/><span class="yt_heading"><?php _e( 'Options For All Player Types' ); ?></span>

<table class="form-table">
<tr>
<th scope="row"><?php _e( 'Template' ); ?></th>
<td><input type="text" size="40" name="youtube_embed_template" value="<?php echo htmlspecialchars( $options[ 'template' ] ); ?>"/>&nbsp;<span class="description">Wrapper for video output. Must include <code>%video%</code> tag to show video position</span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Style' ); ?></th>
<td><input type="text" size="40" name="youtube_embed_style" value="<?php echo htmlspecialchars( $options[ 'style' ] ); ?>"/>&nbsp;<span class="description">CSS elements to apply to video</span></td>
</tr>
</table>

<table class="form-table ytbox_grey">
<tr>
<th scope="row"><?php _e( 'Video size' ); ?></th>
<td><input type="text" size="3" maxlength="3" name="youtube_embed_width" value="<?php echo $options[ 'width' ]; ?>"/>&nbsp;x&nbsp;<input type="text" size="3" maxlength="3" name="youtube_embed_height" value="<?php echo $options[ 'height' ]; ?>"/>&nbsp;<span class="description"><?php _e( 'The width x height of the video, in pixels' ); ?></span></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e( 'Default Sizes' ); ?></th>
<td><select name="youtube_embed_size">
<option value=""<?php if ( $default_size == '' ) { echo " selected='selected'"; } ?>><?php _e( 'Use above sizes' ); ?></option>
<option value="04800385"<?php if ( $default_size == "04800385" ) { echo " selected='selected'"; } ?>><?php echo '480x385 4:3'; ?></option>
<option value="05600340"<?php if ( $default_size == "05600340" ) { echo " selected='selected'"; } ?>><?php echo '560x340 16:9'; ?></option>
<option value="06400385"<?php if ( $default_size == "06400385" ) { echo " selected='selected'"; } ?>><?php echo '640x385 16:9'; ?></option>
<option value="08530505"<?php if ( $default_size == "08530505" ) { echo " selected='selected'"; } ?>><?php echo '853x505 16:9'; ?></option>
<option value="12800745"<?php if ( $default_size == "12800745" ) { echo " selected='selected'"; } ?>><?php echo '1280x745 16:9'; ?></option>
</select>&nbsp;<span class="description"><?php _e( 'Select one of these default sizes to override the above video sizes' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Dynamically Resize' ); ?></th>
<td><input type="checkbox" name="youtube_embed_dynamic" value="1"<?php if ( $options[ 'dynamic' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Show full width and resize with the browser' ); ?></span></td>
</tr>

<tr>
<th scope="row">&nbsp;&nbsp;&nbsp;&nbsp;<?php _e( 'Set Maximum Size' ); ?></th>
<td><input type="checkbox" name="youtube_embed_fixed" value="1"<?php if ( $options[ 'fixed' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Use above width to define maximum size' ); ?></span></td>
</tr>
</table>

<table class="form-table">

<tr>
<th scope="row"><?php _e( 'Audio Only' ); ?></th>
<td><input type="checkbox" name="youtube_embed_audio" value="1"<?php if ( $options[ 'audio' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Only show the toolbar for audio only playback' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Autoplay' ); ?></th>
<td><input type="checkbox" name="youtube_embed_autoplay" value="1"<?php if ( $options[ 'autoplay' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'The video will start playing when the player loads' ); ?></span></td>
</tr>

</table>

<br/><span class="yt_heading"><?php _e( 'Options Not Supported by EmbedPlus' ); ?></span>

<table class="form-table">

<tr>
<th scope="row"><?php _e( 'Auto hide' ); ?></th>
<td><select name="youtube_embed_autohide">
<option value="0"<?php if ( $options[ 'autohide' ] == "0" ) { echo " selected='selected'"; } ?>><?php _e( 'Controls &amp; progress bar remain visible' ); ?></option>
<option value="1"<?php if ( $options[ 'autohide' ] == "1" ) { echo " selected='selected'"; } ?>><?php _e( 'Controls &amp; progress bar fade out' ); ?></option>
<option value="2"<?php if ( $options[ 'autohide' ] == "2" ) { echo " selected='selected'"; } ?>><?php _e( 'Progress bar fades' ); ?></option>
</select>&nbsp;<span class="description"><?php _e( 'Video controls will automatically hide after a video begins playing' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Controls' ); ?></th>
<td><input type="checkbox" name="youtube_embed_controls" value="1"<?php if ( $options[ 'controls' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Video player controls will display' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'SSL' ); ?></th>
<td><input type="checkbox" name="youtube_embed_https" value="1"<?php if ( $options[ 'https' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Use SSL? <a href="http://www.google.com/support/youtube/bin/answer.py?answer=171780&expand=UseHTTPS#HTTPS">Read more</a>' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Loop Video' ); ?></th>
<td><input type="checkbox" name="youtube_embed_loop" value="1"<?php if ( $options[ 'loop' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Play the initial video again and again. In the case of a playlist, this will play the entire playlist and then start again at the first video' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Information' ); ?></th>
<td><input type="checkbox" name="youtube_embed_info" value="1"<?php if ( $options[ 'info' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Display the video title and uploader before the video starts' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Theme' ); ?></th>
<td><select name="youtube_embed_theme">
<option value="dark"<?php if ( $options[ 'theme' ] == "dark" ) { echo " selected='selected'"; } ?>><?php _e( 'Dark' ); ?></option>
<option value="light"<?php if ( $options[ 'theme' ] == "light" ) { echo " selected='selected'"; } ?>><?php _e( 'Light' ); ?></option>
</select>&nbsp;<span class="description"><?php _e( 'Display player controls within a dark or light control bar' ); ?></span></td>
</tr>
</table>

<br/><span class="yt_heading"><?php _e( 'Options for AS3 Player' ); ?></span>
<br/><br/>The following options are not supported if using EmbedPlus or if the IFRAME player uses HTML5.

<table class="form-table">
<tr>
<th scope="row"><?php _e( 'Annotations' ); ?></th>
<td><input type="checkbox" name="youtube_embed_annotation" value="1"<?php if ( $options[ 'annotation' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Video annotations are shown by default' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Closed Captions' ); ?></th>
<td><input type="checkbox" name="youtube_embed_cc" value="1"<?php if ( $options[ 'cc' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Show closed captions (subtitles) by default, even if the user has turned captions off' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Disable Keyboard' ); ?></th>
<td><input type="checkbox" name="youtube_embed_disablekb" value="1"<?php if ( $options[ 'disablekb' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Disable the player keyboard controls' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Fullscreen' ); ?></th>
<td><input type="checkbox" name="youtube_embed_fullscreen" value="1"<?php if ( $options[ 'fullscreen' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'A button will allow the viewer to watch the video fullscreen' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Link to YouTube' ); ?></th>
<td><input type="checkbox" name="youtube_embed_link" value="1"<?php if ( $options[ 'link' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Video links back to YouTube when clicked' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Modest Branding' ); ?></th>
<td><input type="checkbox" name="youtube_embed_modest" value="1"<?php if ( $options[ 'modest' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Reduce branding on video.' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Progress Bar Colour' ); ?></th>
<td><select name="youtube_embed_color">
<option value="red"<?php if ( $options[ 'color' ] == "red" ) { echo " selected='selected'"; } ?>><?php _e( 'Red' ); ?></option>
<option value="white"<?php if ( $options[ 'color' ] == "white" ) { echo " selected='selected'"; } ?>><?php _e( 'White (desaturated)' ); ?></option>
</select>&nbsp;<span class="description"><?php _e( 'The colour that will be used in the player\'s video progress bar to highlight the amount of the video that\'s already been seen' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Related Videos' ); ?></th>
<td><input type="checkbox" name="youtube_embed_related" value="1"<?php if ( $options[ 'related' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Load related videos once playback starts. Also toggles the search option.' ); ?></span></td>
</tr>
</table>

<br/><span class="yt_heading"><?php _e( 'Options Not Supported by HTML5 Player' ); ?></span>

<table class="form-table">
<tr valign="top">
<th scope="row"><?php _e( 'Window Mode' ); ?></th>
<td><select name="youtube_embed_wmode">
<option value="opaque"<?php if ( $options[ 'wmode' ] == "opaque" ) { echo " selected='selected'"; } ?>><?php _e( 'Opaque' ); ?></option>
<option value="transparent"<?php if ( $options[ 'wmode' ] == "transparent" ) { echo " selected='selected'"; } ?>><?php _e( 'Transparent' ); ?></option>
<option value="window"<?php if ( $options[ 'wmode' ] == "window" ) { echo " selected='selected'"; } ?>><?php _e( 'Window' ); ?></option>
</select><span class="description"><?php _e( 'Sets the Window Mode property of the Flash movie for transparency, layering, and positioning in the browser. <a href="http://www.communitymx.com/content/article.cfm?cid=e5141">Learn more</a>.' ); ?></span></td>
</tr>

</table>

<br/><span class="yt_heading"><?php _e( 'Options Only Supported By EmbedPlus' ); ?></span>&nbsp;&nbsp;<span class="description"><?php echo '<a href="http://www.artiss.co.uk/artiss-youtube-embed/further-help#ye-embedplus">' . __( 'Learn more about EmbedPlus' ) . '</a>'; ?></span>

<table class="form-table">
<tr valign="top">
<th scope="row"><?php _e( 'Fallback Embed Type' ); ?></th>
<td><span class="description"><?php _e( 'The type of player to use if Flash is not available and EmbedPlus cannot be used.' ); ?></span><br/>
<input type="radio" name="youtube_embed_fallback" value="v"<?php if ( $options[ 'fallback' ] == "v" ) { echo ' checked="checked"'; } ?>/>&nbsp;<?php _e( 'IFRAME' ); ?><br/>
<input type="radio" name="youtube_embed_fallback" value="p"<?php if ( $options[ 'fallback' ] == "p" ) { echo ' checked="checked"'; } ?>/>&nbsp;<?php _e( 'OBJECT' ); ?></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Play HD' ); ?></th>
<td><input type="checkbox" name="youtube_embed_hd" value="1"<?php if ( $options[ 'hd' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Play the video in HD if possible' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Real-time Reactions' ); ?></th>
<td><input type="checkbox" name="youtube_embed_react" value="1"<?php if ( $options[ 'react' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Show the Real-time Reactions button' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Sweet Spots' ); ?></th>
<td><input type="checkbox" name="youtube_embed_sweetspot" value="1"<?php if ( $options[ 'sweetspot' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Find sweet spots for the next and previous buttons' ); ?></span></td>
</tr>
</table>

<?php wp_nonce_field( 'youtube-embed-profile', 'youtube_embed_profile_nonce', true, true ); ?>

<p class="submit"><input type="submit" name="Submit" class="button-primary" value="<?php _e( 'Save Settings' ); ?>"/></p>

</form>

<div class="updated fade"><p><strong><?php _e( 'Would you like the video below to be yours? <a href="http://www.artiss.co.uk/contact">Contact me</a> for sponsorship information.' ); ?></strong></p></div>

<a href="#" name="video"></a>
<form method="post" action="<?php echo get_bloginfo( 'wpurl' ).'/wp-admin/admin.php?page=aye-profile-options#video' ?>">
<div class="ytbox_grey">
<h3><?php _e( 'YouTube Video Sample' ); ?></h3>
<p><?php _e( 'This uses the above settings, once they have been saved. <b>Would you like this to be your video? If so, <a href="http://www.artiss.co.uk/contact">contact me</a>!</b>' ); ?></p>
<p><?php _e( 'Use the drop-down below to change which parameters the video uses - press the Change Video button to update it.' ); ?></p>
<p><select name="youtube_embed_video_type">
<option value="d"<?php if ( $video_type == "d" ) { echo " selected='selected'"; } ?>><?php _e( 'Standard' ); ?></option>
<option value="p"<?php if ( $video_type == "p" ) { echo " selected='selected'"; } ?>><?php _e( 'EmbedPlus' ); ?></option>
<option value="3"<?php if ( $video_type == "3" ) { echo " selected='selected'"; } ?>><?php _e( '3D' ); ?></option>
<option value="l"<?php if ( $video_type == "l" ) { echo " selected='selected'"; } ?>><?php _e( 'Playlist' ); ?></option>
</select>
<?php wp_nonce_field( 'youtube-embed-profile', 'youtube_embed_profile_nonce', true, true ); ?>
<input type="submit" name="Video" class="button-secondary" value="<?php _e( 'Change video' ); ?>"/></p>

<p><?php
if ( $video_type == "d" ) { $id = '-0Xa4bHcJu8'; $type = ''; }
if ( $video_type == "p" ) { $id = 'YVvn8dpSAt0'; $type = 'm'; }
if ( $video_type == "3" ) { $id = 'NR5UoBY87GM'; $type = ''; ; }
if ( $video_type == "l" ) { $id = '095393D5B42B2266'; $type = ''; }
echo aye_generate_youtube_code( $id, $type, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', $profile_no );
?></p>
</div>

</form>

</div>