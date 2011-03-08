<?php
/*
Plugin Name: YouTube Embed
Plugin URI: http://www.artiss.co.uk/youtube-embed
Description: Embed YouTube Videos in WordPress
Version: 1.4.1
Author: David Artiss
Author URI: http://www.artiss.co.uk
*/
define('youtube_embed_version','1.4.1');

// Set up WordPress shortcodes and actions
add_shortcode('youtube','youtube_video_sc');
add_shortcode('youtube_playlist','youtube_playlist_sc');
add_shortcode('youtube_thumb','youtube_thumbnail_sc');
add_shortcode('youtube_url','youtube_url_sc');
add_shortcode('transcript','youtube_transcript');
add_action('admin_menu','youtube_embed_menu');

/*
Shortcodes
*/

// Embed a YouTube video
function youtube_video_sc($paras="",$content="") {
    extract(shortcode_atts(array('width'=>'','height'=>'','fullscreen'=>'','related'=>'','autoplay'=>'','loop'=>'','egm'=>'','border'=>'','color1'=>'','color2'=>'','start'=>'','hd'=>'','search'=>'','info'=>'','annotation'=>'','cc'=>'','style'=>'','link'=>'','react'=>'','stop'=>'','sweetspot'=>'','embedplus'=>''),$paras));
    $embedplus=ye_convert($embedplus);
    if ($embedplus=="1") {$type="m";}
    if ($embedplus=="0") {$type="v";}
    $youtube_code=generate_youtube_code($content,$type,$width,$height,ye_convert($fullscreen),ye_convert($related),ye_convert($autoplay),ye_convert($loop),ye_convert($egm),ye_convert($border),$color1,$color2,$start,ye_convert($hd),ye_convert($search),ye_convert($info),ye_convert_3($annotation),ye_convert($cc),$style,ye_convert($link),ye_convert($react),$stop,ye_convert($sweetspot));
    return $youtube_code;
}

// Embed a YouTube playlist
function youtube_playlist_sc($paras="",$content="") {
    extract(shortcode_atts(array('width'=>'','height'=>'','fullscreen'=>'','related'=>'','autoplay'=>'','loop'=>'','egm'=>'','border'=>'','color1'=>'','color2'=>'','start'=>'','hd'=>'','search'=>'','info'=>'','annotation'=>'','cc'=>'','style'=>'','link'=>'','react'=>'','stop'=>'','sweetspot'=>''),$paras));
    return generate_youtube_code($content,"p",$width,$height,ye_convert($fullscreen),ye_convert($related),ye_convert($autoplay),ye_convert($loop),ye_convert($egm),ye_convert($border),$color1,$color2,$start,ye_convert($hd),ye_convert($search),ye_convert($info),ye_convert_3($annotation),ye_convert($cc),$style,ye_convert($link),ye_convert($react),$stop,ye_convert($sweetspot));
}

// Return a thumbnail URL
function youtube_thumbnail_sc($paras="",$content="") {
    extract(shortcode_atts(array('style'=>'','class'=>'','rel'=>'','target'=>'','width'=>'','height'=>'','alt'=>''),$paras));
    return generate_thumbnail_code($content,$style,$class,$rel,$target,$width,$height,$alt);
}

// Return a short YouTube URL
function youtube_url_sc($paras="",$content="") {
    if ($content=="") {return youtube_embed_error("No video ID has been supplied");} else {return "http://youtu.be/".$content;}
}

// Shortcode to return YouTube transcripts
function youtube_transcript($paras="",$content="") {
    return get_youtube_transcript($content);
}

/*
Function calls
*/

// Embed a YouTube video
function youtube_video_embed($content,$paras="",$style="") {
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
    $link=youtube_get_parameters($paras,"link");
    $react=youtube_get_parameters($paras,"react");
    $stop=youtube_get_parameters($paras,"stop");
    $sweetspot=youtube_get_parameters($paras,"sweetspot"); 
    $embedplus=ye_convert(youtube_get_parameters($paras,"embedplus"));
    if ($embedplus=="1") {$type="m";}
    if ($embedplus=="0") {$type="v";}
    echo generate_youtube_code($content,$type,$width,$height,ye_convert($fullscreen),ye_convert($related),ye_convert($autoplay),ye_convert($loop),ye_convert($egm),ye_convert($border),$color1,$color2,$start,ye_convert($hd),ye_convert($search),ye_convert($info),ye_convert_3($annotation),ye_convert($cc),$style,ye_convert($link),ye_convert($react),$stop,ye_convert($sweetspot));
    return;
}

// Embed a playlist
function youtube_playlist_embed($content,$paras="",$style="") {
    youtube_video_embed($content,$paras="",$style="","p");
    return;
}

// Display a video thumbnail
function youtube_thumb_embed($content,$paras="",$style="",$alt="") {
    $class=youtube_get_parameters($paras,"class");
    $rel=youtube_get_parameters($paras,"rel"); 
    $target=youtube_get_parameters($paras,"target");
    $width=youtube_get_parameters($paras,"width");
    $height=youtube_get_parameters($paras,"height");
    echo generate_thumbnail_code($content,$style,$class,$rel,$target,$width,$height,$alt);
    return;
}

// Display a short YouTube URL
function youtube_short_url($id) {
    return "http://youtu.be/".$id;
}

// Return XML formatted YouTube transcript
function get_youtube_transcript_xml($id="") {
    $return=youtube_get_file("http://video.google.com/timedtext?lang=en&v=".$id);
    if ($return['rc']<0) {return false;} else {return $return['file'];}
}

/*
Admin Menu
*/

function youtube_embed_menu() {
    add_options_page('YouTube Embed Settings','YouTube Embed',10, 'youtube-embed-settings', 'youtube_embed_options');
}

function youtube_embed_options() {
    include_once(WP_PLUGIN_DIR."/youtube-embed/youtube-embed-options.php");
}

/*
Widgets
*/

global $wp_version;
if((float)$wp_version>=2.8){

    class YouTubeEmbedWidget extends WP_Widget {

        // Constructor
        function YouTubeEmbedWidget() {
            parent::WP_Widget('youtube_embed_widget', 'YouTube Embed', array('description' => 'Embed YouTube Widget.', 'class' => 'my-widget-class'));
        }

        // Display widget
        function widget($args, $instance) {
            extract($args, EXTR_SKIP);
            echo $before_widget;
            $title=$instance['titles'];
            $id=$instance['id']; 
            if (!empty($title)) {echo $before_title.$title.$after_title;}
            echo generate_youtube_code($instance['id'],$instance['type'],$instance['width'],$instance['height'],$instance['fullscreen'],$instance['related'],$instance['autoplay'],$instance['loop'],$instance['egm'],$instance['border'],$instance['color1'],$instance['color2'],$instance['start'],$instance['hd'],$instance['search'],$instance['info'],$instance['annotation'],$instance['cc'],$instance['style'],$instance['link'],$instance['react'],$instance['stop'],$instance['sweetspot']);
            echo $after_widget;
        }

        // Update/save function
        function update($new_instance, $old_instance) {
            $instance=$old_instance;
            $instance['titles']=strip_tags($new_instance['titles']);
            $instance['id']=$new_instance['id'];
            $instance['type']=$new_instance['type'];
            $instance['width']=$new_instance['width'];
            $instance['height']=$new_instance['height'];
            $instance['border']=$new_instance['border'];
            $instance['fullscreen']=$new_instance['fullscreen'];
            $instance['hd']=$new_instance['hd'];
            $instance['color1']=$new_instance['color1'];
            $instance['color2']=$new_instance['color2'];
            $instance['style']=$new_instance['style'];
            $instance['autoplay']=$new_instance['autoplay'];
            $instance['start']=$new_instance['start'];
            $instance['loop']=$new_instance['loop'];
            $instance['cc']=$new_instance['cc'];
            $instance['annotation']=$new_instance['annotation'];
            $instance['egm']=$new_instance['egm']; 
            $instance['related']=$new_instance['related'];
            $instance['info']=$new_instance['info'];
            $instance['search']=$new_instance['search'];
            $instance['link']=$new_instance['link'];
            $instance['react']=$new_instance['react'];
            $instance['stop']=$new_instance['stop'];
            $instance['sweetspot']=$new_instance['sweetspot'];
            return $instance;
        }

        // Admin control form
        function form($instance) {
            include_once(WP_PLUGIN_DIR."/youtube-embed/youtube-widget-options.php");
        }
    }

    // Register widget when loading the WP core
    add_action('widgets_init',youtube_embed_register_widgets);
    function youtube_embed_register_widgets() {register_widget('YouTubeEmbedWidget');}
}

/*
Generate Embed code
*/

// Generate XHTML compatible YouTube embed code
function generate_youtube_code($id,$type,$width,$height,$fullscreen,$related,$autoplay,$loop,$egm,$border,$color1,$color2,$start,$hd,$search,$info,$annotation,$cc,$style,$link,$react,$stop,$sweetspot) {

    // Ensure an ID is passed
    if (($id=="")&&(strtolower($widget)!="yes")) {
        return youtube_embed_error("No video/playlist ID has been supplied");
    } else {

        // Get default values if no values are supplied
        $options=get_option("youtube_embed");
        if (!is_array($options)) {
            $options = array('width'=>'425','height'=>'355','border'=>'0','fullscreen'=>'0','hd'=>'1','color1'=>'2b405b','color2'=>'6b8ab6','style'=>'','autoplay'=>'0','start'=>'0','loop'=>'0','cc'=>'0','annotation'=>'1','egm'=>'0','related'=>'0','info'=>'1','search'=>'1','link'=>'1','react'=>'1','stop'=>'0','sweetspot'=>'1','type'=>'0');
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
        if ($link=="") {$link=$options['link'];}
        if ($react=="") {$react=$options['react'];}
        if ($stop=="") {$stop=$options['stop'];}
        if ($sweetspot=="") {$sweetspot=$options['sweetspot'];}
        if ($type=="") {$type=$options['type'];}

        // Set up EmbedPlus
        if ($type=="m") {
            $type="v";
            $embedplus=true;
            $tab="\t";
            $embedheight=$height+32;
            $objectclass=' class="cantembedplus"';
        } else {
            $embedplus=false;
            $tab="";
            $objectclass="";
        }

        // Convert video ID characters
        $id=str_replace("&#8211;","--",$id);
        $id=str_replace("&#215;","x",$id);

        // Generate parameters to add to URL
        $paras="&amp;fs=".$fullscreen."&amp;rel=".$related."&amp;autoplay=".$autoplay."&amp;loop=".$loop."&amp;egm=".$egm."&amp;border=".$border."&amp;color1=0x".$color1."&amp;color2=0x".$color2."&amp;hd=".$hd."&amp;showsearch=".$search."&amp;showinfo=".$info."&amp;iv_load_policy=".$annotation."&amp;cc_load_policy=".$cc;
        $paras_ep="&amp;width=".$width."&amp;height=".$height."&amp;hd=".$hd."&amp;react=".$react."&amp;sweetspot=".$sweetspot;
        if ($start!=0) {$paras.="&amp;start=".$start; $paras_ep.="&amp;start=".$start;}
        if ($stop!=0) {$paras_ep.="&amp;stop=".$stop;}

        // Code header
        $result="<!-- YouTube Embed v".youtube_embed_version." | http://www.artiss.co.uk/youtube-embed -->\n";
        if ($style!="") {$result.="<div style=\"".$style."\">\n";}

        // Add EmbedPlus code (if required)
        if ($embedplus) {
            $result.="<object type=\"application/x-shockwave-flash\" width=\"".$width."\" height=\"".$embedheight."\" data=\"http://getembedplus.com/embedplus.swf\">\n";
            $result.="<param value=\"http://getembedplus.com/embedplus.swf\" name=\"movie\" />\n";
            $result.="<param value=\"high\" name=\"quality\" />\n";
            $result.="<param value=\"transparent\" name=\"wmode\" />\n";
            $result.="<param value=\"always\" name=\"allowscriptaccess\" />\n";
            if ($fullscreen==1) {$result.="<param name=\"allowFullScreen\" value=\"true\" />\n";}
            $result.="<param name=\"flashvars\" value=\"ytid=".$id.$paras_ep."\" />\n";
        }

        // Add standard YouTube embed code
        $result.=$tab."<object".$objectclass." type=\"application/x-shockwave-flash\" data=\"http://www.youtube.com/".$type."/".$id.$paras."\" width=\"".$width."\" height=\"".$height."\" wmode=\"transparent\">\n";
        $result.=$tab."<param name=\"movie\" value=\"http://www.youtube.com/".$type."/".$id.$paras."\" />\n";
        $result.=$tab."<param name=\"wmode\" value=\"transparent\" />\n";
        if ($fullscreen==1) {$result.=$tab."<param name=\"allowFullScreen\" value=\"true\" />\n";}
        if (($link!=1)&&($link!="")) {$result.=$tab."<param name=\"allowNetworking\" value=\"internal\" />\n";}

        // Code footer
        $result.=$tab."</object>\n";
        if ($embedplus) {$result.="</object>\n<!--[if lte IE 6]> <style type=\"text/css\">.cantembedplus{display:none;}</style><![endif]-->\n";}
        if ($style!="") {$result.="</div>\n";}
        $result.="<!-- End of YouTube Embed code -->\n";
        return $result;
    }
}

// Generate XHTML compatible YouTube video thumbnail
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

// Generate re-encoded YouTube transcript
function get_youtube_transcript($id) {

    // Get transcript file
    $return=youtube_get_file("http://video.google.com/timedtext?lang=en&v=".$id);
    $xml=$return['file'];
    $output="";

    // If transcript file exists, strip and output
    if ($return['rc']>0) {
        $output="<!-- YouTube Embed v".youtube_embed_version." | http://www.artiss.co.uk/youtube-embed -->\n";
        $pos=0;
        $eof=false;
        while (!$eof) {
            $text_start=strpos($xml,"<text ",$pos);
            if ($text_start!==false) {

                // Extract the start time
                $start_start=strpos($xml,'start="',$text_start)+7;
                $start_end=strpos($xml,'"',$start_start)-1;
                $start=substr($xml,$start_start,$start_end-$start_start+1);

                // Convert time format
                $start=str_pad(floor($start),3,"0",STR_PAD_LEFT);
                $start=substr($start,0,-2).":".substr($start,-2,2);
                // Now extract the text
                $text_start=strpos($xml,">",$text_start)+1;
                $text_end=strpos($xml,"</text>",$text_start)-1;
                $text=substr($xml,$text_start,$text_end-$text_start+1);

                // Now return the output
                $output.="<div class=\"Transcript\"><span class=\"TranscriptTime\">".$start."</span> <span class=\"TranscriptText\">".htmlspecialchars_decode($text)."</span></div>";
                $pos=$text_end+7;
            } else {
                $eof=true;
            }
        }
        $output.="<!-- End of YouTube Embed code -->\n";
    }
    return $output;
}

/*
Shared Functions
*/

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

// Function to get a file using CURL or alternative (1.4)
function youtube_get_file($filein) {
    $fileout="";
    // Try to get with CURL, if installed
    if (in_array('curl',get_loaded_extensions())===true) {
        $cURL = curl_init();
        curl_setopt($cURL,CURLOPT_URL,$filein);
        curl_setopt($cURL,CURLOPT_RETURNTRANSFER,1);
        $fileout=curl_exec($cURL);
        curl_close($cURL);
        if ($fileout=="") {$rc=-1;} else {$rc=1;}
    }
    // If CURL failed and a url_fopen is allowed, use that
    $fopen_status=strtolower(ini_get('allow_url_fopen'));
    if (($fileout=="")&&(($fopen_status===true)or($fopen_status=="yes")or($fopen_status=="on")or($fopen_status=="1"))) {
        $fileout=file_get_contents($filein);
        if ($fileout=="") {$rc=-2;} else {$rc=2;}
    }
    if ((in_array('curl',get_loaded_extensions())!==true)&&(ini_get('allow_url_fopen')==1)) {$rc==-3;}
    $file_return['file']=$fileout;
    $file_return['rc']=$rc;
    return $file_return;
}
?>