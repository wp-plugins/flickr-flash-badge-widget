=== Flickr Flash Badge Widget ===
Contributors: erikrasmussen
Donate link: http://www.erik-rasmussen.com/blog/2006/09/14/flash-flickr-badge-widget-for-wordpress/
Tags: flickr, badge, widget, sidebar, flash, photos, media
Requires at least: 2.0.2
Tested up to: 2.7.1
Stable tag: 1.2

Places a Flickr flash badge in your sidebar as a widget and allows for enhanced size, tag, and transition control.

== Description ==

Flickr Flash Badge Widget places a standard Flickr flash badge in your sidebar to display your photos from Flickr.  Note that the flash object comes from Flickr.com and is not hosted from your server.  Your server just communicates with Flickr to get a special code, `magisterLudi`, which changes every 24 hours, and then embeds the flash badge from Flickr into your page.

If you like this plugin, please log in and rate it in the <a href="http://wordpress.org/extend/plugins/flickr-flash-badge-widget/">Wordpress Plugin Directory</a>.

== Installation ==

1. Unzip the plugin into the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Enter your Flickr account details into the widget settings on the Sidebar Widgets page in your WordPress admin (see screenshot)
1. Drag the widget onto the sidebar where you want it on the Sidebar Widgets page in your WordPress admin.

== Frequently Asked Questions ==

= How can I find my @N00 Flickr ID? =

You can go to <a href="http://bighugelabs.com/flickr/dna.php">Big Huge Lab's Flickr DNA page</a> and enter your Flickr username and hit 'Apply'. Your @N00 Flickr ID will appear on the subsequent page.

== Why was this hard? ==

Flickr has a magic variable called `magisterLudi` that changes every 24 hours. When you use their default method with the iframe, the content of the iframe contains the current value of the magisterLudi. This prevents you from just pasting the `<object>` tag to run the flash file on their server and bypassing their iframe. (It will work, but not for more than 24 hours.)

To solve this problem, this plugin goes to fetch the contents of the iframe from Flickr, parses it to get the current magisterLudi value, and uses that to display the flash object directly on your page, thereby avoiding the iframe and bypassing their mechanism intended to force use of their iframe.

A caching mechanism is in place to reduce these server-side calls to Flickr. By default, it will only update the magisterLudi value from Flickr every two minutes. Therefore, for two minutes (after Flickr changes the value) every day the plugin will fail. You may change this value in flickr-badge-widget.php if you wish.

== Screenshots ==

1. The widget editing box where you enter your @N00 ID.
