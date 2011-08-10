<?php
/**
* General Options Page
*
* Screen for generic options
*
* @package	YouTubeEmbed
* @since	2.0
*/

?>
<div class="wrap">
<div class="icon32"><img src="<?php echo WP_PLUGIN_URL; ?>/youtube-embed/images/screen_icon.png" alt="" title="" height="32px" width="32px"/><br /></div>
<h2>Artiss YouTube Embed Options</h2>

<?php
// If options have been updated on screen, update the database
if ( ( !empty( $_POST ) ) && ( check_admin_referer( 'youtube-embed-general', 'youtube_embed_general_nonce' ) ) ) {

	$options[ 'editor_button' ] = $_POST[ 'youtube_embed_editor_button' ];
	$options[ 'admin_bar' ]	= $_POST[ 'youtube_embed_admin_bar' ];
	$options[ 'profile_no' ] = $_POST[ 'youtube_embed_profile_no' ];

	// If the number of profiles is less than zero, put it to 0
	if ( $options[ 'profile_no' ] < 0 ) { $options[ 'profile_no' ] = 0; }

	$options[ 'list_no' ] = $_POST[ 'youtube_embed_list_no' ];

	// If the number of lists is less than 1, put it to 1
	if ( $options[ 'list_no' ] < 1 ) { $options[ 'list_no' ] = 1; }

	$options[ 'embed_cache' ] = $_POST[ 'youtube_embed_embed_cache' ];
	$options[ 'info_cache' ] = $_POST[ 'youtube_embed_info_cache' ];
	$options[ 'transcript_cache' ] = $_POST[ 'youtube_embed_transcript_cache' ];
	$options[ 'fetch_title' ] = $_POST[ 'youtube_embed_fetch_title' ];
	$options[ 'alt_profile' ] = $_POST[ 'youtube_embed_alt_profile' ];
	$options[ 'alt_profile2' ] = $_POST[ 'youtube_embed_alt_profile2' ];
	$options[ 'bracket' ] = $_POST[ 'youtube_embed_bracket' ];
	$options[ 'alt' ] = $_POST[ 'youtube_embed_alt' ];
	$options[ 'other_profile' ] = $_POST[ 'youtube_embed_other_profile' ];
	$options[ 'url_profile' ] = $_POST[ 'youtube_embed_url_profile' ];
	$options[ 'comments' ] = $_POST[ 'youtube_embed_comments' ];
	$options[ 'comments_profile' ] = $_POST[ 'youtube_embed_comments_profile' ];
	$options[ 'metadata' ] = $_POST[ 'youtube_embed_metadata' ];
	$options[ 'feed' ] = $_POST[ 'youtube_embed_feed' ];
	$options[ 'api_errors' ] = $_POST[ 'youtube_embed_api_errors' ];

	// Update the options
	update_option( 'youtube_embed_general', $options );

	// Update the alternative shortcodes
	$shortcode[ 1 ] = $_POST[ 'youtube_embed_shortcode' ];
	$shortcode[ 2 ] = $_POST[ 'youtube_embed_shortcode2' ];	
	update_option( 'youtube_embed_shortcode', $shortcode );

	// Update the URL override
	update_option( 'youtube_embed_url', $_POST[ 'youtube_embed_url' ] );

	echo '<div class="updated fade"><p><strong>' . __( 'Settings Saved.' ) . "</strong></p></div>\n";
}

// Get options
$options = ye_set_general_defaults();
$shortcode = ye_set_shortcode_option();
$url = ye_set_url_option();
?>

<p><?php _e( 'These are the general settings for Artiss YouTube Embed. Please select <a href="http://www.artiss.co.uk/wp-admin/admin.php?page=youtube-embed-profiles">Profiles</a> for default embedding settings.' ); ?></p>

<form method="post" action="<?php echo get_bloginfo( 'wpurl' ).'/wp-admin/admin.php?page=youtube-embed-general' ?>">

<span class="yt_heading"><?php _e( 'Embedding' ); ?></span>

<table class="form-table">
<tr>
<th scope="row"><?php _e( 'Add Metadata' ); ?></th>
<td><input type="checkbox" name="youtube_embed_metadata" value="1"<?php if ( $options[ 'metadata' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Allow rich metadata to be added to code. <a href="http://www.artiss.co.uk/artiss-youtube-embed/further-help#ye-metadata">Learn more</a>' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'URL Embedding' ); ?></th>
<td><input type="checkbox" name="youtube_embed_url" value="1"<?php if ( $url == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Override built-in WP processing of YouTube URLs. <a href="http://www.artiss.co.uk/artiss-youtube-embed/further-help#ye-urls">Learn more</a>' ); ?></span></td>
</tr>

<tr>
<th scope="row">&nbsp;&nbsp;&nbsp;&nbsp;<?php _e( 'Profile to use' ); ?></th>
<td><select name="youtube_embed_url_profile">
<?php ye_generate_profile_list( $options[ 'url_profile' ], $options[ 'profile_no' ] ) ?>
</select></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Comment Embedding' ); ?></th>
<td><input type="checkbox" name="youtube_embed_comments" value="1"<?php if ( $options[ 'comments' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Allow YouTube URLs in comments - will display as embedded videos. <a href="http://www.artiss.co.uk/artiss-youtube-embed/further-help#ye-comments">Learn more</a>' ); ?></span></td>
</tr>

<tr>
<th scope="row">&nbsp;&nbsp;&nbsp;&nbsp;<?php _e( 'Profile to use' ); ?></th>
<td><select name="youtube_embed_comments_profile">
<?php ye_generate_profile_list( $options[ 'comments_profile' ], $options[ 'profile_no' ] ) ?>
</select></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Feed' ); ?></th>
<td><select name="youtube_embed_feed">
<option value="t"<?php if ( $options[ 'feed' ] == "t" ) { echo " selected='selected'"; } ?>><?php _e ( 'Text link' ); ?></option>
<option value="v"<?php if ( $options[ 'feed' ] == "v" ) { echo " selected='selected'"; } ?>><?php _e ( 'Thumbnail' ); ?></option>
<option value="b"<?php if ( $options[ 'feed' ] == "b" ) { echo " selected='selected'"; } ?>><?php _e ( 'Thumbnail &amp; Text Link' ); ?></option>
</select>&nbsp;<span class="description"><?php _e( 'Videos cannot be embedded in feeds. Select how you wish them to be shown instead.' ); ?></span></td>
</tr>
</table>

<br/><span class="yt_heading"><?php _e( 'Alternative Shortcodes' ); ?></span><br/><br/>Specify up to 2 alternative shortcodes to compliment the standard <code>[youtube]</code> shortcode.

<table class="form-table">
<tr>
<th scope="row"><?php _e( 'Alternative Shortcode 1' ); ?></th>
<td><input type="text" size="30" name="youtube_embed_shortcode" value="<?php echo $shortcode[ 1 ]; ?>"/></td>
</tr>

<tr>
<th scope="row">&nbsp;&nbsp;&nbsp;&nbsp;<?php _e( 'Profile to use' ); ?></th>
<td><select name="youtube_embed_alt_profile">
<?php ye_generate_profile_list( $options[ 'alt_profile' ], $options[ 'profile_no' ] ) ?>
</select></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Alternative Shortcode 2' ); ?></th>
<td><input type="text" size="30" name="youtube_embed_shortcode2" value="<?php echo $shortcode[ 2 ]; ?>"/></td>
</tr>

<tr>
<th scope="row">&nbsp;&nbsp;&nbsp;&nbsp;<?php _e( 'Profile to use' ); ?></th>
<td><select name="youtube_embed_alt_profile2">
<?php ye_generate_profile_list( $options[ 'alt_profile2' ], $options[ 'profile_no' ] ) ?>
</select></td>
</tr>
</table>

<br/><span class="yt_heading"><?php _e( 'Migration' ); ?></span><br/><br/>Switch on compatibility with other embedding plugins. For more details on migrating from another plugin, please <a href="http://www.artiss.co.uk/artiss-youtube-embed/compatibility">click here</a>.

<table class="form-table">
<tr>
<th scope="row"><?php _e( 'Bracket Embedding' ); ?></th>
<td><input type="checkbox" name="youtube_embed_bracket" value="1"<?php if ( $options[ 'bracket' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Allow embedding using URLs within brackets. Activating impacts performance' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Alternative Embedding' ); ?></th>
<td><input type="checkbox" name="youtube_embed_alt" value="1"<?php if ( $options[ 'alt' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Allow all other types of embedding. Activating impacts performance' ); ?></span></td>
</tr>

<tr>
<th scope="row">&nbsp;&nbsp;&nbsp;&nbsp;<?php _e( 'Profile to use' ); ?></th>
<td><select name="youtube_embed_other_profile">
<?php ye_generate_profile_list( $options[ 'other_profile' ], $options[ 'profile_no' ] ) ?>
</select>&nbsp;<span class="description"><?php _e( 'For above 2 options' ); ?></span></td>
</tr>
</table>

<br/><span class="yt_heading"><?php _e( 'Admin Options' ); ?></span>

<table class="form-table">
<tr>
<th scope="row"><?php _e( 'Show YouTube Button' ); ?></th>
<td><input type="checkbox" name="youtube_embed_editor_button" value="1"<?php if ( $options[ 'editor_button' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Show the YouTube button on the post editor' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Add to Admin Bar' ); ?></th>
<td><input type="checkbox" name="youtube_embed_admin_bar" value="1"<?php if ( $options[ 'admin_bar' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'Add link to options screen to Admin Bar' ); ?></span></td>
</tr>
</table>

<br/><span class="yt_heading"><?php _e( 'Profile &amp; List Sizes' ); ?></span>

<table class="form-table">
<tr>
<th scope="row"><?php _e( 'Number of Profiles' ); ?></th>
<td><input type="text" size="2" maxlength="2" name="youtube_embed_profile_no" value="<?php echo $options[ 'profile_no' ]; ?>"/>&nbsp;<span class="description"><?php _e( 'Maximum number of profiles' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Number of Lists' ); ?></th>
<td><input type="text" size="2" maxlength="2" name="youtube_embed_list_no" value="<?php echo $options[ 'list_no' ]; ?>"/>&nbsp;<span class="description"><?php _e( 'Maximum number of lists' ); ?></span></td>
</tr>
</table>

<br/><span class="yt_heading"><?php _e( 'Performance' ); ?></span>

<table class="form-table">
<tr>
<th scope="row"><?php _e( 'Embed Cache' ); ?></th>
<td><input type="text" size="3" maxlength="3" name="youtube_embed_embed_cache" value="<?php echo $options[ 'embed_cache' ]; ?>"/>&nbsp;<span class="description"><?php _e( 'How many hours to retain embed output. 0 to switch off' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Video Information Cache' ); ?></th>
<td><input type="text" size="3" maxlength="3" name="youtube_embed_info_cache" value="<?php echo $options[ 'info_cache' ]; ?>"/>&nbsp;<span class="description"><?php _e( 'How many hours to retain video information, including it\'s validity.  0 to switch off' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Transcript Cache' ); ?></th>
<td><input type="text" size="3" maxlength="3" name="youtube_embed_transcript_cache" value="<?php echo $options[ 'transcript_cache' ]; ?>"/>&nbsp;<span class="description"><?php _e( 'How many hours to store transcripts for in cache. 0 to switch off' ); ?></span></td>
</tr>
</table>

<br/><span class="yt_heading"><?php _e( 'Error Reporting' ); ?></span>

<table class="form-table">
<tr>
<th scope="row"><?php _e( 'Report API Errors' ); ?></th>
<td><input type="checkbox" name="youtube_embed_api_errors" value="1"<?php if ( $options[ 'api_errors' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( 'If switched off errors with the YouTube API will not be reported. Read the plugin FAQ for more details about this before proceeding' ); ?></span></td>
</tr>
</table>

<?php wp_nonce_field( 'youtube-embed-general','youtube_embed_general_nonce', true, true ); ?>

<p class="submit"><input type="submit" name="Submit" class="button-primary" value="<?php _e( 'Save Settings' ); ?>"/></p>

</form>

</div>