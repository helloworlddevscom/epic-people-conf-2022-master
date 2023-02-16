=== WordPress Colorbox Lightbox ===
Contributors: naa986
Donate link: https://noorsplugin.com/
Tags: colorbox, gallery, images, lightbox, photos,
Requires at least: 3.0
Tested up to: 5.1
Stable tag: 1.1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

View image, video (YouTube, Vimeo), page, inline HTML, custom content in lightbox. Add jQuery Colorbox lightbox effect to your WordPress site.

== Description ==

[WordPress Colorbox](https://noorsplugin.com/wordpress-colorbox-plugin/) plugin is a simple lightbox tool for WordPress. It allows users to pop up content in lightbox using the popular jQuery ColorBox library. They can also view the larger version of a particular media file without leaving the page.

= Requirements =

* Latest version of WordPress
* A self-hosted website running on [WordPress hosting](https://noorsplugin.com/how-to-choose-the-right-wordpress-hosting/)

= Feature =

* Beautiful lightbox popup style
* Flexiblity of creating your own lightbox link
* Pop up custom/HTML content in lightbox
* Trigger lightbox from either a text/image link
* Compatible with WordPress multisite
* Add lightbox to a YouTube or Vimeo video link
* Enable lightbox functionality on your site which supports all major browsers
* Use a simple shortcode anywhere on your site (Post, Page, Homepage etc.)to pop up a media file in lightbox
* Apply lightbox effect on images inserted into WordPress post/page
* Open external page in lightbox using iframe
* Responsive lightbox popup which works on mobile devices. Also it fits perfectly on smaller screens.

= WP Colorbox Plugin Usage =

https://www.youtube.com/watch?v=2osxJcPTS1E&rel=0

**Pop up image in lightbox**

Create a new post/page and use the following shortcode to create a text/image link which will trigger lightbox once clicked:

`[wp_colorbox_media url="http://example.com/wp-content/uploads/images/overlay.jpg" type="image" hyperlink="click here to pop up image"]`

here, url is the link to the media file that you wish to open in lightbox and hyperlink is the anchor text/image.

`[wp_colorbox_media url="http://example.com/wp-content/uploads/images/overlay.jpg" type="image" hyperlink="http://example.com/wp-content/uploads/images/thumb.jpg"]`

**Pop up YouTube video in lightbox**

`[wp_colorbox_media url="http://www.youtube.com/embed/nmp3Ra3Yj24" type="youtube" hyperlink="click here to pop up youtube video"]`

**Pop up Vimeo video in lightbox**

`[wp_colorbox_media url="http://www.youtube.com/embed/1284237" type="vimeo" hyperlink="click here to pop up vimeo video"]`

**Show Title in lightbox**

`[wp_colorbox_media url="http://example.com/wp-content/uploads/images/overlay.jpg" title="overlay image" type="image" hyperlink="click here to pop up image"]`

**Specify an Alternate Text for an Image**

`[wp_colorbox_media url="http://example.com/wp-content/uploads/images/overlay.jpg" title="overlay image" type="image" hyperlink="http://example.com/wp-content/uploads/images/thumb.jpg" alt="Thumbnail image description"]`

**Apply Custom CSS**

You can specify your own CSS class in the shortcode to customize a text/image link.

`[wp_colorbox_media url="http://www.youtube.com/embed/nmp3Ra3Yj24" type="youtube" hyperlink="click here to pop up youtube video" class="custom_class"]`

Multiple CSS classes can be separated with a space. For example:

`[wp_colorbox_media url="http://www.youtube.com/embed/nmp3Ra3Yj24" type="youtube" hyperlink="click here to pop up youtube video" class="custom_class custom_class2"]`

For detailed documentation please visit the [WordPress Colorbox](https://noorsplugin.com/wordpress-colorbox-plugin/) plugin page

= Recommended Reading =

* [WordPress Colorbox Documentation](https://noorsplugin.com/wordpress-colorbox-plugin/)
* My [Free WordPress Plugins](https://noorsplugin.com/wordpress-plugins/)

== Installation ==

1. Go to the Add New plugins screen in your WordPress Dashboard
1. Click the upload tab
1. Browse for the plugin file (wp-colorbox.zip) on your computer
1. Click "Install Now" and then hit the activate button

== Frequently Asked Questions ==

= Can I use this plugin to pop up an image in lightbox? =

Yes.

= Can I use this plugin to pop up a YouTube video in lightbox? =

Yes.

= Can I use this plugin to pop up a Vimeo video in lightbox? =

Yes.

= Can I use this plugin to pop up an external page in lightbox? =

Yes.

= Can I use this plugin to pop up inline HTML content in lightbox? =

Yes.

= Is this plugin responsive? =

Yes.

= Is this plugin compatible with desktop, tablet and mobile devices? =

Yes.

== Screenshots ==

1. Image popup in lightbox
2. YouTube video popup in lightbox
3. Vimeo video popup in lightbox
4. External page popup in lightbox

== Upgrade Notice ==
none

== Changelog ==

= 1.1.2 =
* Updated Colorbox to the latest version (1.6.4).

= 1.1.1 =
* Compatible with WordPress 4.8
* Updated all the permalinks

= 1.1.0 =
* Disabled scrolling option for YouTube and Vimeo videos.

= 1.0.9 =
* Alt (alternate text) attribute can now be specified in the shortcode for a thumbnail image.

= 1.0.8 =
* Added translation option so the plugin can take advantage of language packs
* WP Colorbox is now compatible with WordPress 4.4

= 1.0.7 =
* WP Colorbox is now compatible with WordPress 4.3

= 1.0.6 =
* Added a new shortcode parameter to apply custom CSS classes on a text/image link

= 1.0.5 =
* Added a new shortcode parameter to show the title of a media in lightbox

= 1.0.4 =
* colorbox shortcodes can now be embedded in a text widget

= 1.0.3 =
* Lightbox now opens full-sized images

= 1.0.2 =
* Lightbox window is now responsive

= 1.0.1 =
* WP Colorbox is now compatible with WordPress 3.9

= 1.0 =
* First commit
