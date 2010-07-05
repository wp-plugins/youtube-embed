<?php
/*
Plugin Name: YouTube Embed
Plugin URI: http://www.artiss.co.uk/youtube-embed
Description: Embed YouTube Videos in WordPress
Version: 1.1
Author: David Artiss
Author URI: http://www.artiss.co.uk
*/
// Set up WordPress shortcodes and actions
add_shortcode('youtube','youtube_video_sc');
add_shortcode('youtube_playlist','youtube_playlist_sc');
add_shortcode('youtube_thumb','youtube_thumbnail_sc');
add_shortcode('youtube_url','youtube_url_sc');
add_action('admin_menu','youtube_embed_menu');
add_action('plugins_loaded','youtube_widget_init');

// Shortcode function to embed a YouTube video
function youtube_video_sc($paras="",$content="") {
    extract(shortcode_atts(array('width'=>'','height'=>'','fullscreen'=>'','related'=>'','autoplay'=>'','loop'=>'','egm'=>'','border'=>'','color1'=>'','color2'=>'','start'=>'','hd'=>'','search'=>'','info'=>'','annotation'=>'','cc'=>'','style'=>''),$paras));
    $youtube_code=generate_youtube_code($content,"v",$width,$height,ye_convert($fullscreen),ye_convert($related),ye_convert($autoplay),ye_convert($loop),ye_convert($egm),ye_convert($border),$color1,$color2,$start,ye_convert($hd),ye_convert($search),ye_convert($info),ye_convert_3($annotation),ye_convert($cc),$style);
    return $youtube_code;
}

// Shortcode function to embed a YouTube playlist
function youtube_playlist_sc($paras="",$content="") {
    extract(shortcode_atts(array('width'=>'','height'=>'','fullscreen'=>'','related'=>'','autoplay'=>'','loop'=>'','egm'=>'','border'=>'','color1'=>'','color2'=>'','start'=>'','hd'=>'','search'=>'','info'=>'','annotation'=>'','cc'=>'','style'=>''),$paras));
    return generate_youtube_code($content,"p",$width,$height,ye_convert($fullscreen),ye_convert($related),ye_convert($autoplay),ye_convert($loop),ye_convert($egm),ye_convert($border),$color1,$color2,$start,ye_convert($hd),ye_convert($search),ye_convert($info),ye_convert_3($annotation),ye_convert($cc),$style);
}

// TShortcode function to embed a YouTube playlist
function youtube_thumbnail_sc($paras="",$content="") {
    extract(shortcode_atts(array('style'=>'','class'=>'','rel'=>'','target'=>'','width'=>'','height'=>'','alt'=>''),$paras));
    return generate_thumbnail_code($content,$style,$class,$rel,$target,$width,$height,$alt);
}

// Shortcode function to return a short YouTube URL
function youtube_url_sc($paras="",$content="") {
    if ($content=="") {return youtube_embed_error("No video ID has been supplied");} else {return "http://youtu.be/".$content;}
}

// Embed a video via your own function call
function youtube_video_embed($content,$paras="",$style="",$type="v") {
    $width=youtube_get_parameters($paras,"width");
    $height=youtube_get_parameters($paras,"height");
    $fullscreen=youtube_get_parameters($paras,"fullscreen");
    $related=youtube_get_parameters($paras,"related");
    $autoplay=youtube_get_parameters($paras,"autoplay");
    $loop=youtube_get_parameters($paras,"loop");
    $egm=youtube_get_parameters($paras,"egm");
    $border=youtube_get_parameters($paras,"border");
    $color1=youtube_get_parameters($paras,"color1");
    $color2=youtube_get_parameters($paras,"color2");
    $start=youtube_get_parameters($paras,"start");
    $hd=youtube_get_parameters($paras,"hd");  
    $search=youtube_get_parameters($paras,"search");
    $info=youtube_get_parameters($paras,"info");
    $annotation=youtube_get_parameters($paras,"annotation");
    $cc=youtube_get_parameters($paras,"cc");
    echo generate_youtube_code($content,$type,$width,$height,ye_convert($fullscreen),ye_convert($related),ye_convert($autoplay),ye_convert($loop),ye_convert($egm),ye_convert($border),$color1,$color2,$start,ye_convert($hd),ye_convert($search),ye_convert($info),ye_convert_3($annotation),ye_convert($cc),$style);
    return;
}

// Embed a playlist via your own function call
function youtube_playlist_embed($content,$paras="",$style="") {
    youtube_video_embed($content,$paras="",$style="","p");
    return;
}

// Display a video thumbnail via your own function call
function youtube_thumb_embed($content,$paras="",$style="",$alt="") {
    $class=youtube_get_parameters($paras,"class");
    $rel=youtube_get_parameters($paras,"rel"); 
    $target=youtube_get_parameters($paras,"target");
    $width=youtube_get_parameters($paras,"width");
    $height=youtube_get_parameters($paras,"height");
    echo generate_thumbnail_code($content,$style,$class,$rel,$target,$width,$height,$alt);
    return;
}

// Display a short YouTube URL via your own function call
function youtube_short_url($id) {return "http://youtu.be/".$id;}

// Generate XHTML compatible YouTube embed code
function generate_youtube_code($id,$type,$width,$height,$fullscreen,$related,$autoplay,$loop,$egm,$border,$color1,$color2,$start,$hd,$search,$info,$annotation,$cc,$style,$widget="") {
    $version=1.1;
    // Ensure an ID is passed
    if (($id=="")&&(strtolower($widget)!="yes")) {
        return youtube_embed_error("No video/playlist ID has been supplied");
    } else {
        // Get default values if no override values are supplied
        if (strtolower($widget)=="yes") {
            $options=get_option("youtube_widget");
            if (!is_array($options)) {
                $options=array('id'=>'','type'=>'v','width'=>'170','height'=>'142','border'=>'0','fullscreen'=>'0','hd'=>'1','color1'=>'2b405b','color2'=>'6b8ab6','style'=>'','autoplay'=>'0','start'=>'0','loop'=>'0','cc'=>'0','annotation'=>'1','egm'=>'0','related'=>'0','info'=>'1','search'=>'1');
            }
            $id=$options['id'];
            $type=$options['type'];
        } else {
            $options=get_option("youtube_embed");
            if (!is_array($options)) {
                $options = array('width'=>'425','height'=>'355','border'=>'0','fullscreen'=>'0','hd'=>'1','color1'=>'2b405b','color2'=>'6b8ab6','style'=>'','autoplay'=>'0','start'=>'0','loop'=>'0','cc'=>'0','annotation'=>'1','egm'=>'0','related'=>'0','info'=>'1','search'=>'1');
            }
        }
        if ($width=="") {$width=$options['width'];}
        if ($height=="") {$height=$options['height'];}
        if ($fullscreen=="") {$fullscreen=$options['fullscreen'];}
        if ($related=="") {$related=$options['related'];}
        if ($autoplay=="") {$autoplay=$options['autoplay'];}
        if ($loop=="") {$loop=$options['loop'];} 
        if ($egm=="") {$egm=$options['egm'];}
        if ($border=="") {$border=$options['border'];}
        if ($color1=="") {$color1=$options['color1'];}
        if ($color2=="") {$color2=$options['color2'];}
        if ($start=="") {$start=$options['start'];}
        if ($hd=="") {$hd=$options['hd'];}
        if ($search=="") {$search=$options['search'];}
        if ($info=="") {$info=$options['info'];}
        if ($annotation=="") {$annotation=$options['annotation'];}
        if ($cc=="") {$cc=$options['cc'];}
        if ($style=="") {$style=$options['style'];}
        // Convert video ID characters
        $id=str_replace("&#8211;","--",$id);
        $id=str_replace("&#215;","x",$id);
        // Generate parameters to add to URL
        $paras="&amp;fs=".$fullscreen."&amp;rel=".$related."&amp;autoplay=".$autoplay."&amp;loop=".$loop."&amp;egm=".$egm."&amp;border=".$border."&amp;color1=0x".$color1."&amp;color2=0x".$color2."&amp;hd=".$hd."&amp;showsearch=".$search."&amp;showinfo=".$info."&amp;iv_load_policy=".$annotation."&amp;cc_load_policy=".$cc;
        if ($start!=0) {$paras=$paras."&amp;start=".$start;}
        // Write out code
        $result="<!-- YouTube Embed v".$version." | http://www.artiss.co.uk/youtube-embed -->\n";
        if ($style!="") {$result.="<div style=\"".$style."\">\n";}
        $result.="<object type=\"application/x-shockwave-flash\" data=\"http://www.youtube.com/".$type."/".$id.$paras."\" width=\"".$width."px\" height=\"".$height."px\">\n";
        $result.="<param name=\"movie\" value=\"http://www.youtube.com/".$type."/".$id.$paras."\"></param>\n";
        if ($fullscreen==1) {$result.="<param name=\"allowFullScreen\" value=\"true\"></param>\n";}
        $result.="</object>\n";
        if ($style!="") {$result.="</div>\n";}
        $result.="<!-- End of YouTube Embed code -->\n";
        return $result;
    }
}

// Function to generate XHTML compatible YouTube video thumbnail
function generate_thumbnail_code($id,$style,$class,$rel,$target,$width,$height,$alt) {
    if ($alt=="") {$alt="YouTube Video ".$id;}
    $youtube_code="<a href=\"http://www.youtube.com/watch?v=".$id."\"";
    if ($style!="") {$youtube_code=$youtube_code." style=\"".$style."\"";}
    if ($class!="") {$youtube_code=$youtube_code." class=\"".$class."\"";}
    if ($rel!="") {$youtube_code=$youtube_code." rel=\"".$rel."\"";}
    if ($target!="") {$youtube_code=$youtube_code." target=\"".$target."\"";} 
    $youtube_code=$youtube_code."><img src=\"http://img.youtube.com/vi/".$id."/2.jpg\"";
    if ($width!="") {$youtube_code=$youtube_code." width=\"".$width."px\"";} 
    if ($height!="") {$youtube_code=$youtube_code." height=\"".$height."px\"";}
    $youtube_code=$youtube_code." alt=\"".$alt."\"";
    return $youtube_code."/></a>";
}

// Function to generate YouTube widget
function youtube_widget($args) {
    extract($args);
    echo $before_widget;
    echo $before_title."YouTube".$after_title;
    echo generate_youtube_code("","","","","","","","","","","","","","","","","","","","yes");
    echo $after_widget;
}

// Function to extract parameters from an input string (1.0)
function youtube_get_parameters($input,$para) {
    $start=strpos(strtolower($input),$para."=");
    $content="";
    if ($start!==false) {
        $start=$start+strlen($para)+1;
        $end=strpos(strtolower($input),"&",$start);
        if ($end!==false) {$end=$end-1;} else {$end=strlen($input);}
        $content=substr($input,$start,$end-$start+1);
    }
    return $content;
}

// Function to report an error
function youtube_embed_error($errorin) {return "<p style=\"color: #f00; font-weight: bold;\">YouTube Embed: ".$errorin."</p>\n";}

// Function to convert a Yes or No input to an equivalent 1 or 0 output
function ye_convert($input) {
    $input=strtolower($input);
    $output="";
    if (($input=="yes")or($input=="1")) {$output="1";}
    if (($input=="no")or($input=="0")) {$output="0";}
    return $output;
}

// Function to convert a Yes or No input to an equivalent 1 or 3 output
function ye_convert_3($input) {
    $input=strtolower($input);
    $output="";
    if (($input=="yes")or($input=="1")) {$output="1";}
    if (($input=="no")or($input=="3")) {$output="3";}
    return $output;
}

function youtube_embed_menu() {add_options_page('YouTube Embed Settings','YouTube Embed',10, 'youtube-embed-settings', 'youtube_embed_options');}
function youtube_embed_options() {include_once(WP_PLUGIN_DIR."/youtube-embed/youtube-embed-options.php");}
function youtube_widget_init() {
    register_sidebar_widget(__('YouTube Embed'),'youtube_widget');
    register_widget_control('YouTube Embed','youtube_widget_options');
}
function youtube_widget_options() {include_once(WP_PLUGIN_DIR."/youtube-embed/youtube-widget-options.php");}
?>