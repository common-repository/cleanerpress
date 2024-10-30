=== CleanerPress ===
Contributors: Arevico 
Tags: minify, css, cache,speed,performance
Requires at least: 3.0
Tested up to: 3.5
Stable tag: 2.0.1

Every admin wants to have their website loaded as fast as possible.CleanerPress tries to give you some more control over what is outputted to the user

== Description ==

Every admin wants to have their website loaded as fast as possible. A fast website results in more actions per visitors and higher conversions (signups, shares, reads, comments,etc).

[youtube http://www.youtube.com/watch?v=gLMxXUETQOc]

CleanerPress tries to give you some more control over what is outputted to the user. It currently does te following:

*   Combine CSS stylesheets and caches it. Only static css files are returned to the user. - make sure to chmod the folder is needed
*   Remove the admin bar if you don't want to have it
*   Hide version numbers, RSS, WLW endpoints to reduce html size and give hackers a harder time.
*   Loading all of your scripts via HeadJS. This means that the amount of request doesn't matter, the website gets rendered 2-4 times faster. Will also be applied to the admin area
*   Load jQuery from the google cdn, so the visitor allready has it cached (well, 90% of the times)
*	select which plugins are loaded where
** NOTE: All options can safely be enabled and don't affect seo negative (speed is good). **

== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page

make sure that wp-content is correctly chmodded
== Frequently Asked Questions ==

**Q. The CSS combiner does not work?**

CHMOD all files and folders (or at least arevico-css-cache_ in wp_content/ to 755. Make sure to include wp-content also

**Q. Plugin X doesn't work with this plugin?**

Not all plugin include javascript the way specified in the codex. Sometimes, there is a good reason for, sometimes not. It is best to email us with a link to your website and tell us with which plugin it conflicts. We can then diagnose and specify a solution.

**Q. Not all CSS Files are cached?**

Dynamic css files are excluded, since these require a request from the server. This generates too much overhead. Some plugins also output CSS instead of enqueing it. This plugin doesn't detect that. Same goes with javascripts.

**Q. Why is javascript not combined?* *

Because it blocks! It is much better to load javascript after the page has been fully rendered.

*If you have any questions or feature suggestions, please DO ask.*
== Screenshots ==
1. Option screen 1

2. Option screen 2

== Changelog ==
**2.0.1**
fixed arevico-css-cache

Initial release
**1.0.0**

Initial release