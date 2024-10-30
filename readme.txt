=== Missing Widgets for Elementor ===
Contributors: jargovi, freemius
Tags: Elementor,Widgets,Button,Missing,Formidable Forms,FormAssembly,Forms,Cookie Consent Popup,Label listing,Anchor,Offset,Sticky, Scrolling, Transparent icon, Background color, Text editor
Requires at least: 5.0
Tested up to: 6.6
Requires PHP: 7.4
Stable tag: 1.4.7
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Usefull widgets for Elementor that other widgetbuilders have missed.

== Description ==
With more than 5 million active installations Elementor is the most popular page builder plugin of WordPress. With it’s drag and drop interface and easy editing any user can create in no-time beautiful content for it’s own website.

Elementor can be extended with extra features and widgets by adding third party Elementor plugins. However in my experience as a website builder these plugins were always missing some features i needed. So i ended up coding these features myself.
For re-use in various projects i've bundled them into a handy plugin called “Missing Widgets for Elementor”. Now i’m publishing this plugin so other can use them as well. I hope you like them.

These are the widgets i've created so far:

##NEW: Dynamic Field List widget
Use the Elementor Dynamic Field list widget to create a list of static/dynamic fields with a separator between the different fields,
like a horizontal menu or vertical list of product properties.

##Footermenu widget
With this widget you can easily create a 2-layer navigation menu inside the footer of your website. 
you can control the menuitems inside the WordPress menu's adminpage. Use main and submenu items to create to listings of the various menu columns.
Add styling and extra icons in front of the submenu items to create a fancy footermenu.

##Extra styling for a Button widget
In the global styling of Elementor you can set the styling of a general button. Most of the time i\'m using different styled buttons in 1 website.
However the styling of the types of the elementor button widget is not defined. This plugin adds an extra tab to the global styling where you can set the styling of all the different types
of the elementor button widget. This way you now can create up to 5 globally styled elementor buttons instead of 1.

##Cookie Consent Popup widget
Create and style you own GDPR/AVG Compliant Cookie Consent Popup and integrate this with Google Tag Manager.
Based on the setting inside GTM and the preferences of the visitor cookie scripts are loaded or not.
For more info on how to integrate with GTM see the [feature page of the cookie consent widget](https://missingwidgets.com/missing-widgets-features/elementor-cookie-consent-popup-widget).

##Label List Widget
Just like the Icon List Widget of Elementor you can display a list of terms but this widget shows labels/text in front of them instead of icons.
I added a "hide when empty" feature to it as well.

##Numbered List Widget
Just like the Icon List Widget of Elementor you can display a list of terms but this widget shows numbers in front of them instead of icons.
I added a "hide when empty" feature to it as well.

##FormAssembly form widget
Drag and Drop a FormAssembly Form to your elementor page. Most widgetbuilders have various form integrations but not for
the FormAssembly Form plugin. Even better, set the widget not to use the iframe setting and you can style the form inside Elementor!

##Scroll to top button widget
With this widget you can add a scroll to top button on every page to set go back to the top of a long webpage.
The button can easily styled and positioned and appears on the screen when needed. It automatically shows and hides
when needed.

##Maximum content length widget
With this widget you now can set the maximum length of any dynamic content field. Handy for displaying searchresults and archive pages.

##Anchor with Offset widget
This widget gives you more control to set the offset and scrolling speed of the anchor from the top your page in contrast to the default anchor widget.
Extra benefit is that the settings of the offset-anchor widget are used when you come from a different page.

##Formidable forms widget
Drag and Drop a Formidable Form to your elementor page. Formidable Forms has an Elementor widget but you cannot style the form inside Elementor. With this widget you can.

##SideBox Information widget
Elementor Pro Widget: Widget for adding an fixed information box on the side of your page which can be hidden and shown with a single click.

##Transparent icon in Icon List
To Align items with icons, like in the icon list widget, i've added a transparent icon to the icon selection tab. By selecting this icon you can
the text of these items are aligned just like the one with icons.

##Sticky Scrolling Effects
Add extra scrolling effects to a fixed section (an Elementor Pro feature), like downsizing images or sections, changing the background color or adding a border
to this sticky section.

##Text Editor Widget Improvements
Added a background color button inside the wsyiswyg editor so text can be highlighted

== Installation ==
To install the plugin, please follow these steps:
1.   Make sure you have the plugin 'elementor' installed and actived. The plugin 'Elementor Pro' also needs to be actived for some features of this plugin.
2.   Upload plugin files to the directory /wp-content/plugins/missingwidgets
3.   Activate the plugin in the ‘Plugins’ section of the WordPress console

For more documentation and configuration visit [missingwidgets.com](https://missingwidgets.com).

== Frequently Asked Questions ==

**Can i use this plugin without the Elementor plugin?**

No. You'll need at least the free version of Elementor to be installed and activated.
Some widgets require additional plugins to be installed. For instance in order to use the Formidable Forms widget you'll need to have the plugin of Formidable Forms to be installed and activated as well.

**Can i suggests a new feature for this plugin?**
Yes. just go to the [feature request form](https://missingwidgets.com/feature-request/), describe your request and i'll check if i can create it.
Every year i'll make a shortlist of the most cool suggested features and the pro users can vote which new feature they want to see inside this plugin.

**How can i become a pro user?**
Simple by buying a license for the pro-version of "Missing Widgets for Elementor". Just go to [pricing](https://missingwidgets.com/pricing/) and purchase the Pro-license

== Screenshots ==
1. **Multiple global styled buttons.** Extend the Elementor Button Widget to 5 globally styled elementor buttons instead of 1.
2. **Cookie Consent Popup Widget.** Customize a cookie consent popup inside Elementor which integration with Google Tag Manager.
3. **Footer Menu** Create a footer menu.
4. **To top Button.** Create a scroll to top button for easy navigation.
5. **Formidable Forms.** Configure Formidable Forms inside Elementor.
6. **Label List.** Create and style a responsive listing of labels and text.
7. **Transparent icon.** How to select a transparent icon.
8. **Transparent icon.** See the difference for using the transparent icon inside the icon list widget.
9. **Sticky Scrolling Effects.** Add extra scrolling effects to your fixed header.
10. **Numbered list widget.** Create and style a responsive numbered listing.

== Changelog ==
= 1.4.7 = 2024-10-23=
* Updated to new version of Freemius SDK 2.9.0
= 1.4.6 = 2024-07-19=
* testing with wordpress 6.6
= 1.4.5 = 2024-05-20=
* Updated to new version of Freemius SDK
* Updated elementor-stub files
* Updated phpstan config
* Added dynamic field list widget
= 1.4.3 = 2024-04-03=
* testing with wordpress 6.5
= 1.4.2 = 2024-02-19=
* Added hide when empty feature to labellist and numberlist widget
= 1.4.1 = 2023-11-08=
* upgrade freemius sdk
= 1.4.0 = 2023-11-08=
* testing with wordpress 6.4
= 1.3.9 = 2023-09-20=
* Fix totop javascript for other anchors
= 1.3.8 = 2023-08-29=
* Added sidebox info widget
= 1.3.7 = 2023-08-24=
* bugfix stripping html in maximum content length widget
= 1.3.6 = 2023-8-2=
* tested on wordpress 6.3
* removed scheme colors from footermenu
* renamed composer bump script to bumpversion
* totop widget: added middle option for premium users
* updated help urls
= 1.3.5 = 2023-7-7=
* upgrade freemius sdk
= 1.3.3 = 2023-4-17=
* fix missing styling sheets
= 1.3.2 = 2023-4-11=
* update to wordpress 6.2
= 1.3.1 = 2023-1-6=
* fix bug freemius sdk
= 1.2.9 = 2023-1-6=
* new freemius sdk
= 1.2.8 = 2023-01-04 =
* added prefill fields to assembly widgets.
* bugfix in cookieconsent code.
* small fixes in core.
= 1.2.7 = 2022-12-27 =
* added aligment features to labellist widget
= 1.2.6 = 2022-11-04 =
* Tested for WordPress 6.1
= 1.2.5 = 2022-10-22 =
* Updated Freemius SDK version to 2.4.5
= 1.2.4 = 2022-08-02 =
* Added fix for error if elementor is disabled
= 1.2.3 = 2022-07-29 =
* Reformatted code
= 1.2.2 = 2022-06-09 =
* Added numbered list widget
= 1.2.1 = 2022-05-31 =
* Added background color button for highlighting text
= 1.2.0 = 2022-05-28 =
* Added Sticky Scrolling Effects to a fixed section
* Added domain path variable to plugin
* Fixed loading translation files
= 1.1.6 = 2022-05-23 =
* Tested for WordPress 6.0
= 1.1.5 - 2022-04-21 =
* Adding a Transparent Icon to the icon library
= 1.1.4 - 2022-03-10 =
* Widget Formidable Forms: Added fonts settings for error/message boxes
* Widget Formidable Forms: Removed next/previous button section
* Widget FormAssembly Forms: Added styling tab
* Set Minimum PHP version to 7.1
= 1.1.3 - 2022-03-09 =
* Fixed naming widget Formidable Forms
* Widget Formidable Forms: Fix for textarea height
* Widget Formidable Forms: Added margin for checkbox/radio items
* Widget Formidable Forms: Added padding for error/message boxes
= 1.1.2 - 2022-03-08 =
* Fixed Formidable Forms styling for no-style selection
= 1.1.1 - 2022-03-01 =
* Fixed edit Formidable Forms button
* Added styling tab for Formidable Forms widget
* Renamed German Language files
* Updated language files
= 1.1.0 - 2022-02-25 =
* Added Anchor With Offset widget
* Updated Freemius SDK to 2.4.3
* Updated Language files
* Added German language file
= 1.0.22 - 2022-02-22 =
* Fix for cookie consent popup in a cached environment.
= 1.0.20 - 2022-02-21 =
* Updated Readme.txt
= 1.0.19 - 2022-02-18 =
* Label List Link fix.
= 1.0.17 - 2022-02-17 =
* Cookie consent responsive styling fix.
= 1.0.16 - 2022-02-17 =
* Updated Freemius integration code
= 1.0.15 - 2022-02-16 =
* Updated to the latest Freemius SDK
= 1.0.14 - 2022-02-15 =
* Fixed cookie consent value
= 1.0.13 - 2022-02-15 =
* Changed WordPress Coding Standard check and fixed coding issues.
= 1.0.12 - 2022-02-11 =
* Added filter_var_array for cookies and renamed elementor-aliases.php to elementor-stubs.php
= 1.0.11 - 2022-02-10 =
* Recoding of the plugin to meet the WordPress Coding Standards.
= 1.0.5 - 2021-08-03 =
* Initial Public Beta Release