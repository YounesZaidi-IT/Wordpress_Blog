=== Access Category Password ===
Contributors: jojaba
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=5PXUPNR78J2YW&lc=FR&item_name=Jojaba&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Tags: protect, password, category
Requires at least: 3.0.1
Tested up to: 5.1
Stable tag: 1.4.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Protects posts in categories by setting a unique Password for all restricted categories.

== Description ==

This plugin makes it possible to restrict the access of posts contained in categries by setting a password and giving the impacted categories. The content and the excerpt of these posts are replaced by a password form that the user can fill out to get access. The WordPress generated feeds are modified (the description is replaced by a sentence that you can define).

Here's the list of the settings (see screenshots for further infos):

* Set the password.
* Check the categories that has to be protected
* Check the users granted to access the categories without password
* Tell if the excerpt should be displayed or not
* Set the info message that display before the password form
* Set the placeholder in password field
* Set the error message when typing the wrong password
* Set the valdation button text
* Set the text replacing the feed item description of protected posts
* You can style the form using the available classes in your styles.css file

Availabe languages : English, French, Simplified Chinese (thanks to Changmeng Hu), German.

This plugin uses php Sessions (more secure than cookies) to keep in mind the authenticated users. The password is crypted before it is stored. The regular feed content is filtered to avoid content display of restricted categories posts.

== Installation ==

1. Type "access category password" in the extension adding search form and install it or, after dowloaded the package, extract the `access-category-password` directory and upload it to the `/wp-content/plugins/` directory of your Wordpress installation
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Settings Â» Access Category Password to set up the plugin


== Frequently Asked Questions ==

= Could I protect more than one category =

Yes. You just have to check the right checkboxes in the plugin options screen.

= Could I style the password form? =

Yes. Beginning with version 1.4 of Access Category Password. You can add in your regular theme stylesheet (style.css) the selectors and their properties. Here are the available classes:
* `acpwd-container` class: the container of all elements that replace the content.
* `acpwd-info-message` class: the `<p>` tag containing the info message.
* `acpwd-form` class: the `<form>` tag.
* `acpwd-pass` class: the `<input type="password">` tag.
* `acpwd-submit` class: the `<input type="submit">` tag.
* `acpwd-error-message` class: the `<p>` tag containing the error message.

= Could I display the excerpt but not the content of a protected article? =

Yes. You just have to check the "Only single posts" checkbox in admin options panel.

= Could I set more than one Password? =

No, sorry, I wanted to keep the plugin simple. But this would be a functionnality that could be added later,â€¦

= Are the attachments in the posts protected ? =

No, sorry, I didn't find yet a solution to solve this. So if someone gets the link to the attachment of a protected post, he will be able to download it.

= Is this plugin compatible with Gutenberg, the new WordPress Editor? =

Yes.

== Screenshots ==

1. Access Category Password options page (beginning with version 1.4)
2. Protected content in Twenty Fifteen Theme
3. When wrong password...

== Changelog ==

= 1.4.1 =
* Fixed text domain issue.

= 1.4 =
* possibility to grant the selected roles to get access without providing the password.
* Make it possible to show the excerpt (in category listing for instance) even if the article is protected.
* Added zn_CN (thanks to Changmeng Hu) and de_DE translation.
* Added classes to password form to ease the styling.
* Fixed impossible to add working html tags to info message.

= 1.3 =
* Fixed the modified info message (in admin option panel) not beeing taken in account on frontpage.
* Added the possibility to change the validation button string.
* Better subitting text filtering in admin panel (using WP esc_attr() function)
* Fixed obsolete description strings.

= 1.2 =
* Fixed the characters already sent error on activation (it was simply an encoding issue).
* Keep now the regular feed (doesn't replace it) and sanitize it.
* Better session handling (session destroy on logout).

= 1.1 =
* Fixed wrong custom feed template inclusion path. Sorry for that!

= 1.0 =
* First release. Thanks for your feedback!
