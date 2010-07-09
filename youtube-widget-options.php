<?php
$options=get_option("youtube_widget");
if (!is_array($options)) {
    $options=array('id'=>'','type'=>'v','width'=>'170','height'=>'142','border'=>'0','fullscreen'=>'0','hd'=>'1','color1'=>'2b405b','color2'=>'6b8ab6','style'=>'','autoplay'=>'0','start'=>'0','loop'=>'0','cc'=>'0','annotation'=>'1','egm'=>'0','related'=>'0','info'=>'1','search'=>'1');
}
if ($_POST['youtube-widget-submit']) {
    $options['id']=$_POST['youtube_widget_id'];
    $options['type']=$_POST['youtube_widget_type'];
    $options['width']=$_POST['youtube_widget_width'];
    $options['height']=$_POST['youtube_widget_height'];
    $options['border']=$_POST['youtube_widget_border'];
    $options['fullscreen']=$_POST['youtube_widget_fullscreen'];
    $options['hd']=$_POST['youtube_widget_hd'];
    $options['color1']=$_POST['youtube_widget_color1'];
    $options['color2']=$_POST['youtube_widget_color2'];
    $options['style']=$_POST['youtube_widget_style'];
    $options['autoplay']=$_POST['youtube_widget_autoplay'];
    $options['start']=$_POST['youtube_widget_start'];
    $options['loop']=$_POST['youtube_widget_loop'];
    $options['cc']=$_POST['youtube_widget_cc'];
    $options['annotation']=$_POST['youtube_widget_annotation'];
    $options['egm']=$_POST['youtube_widget_egm'];
    $options['related']=$_POST['youtube_widget_related'];
    $options['info']=$_POST['youtube_widget_info'];
    $options['search']=$_POST['youtube_widget_search'];
    update_option("youtube_widget",$options);
}
?>
<p>
<label for="youtube_widget_id"><?php _e('Video ID'); ?>: </label>
<input type="text" name="youtube_widget_id" value="<?php echo $options['id'];?>" /><br/>

<label for="youtube_widget_type"><?php _e('Embed Type'); ?>: </label>
<select name="youtube_widget_type">
<option value="v"<?php if ($options['type']=="v") {echo " selected='selected'";} ?>><?php _e('Video'); ?></option>
<option value="p"<?php if ($options['type']=="p") {echo " selected='selected'";} ?>><?php _e('Playlist'); ?></option>
</select><br/>

<h3><?php _e('Video Display Properties'); ?></h3>

<label for="youtube_widget_width"><?php _e('Width'); ?>: </label>
<input type="text" size="3" maxlength="3" name="youtube_widget_width" value="<?php echo $options['width']; ?>"/>px<br/>

<label for="youtube_widget_height"><?php _e('Height'); ?>: </label>
<input type="text" size="3" maxlength="3" name="youtube_widget_height" value="<?php echo $options['height']; ?>"/>px<br/>

<label for="youtube_widget_border"><?php _e('Show Border'); ?>: </label>
<select name="youtube_widget_border">
<option value="0"<?php if ($options['border']=="0") {echo " selected='selected'";} ?>><?php _e('No'); ?></option>
<option value="1"<?php if ($options['border']=="1") {echo " selected='selected'";} ?>><?php _e('Yes'); ?></option>
</select><br/>

<label for="youtube_widget_fullscreen"><?php _e('Fullscreen Button'); ?>: </label>
<select name="youtube_widget_fullscreen">
<option value="0"<?php if ($options['fullscreen']=="0") {echo " selected='selected'";} ?>><?php _e('No'); ?></option>
<option value="1"<?php if ($options['fullscreen']=="1") {echo " selected='selected'";} ?>><?php _e('Yes'); ?></option>
</select><br/>

<label for="youtube_widget_hd"><?php _e('Default to HD Quality'); ?>: </label>
<select name="youtube_widget_hd">
<option value="0"<?php if ($options['hd']=="0") {echo " selected='selected'";} ?>><?php _e('No'); ?></option>
<option value="1"<?php if ($options['hd']=="1") {echo " selected='selected'";} ?>><?php _e('Yes'); ?></option>
</select><br/>

<label for="youtube_widget_color1"><?php _e('Color 1'); ?>: </label>
#<input type="text" size="6" maxlength="6" name="youtube_widget_color1" value="<?php echo $options['color1']; ?>"/>&nbsp;<span style="padding-right: 16px; background-color: #<?php echo $options['color1']; ?>">&nbsp;</span><br/>

<label for="youtube_widget_color2"><?php _e('Color 2'); ?>: </label>
#<input type="text" size="6" maxlength="6" name="youtube_widget_color2" value="<?php echo $options['color2']; ?>"/>&nbsp;<span style="padding-right: 16px; background-color: #<?php echo $options['color2'] ?>">&nbsp;</span><br/>

<label for="youtube_widget_style"><?php _e('Style'); ?>: </label>
<input type="text" size="20" name="youtube_widget_style" value="<?php echo $options['style']; ?>"/><br/>

<h3><?php _e('Playback'); ?></h3>

<label for="youtube_widget_autoplay"><?php _e('Autoplay'); ?>: </label>
<select name="youtube_widget_autoplay">
<option value="0"<?php if ($options['autoplay']=="0") {echo " selected='selected'";} ?>><?php _e('No'); ?></option>
<option value="1"<?php if ($options['autoplay']=="1") {echo " selected='selected'";} ?>><?php _e('Yes'); ?></option>
</select><br/>

<label for="youtube_widget_start"><?php _e('Start'); ?>: </label>
<input type="text" size="3" maxlength="3" name="youtube_widget_start" value="<?php echo $options['start']; ?>"/> seconds<br/>

<label for="youtube_widget_loop"><?php _e('Loop Video'); ?>: </label>
<select name="youtube_widget_loop">
<option value="0"<?php if ($options['loop']=="0") {echo " selected='selected'";} ?>><?php _e('No'); ?></option>
<option value="1"<?php if ($options['loop']=="1") {echo " selected='selected'";} ?>><?php _e('Yes'); ?></option>
</select><br/>

<label for="youtube_widget_cc"><?php _e('Show Closed Captions'); ?>: </label>
<select name="youtube_widget_cc">
<option value="0"<?php if ($options['cc']=="0") {echo " selected='selected'";} ?>><?php _e('No'); ?></option>
<option value="1"<?php if ($options['cc']=="1") {echo " selected='selected'";} ?>><?php _e('Yes'); ?></option>
</select><br/>

<label for="youtube_widget_annotation"><?php _e('Show Annotations'); ?>: </label>
<select name="youtube_widget_annotation">
<option value="3"<?php if ($options['annotation']=="3") {echo " selected='selected'";} ?>><?php _e('No'); ?></option>
<option value="1"<?php if ($options['annotation']=="1") {echo " selected='selected'";} ?>><?php _e('Yes'); ?></option>
</select><br/>

<h3><?php _e('Video Information'); ?></h3>

<label for="youtube_widget_egm"><?php _e('Enable Enhanced Genie Menu'); ?>: </label>
<select name="youtube_widget_egm">
<option value="0"<?php if ($options['egm']=="0") {echo " selected='selected'";} ?>><?php _e('No'); ?></option>
<option value="1"<?php if ($options['egm']=="1") {echo " selected='selected'";} ?>><?php _e('Yes'); ?></option>
</select><br/>

<label for="youtube_widget_related"><?php _e('Show Related Videos'); ?>: </label>
<select name="youtube_widget_related">
<option value="0"<?php if ($options['related']=="0") {echo " selected='selected'";} ?>><?php _e('No'); ?></option>
<option value="1"<?php if ($options['related']=="1") {echo " selected='selected'";} ?>><?php _e('Yes'); ?></option>
</select><br/>

<label for="youtube_widget_info"><?php _e('Show Video Information'); ?>: </label>
<select name="youtube_widget_info">
<option value="0"<?php if ($options['info']=="0") {echo " selected='selected'";} ?>><?php _e('No'); ?></option>
<option value="1"<?php if ($options['info']=="1") {echo " selected='selected'";} ?>><?php _e('Yes'); ?></option>
</select><br/>

<label for="youtube_widget_search"><?php _e('Show Search Box'); ?>: </label>
<select name="youtube_widget_search">
<option value="0"<?php if ($options['search']=="0") {echo " selected='selected'";} ?>><?php _e('No'); ?></option>
<option value="1"<?php if ($options['search']=="1") {echo " selected='selected'";} ?>><?php _e('Yes'); ?></option>
</select>

<input type="hidden" id="youtube-widget-submit" name="youtube-widget-submit" value="1" />
</p>