<?php
/**
* README Page
*
* Display the README instructions
*
* @package	Artiss-YouTube-Embed
* @since	2.4
*/
?>
<div class="wrap">
<div class="icon32" id="icon-edit-pages"></div>

<h2><?php _e( 'Artiss YouTube Embed README', 'youtube-embed' ); ?></h2>

<?php
$options = aye_set_general_defaults();
if ( $options[ 'donated'] != 1 ) { artiss_plugin_ads( 'youtube-embed', 990 ); }

if ( !function_exists( 'wp_readme_parser' ) ) {
    echo '<p>You shouldn\'t be able to see this but I guess that odd things can happen!<p>';
    echo '<p>To display the README you must install the <a href="http://wordpress.org/extend/plugins/wp-readme-parser/">README Parser plugin</a>.</p>';
} else {
    echo wp_readme_parser( array( 'exclude' => 'meta,upgrade notice,screenshots,support,changelog,links,installation,licence', 'ignore' => 'For help with this plugin,,for more information and advanced options ' ), 'http://plugins.svn.wordpress.org/youtube-embed/tags/' . youtube_embed_version . '/readme.txt' );
}
?>
</div>