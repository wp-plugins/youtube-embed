<?php
/**
* Admin Config Functions
*
* Various functions relating to the various administration screens
*
* @package	YouTubeEmbed
*/

/**
* Admin Screen Initialisation
*
* Set up admin menu and submenu options
*
* @since	2.0
*
* @uses		ye_add_submenu	Add a submenu, with optional help drop-down
*/

function ye_menu_initialise() {

	add_menu_page( 'YouTube Embed Options', 'YouTube', 'manage_options', 'youtube-embed-general', 'ye_general_options', plugins_url() . '/youtube-embed/images/menu_icon.png' );

	ye_add_submenu( 'YouTube Embed Options', 'Options', 'youtube-embed-general', 'ye_general_options' );
	ye_add_submenu( 'YouTube Embed Profiles', 'Profiles', 'youtube-embed-profiles', 'ye_profile_options' );
	ye_add_submenu( 'YouTube Embed Lists', 'Lists', 'youtube-embed-lists', 'ye_list_options' );

    if ( function_exists( 'wp_readme_parser' ) ) {
        ye_add_submenu( 'YouTube Embed README', 'README', 'youtube-embed-readme', 'ye_support_readme' );
    }

	ye_add_submenu( 'YouTube Embed About', 'About', 'youtube-embed-about', 'ye_support_about' );

	add_filter( 'plugin_action_links', 'ye_add_settings_link', 10, 2 );
}

add_action( 'admin_menu','ye_menu_initialise' );

add_filter( 'plugin_row_meta', 'ye_set_plugin_meta', 10, 2 );

/**
* Include general options screen
*
* XHTML options screen to prompt and update some general plugin options
*
* @since	2.0
*/

function ye_general_options() {

	include_once( WP_PLUGIN_DIR . "/youtube-embed/includes/options-general.php" );

}

/**
* Include profile options screen
*
* XHTML options screen to prompt and update profile options
*
* @since	2.0
*/

function ye_profile_options() {

	include_once( WP_PLUGIN_DIR . "/youtube-embed/includes/options-profiles.php" );

}

/**
* Include list options screen
*
* XHTML options screen to prompt and update list options
*
* @since	2.0
*/

function ye_list_options() {

	include_once( WP_PLUGIN_DIR . "/youtube-embed/includes/options-lists.php" );

}

/**
* Include README screen
*
* Parse and display the README instructions
*
* @since	2.4
*/

function ye_support_readme() {
	include_once( WP_PLUGIN_DIR . "/youtube-embed/includes/display-readme.php" );
}

/**
* Include about and support screen
*
* XHTML about screen which will, optionally, display help details as well
*
* @since	2.0
*/

function ye_support_about() {

	include_once( WP_PLUGIN_DIR . "/youtube-embed/includes/about.php" );

}

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

function ye_add_settings_link( $links, $file ) {

	static $this_plugin;

	if ( !$this_plugin ) { $this_plugin = plugin_basename( __FILE__ ); }

	if ( strpos( $file, 'youtube-embed.php' ) !== false ) {
		$settings_link = '<a href="admin.php?page=youtube-embed-general">' . __( 'Settings' ) . '</a>';
		array_unshift( $links, $settings_link );
	}

	return $links;
}

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

function ye_set_plugin_meta( $links, $file ) {

	if ( strpos( $file, 'youtube-embed.php' ) !== false ) {

		$links = array_merge( $links, array( '<a href="admin.php?page=youtube-embed-about">' . __( 'Support' ) . '</a>' ) );

		$links = array_merge( $links, array( '<a href="http://www.artiss.co.uk/donate">' . __( 'Donate' ) . '</a>' ) );

	}

	return $links;
}


/**
* Add a submenu and, optionally, help
*
* Add a submenu and, if using WP 3 and above, help instructions to the drop-down
* at the top of the screen
*
* @since	2.0
*
* @param	string	$page_title	Title to give menu page
* @param	string	$menu_title	Title for menu option
* @param	string	$menu_slug	Unique slug for the menu
* @param	string	$function	Function name for menu option
*/

function ye_add_submenu( $page_title, $menu_title, $menu_slug, $function ) {

	$profile_slug = add_submenu_page( 'youtube-embed-general', $page_title, $menu_title, 'manage_options', $menu_slug, $function );

	if ( $menu_slug == "youtube-embed-general" ) { $help_text = '<p>This screen allows you to select non-specific options for the Artiss YouTube Embed plugin. For the default embedding settings, please select the <a href="http://www.artiss.co.uk/wp-admin/admin.php?page=youtube-embed-profiles">Profiles</a> administration option.</p>'; }

	if ( $menu_slug == "youtube-embed-profiles" ) { $help_text = "<p>This screen allows you to set the options for the default and additional profiles. If you don't specify a specific parameter when displaying your YouTube video then the default profile option will be used instead. Additional profiles, which you may name, can be used as well and used as required.</p>"; }

	if ( $menu_slug == "youtube-embed-lists" ) { $help_text = '<p>This screen allows you to create lists of YouTube videos, which may be named. These lists can then be used in preference to a single video ID.</p>'; }

	if ( ( $menu_slug != "youtube-embed-about" ) && ( $menu_slug != "youtube-embed-readme" ) ) {
		$help_text .= '<p>Remember to click the Save Settings button at the bottom of the screen for new settings to take effect.</p>';
	} else {
		$help_text = '<p>This screen provides useful information about this plugin along with methods of support.</p>';
	}

	$help_text .= '<p><strong>For more information:</strong></p><p><a href="http://www.artiss.co.uk/artiss-youtube-embed">Artiss YouTube Embed Plugin Documentation</a></p><p><a href="http://code.google.com/apis/youtube/player_parameters.html">YouTube Player Documentation</a></p>';

	if ( $menu_slug == "youtube-embed-profiles" ) { $help_text .= '<p><a href="http://embedplus.com/">EmbedPlus website</a></p>'; }

	$help_text .= '<p><a href="http://www.artiss.co.uk/forum/specific-plugins-group2/artiss-youtube-embed-forum7">Artiss YouTube Embed Support Forum</a></p><h4>This plugin, and all support, is supplied for free, but <a title="Donate" href="http://artiss.co.uk/donate" target="_blank">donations</a> are always welcome.</h4>';

	add_contextual_help( $profile_slug, __( $help_text ) );

	return;
}

/**
* Detect plugin activation
*
* Upon detection of activation set an option
*
* @since	2.4
*/

function ye_plugin_activate() {

	update_option( 'youtube_embed_activated', true );

}
register_activation_hook( WP_PLUGIN_DIR . "/youtube-embed/youtube-embed.php", 'ye_plugin_activate' );

// If plugin activated, run activation commands and delete option

global $wp_version;

if ( get_option( 'youtube_embed_activated' ) && ( ( float ) $wp_version >= 3.3 ) ) {

    add_action( 'admin_enqueue_scripts', 'ye_admin_enqueue_scripts' );

    delete_option( 'youtube_embed_activated' );

}

/**
* Enqueue Feature Pointer files
*
* Add the required feature pointer files
*
* @since	2.4
*/

function ye_admin_enqueue_scripts() {

    wp_enqueue_style( 'wp-pointer' );
    wp_enqueue_script( 'wp-pointer' );

    add_action( 'admin_print_footer_scripts', 'ye_admin_print_footer_scripts' );
}

/**
* Show Feature Pointer
*
* Display feature pointer
*
* @since	2.4
*/

function ye_admin_print_footer_scripts() {

    $pointer_content = '<h3>Welcome to Artiss YouTube Embed</h3>';
    $pointer_content .= '<p style="font-style:italic;">Thank you for installing this plugin.</p>';
    $pointer_content .= '<p>These new menu options will allow you to configure your videos to just how you want them and provide links for help and support.</p><p>Even if you do nothing else, please visit the Profiles option to check your default video values.';
?>
<script>
jQuery(function () {
	var body = jQuery(document.body),
	menu = jQuery('#toplevel_page_youtube-embed-general'),
	collapse = jQuery('#collapse-menu'),
	yembed = menu.find("a[href='admin.php?page=youtube-embed-profiles']"),
	options = {
		content: '<?php echo $pointer_content; ?>',
		position: {
			edge: 'left',
			align: 'center',
			of: menu.is('.wp-menu-open') && !menu.is('.folded *') ? yembed : menu
		},
		close: function() {
		}};

	if ( !yembed.length )
		return;

	body.pointer(options).pointer('open');
});
</script>
<?php
}
?>