=== Polymer Components ===
Contributors: blocknot.es
Tags: plugin,google,shortcode,page,posts,Post
Donate link: http://www.blocknot.es/home/me/
Requires at least: 3.5.0
Tested up to: 4.0
Stable tag: 1.0.6
License: GPL3
License URI: http://www.gnu.org/licenses/gpl-3.0.txt

Add Polymer components to your website!
Polymer brings an implementation of Google Material Design to the web.

== Description ==

This plugin allows to add Polymer elements in your posts and pages. The same components used in Android Lollypop. You can use the HTML editor with the Polymer tags or the shortcode *[poly]* for all the elements. The correct HTML libraries will be loaded automatically when you use a Polymer tag.
Polymer documentation page: http://www.polymer-project.org/

Shortcode syntax: [poly ELEMENT-TAG ELEMENT-OPTIONS]

Tags: core-icon, paper-button, paper-checkbox, paper-slider, etc.

Options: style, id, class, etc.

Examples:

* [poly core-icon icon="favorite"][/poly]
* [poly paper-checkbox][/poly]
* [poly paper-button raised style="color: green"]A green button[/poly]
* [poly paper-item icon="home" label="Test link"]<a href="http://www.google.it" target="_blank"></a>[/poly]

== Installation ==

1. Install and activate the plugin
1. Edit a post or a page
1. Add one or more Polymer tags (in the HTML editor) or use the shortcode

== Frequently Asked Questions ==

= How can I interact with the Polymer elements? =

You can add your Javascript code for your page or post, under the content editor there is a textarea in Polymer components meta box.
Example code to open a dialog from a button click:

		window.addEventListener('polymer-ready', function(e) {
		  document.querySelector('#btn_test').addEventListener('click', function(e) {
		    document.querySelector('#my-dialog').toggle();
		  });
		});

== Screenshots ==

1. Some Polymer components in a post

== Upgrade Notice ==

= 1.0.5 =
* Added Javascript textarea to posts and pages
= 1.0.2 =
* Small fix for admin docs
= 1.0.0 =
* First release

== Changelog ==

= 1.0.5 =
* Added Javascript textarea to posts and pages
= 1.0.2 =
* Small fix for admin docs
= 1.0.0 =
* First release
