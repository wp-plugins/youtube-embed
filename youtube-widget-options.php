<?php
$default=array('titles'=>'YouTube','id'=>'','type'=>'v','width'=>'170','height'=>'142','border'=>'0','fullscreen'=>'0','hd'=>'1','color1'=>'2b405b','color2'=>'6b8ab6','style'=>'','autoplay'=>'0','start'=>'0','loop'=>'0','cc'=>'0','annotation'=>'1','egm'=>'0','related'=>'0','info'=>'1','search'=>'1','link'=>'1','react'=>'1','stop'=>'0','sweetspot'=>'1');
$instance=wp_parse_args( (array) $instance, $default);

$field_id=$this->get_field_id('titles');
$field_name=$this->get_field_name('titles');
echo "\r\n".'<p><label for="'.$field_id.'">'.__('Title').': </label><input type="text" class="widefat" id="'.$field_id.'" name="'.$field_name.'" value="'.attribute_escape( $instance['titles'] ).'" /></p>';

$field_id=$this->get_field_id('id');
$field_name=$this->get_field_name('id');
echo "\r\n".'<p><label for="'.$field_id.'">'.__('Video ID').': </label><input type="text" class="widefat" id="'.$field_id.'" name="'.$field_name.'" value="'.attribute_escape( $instance['id'] ).'" /></p>';

$field_id=$this->get_field_id('type');
$field_name=$this->get_field_name('type');
echo "\r\n".'<p><label for="'.$field_id.'">'.__('Embed Type').': </label><select name="'.$field_name.'" class="widefat" id="'.$field_id.'"><option value="v"';
if (attribute_escape( $instance['type'] )=="v") {echo " selected='selected'";}
echo '>'.__('Video (Standard)').'</option><option value="m"';
if (attribute_escape( $instance['type'] )=="m") {echo " selected='selected'";}
echo '>'.__('Video (EmbedPlus)').'</option><option value="p"';
if (attribute_escape( $instance['type'] )=="p") {echo " selected='selected'";}
echo '>'.__('Playlist').'</option></select></p>';

$field_id=$this->get_field_id('style');
$field_name=$this->get_field_name('style');
echo "\r\n".'<p><label for="'.$field_id.'">'.__('Style').': </label><input type="text" class="widefat" id="'.$field_id.'" name="'.$field_name.'" value="'.attribute_escape( $instance['style'] ).'" /></p>';

$field_id=$this->get_field_id('width');
$field_name=$this->get_field_name('width');
echo "\r\n".'<p><label for="'.$field_id.'">'.__('Width').': </label><input type="text" size="3" maxlength="3" id="'.$field_id.'" name="'.$field_name.'" value="'.attribute_escape( $instance['width'] ).'" />px</p>';

$field_id=$this->get_field_id('height');
$field_name=$this->get_field_name('height');
echo "\r\n".'<p><label for="'.$field_id.'">'.__('Height').': </label><input type="text" size="3" maxlength="3" id="'.$field_id.'" name="'.$field_name.'" value="'.attribute_escape( $instance['height'] ).'" />px</p>';

$field_id=$this->get_field_id('fullscreen');
$field_name=$this->get_field_name('fullscreen');
echo "\r\n".'<p><label for="'.$field_id.'">'.__('Fullscreen Button').': </label><select name="'.$field_name.'" class="widefat" id="'.$field_id.'"><option value="1"';
if (attribute_escape( $instance['fullscreen'] )=="1") {echo " selected='selected'";}
echo '>'.__('Yes').'</option><option value="0"';
if (attribute_escape( $instance['fullscreen'] )=="0") {echo " selected='selected'";}
echo '>'.__('No').'</option></select></p>';

$field_id=$this->get_field_id('start');
$field_name=$this->get_field_name('start');
echo "\r\n".'<p><label for="'.$field_id.'">'.__('Start').': </label><input type="text" size="3" maxlength="3" id="'.$field_id.'" name="'.$field_name.'" value="'.attribute_escape( $instance['start'] ).'" /> seconds</p>';

?>
<h3><?php _e('Standard Video/Playlist Only'); ?></h3>
<?php

$field_id=$this->get_field_id('border');
$field_name=$this->get_field_name('border');
echo "\r\n".'<p><label for="'.$field_id.'">'.__('Show Border').': </label><select name="'.$field_name.'" class="widefat" id="'.$field_id.'"><option value="1"';
if (attribute_escape( $instance['border'] )=="1") {echo " selected='selected'";}
echo '>'.__('Yes').'</option><option value="0"';
if (attribute_escape( $instance['border'] )=="0") {echo " selected='selected'";}
echo '>'.__('No').'</option></select></p>';

$field_id=$this->get_field_id('hd');
$field_name=$this->get_field_name('hd');
echo "\r\n".'<p><label for="'.$field_id.'">'.__('Default to HD Quality').': </label><select name="'.$field_name.'" class="widefat" id="'.$field_id.'"><option value="1"';
if (attribute_escape( $instance['hd'] )=="1") {echo " selected='selected'";}
echo '>'.__('Yes').'</option><option value="0"';
if (attribute_escape( $instance['hd'] )=="0") {echo " selected='selected'";}
echo '>'.__('No').'</option></select></p>';

$field_id=$this->get_field_id('color1');
$field_name=$this->get_field_name('color1');
echo "\r\n".'<p><label for="'.$field_id.'">'.__('Color 1').': #</label><input type="text" size="6" maxlength="6" id="'.$field_id.'" name="'.$field_name.'" value="'.attribute_escape( $instance['color1'] ).'" /></p>';

$field_id=$this->get_field_id('color2');
$field_name=$this->get_field_name('color2');
echo "\r\n".'<p><label for="'.$field_id.'">'.__('Color 2').': #</label><input type="text" size="6" maxlength="6" id="'.$field_id.'" name="'.$field_name.'" value="'.attribute_escape( $instance['color2'] ).'" /></p>';

$field_id=$this->get_field_id('autoplay');
$field_name=$this->get_field_name('autoplay');
echo "\r\n".'<p><label for="'.$field_id.'">'.__('Autoplay').': </label><select name="'.$field_name.'" class="widefat" id="'.$field_id.'"><option value="1"';
if (attribute_escape( $instance['autoplay'] )=="1") {echo " selected='selected'";}
echo '>'.__('Yes').'</option><option value="0"';
if (attribute_escape( $instance['autoplay'] )=="0") {echo " selected='selected'";}
echo '>'.__('No').'</option></select></p>';

$field_id=$this->get_field_id('loop');
$field_name=$this->get_field_name('loop');
echo "\r\n".'<p><label for="'.$field_id.'">'.__('Loop Video').': </label><select name="'.$field_name.'" class="widefat" id="'.$field_id.'"><option value="1"';
if (attribute_escape( $instance['loop'] )=="1") {echo " selected='selected'";}
echo '>'.__('Yes').'</option><option value="0"';
if (attribute_escape( $instance['loop'] )=="0") {echo " selected='selected'";}
echo '>'.__('No').'</option></select></p>';

$field_id=$this->get_field_id('cc');
$field_name=$this->get_field_name('cc');
echo "\r\n".'<p><label for="'.$field_id.'">'.__('Show Closed Captions').': </label><select name="'.$field_name.'" class="widefat" id="'.$field_id.'"><option value="1"';
if (attribute_escape( $instance['cc'] )=="1") {echo " selected='selected'";}
echo '>'.__('Yes').'</option><option value="0"';
if (attribute_escape( $instance['cc'] )=="0") {echo " selected='selected'";}
echo '>'.__('No').'</option></select></p>';

$field_id=$this->get_field_id('annotation');
$field_name=$this->get_field_name('annotation');
echo "\r\n".'<p><label for="'.$field_id.'">'.__('Show Annotations').': </label><select name="'.$field_name.'" class="widefat" id="'.$field_id.'"><option value="1"';
if (attribute_escape( $instance['annotation'] )=="1") {echo " selected='selected'";}
echo '>'.__('Yes').'</option><option value="3"';
if (attribute_escape( $instance['annotation'] )=="3") {echo " selected='selected'";}
echo '>'.__('No').'</option></select></p>';

$field_id=$this->get_field_id('egm');
$field_name=$this->get_field_name('egm');
echo "\r\n".'<p><label for="'.$field_id.'">'.__('Enable Enhanced Genie Menu').': </label><select name="'.$field_name.'" class="widefat" id="'.$field_id.'"><option value="1"';
if (attribute_escape( $instance['egm'] )=="1") {echo " selected='selected'";}
echo '>'.__('Yes').'</option><option value="0"';
if (attribute_escape( $instance['egm'] )=="0") {echo " selected='selected'";}
echo '>'.__('No').'</option></select></p>';

$field_id=$this->get_field_id('related');
$field_name=$this->get_field_name('related');
echo "\r\n".'<p><label for="'.$field_id.'">'.__('Show Related Videos').': </label><select name="'.$field_name.'" class="widefat" id="'.$field_id.'"><option value="1"';
if (attribute_escape( $instance['related'] )=="1") {echo " selected='selected'";}
echo '>'.__('Yes').'</option><option value="0"';
if (attribute_escape( $instance['related'] )=="0") {echo " selected='selected'";}
echo '>'.__('No').'</option></select></p>';

$field_id=$this->get_field_id('info');
$field_name=$this->get_field_name('info');
echo "\r\n".'<p><label for="'.$field_id.'">'.__('Show Video Information').': </label><select name="'.$field_name.'" class="widefat" id="'.$field_id.'"><option value="1"';
if (attribute_escape( $instance['info'] )=="1") {echo " selected='selected'";}
echo '>'.__('Yes').'</option><option value="0"';
if (attribute_escape( $instance['info'] )=="0") {echo " selected='selected'";}
echo '>'.__('No').'</option></select></p>';

$field_id=$this->get_field_id('search');
$field_name=$this->get_field_name('search');
echo "\r\n".'<p><label for="'.$field_id.'">'.__('Show Search Box').': </label><select name="'.$field_name.'" class="widefat" id="'.$field_id.'"><option value="1"';
if (attribute_escape( $instance['search'] )=="1") {echo " selected='selected'";}
echo '>'.__('Yes').'</option><option value="0"';
if (attribute_escape( $instance['search'] )=="0") {echo " selected='selected'";}
echo '>'.__('No').'</option></select></p>';

$field_id=$this->get_field_id('link');
$field_name=$this->get_field_name('link');
echo "\r\n".'<p><label for="'.$field_id.'">'.__('Link Back to YouTube').': </label><select name="'.$field_name.'" class="widefat" id="'.$field_id.'"><option value="1"';
if (attribute_escape( $instance['link'] )=="1") {echo " selected='selected'";}
echo '>'.__('Yes').'</option><option value="0"';
if (attribute_escape( $instance['link'] )=="0") {echo " selected='selected'";}
echo '>'.__('No').'</option></select></p>';

?>
<h3><?php _e('EmbedPlus Video Only'); ?></h3>
<?php

$field_id=$this->get_field_id('stop');
$field_name=$this->get_field_name('stop');
echo "\r\n".'<p><label for="'.$field_id.'">'.__('Stop').': </label><input type="text" size="3" maxlength="3" id="'.$field_id.'" name="'.$field_name.'" value="'.attribute_escape( $instance['stop'] ).'" /> seconds</p>';

$field_id=$this->get_field_id('react');
$field_name=$this->get_field_name('react');
echo "\r\n".'<p><label for="'.$field_id.'">'.__('Show Reactions Button').': </label><select name="'.$field_name.'" class="widefat" id="'.$field_id.'"><option value="1"';
if (attribute_escape( $instance['react'] )=="1") {echo " selected='selected'";}
echo '>'.__('Yes').'</option><option value="0"';
if (attribute_escape( $instance['react'] )=="0") {echo " selected='selected'";}
echo '>'.__('No').'</option></select></p>';

$field_id=$this->get_field_id('sweetspot');
$field_name=$this->get_field_name('sweetspot');
echo "\r\n".'<p><label for="'.$field_id.'">'.__('Find Sweet Spots').': </label><select name="'.$field_name.'" class="widefat" id="'.$field_id.'"><option value="1"';
if (attribute_escape( $instance['sweetspot'] )=="1") {echo " selected='selected'";}
echo '>'.__('Yes').'</option><option value="0"';
if (attribute_escape( $instance['sweetspot'] )=="0") {echo " selected='selected'";}
echo '>'.__('No').'</option></select></p>';
?>