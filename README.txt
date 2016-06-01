=== Plugin Name ===
Contributors: sarahovenall
Tags: usability testing
Requires at least: 3.0.1
Tested up to: 4.5
Stable tag: 4.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Generates a form on your site for remote (self-reported) usability testing.

== Description ==

This plugin generates a form on your site for informal self-reported usability testing. To use it:

1. Install CMB2 and this plugin in your site.
2. In your admin site, go to UX Testing. This is an options page with a simple form. Enter your tasks, and save.
3. Create a post or page on your site with instructions for your users. At the bottom of the content area, place the [uxtest] shortcde. The post or page will display a form with simple questions for each task, and a general comment area at the bottom.
4. To view a table of all responses grouped by task, go to UX Testing > UX Test Results in the admin site.
5. To view each user's response, go to UX Testing > UX All Responses.

== Installation ==

1. Upload the `sww-ux` directory to the `/wp-content/plugins/` directory
2. Download CMB2 from the WordPress Plugin repository, and upload it to the `/wp-content/plugins/` directory
3. Activate both CMB2 and UX Testing Form through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Help! I installed the plugin and there's an error message instead of a form for my tasks. =

This plugin relies on CMB2 to generate forms. Make sure CMB2 is also installed and active. https://wordpress.org/plugins/cmb2/

= How do I change the usability tasks? =

In the admin site, go to UX Testing. Enter your tasks in the form provided. You can use the up-down arrows to reorder tasks if needed.

= How do I display the usability test on my site? =

Create a post of page with instructions for your user test. At the bottom of the instructions place the shortcode [uxtest]. The shortcode will display the form.

= How do I change the questions that go with each task? =

To change or add questions you will need to edit the PHP file /public/class-sww-ux-public.php
The form is based on CMB2. Instructions on how to edit CMB2 fields here: https://github.com/WebDevStudios/CMB2/wiki/Field-Types

= I have more questions. =

Contact Sarah Ovenall at @sovenall

== Changelog ==

= 1.1 =
* Moved task list to options page rather than hard-coded.
* Decoupled from SWW Forms plugin for distribution.

= 1.0 =
* Initial plugin.


