<?php
/**
* Admin Bar
*
* Set up Admin Bar links
*
* @package	Artiss-YouTube-Embed
*/

/**
* Add option to Admin Bar (WP 3.1 - 3.3)
*
* Add link to YouTube Embed profile options to Admin Bar. This will only appear
* if the user can edit plugins
* With help from http://technerdia.com/1140_wordpress-admin-bar.html
*
* @uses     aye_set_general_default     Set default options
*
* @since	2.0
*/

function aye_admin_bar_render_3_1() {

    global $wp_version;

	if ( current_user_can( 'edit_plugins' ) && ( ( float ) $wp_version >= 3.1 ) && ( ( float ) $wp_version < 3.3 ) )  {

		$options = aye_set_general_defaults();

		if ( $options[ 'admin_bar' ] != '' ) {

			global $wp_admin_bar;
			$wp_admin_bar -> add_menu( array(
				'parent' => 'appearance',
				'id' => 'aye-options',
				'title' => __( 'YouTube Embed', 'youtube-embed' ),
				'href' => admin_url( 'admin.php?page=youtube-embed-profiles' ),
				'meta' => false ) );
		}
	}
}

add_action( 'wp_before_admin_bar_render', 'aye_admin_bar_render_3_1' );

/**
* Add option to Admin Bar (WP 3.3+)
*
* Add link to YouTube Embed profile options to Admin Bar.
* With help from http://technerdia.com/1140_wordpress-admin-bar.html
*
* @uses     aye_set_general_default     Set default options
*
* @since	2.5
*/

function aye_admin_bar_render_3_3( $meta = TRUE ) {

    global $wp_version;

    if ( ( float ) $wp_version >= 3.3 ) {

        $options = aye_set_general_defaults();

        if ( $options[ 'admin_bar' ] != '' ) {

            global $wp_admin_bar;

            if ( !is_user_logged_in() ) { return; }
            if ( !is_super_admin() || !is_admin_bar_showing() ) { return; }

            $wp_admin_bar -> add_menu( array(
                'id' => 'aye-menu',
                'title' => __( 'YouTube Embed', 'youtube-embed' ) ) );

            $wp_admin_bar -> add_menu( array(
                'parent' => 'aye-menu',
                'id' => 'aye-options',
                'title' => __( 'Options', 'youtube-embed' ),
                'href' => admin_url( 'admin.php?page=aye-general-options' ),
                'meta' => array( 'target' => '_blank' ) ) );

            $wp_admin_bar -> add_menu( array(
                'parent' => 'aye-menu',
                'id' => 'aye-profile',
                'title' => __( 'Profiles', 'youtube-embed' ),
                'href' => admin_url( 'admin.php?page=aye-profile-options' ),
                'meta' => array( 'target' => '_blank' ) ) );

            $wp_admin_bar -> add_menu( array(
                'parent' => 'aye-menu',
                'id' => 'aye-lists',
                'title' => __( 'Lists', 'youtube-embed' ),
                'href' => admin_url( 'admin.php?page=aye-list-options' ),
                'meta' => array( 'target' => '_blank' ) ) );

            $wp_admin_bar -> add_menu( array(
                'parent' => 'aye-menu',
                'id' => 'aye-readme',
                'title' => __( 'README', 'youtube-embed' ),
                'href' => admin_url( 'admin.php?page=aye-support-readme' ),
                'meta' => array( 'target' => '_blank' ) ) );
        }
    }
}

add_action( 'admin_bar_menu', 'aye_admin_bar_render_3_3', 40 );
?>