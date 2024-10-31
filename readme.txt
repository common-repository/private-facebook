=== Private Facebook ===
Contributors: benjamin.netter
Donate link: http://www.twitter.com/benjaminnetter
Tags: facebook, security, restricted, private
Requires at least: 2.0
Tested up to: 3.3.1
Stable tag: 1.0.6

Restrict your blog to a specific list of Facebook users.

== Description ==

Private Facebook is a simple plugin for allowing a certain list of persons by their Facebook account.

Users can ask for permissions to read the blog, then you'd have to approve them so they can read it.

== Installation ==

1. Upload the `private-facebook` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Create a facebook app and link it in the settings of the plugin
4. (optional) You can edit the look of the waiting pages

== Frequently Asked Questions ==

= How can I edit the look of the pages? =

Copy the two files not-authorized.php and waiting-approval.php from the 'html' plugin directory to the theme directory, rename them to pf-not-authorized.php and pf-waiting-approval.php.
This will overwrite the default files.

= If you have any question =

You can send me your questions and feedbacks directly to my Twitter account @benjaminnnetter

== Screenshots ==

1. Your blog, the protected way
2. The access list

== Changelog ==
= 1.0.6 =
* Finally understood how to push the latest version (i think).

= 1.0.5 =
* Now displaying e-mail addresses

= 1.0.4 =
* Made a small typo error, broke it all. Now fixed !

= 1.0.2 =
* Thanks to @god_daaamn I solved a major problem with the user validation
* You can now customize the look of the pages

= 1.0.1 =
* Thanks to @pixxelboy I solved a major problem with the settings of the app, sorry for that guys
* Also had a problem with the font in the auhorization page

= 1.0 =
* First stable version
* You can approve users from your admin

== Upgrade Notice ==

= 1.0.4 =
Major bug solving. You have to upgrade as soon as possible.
