<div class="wrap">
<?php screen_icon(); ?>
<h2>YouTube Embed Options</h2>
<?php
// If options have been updated on screen, update the database
if(!empty($_POST['Submit'])) {
    $options['width']=$_POST['youtube_embed_width'];
    $options['height']=$_POST['youtube_embed_height'];
    $options['border']=$_POST['youtube_embed_border'];
    $options['fullscreen']=$_POST['youtube_embed_fullscreen'];
    $options['hd']=$_POST['youtube_embed_hd'];
    $options['color1']=$_POST['youtube_embed_color1'];
    $options['color2']=$_POST['youtube_embed_color2'];
    $options['style']=$_POST['youtube_embed_style'];
    $options['autoplay']=$_POST['youtube_embed_autoplay'];
    $options['start']=$_POST['youtube_embed_start'];
    $options['loop']=$_POST['youtube_embed_loop'];
    $options['cc']=$_POST['youtube_embed_cc'];
    $options['annotation']=$_POST['youtube_embed_annotation'];
    $options['egm']=$_POST['youtube_embed_egm'];
    $options['related']=$_POST['youtube_embed_related'];
    $options['info']=$_POST['youtube_embed_info'];
    $options['search']=$_POST['youtube_embed_search'];
    $options['link']=$_POST['youtube_embed_link'];
    $options['react']=$_POST['youtube_embed_react'];
    $options['stop']=$_POST['youtube_embed_stop'];
    $options['sweetspot']=$_POST['youtube_embed_sweetspot'];
    $options['type']=$_POST['youtube_embed_type'];
    update_option("youtube_embed",$options);
}
// Fetch options into an array
$options=get_option("youtube_embed");
// Set defaults if no array is defined
if (!is_array($options)) {
    echo "<div class=\"updated\"><p><strong>Please review the default options below and click \"Save Settings\" to update them.</strong></p></div>\n";
    $options = array('width'=>'425','height'=>'355','border'=>'0','fullscreen'=>'0','hd'=>'1','color1'=>'2b405b','color2'=>'6b8ab6','style'=>'','autoplay'=>'0','start'=>'0','loop'=>'0','cc'=>'0','annotation'=>'1','egm'=>'0','related'=>'0','info'=>'1','search'=>'1','link'=>'1','react'=>'1','stop'=>'0','sweetspot'=>'1','type'=>'v');}
?>

<a href="http://embedplus.com/"><img src="<?php echo WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)); ?>embedplus.png" alt="EmbedPlus" title="EmbedPlus" align="right" /></a>

<p><?php _e('These are the default settings for YouTube videos embedded with YouTube Embed.'); ?></p>
<p><?php _e('Further details about these parameters can be found in <a href="http://code.google.com/apis/youtube/player_parameters.html">the official YouTube documentation</a> for normal embedded videos.'); ?></p>
<p><?php _e('You can find about more information about EmbedPlus from <a href="http://embedplus.com/">their website</a>.'); ?></p>
<p><?php _e('If you like this plugin, please <a href="http://www.artiss.co.uk/donate">consider donating</a>.'); ?></p>

<form method="post" action="<?php echo get_bloginfo('wpurl').'/wp-admin/options-general.php?page=youtube-embed-settings&amp;updated=true' ?>">
<table class="form-table">

<tr valign="top">
<th scope="row"><?php _e('Embed Type'); ?></th>
<td><select name="youtube_embed_type">
<option value="v"<?php if ($options['type']=="v") {echo " selected='selected'";} ?>><?php _e('Standard'); ?></option>
<option value="m"<?php if ($options['type']=="m") {echo " selected='selected'";} ?>><?php _e('EmbedPlus'); ?></option>
</select></td>
</tr><tr>

<th scope="row"><?php _e('Style Information'); ?></th>
<td colspan="2"><input type="text" size="40" name="youtube_embed_style" value="<?php echo $options['style']; ?>"/> e.g. text-align:center</td>
</tr><tr>

<th scope="row"><?php _e('Width'); ?></th>
<td><input type="text" size="3" maxlength="3" name="youtube_embed_width" value="<?php echo $options['width']; ?>"/>px</td>

<th scope="row"><?php _e('Height'); ?></th>
<td><input type="text" size="3" maxlength="3" name="youtube_embed_height" value="<?php echo $options['height']; ?>"/>px</td>
</tr><tr>

<th scope="row"><?php _e('Fullscreen Button'); ?></th>
<td><select name="youtube_embed_fullscreen">
<option value="0"<?php if ($options['fullscreen']=="0") {echo " selected='selected'";} ?>><?php _e('No'); ?></option>
<option value="1"<?php if ($options['fullscreen']=="1") {echo " selected='selected'";} ?>><?php _e('Yes'); ?></option>
</select></td>

<th scope="row"><?php _e('Start'); ?></th>
<td><input type="text" size="3" maxlength="3" name="youtube_embed_start" value="<?php echo $options['start']; ?>"/> seconds</td>
</tr><tr>

<th style="font-weight: bold" scope="row"><?php _e('Standard Video/Playlist Only'); ?></th>
</tr><tr>

<th scope="row"><?php _e('Show Border'); ?></th>
<td><select name="youtube_embed_border">
<option value="0"<?php if ($options['border']=="0") {echo " selected='selected'";} ?>><?php _e('No'); ?></option>
<option value="1"<?php if ($options['border']=="1") {echo " selected='selected'";} ?>><?php _e('Yes'); ?></option>
</select></td>

<th scope="row"><?php _e('Default to HD Quality'); ?></th>
<td colspan="2"><select name="youtube_embed_hd">
<option value="0"<?php if ($options['hd']=="0") {echo " selected='selected'";} ?>><?php _e('No'); ?></option>
<option value="1"<?php if ($options['hd']=="1") {echo " selected='selected'";} ?>><?php _e('Yes'); ?></option>
</select> (if available)</td>
</tr><tr>

<th scope="row"><?php _e('Color 1'); ?></th>
<td>#<input type="text" size="6" maxlength="6" name="youtube_embed_color1" value="<?php echo $options['color1']; ?>"/>&nbsp;<span style="padding-right: 16px; background-color: #<?php echo $options['color1']; ?>">&nbsp;</span></td>

<th scope="row"><?php _e('Color 2'); ?></th>
<td>#<input type="text" size="6" maxlength="6" name="youtube_embed_color2" value="<?php echo $options['color2']; ?>"/>&nbsp;<span style="padding-right: 16px; background-color: #<?php echo $options['color2'] ?>">&nbsp;</span></td>
</tr><tr>

<th scope="row"><?php _e('Autoplay'); ?></th>
<td><select name="youtube_embed_autoplay">
<option value="0"<?php if ($options['autoplay']=="0") {echo " selected='selected'";} ?>><?php _e('No'); ?></option>
<option value="1"<?php if ($options['autoplay']=="1") {echo " selected='selected'";} ?>><?php _e('Yes'); ?></option>
</select></td>

<th scope="row"><?php _e('Loop Video'); ?></th>
<td><select name="youtube_embed_loop">
<option value="0"<?php if ($options['loop']=="0") {echo " selected='selected'";} ?>><?php _e('No'); ?></option>
<option value="1"<?php if ($options['loop']=="1") {echo " selected='selected'";} ?>><?php _e('Yes'); ?></option>
</select></td>
</tr><tr>

<th scope="row"><?php _e('Show Closed Captions'); ?></th>
<td><select name="youtube_embed_cc">
<option value="0"<?php if ($options['cc']=="0") {echo " selected='selected'";} ?>><?php _e('No'); ?></option>
<option value="1"<?php if ($options['cc']=="1") {echo " selected='selected'";} ?>><?php _e('Yes'); ?></option>
</select></td>

<th scope="row"><?php _e('Show Annotations'); ?></th>
<td><select name="youtube_embed_annotation">
<option value="3"<?php if ($options['annotation']=="3") {echo " selected='selected'";} ?>><?php _e('No'); ?></option>
<option value="1"<?php if ($options['annotation']=="1") {echo " selected='selected'";} ?>><?php _e('Yes'); ?></option>
</select></td>
</tr><tr>

<th scope="row"><?php _e('Enable Enhanced Genie Menu'); ?></th>
<td><select name="youtube_embed_egm">
<option value="0"<?php if ($options['egm']=="0") {echo " selected='selected'";} ?>><?php _e('No'); ?></option>
<option value="1"<?php if ($options['egm']=="1") {echo " selected='selected'";} ?>><?php _e('Yes'); ?></option>
</select></td>

<th scope="row"><?php _e('Show Related Videos'); ?></th>
<td><select name="youtube_embed_related">
<option value="0"<?php if ($options['related']=="0") {echo " selected='selected'";} ?>><?php _e('No'); ?></option>
<option value="1"<?php if ($options['related']=="1") {echo " selected='selected'";} ?>><?php _e('Yes'); ?></option>
</select></td>
</tr><tr>

<th scope="row"><?php _e('Show Video Information'); ?></th>
<td><select name="youtube_embed_info">
<option value="0"<?php if ($options['info']=="0") {echo " selected='selected'";} ?>><?php _e('No'); ?></option>
<option value="1"<?php if ($options['info']=="1") {echo " selected='selected'";} ?>><?php _e('Yes'); ?></option>
</select></td>

<th scope="row"><?php _e('Show Search Box'); ?></th>
<td><select name="youtube_embed_search">
<option value="0"<?php if ($options['search']=="0") {echo " selected='selected'";} ?>><?php _e('No'); ?></option>
<option value="1"<?php if ($options['search']=="1") {echo " selected='selected'";} ?>><?php _e('Yes'); ?></option>
</select></td>
</tr><tr>

<th scope="row"><?php _e('Link back to YouTube'); ?></th>
<td><select name="youtube_embed_link">
<option value="0"<?php if (($options['link']=="0")&&($options['link']!="")) {echo " selected='selected'";} ?>><?php _e('No'); ?></option>
<option value="1"<?php if (($options['link']=="1")or($options['link']=="")) {echo " selected='selected'";} ?>><?php _e('Yes'); ?></option>
</select></td>
</tr><tr>

<th style="font-weight: bold" scope="row"><?php _e('EmbedPlus Video Only'); ?></th>
</tr><tr>

<th scope="row"><?php _e('Stop'); ?></th>
<td><input type="text" size="3" maxlength="3" name="youtube_embed_stop" value="<?php echo $options['stop']; ?>"/> seconds</td>
</tr><tr>

<th scope="row"><?php _e('Show Real-time Reactions Button'); ?></th>
<td><select name="youtube_embed_react">
<option value="1"<?php if ($options['react']=="1") {echo " selected='selected'";} ?>><?php _e('Yes'); ?></option>
<option value="0"<?php if ($options['react']=="0") {echo " selected='selected'";} ?>><?php _e('No'); ?></option>
</select></td>

<th scope="row"><?php _e('Find Sweet Spots for Next/Prev Buttons'); ?></th>
<td><select name="youtube_embed_sweetspot">
<option value="1"<?php if ($options['sweetspot']=="1") {echo " selected='selected'";} ?>><?php _e('Yes'); ?></option>
<option value="0"<?php if ($options['sweetspot']=="0") {echo " selected='selected'";} ?>><?php _e('No'); ?></option>
</select></td>

</tr>
</table>
<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php _e('Save Settings'); ?>"/>
</p>
</form>

<h3><?php _e('YouTube Video Sample'); ?></h3>
<p><?php _e('This uses the above settings, once they have been saved. <b>Would you like this to be your video? If so, <a href="http://www.artiss.co.uk/contact">contact me</a>!</b>'); ?></p>
<p><?php youtube_video_embed("ru6219KIKS0"); ?></p>

<h3><?php _e('Further Help'); ?></h3>
<?php _e('<p>All of my plugins are supported via <a title="Artiss.co.uk" href="http://www.artiss.co.uk" target="_blank">my website</a>.</p><p>Please feel free to visit the site for plugin updates and development news - either visit the site regularly, follow <a title="RSS News Feed" href="http://www.artiss.co.uk/feed" target="_blank">my news feed</a> or <a title="Artiss.co.uk on Twitter" href="http://www.twitter.com/artiss_tech" target="_blank">follow me on Twitter</a> (@artiss_tech).</p><p>For problems, suggestions or enhancements for this plugin, there is <a title="YouTube Embed" href="http://www.artiss.co.uk/youtube-embed" target="_blank">a dedicated page</a> and <a title="WordPress Plugins Forum" href="http://www.artiss.co.uk/forum" target="_blank">a forum</a>. The dedicated page will also list any known issues and planned enhancements.</p><p>Alternatively, please <a title="Contact Me" href="http://www.artiss.co.uk/contact" target="_blank">contact me directly</a>.</p><p style="font-weight: bold">This plugin, and all support, is supplied for free, but <a title="Donate" href="http://artiss.co.uk/donate" target="_blank">donations</a> are always welcome.</p>'); ?>
<p><a href="http://validator.w3.org"><img src="http://www.w3.org/Icons/valid-xhtml10-blue" alt="Valid XHTML 1.0 Transitional" height="31px" width="88px" style="float: right"/></a></p>
</div>