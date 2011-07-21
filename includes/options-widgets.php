<?php
// Set default options
$default = array( 'titles' => 'YouTube', 'id' => '', 'type' => 'v', 'width' => '320', 'height' => '240', 'fullscreen' => '', 'related' => '', 'autoplay' => '', 'loop' => '', 'start' => '', 'info' => '1', 'annotation' => '1', 'cc' => '', 'link' => '1', 'react' => '1', 'stop' => '', 'sweetspot' => '1', 'disablekb' => '', 'autohide' => '2', 'controls' => '1', 'profile' => '0', 'list' => '', 'template' => '%video%', 'hd' => '1', 'style' => '' );
$instance = wp_parse_args( ( array ) $instance, $default );
$general = ye_set_general_defaults();

// Title field
$field_id = $this -> get_field_id( 'titles' );
$field_name = $this -> get_field_name( 'titles' );
echo "\r\n" . '<p><label for="' . $field_id . '">' . __( 'Title' ) . ': </label><input type="text" class="widefat" id="' . $field_id . '" name="' . $field_name . '" value="' . attribute_escape( $instance[ 'titles' ] ).'" /></p>';

// Video ID field
$field_id = $this -> get_field_id( 'id' );
$field_name = $this -> get_field_name( 'id' );
echo "\r\n" . '<p><label for="' . $field_id . '">' . __( 'Video URL, ID or List name' ) . ': </label><input type="text" class="widefat" id="' . $field_id . '" name="' . $field_name . '" value="' . attribute_escape( $instance[ 'id' ] ) . '" /></p>';

// Profile field
$field_id = $this -> get_field_id( 'profile' );
$field_name = $this -> get_field_name( 'profile' );
echo "\r\n" . '<p><label for="' . $field_id . '">' . __( 'Profile' ) . ': </label><select name="' . $field_name . '" class="widefat" id="' . $field_id . '">';
ye_generate_profile_list( attribute_escape( $instance[ 'profile' ] ), $general[ 'profile_no' ]  );
echo '</select></p>';

// Embed type field
$field_id = $this -> get_field_id( 'type' );
$field_name = $this -> get_field_name( 'type' );
echo "\r\n" . '<p><label for="' . $field_id . '">' . __( 'Embed Type' ) . ': </label><select name="' . $field_name . '" class="widefat" id="' . $field_id . '"><option value="v"';
if ( attribute_escape( $instance[ 'type' ] ) == 'v' ) { echo " selected='selected'"; }
echo '>' . __( 'IFRAME' ) . '</option><option value="p"';
if ( attribute_escape( $instance[ 'type' ] ) == 'p' ) { echo " selected='selected'"; }
echo '>' . __( 'OBJECT' ) . '</option><option value="m"';
if ( attribute_escape( $instance[ 'type' ] ) == 'm' ) { echo " selected='selected'"; }
echo '>' . __( 'EmbedPlus' ) . '</option></select></p>';

// Template
$field_id = $this -> get_field_id( 'template' );
$field_name = $this -> get_field_name( 'template' );
echo "\r\n" . '<p><label for="' . $field_id . '">'.__( 'Template' ).': </label><input type="text" class="widefat" id="' . $field_id . '" name="' . $field_name . '" value="' . attribute_escape( $instance[ 'template' ] ) . '" /></p>';

// Style
$field_id = $this -> get_field_id( 'style' );
$field_name = $this -> get_field_name( 'style' );
echo "\r\n" . '<p><label for="' . $field_id . '">'.__( 'Style' ).': </label><input type="text" class="widefat" id="' . $field_id . '" name="' . $field_name . '" value="' . attribute_escape( $instance[ 'style' ] ) . '" /></p>';

// Size fields
$field_id = $this -> get_field_id( 'width' );
$field_name = $this -> get_field_name( 'width' );
echo "\r\n" . '<p><label for="' . $field_id . '">' . __( 'Size' ) . ': </label><input type="text" size="3" maxlength="3" id="' . $field_id . '" name="' . $field_name . '" value="' . attribute_escape( $instance[ 'width' ] ) . '" />&nbsp;x&nbsp;';

$field_id = $this -> get_field_id( 'height' );
$field_name = $this -> get_field_name( 'height' );
echo '<input type="text" size="3" maxlength="3" id="' . $field_id . '" name="' . $field_name . '" value="' . attribute_escape( $instance[ 'height' ] ) . '" />&nbsp;pixels</p>';

// Autoplay field
$field_id = $this -> get_field_id( 'autoplay' );
$field_name = $this -> get_field_name( 'autoplay' );
echo "\r\n" . '<tr><td width="100%">' . __( 'Autoplay' ) . '</td><td><input type="checkbox" name="' . $field_name . '" id="' . $field_id . '" value="1" ';
if ( attribute_escape( $instance[ 'autoplay' ] ) == '1') { echo "checked='checked' "; }
echo '/></td></tr>';

// Start field
$field_id = $this -> get_field_id( 'start' );
$field_name = $this -> get_field_name( 'start' );
echo "\r\n" . '<p><label for="' . $field_id . '">' . __( 'Start' ) . ': </label><input type="text" size="3" maxlength="3" id="' . $field_id . '" name="' . $field_name . '" value="' . attribute_escape( $instance[ 'start' ] ) . '" /> seconds</p>';

?>
<h4><?php _e( 'Non-EmbedPlus Options' ); ?></h4>
<?php

// Autohide field
$field_id = $this -> get_field_id( 'autohide' );
$field_name = $this -> get_field_name( 'autohide' );
echo "\r\n" . '<p><label for="' . $field_id . '">' . __( 'Auto hide' ) . ': </label><select name="' . $field_name . '" class="widefat" id="' . $field_id . '"><option value="0"';
if ( attribute_escape( $instance[ 'autohide' ] ) == '0' ) { echo " selected='selected'"; }
echo '>' . __( 'Controls &amp; progress bar visible' ) . '</option><option value="1"';
if ( attribute_escape( $instance[ 'autohide' ] ) == '1' ) { echo " selected='selected'"; }
echo '>' . __( 'Controls &amp; progress bar fade out' ) . '</option><option value="2"';
if ( attribute_escape( $instance[ 'autohide' ] ) == '2' ) { echo " selected='selected'"; }
echo '>' . __( 'Progress bar fades' ) . '</option></select></p>';

// List field
$field_id = $this -> get_field_id( 'list' );
$field_name = $this -> get_field_name( 'list' );
echo "\r\n" . '<p><label for="' . $field_id . '">' . __( 'List Playback' ) . ': </label><select name="' . $field_name . '" class="widefat" id="' . $field_id . '"><option value="order"';
if ( attribute_escape( $instance[ 'list' ] ) == 'order' ) { echo " selected='selected'"; }
echo '>' . __( 'Play each video in order' ) . '</option><option value="random"';
if ( attribute_escape( $instance[ 'list' ] ) == 'random' ) { echo " selected='selected'"; }
echo '>' . __( 'Play videos randomly' ) . '</option><option value="single"';
if ( attribute_escape( $instance[ 'list' ] ) == 'single' ) { echo " selected='selected'"; }
echo '>' . __( 'Play one random video' ) . '</option></select></p>';

echo "<table>\n";

// Controls field
$field_id = $this -> get_field_id( 'controls' );
$field_name = $this -> get_field_name( 'controls' );
echo "\r\n" . '<tr><td>' . __( 'Controls' ) . '</td><td><input type="checkbox" name="' . $field_name . '" id="' . $field_id . '" value="1" ';
if ( attribute_escape( $instance[ 'controls' ] ) == '1') { echo "checked='checked' "; }
echo '/></td></tr>';

// Loop video field
$field_id = $this -> get_field_id( 'loop' );
$field_name = $this -> get_field_name( 'loop' );
echo "\r\n" . '<tr><td>' . __( 'Loop Video' ) . '</td><td><input type="checkbox" name="' . $field_name . '" id="' . $field_id . '" value="1" ';
if ( attribute_escape( $instance[ 'loop' ] ) == '1') { echo "checked='checked' "; }
echo '/></td></tr>';

echo "</table>\n";

?>
<h4><?php _e( 'Non-EmbedPlus & HTML5 Options' ); ?></h4>
<?php

echo "<table>\n";

// Annotation field
$field_id = $this -> get_field_id( 'annotation' );
$field_name = $this -> get_field_name( 'annotation' );
echo "\r\n" . '<tr><td width="100%">' . __( 'Annotations' ) . '</td><td><input type="checkbox" name="' . $field_name . '" id="' . $field_id . '" value="1" ';
if ( attribute_escape( $instance[ 'annotation' ] ) == '1') { echo "checked='checked' "; }
echo '/></td></tr>';

// Closed Caption field
$field_id = $this -> get_field_id( 'cc' );
$field_name = $this -> get_field_name( 'cc' );
echo "\r\n" . '<tr><td width="100%">' . __( 'Closed Captions' ) . '</td><td><input type="checkbox" name="' . $field_name . '" id="' . $field_id . '" value="1" ';
if ( attribute_escape( $instance[ 'cc' ] ) == '1') { echo "checked='checked' "; }
echo '/></td></tr>';

// Disable keyboard field
$field_id = $this -> get_field_id( 'disablekb' );
$field_name = $this -> get_field_name( 'disablekb' );
echo "\r\n" . '<tr><td width="100%">' . __( 'Disable Keyboard' ) . '</td><td><input type="checkbox" name="' . $field_name . '" id="' . $field_id . '" value="1" ';
if ( attribute_escape( $instance[ 'disablekb' ] ) == '1') { echo "checked='checked' "; }
echo '/></td></tr>';

// Fullscreen field
$field_id = $this -> get_field_id( 'fullscreen' );
$field_name = $this -> get_field_name( 'fullscreen' );
echo "\r\n" . '<tr><td width="100%">' . __( 'Fullscreen' ) . '</td><td><input type="checkbox" name="' . $field_name . '" id="' . $field_id . '" value="1" ';
if ( attribute_escape( $instance[ 'fullscreen' ] ) == '1') { echo "checked='checked' "; }
echo '/></td></tr>';

// Information field
$field_id = $this -> get_field_id( 'info' );
$field_name = $this -> get_field_name( 'info' );
echo "\r\n" . '<tr><td width="100%">' . __( 'Information' ) . '</td><td><input type="checkbox" name="' . $field_name . '" id="' . $field_id . '" value="1" ';
if ( attribute_escape( $instance[ 'info' ] ) == '1') { echo "checked='checked' "; }
echo '/></td></tr>';

// YouTube Link field
$field_id = $this -> get_field_id( 'link' );
$field_name = $this -> get_field_name( 'link' );
echo "\r\n" . '<tr><td width="100%">' . __( 'Link to YouTube' ) . '</td><td><input type="checkbox" name="' . $field_name . '" id="' . $field_id . '" value="1" ';
if ( attribute_escape( $instance[ 'link' ] ) == '1') { echo "checked='checked' "; }
echo '/></td></tr>';

// Related videos field
$field_id = $this -> get_field_id( 'related' );
$field_name = $this -> get_field_name( 'related' );
echo "\r\n" . '<tr><td width="100%">' . __( 'Related Videos' ) . '</td><td><input type="checkbox" name="' . $field_name . '" id="' . $field_id . '" value="1" ';
if ( attribute_escape( $instance[ 'related' ] ) == '1') { echo "checked='checked' "; }
echo '/></td></tr>';

echo "</table>\n";

?>
<h4><?php _e('EmbedPlus Options'); ?></h4>
<?php

// Stop field
$field_id = $this -> get_field_id( 'stop' );
$field_name = $this -> get_field_name( 'stop' );
echo "\r\n" . '<p><label for="' . $field_id . '">' . __( 'Stop' ) . ': </label><input type="text" size="3" maxlength="3" id="' . $field_id . '" name="' . $field_name . '" value="' . attribute_escape( $instance[ 'stop' ] ) . '" /> seconds</p>';

echo "<table>\n";

// HD field
$field_id = $this -> get_field_id( 'hd' );
$field_name = $this -> get_field_name( 'hd' );
echo "\r\n" . '<tr><td width="100%">' . __( 'Play HD' ) . '</td><td><input type="checkbox" name="' . $field_name . '" id="' . $field_id . '" value="1" ';
if ( attribute_escape( $instance[ 'hd' ] ) == '1') { echo "checked='checked' "; }
echo '/></td></tr>';

// Reactions field
$field_id = $this -> get_field_id( 'react' );
$field_name = $this -> get_field_name( 'react' );
echo "\r\n" . '<tr><td width="100%">' . __( 'Real-time Reactions' ) . '</td><td><input type="checkbox" name="' . $field_name . '" id="' . $field_id . '" value="1" ';
if ( attribute_escape( $instance[ 'react' ] ) == '1') { echo "checked='checked' "; }
echo '/></td></tr>';

// Sweetspot field
$field_id = $this -> get_field_id( 'sweetspot' );
$field_name = $this -> get_field_name( 'sweetspot' );
echo "\r\n" . '<tr><td width="100%">' . __( 'Sweet Spots' ) . '</td><td><input type="checkbox" name="' . $field_name . '" id="' . $field_id . '" value="1" ';
if ( attribute_escape( $instance[ 'sweetspot' ] ) == '1') { echo "checked='checked' "; }
echo '/></td></tr>';

echo "</table>\n";
?>