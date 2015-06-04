<?php
/**
* Admin Bar
*
* Set up Admin Bar links
*
* @package	YouTube-Embed
*/

/**
* Add option to Admin Bar
*
* Add link to YouTube Embed profile options to Admin Bar.
* With help from http://technerdia.com/1140_wordpress-admin-bar.html
*
* @uses     vye_set_general_default     Set default options
*
* @since	2.5
*/

function vye_admin_bar_render( $meta = TRUE ) {

	$options = vye_set_general_defaults();

	if ( $options[ 'admin_bar' ] != '' ) {

		global $wp_admin_bar;

		if ( !is_user_logged_in() ) { return; }
		if ( !is_admin_bar_showing() ) { return; }
		if ( !current_user_can( $options[ 'menu_access' ] ) ) { return; }

		$wp_admin_bar -> add_menu( array(
			'id' => 'aye-menu',
			'title' => __( 'YouTube Embed', 'youtube-embed' ) ) );

		$wp_admin_bar -> add_menu( array(
			'parent' => 'aye-menu',
			'id' => 'aye-options',
			'title' => __( 'Options', 'youtube-embed' ),
			'href' => admin_url( 'admin.php?page=general-options' ),
			'meta' => array( 'target' => '_blank' ) ) );

		$wp_admin_bar -> add_menu( array(
			'parent' => 'aye-menu',
			'id' => 'aye-profile',
			'title' => __( 'Profiles', 'youtube-embed' ),
			'href' => admin_url( 'admin.php?page=profile-options' ),
			'meta' => array( 'target' => '_blank' ) ) );

		$wp_admin_bar -> add_menu( array(
			'parent' => 'aye-menu',
			'id' => 'aye-lists',
			'title' => __( 'Lists', 'youtube-embed' ),
			'href' => admin_url( 'admin.php?page=list-options' ),
			'meta' => array( 'target' => '_blank' ) ) );
	}
}

add_action( 'admin_bar_menu', 'vye_admin_bar_render', 40 );
?>