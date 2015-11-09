<?php
/**
* Admin Config Functions
*
* Various functions relating to the various administration screens
*
* @package	YouTube-Embed
*/

/**
* Add Settings link to plugin list
*
* Add a Settings link to the options listed against this plugin
*
* @since	2.0
*
* @param	string  $links	Current links
* @param	string  $file	File in use
* @return   string			Links, now with settings added
*/

function vye_add_settings_link( $links, $file ) {

	static $this_plugin;

	if ( !$this_plugin ) { $this_plugin = plugin_basename( __FILE__ ); }

	if ( strpos( $file, 'youtube-embed.php' ) !== false ) {
		$settings_link = '<a href="admin.php?page=ye-general-options">' . __( 'Settings', 'youtube-embed' ) . '</a>';
		array_unshift( $links, $settings_link );
	}

	return $links;
}

add_filter( 'plugin_action_links', 'vye_add_settings_link', 10, 2 );

/**
* Add meta to plugin details
*
* Add options to plugin meta line
*
* @since	2.0
*
* @param	string  $links	Current links
* @param	string  $file	File in use
* @return   string			Links, now with settings added
*/

function vye_set_plugin_meta( $links, $file ) {

	if ( strpos( $file, 'youtube-embed.php' ) !== false ) {

		$links = array_merge( $links, array( '<a href="https://wordpress.org/support/plugin/youtube-embed">' . __( 'Support', 'youtube-embed' ) . '</a>' ) );
		$links = array_merge( $links, array( '<a href="http://www.artiss.co.uk/donate">' . __( 'Donate', 'youtube-embed' ) . '</a>' ) );

	}

	return $links;
}

add_filter( 'plugin_row_meta', 'vye_set_plugin_meta', 10, 2 );

/**
* Admin Screen Initialisation
*
* Set up admin menu and submenu options
*
* @since	2.0
*
* @uses     vye_contextual_help_type    Work out help type
*/

function vye_menu_initialise() {

	// Get level access for menus

	$options = vye_set_general_defaults();

	$menu_access = $options[ 'menu_access' ];

	// Add main admin option

	$menu_icon = 'dashicons-video-alt3';

	add_menu_page( __( 'About YouTube Embed', 'youtube-embed' ), __( 'YouTube', 'youtube-embed' ), $menu_access, 'ye-general-options', 'vye_general_options', $menu_icon, 12 );

	// Add options sub-menu

	global $vye_options_hook;

	$vye_options_hook = add_submenu_page( 'ye-general-options', __( 'YouTube Embed Options', 'youtube-embed' ),  __( 'Options', 'youtube-embed' ), $menu_access, 'ye-general-options', 'vye_general_options' );

	add_action( 'load-' . $vye_options_hook, 'vye_add_options_help' );

	// Add profiles sub-menu

	global $vye_profiles_hook;

	$vye_profiles_hook = add_submenu_page( 'ye-general-options', __( 'YouTube Embed Profiles', 'youtube-embed' ), __( 'Profiles', 'youtube-embed' ), $menu_access, 'ye-profile-options', 'vye_profile_options' );

	add_action( 'load-' . $vye_profiles_hook, 'vye_add_profiles_help' );

	// Add lists sub-menu

	global $vye_lists_hook;

	$vye_lists_hook = add_submenu_page( 'ye-general-options', __( 'YouTube Embed Lists', 'youtube-embed' ), __( 'Lists', 'youtube-embed' ), $menu_access, 'ye-list-options', 'vye_list_options' );

	add_action( 'load-' . $vye_lists_hook, 'vye_add_lists_help' );

}

add_action( 'admin_menu', 'vye_menu_initialise' );

/**
* Include general options screen
*
* XHTML options screen to prompt and update some general plugin options
*
* @since	2.0
*/

function vye_general_options() {

	include_once( WP_PLUGIN_DIR . '/youtube-embed/includes/options-general.php' );

}

/**
* Include profile options screen
*
* XHTML options screen to prompt and update profile options
*
* @since	2.0
*/

function vye_profile_options() {

	include_once( WP_PLUGIN_DIR . '/youtube-embed/includes/options-profiles.php' );

}

/**
* Include list options screen
*
* XHTML options screen to prompt and update list options
*
* @since	2.0
*/

function vye_list_options() {

	include_once( WP_PLUGIN_DIR . '/youtube-embed/includes/options-lists.php' );

}

/**
* Add Options Help
*
* Add help tab to options screen
*
* @since	2.5
*
* @uses     vye_options_help    Return help text
*/

function vye_add_options_help() {

	global $vye_options_hook;
	$screen = get_current_screen();

	if ( $screen->id != $vye_options_hook ) { return; }

	$screen -> add_help_tab( array( 'id' => 'options-help-tab', 'title'	=> __( 'Help', 'youtube-embed' ), 'content' => vye_options_help() ) );
}

/**
* Options Help
*
* Return help text for options screen
*
* @since	2.5
*
* @return	string	Help Text
*/

function vye_options_help() {

	$help_text = '<p>' . __( 'This screen allows you to select non-specific options for the YouTube Embed plugin. For the default embedding settings, please select the <a href="admin.php?page=ye-profile-options">Profiles</a> administration option.', 'youtube-embed' ) . '</p>';
	$help_text .= '<p>' . __( 'Remember to click the Save Changes button at the bottom of the screen for new settings to take effect.', 'youtube-embed' ) . '</p>';
	$help_text .= '<p><strong>' . __( 'For more information:', 'youtube-embed' ) . '</strong></p>';
	$help_text .= '<p><a href="https://wordpress.org/plugins/youtube-embed/">' . __( 'YouTube Embed Plugin Documentation', 'youtube-embed' ) . '</a></p>';
	$help_text .= '<p><a href="http://code.google.com/apis/youtube/player_parameters.html">' . __( 'YouTube Player Documentation', 'youtube-embed' ) . '</a></p>';

	return $help_text;
}

/**
* Add Profiles Help
*
* Add help tab to profiles screen
*
* @since	2.5
*
* @uses     vye_profiles_help    Return help text
*/

function vye_add_profiles_help() {

	global $vye_profiles_hook;
	$screen = get_current_screen();

	if ( $screen->id != $vye_profiles_hook ) { return; }

	$screen -> add_help_tab( array( 'id' => 'profiles-help-tab', 'title'	=> __( 'Help', 'youtube-embed' ), 'content' => vye_profiles_help() ) );
}

/**
* Profiles Help
*
* Return help text for profiles screen
*
* @since	2.5
*
* @return	string	Help Text
*/

function vye_profiles_help() {

	$help_text = '<p>' . __( 'This screen allows you to set the options for the default and additional profiles. If you don\'t specify a specific parameter when displaying your YouTube video then the default profile option will be used instead. Additional profiles, which you may name, can be used as well and used as required.', 'youtube-embed' ) . '</p>';
	$help_text .= '<p>' . __( 'All settings will work whether the Flash or HTML5 player is used, unless one of the following icons is shown, indicating which format the option works with...', 'youtube-embed' ) . '</p>';
	$help_text .= "<p><img src='" . plugins_url() . "/youtube-embed/images/flash.png' width='10px'> - " . __( 'Flash player', 'youtube-embed' ) . '</br>';
	$help_text .= "<img src='" . plugins_url() . "/youtube-embed/images/html5.png' width='10px'> - " . __( 'HTML5 player', 'youtube-embed' ) . '</br>';
	$help_text .= '<p>' . __( 'Remember to click the Save Changes button at the bottom of the screen for new settings to take effect.', 'youtube-embed' ) . '</p>';
	$help_text .= '<p><strong>' . __( 'For more information:' ) . '</strong></p>';
	$help_text .= '<p><a href="https://wordpress.org/plugins/youtube-embed/">' . __( 'YouTube Embed Plugin Documentation', 'youtube-embed' ) . '</a></p>';
	$help_text .= '<p><a href="http://code.google.com/apis/youtube/player_parameters.html">' . __( 'YouTube Player Documentation', 'youtube-embed' ) . '</a></p>';

	return $help_text;
}

/**
* Add Lists Help
*
* Add help tab to lists screen
*
* @since	2.5
*
* @uses     vye_lists_help    Return help text
*/

function vye_add_lists_help() {

	global $vye_lists_hook;
	$screen = get_current_screen();

	if ( $screen->id != $vye_lists_hook ) { return; }

	$screen -> add_help_tab( array( 'id' => 'lists-help-tab', 'title'	=> __( 'Help', 'youtube-embed' ), 'content' => vye_lists_help() ) );
}

/**
* List Help
*
* Return help text for lists screen
*
* @since	2.5
*
* @return	string	Help Text
*/

function vye_lists_help() {

	$help_text = '<p>' . __( 'This screen allows you to create lists of YouTube videos, which may be named. These lists can then be used in preference to a single video ID.', 'youtube-embed' ) . '</p>';
	$help_text .= '<p>' . __( 'Remember to click the Save Changes button at the bottom of the screen for new settings to take effect.', 'youtube-embed' ) . '</p>';
	$help_text .= '<p><strong>' . __( 'For more information:', 'youtube-embed' ) . '</strong></p>';
	$help_text .= '<p><a href="https://wordpress.org/plugins/youtube-embed/">' . __( 'YouTube Embed Plugin Documentation', 'youtube-embed' ) . '</a></p>';
	$help_text .= '<p><a href="http://code.google.com/apis/youtube/player_parameters.html">' . __( 'YouTube Player Documentation', 'youtube-embed' ) . '</a></p>';

	return $help_text;
}

/**
* Set up TinyMCE button
*
* Add filters (assuming user is editing) for TinyMCE
*
* @uses     vye_set_general_defaults    Set default options
*
* @since 	2.0
*/

function youtube_embed_button() {

	// Ensure user is in rich editor and button option is switched on

	if ( get_user_option( 'rich_editing' ) == 'true' ) {

		$options = vye_set_general_defaults();
		if ( $options[ 'editor_button' ] != '' ) {

			// Add filters

			add_filter( 'mce_external_plugins', 'add_youtube_embed_mce_plugin' );
			add_filter( 'mce_buttons', 'register_youtube_embed_button' );
		}
	}
}
add_action( 'init', 'youtube_embed_button' );

/**
* Register new TinyMCE button
*
* Register details of new TinyMCE button
*
* @since	2.0
*
* @param	string	$buttons	TinyMCE button data
* @return	string				TinyMCE button data, but with new YouTube button added
*/

function register_youtube_embed_button( $buttons ) {

	array_push( $buttons, 'mce4_youtube_button' );

	return $buttons;
}

/**
* Register TinyMCE Script
*
* Register JavaScript that will be actioned when the new TinyMCE button is used
*
* @since	2.0
*
* @param	string	$plugin_array	Array of MCE plugin data
* @return	string					Array of MCE plugin data, now with URL of MCE script
*/

function add_youtube_embed_mce_plugin( $plugin_array ) {

	$plugin_array[ 'mce4_youtube_button' ] = plugins_url() . '/youtube-embed/js/mce4-button.min.js';

	return $plugin_array;
}
?>