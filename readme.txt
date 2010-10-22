=== YouTube Embed ===
Contributors: dartiss
Donate link: http://artiss.co.uk/donate
Tags: YouTube, Embed, XHTML, Video, Playlist, Thumbnail
Requires at least: 2.0
Tested up to: 3.0.1
Stable tag: 1.3.1

YouTube Embed is a powerful, but simple to use, method of embedding YouTube videos in your WordPress theme.

== Description ==

YouTube Embed is a powerful, but simple to use, method of embedding YouTube videos in your WordPress theme.

It works with all the current YouTube API parameters, including HD video, and produces XHTML valid output. It also, unlike many others similar plugins, works with videos with certain characters within their ID (e.g. double dashes).

Over the coming instructions I'll take you through the various ways to embed video, playlists and other YouTube related abilities.

There are 3 ways to embed a video - a function call (requires PHP coding, but can be placed anywhere), a short code (which can be easily placed in a post or page) or with a sidebar widget.

A video will use the default settings - these can be changed via the YouTube Embed options screen within your administration panel. However, with the exception of the widget, you can also change any of these settings on a per-video basis.

Let's go through each of the 3 methods in turn...

**1. Function Call**

For those with access (and the requirement) to their theme PHP, a function calls adds total flexibility as it can be added anywhere within your theme.

`<?php if (function_exists('youtube_video_embed')) {youtube_video_embed('id','paras','style');} ?>`

Where id is the video ID, paras is a list of parameters (more on this in a minute) and style (optional) is a list of stylesheet elements that you wish to apply to the resulting video.

The parameters are supplied with an ampersand seperating each. See the "Parameters" section of these instructions for details on what parameters are available, but here's an example where I override the height and width of a video...

`<?php if (function_exists('youtube_video_embed')) {youtube_video_embed('id','width=100&height=200');} ?>`

**2. Short Code**

This is an easy one. Within any post or page, simply type the following...

`[youtube]id[/youtube]`

Where id is the ID of the video.

If you wish to override any of the settings, then these must be specified within the opening short code. So, to adjust the width and height, you'd put...

`[youtube width=100 height=200]id[/youtube]`

In this case, the width is 100px and the height is 200px.

For a complete list of the parameters, please see the appropriate tab above. You may also specify a stylesheet override by using the `style` parameter. For example...

`[youtube style="text-align:center"]id[/youtube]`

This will centre the resulting video.

**3. Widget**

The Widget is available from the Appearance->Widgets menu within Administation. Drag it to the appropriate sidebar and click on the down arrow to modify the default options.

These NEED to be done as you also have to specify the video ID and type (video or playlist).

**Playlists**

You can also embed playlists using any of the video embedding methods mentioned before.

For function calls, simply use the function `youtube_playlist_embed`, with the same parameters as the video equivalent.

For short codes, use the short code `[youtube_playlist]`, again with the same parameters as before.

For the widget, simply change the "Type" option in the Widget options to "Playlist".

In all cases you must specify a valid playlist ID, instead of the standard video ID.

**Thumbnails**

YouTube embed also has the ability to return a thumbnail of a video (sorry, this doesn't work with playlists).

There are two methods you can use for this - a shortcode or a function call.

Use the following function call to add a thumbnail to any part of your theme.

`<?php if (function_exists('youtube_thumb_embed')) {youtube_thumb_embed('id','paras','style','alt');} ?>`

Like the video embed equivalent, the ID is the video ID, the style is a list of stylesheet elements (but is optional) and alt is the alternative text for the thumbnail image (also optional). The parameters are different, however, but, again, are seperated by ampersand.

The parameters are as follows...

* *rel* - specify a REL override, e.g. rel="nofollow"
* *target* - specify a TARGET override, e.g. target="_blank"
* *width* - this specifies the width of the thumbnail image
* *height* - this specifies the height of the thumbnail image

Here's an example, with parameters to specify the REL, TARGET and ALT elements.

`<?php if (function_exists('youtube_thumb_embed')) {youtube_thumb_embed('id','rel=nofollow&target=_blank','','Demo Video');} ?>`

To use the short code method, insert [youtube_thumb]id[/youtube_thumb] into a post or page to create a thumbnail of the relevant video ID which, once clicked, will open up the appropriate YouTube page.

Like the function call above, you can specify a number of parameters. They are the same as detailed above but with the addition of two further parameters...

* *style* - allows you to specify any stylesheet elements that you'd like applied
* *alt* - specify some "ALT" text for the thumbnail image

For example...

`[youtube_thumb target="_blank" alt="Demo video"]id[/youtube_thumb]`

This overrides the TARGET and ALT elements of the thumbnail.

**Short URL**

You may return a short URL for any YouTube video by way of either a function call or a shortcode.

For a function call, add the following to your code to return a URL - note that this is not written out, but returned as a value. id is the video ID.

`<?php if (function_exists('youtube_short_url')) {youtube_short_url('id');} ?>`

So, an example may be...

`<a href="<?php echo youtube_short_url('id'); ?>"Click here for video</a>`

This will create a link to a video using the short URL standard.

To use the shortcode method simply insert `[youtube_url]id[/youtube_url]` anywhere within a post or page to return a shortened URL. As with other examples, id is the ID of the video.

== Parameters ==

The following parameters can be specified for any embedded YouTube video. Some of these will also work with playlists but, due to a lack of YouTube documentation on the subject, I'm unable to say which they are.

* *width* - the width of the video in pixels
* *height* - the height of the video in pixels
* *fullscreen* - yes or no, this adds a button to the video player, allowing the video to be shown fullscreen
* *hd* - yes or no, this determines whether a video defaults to HD quality, if available
* *color1* - this is 1 of 2 colors that can be used on the video player. It is in a hex RGB format, and should be 6 letters long.
* *color2* - this is the second video player colour. Again, this is a hex RGB format.
* *autoplay* - yes or no, this specifies whether the video automatically starts to play
* *start* - this can be specified if you wish for the video not to start at the beginning. Specify a number of seconds.
* *loop* - yes or no, this specifies whether the video loops back to the beginning once it completes
* *cc* - yes or no, this turns on or off closed captions (subtitles)
* *annotation* - yes or no, this specifies whether you wish video annotations to be shown
* *egm* - yes or no, this enables or disables the Enhanced Genie Menu
* *related* - yes or no, this specifies whether you wish to display related videos
* *info* - yes or no, this determines whether video information is shown
* *search* - yes or no, this specifies whether the search box is shown

For further details on these parameters, please read the [YouTube documentation](http://code.google.com/apis/youtube/player_parameters.html "YouTube Embedded Player Parameters").

== Screenshots ==

1. YouTube Embed admin screen, showing demonstration video

== Installation ==

1. Upload the entire `youtube-embed` folder to your `wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Visit the YouTube Embed options screen in your Administration menu and set the default parameters
4. If using the widget, browse to `Appearance->Widgets`, add the widget, and configure the options

== Frequently Asked Questions ==

= How do I find the ID of a YouTube video? =

If you play a YouTube video, look at the URL - it will probably look something like this...

`http://www.youtube.com/watch?v=L5Y4qzc_JTg`

The video ID is the list of letters and numbers after `v=`, in this case `L5Y4qzc_JTg`.

= How can I get help or request possible changes =

Feel free to report any problems, or suggestions for enhancements, to me either via [my contact form](http://www.artiss.co.uk/contact "Contact Me") or by [the plugins homepage](http://www.artiss.co.uk/youtube-embed "YouTube Embed").

== Changelog ==  
  
= 1.0 =
* Initial release

= 1.1 =
* Updated test video on options screen, as previous one had been removed
* Resulting XHTML code is better formatted, with comments identifying code location
* Confirmed WP 3.0 compatibility

= 1.2 =
* Minor changes to the XHTML code to prevent warnings from certain validators

= 1.3 =
* Added transparency option so that videos won't cover up layers

= 1.3.1 =
* New widget option to specify title

== Upgrade Notice ==

= 1.0 =
* Initial release

= 1.1 =
* Update to get the test video on the options screen working again!

= 1.2 =
* Update to ensure no warnings are reported by XHTML validators

= 1.3 =
* Update if you find that the videos are covering up layers

= 1.3.1 =
* Update if you wish to change the widget heading