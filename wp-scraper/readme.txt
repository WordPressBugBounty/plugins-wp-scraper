=== WP Scraper ===
Contributors: Rico Macchi
Tags: wp scraper, website migration, content scraper, website copier, content migration
Requires at least: 4.7
Tested up to: 6.5.5
Stable tag: 5.8.1
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
This Wordpress Scraper allows you to move a non-Wordpress website into a Wordpress site.

== Description ==

= Migrating A Website Has Never Been Easier =

Easily copy pages of content with images from your old website and create your own Wordpress pages and posts.

Most of the web migration software available is hard to use and needs advanced knowledge. WP Scraper makes it simple with an easy to use visual interface on your WordPress site.

* Visual interface for selecting content.
* No need to know CSS selectors.
* Images are imported to your media library.
* Simply add your url and start grabbing content.
* Automatically populate the featured image, title, tags, and categories.
* Save as draft, post, or page.
* Strip unwanted css, iframes, and/or videos from content
* Remove links from the content.
* Post to a selected category.

= Two Pro Versions Available =

The WP Scraper Pro version lets you scrape 100's of pages at a time with the Multiple Scrape, or on a set schedule with the Auto Scraper. The Pro version is also packed with extra features to remove ads during import, filter content, and even an upgraded url selection. Please visit http://www.wpscraper.com/ for more information.

The WP Live Scraper provides a shortcode that can be used in any post or page and will automatically refresh scraped content with a recurring cron schedule. This can be used for events, ratings, reviews, scores, prices and so much more! Please visit http://www.wplivescraper.com/ for more information.

== Installation ==

Installation
Uploading via WordPress Dashboard

1. Navigate to the ‘Add New’ in the plugins dashboard
2. Navigate to the ‘Upload’ area
3. Select wp-scraper.zip from your computer
4. Click ‘Install Now’
5. Activate the plugin in the Plugin dashboard

Using FTP

1. Download wp-scraper.zip
2. Extract the wp-scraper.zip directory to your computer
3. Upload the wp-scraper.zip directory to the /wp-content/plugins/directory
4. Activate the WP Scraper plugin in the Plugin dashboard

== Usage ==

= Single Scrape =

URL
Enter the URL you wish to copy content from.

Title
You may select a title from the source page or add your own.

Post Content
You may select multiple areas of the source page including images.

Post Type
Post Type: Post, Page – Status: Published, Draft, Pending Review

Options
Only Text and Images – Checked will remove all html elements except p, div, table, list, break, headings, span, and images. CSS will not be included with this option and links and videos are automatically removed.
Remove Links – Checked will remove all external links from the content.
Add source link to the content – Checked will Add source link to the content.

Categories
Select a category or create a new one.

Tags
Select tags from source page or add your own.

Featured Image
Select an image from the source page or add your own.

== Screenshots ==

1. Using the Single Scrape.

2. This is how easy it is to choose content from your website.

3. The Results page lists each post as it is created (Pro version only).

4. PHP Crawler to gather URL's (Pro version only).

5. WP Scraper Pro.

6. WP Live Scraper.





== ChangeLog ==

= Version 1.0 =

* Initial version of this plugin.

= Version 2.0 =

* Added additional fields to the single scraper
* Added a limited version of the multiple scraper which is available in the WP Scraper Pro version.

= Version 2.4 =

* Various bug fixes
* Added the Only Text and Images option for simplified scraping use.

= Version 3.0 =

* Edited visual interface and various bug fixes.

= Version 4.0 =

* Redesigned selector interface, and corrected issue with shared hosting servers.

= Version 4.1 =

* Tested and updated for Wordpress 4.6 release

= Version 4.2 =

* Various bug fixes

= Version 5.0 =

* Updated for compatibility with Wordpress 4.8.3 release
* Updated for compatibility with new WP Scraper Pro release

= Version 5.1 =

* Added Video Scrape Function


= Version 5.4 =

* Various bug fixes


= Version 5.5 =

* Updated for compatibility with Wordpress 5.4 release


= Version 5.5 =

* Updated for compatibility with Wordpress 5.6 release

= Version 5.6 =

* Tested compatibility with Wordpress 5.7 release


= Version 5.6 =

* Tested compatibility with Wordpress 5.8 release
* Tested compatibility with Wordpress 5.9 release


= Version 5.7 =

* Fixed CSS issues
*PHP crawler will now work with PHP 8
*Tested for compatibility with WordPress 6.1

= Version 5.8 =

* Security fixes
* Updated to latest Wordpress Standards
* Tested for compatibility with WordPress 6.5

= Version 5.8 =

*Fixed selection for post type