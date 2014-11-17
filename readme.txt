=== Polymer for WordPress ===
Contributors: blocknot.es
Tags: plugin,google,shortcode,page,posts,Post
Donate link: http://www.blocknot.es/home/me/
Requires at least: 3.5.0
Tested up to: 4.0
Stable tag: 1.3.0
License: GPL3
License URI: http://www.gnu.org/licenses/gpl-3.0.txt

Add Polymer elements to your website!
Polymer brings an implementation of Google Material Design to the web.

== Description ==

This plugin allows to add Polymer elements in your posts and pages, the same components used in Android Lollypop. You can use the HTML editor with the Polymer tags or the shortcode *[poly]* for all the elements. The correct HTML libraries will be loaded automatically.
Polymer documentation page: http://www.polymer-project.org/

Notice: Polymer is still in *developer* *preview* so some constructs may change in future. A modern browser is required to run Polymer apps.

Features:

* Polymer tags directly available (core & paper) in posts / pages in the HTML editor;
* [poly] shortcode to access all tags;
* simple widget;
* auto import the necessary HTML components;
* Javascript editor in posts / pages admin;
* CSS editor in posts / pages admin;
* autop on/off option;
* template override on/off option;
* documentation links for each tag.

Shortcode syntax: [poly ELEMENT-TAG ELEMENT-OPTIONS]

Tags: core-icon, paper-button, paper-checkbox, paper-slider, etc.

Options: style, id, class, etc.

Examples:

	[poly core-icon icon="favorite"][/poly]
	[poly paper-checkbox][/poly]
	[poly paper-button raised style="color: green"]A green button[/poly]
	[poly paper-item icon="home" label="Test link"]<a href="http://www.google.it" target="_blank"></a>[/poly]

Notes:

* autop option: the autop() Wordpress function adds p and br tags to the contents when a newline is found, but this can break the Polymer tags. This option allows to enable/disable autop() in posts / pages (plugin default: no autop)
* template override option: if this option is enabled this plugin will load a special template which provides only the required components to run a Polymer app. This is useful if you want a "fullscreen" Polymer app

== Installation ==

1. Install the plugin
1. Activate it
1. Edit a post or a page
1. Use the shortcode to add Polymer elements and/or add directly Polymer tags (in the HTML editor)

== Frequently Asked Questions ==

= How can I interact with the Polymer elements? =

You can add your Javascript code for your page or post in the Javascript editor under the content editor - Polymer Components meta box.
Sample code to open a dialog from a button click:

	window.addEventListener('polymer-ready', function(e) {
	  document.querySelector('#btn_test').addEventListener('click', function(e) {
	    document.querySelector('#my-dialog').toggle();
	  });
	});

= Can I create my elements? =

Yes, you can use the *polymer-element* tag in posts and pages also with script blocks.

== Screenshots ==

1. Some Polymer elements in a post
2. Polymer Components meta box in post / page editor
3. A custom element

== Upgrade Notice ==

= 1.3.0 =
* Update Polymer to 0.5.1
= 1.2.8 =
* New setting: CSS editor on/off
* Small fix
= 1.2.5 =
* New CSS editor for posts / pages
* New options: autop, override template
* Internal improvements
= 1.2.0 =
* New widget
* Auto-import improved
* Small fix to JS editor

== Changelog ==

= 1.3.0 =
* Update Polymer to 0.5.1
= 1.2.8 =
* New setting: CSS editor on/off
* Small fix
= 1.2.5 =
* New CSS editor for posts / pages
* New options: autop, override template
* Internal improvements
= 1.2.0 =
* New widget
* Auto-import improved
* Small fix to JS editor
= 1.1.2 =
* Small fix and changes to settings
= 1.1.0 =
* New settings screen
* New settings: JS in posts / pages
* Improved Javascript editor
* Added polymer-element tag
= 1.0.6 =
* New Javascript editor for posts / pages
= 1.0.2 =
* Small fix for admin docs
= 1.0.0 =
* First release
