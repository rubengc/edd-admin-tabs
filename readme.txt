=== EDD Admin Tabs ===
Contributors: tsunoa, rubengc
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=64N6CERD8LPZN
Tags: easy digital downloads, digital, download, downloads, edd, tsunoa, rubengc, admin, tab, tabs, order, e-commerce
Requires at least: 4.0
Tested up to: 4.7.4
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Better organization of download's edit page with tabs

== Description ==
This plugin requires [Easy Digital Downloads](http://wordpress.org/extend/plugins/easy-digital-downloads/ "Easy Digital Downloads").

Once activated, EDD Admin Tabs will distribute meta boxes from download's edit page in tabs.

Current tabs distribution:

1. General Information
1. Prices and files
1. Software Licensing
1. Vendor (FES and Commissions meta boxes)
1. Feedback (Comments and reviews)
1. Revisions (If download post type supports it)

Supported plugins:

1. EDD Frontend Submissions
1. EDD Commissions
1. EDD Reviews
1. EDD Software Licensing
1. EDD Googl
1. Restrict Content
1. Visual Composer
1. The SEO Framework
1. Yoast SEO

If you want support for any plugin you can send to me an email at rubengcdev@gmail.com.

There's a [GIT repository](https://github.com/rubengc/edd-admin-tabs) too if you want to contribute a patch.

== Installation ==

1. Unpack the entire contents of this plugin zip file into your `wp-content/plugins/` folder locally
1. Upload to your site
1. Navigate to `wp-admin/plugins.php` on your site (your WP Admin plugin page)
1. Activate this plugin
1. That's it!

OR you can just install it with WordPress by going to Plugins >> Add New >> and type this plugin's name

== Frequently Asked Questions ==

= How can I customize tabs? =

First of all you need add a filter to changes how tabs are rendered, and at this point you could add, change or move tabs.

This is the structure for a tab:

``
$tab = array(
    'tab-identifier' => array(
        'label' => 'My tab',
        'selectors' => array(
            '#my-meta-box',
            '.group-of-meta-boxes',
        )
    )
);
``

This is an example of tab customization:

``
function custom_download_tabs( $tabs ) {
    // Adding a meta box to general tab
    $tabs['general']['selectors'][] = '#my-meta-box';

    // Moving a tab
    $temp_tab = $tabs['price-files'];

    unset($tabs['price-files']);

    $tabs['price-files'] = $temp_tab;

    // Removing a tab
    unset($tabs['feedback']);

    return $tabs;
}

add_filter( 'edd_admin_tabs_download_tabs', 'custom_download_tabs');
``

Note: Meta boxes that are not in a tab will be kept always visible, such as submit meta box

== Screenshots ==

== Upgrade Notice ==

== Changelog ==

= 1.0.2 =
* Added support for:
Revisions (If download post type supports it)
EDD Software Licensing
Restrict content
Visual Composer
The SEO Framework

= 1.0.1 =
* Added support for Yoast SEO

= 1.0 =
* Initial release