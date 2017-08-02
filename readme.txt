=== OrderStorm WordPress e-Commerce ===
Contributors:  carlosman, dansallis
Donate link: www.orderstorm.com/wordpress-e-commerce-sign-up/ecommerce-wordpress-plugin-pricing/
Tags: e-commerce, ecommerce, shopping cart, ecommerce shopping cart, cart, store, storefront, checkout, sell, shop
Requires at least: 3.0
Tested up to: 4.3.1
Stable tag: 1.0-2015.09.29
License: GPL2 or later

A robust shopping cart with extensive order management, automated drop-shipping, quoting, digital downloads, automotive & motorcycle applications.

== Description ==
NOTE: Please go to http://www.OrderStorm.com to sign up for either a free or a paid subscription to use this plugin.

OrderStorm is a SaaS solution.  Since all data is entered and stored in the secure OrderStorm cloud, you won't see much in the dashboard after you install the plugin. You must log in at http://www.OrderStorm.com to see and use all the back end funtionality. Unlike other SaaS e-commerce solutions, OrderStorm delivers front-end applications that are resident on (not remote to) your website. Customers never leave your website and there is no linking out to complete a purchase.

= Product Description =

OrderStorm WordPress e-Commerce - A feature-rich shopping cart that runs on your WordPress website, hosted anywhere. You can sell your products with flexibility, customization, security and integrity with the OrderStorm WordPress e-Commerce plugin and achieve online success. Works with any theme.

The OrderStorm WordPress e-commerce engine is a cloud computing solution (also called SaaS - Software as a Service). This means that our servers do the heavy lifting and all you need is to use the OrderStorm WordPress e-commerce plugin to access the power of our feature-rich shopping cart.

The OrderStorm WordPress ecommerce shopping cart is a full featured product for serious web merchants. Categories and Products are not WordPress pages or posts. They are stored in an external SQL database. OrderStorm WordPress e-Commerce is just right for:
<ul>
<li>Businesses that need more functionality than the other plug-ins provide</li>
<li>Businesses that are drop-shipping from more than one supplier</li>
<li>Businesses models that require secure storage of credit card data</li>
<li>Stores with large numbers of SKUs</li>
<li>Businesses that have multiple CSRs working on orders</li>
</ul>
The OrderStorm WordPress e-Commerce shopping cart offers a wide range of built in features making it easy to manage your product catalog and your day-to-day sales. Shopping cart features include:
<ul>
<li>Creative product display</li>
<li>Sell products, services, events, digital downloads</li>
<li>Products organized into logical categories</li>
<li>Unlimited number of features and options</li>
<li>Up-sell with optional product add-ons</li>
<li>Import products from a spreadsheet</li>
<li>Batch price updates</li>
<li>Automated drop shipping features including POs to suppliers</li>
<li>Vendor management</li>
<li>Related links to installation instructions, drawings, manuals or other documents</li>
<li>Short and long description fields</li>
<li>Quantity discounts</li>
<li>Add variations to products using feature sets</li>
<li>Automatic sizing of thumbnail, medium and large images</li>
<li>Unlimited number of additional photos per product</li>
<li>Integrated search engine optimization (SEO) with meta page title and description each category and product</li>
<li>Integrated with the Google XML Sitemaps plugin for proper product indexing.
<li>Full range of transactions from simple credit card processing to complex transactions with deposits and contracts</li>
<li>Accept credit cards, checks, money orders, wire transfers, Google Checkout and PayPal Express</li>
<li>PCI compliant</li>
<li>No SSL required - checkout uses OrderStorm's SSL.</li>
<li>Large selection of gateways</li>
<li>Sends email order confirmations and shipping notices</li>
<li>Set coupon codes for promotions</li>
<li>Accept file uploads with an order</li>
<li>Sales tax collection</li>
<li>Automated FAQ list per product</li>
<li>Easy order management including order Notes and Action Items lists</li>
<li>Mobile marketing.  Manage your cart from your mobile device</li>
<li>Free shipping, free shipping on orders over X dollars, charge by flat rate or percent of order total</li>
<li>Flexible options for different shipping zones and international shipping</li>
<li>Reports including sales per product, COGS and sales by day, month, year</li>
</ul>
== Installation ==

From the dashboard, under Plugins, select Add New. Search for OrderStorm. Click on Install Now.

or

1. Download the plugin .zip file.
2. Log in to your WordPress dashboard and click on the 'Plugins' tab and then 'Add New.'
3. Click on 'Upload' near the top of the page.</br>
4. Click the 'Choose File' button and find the OrderStorm e-Commerce plugin .zip file. Click 'Choose' followed by the 'Install Now' button.  WordPress will now upload and install your plugin.
5. Once the installation of your plugin has finished click the 'Activate Plugin' link.

== Setup ==
1. The plugin creates 2 pages: Product and Category. Set the Product page to not display in your menu - it has nothing on it but shortcode.  The Category page shows all of your root categories. You can either use this page or set it to not display if you are using the Categories Menu widget in a sidebar.
2. Rename these pages and their permalinks to something that is SEO friendly for your particular site. After you change the slugs, go to the OrderStorm.com sys admin to Settings, Storefront Settings and enter the slugs in the corresponding fields.
3. The Key you see is an example key. To add your categories and products to the shopping cart, sign up for a subscription on the http://www.OrderStorm.com/wordpress-e-commerce-sign-up/ecommerce-wordpress-plugin-pricing/ page.  After you sign up and login through the OrderStorm.com home page, you will find the key under **Settings -> WordPress/API keys**.   Replace the example key with your key. Note that even the free version requires a subscription and key.

= Customize Appearance =
1. Two widgets are added to the Widgets page during the initial installation. One for the Categories Menu and another for the Shopping Cart status box. You can put them anywhere you want plus put them in multiple places on your site.
2. To display the Categories Menu, go to Appearance, Widgets. The OrderStorm e-Commerce widgets were added to the list of Widgets during installation.
3. Drag the Categories Menu widget to a sidebar wherever you want it.
4. To change the Categories Menu settings, click the arrow on the widget to open up the settings box.
5. Maximum menu level depth can be set as 0, which displays all menus or any other number to limit the number of menu levels that fly out before a customer has to click on something.
6. The Parent Category Key can be set if you want to display a subset of the menu on a particular page.
7. An individual category can be added to any page or post using this shortcode:
[orderstorm_ecommerce_display_product_category_page cat_link="your category SEO-friendly slug"]
8. The OrderStorm View Cart Status widget draws a box that shows how many items are currently in the customer's shopping cart and the total dollar amount. Customers can click on this box to check out.
9. The View Cart Status box can be included in any part of a theme. This example shows the way to include it in PHP.

	<code>&lt;?php orderstorm_ecommerce_shopping_cart_status('topright'); ?&gt;</code>

	The **'topright'** value you see is an argument for the function's **$idSuffix** parameter, used to provide a unique ID for the DIV containing the status box. Each instance should be named differently, using this suffix, in order to allow for styling or **ostrm_shopping_cart_status_$idSuffix**,
which for the PHP code example above would translate into:

	**ostrm_shopping_cart_status_topright**.

10. To change the look of the categories and products, go to the Plugin page. Then go to OrderStorm e-Commerce, click on 'Edit'.
11. The .css files controlling the appearance of the categories, subcategories and products are here.  You can completely customize colors, fonts, product display, product box sizes etc.
12. After you have your .css files changed the way you want them, create a backup copy of your .css files in a separate folder or use the OrderStorm eCommerce Custom Files Manager plugin. OrderStorm will overwrite the main plugin .css files when we issue updates.

== Frequently Asked Questions ==

= How do I get a key? =

To begin using the plugin and get your key, sign up on the Plans and Pricing page at
http://www.orderstorm.com/wordpress-e-commerce-sign-up/ecommerce-wordpress-plugin-pricing/. The free version still requires a key.

= How do I configure my shopping cart settings? =

Configure your shopping cart settings using your login to http://www.orderstorm.com.  You will select your login and password when you sign up for a subscription.  For detailed instructions, see the User Manual, Initial Setup page:
http://www.orderstorm.com/wordpress-ecommerce/wordpress-shopping-cart-user-manual/initial-setup-wordpress-ecommerce/

The User Manual provides complete instructions for managing your online catalog and orders.  Refer to the Table of Contents at
http://www.orderstorm.com/wordpress-ecommerce/wordpress-shopping-cart-user-manual/ to find help with adding and managing categories, products and photos.

= How do I get support? =

Send your questions and comments to support@orderstorm.com.  Premium package users can call for phone support - see the Plans and Pricing page for information on which subscription levels come with phone support.

== Screenshots ==

Go to http://www.OrderStorm.com/wordpress-ecommerce/wordpress-shopping-cart-screenshots/ to see a full set of screenshots of the shopping cart features and the complete User Manual.

== Changelog ==

= 1.0 [2015.09.29] =
* Unified connectivity for our new infrastructure
* Added product image gallery presentation and management for administrative users
* Added category image management for administrative users
* Fixed display of categories and subcategories
* Fixed SSL host verification to use the new options available for cUrl
* Fixed the categories menu
= 0.6.2.1 [2013.06.12] =
* Made corrections and changes in order of appearance of some elements of the product page template
= 0.6.2 [2013.06.08] =
* Added functionality allowing presentation of "product order forms", which allow the customer to add different quantities of the same product, based on a certain feature (for instance: 2 "Happy face T-shirts" of size medium, and 3 of size large)
* Fixed the product details template to display more detailed information about each product in a product list, removing also the pricing information for the "main" product from said template
= 0.6.1 [2013.05.29] =
* Added functionality allowing presentation of products with features of type "Products List", which are composed, of course, by various products, making it possible to add many products to the cart at once, by filling a form with their corresponding quantities
* Corrected syntax errors in many CSS files
* Updated a JavaScript compatibility function
= 0.6.0.3 [2013.04.22] =
* Fixed syntax error in the product page template
= 0.6.0.2 [2013.03.19] =
* Fixed potential bug related to the "Force HTTPS for product and category page URLs" backend-configurable setting
* Fixed a bug that incorrectly displayed the "item on back order" product page message
= 0.6.0.1 [2013.03.18] =
* Fixed pre-5.3 PHP incompatibility when using func_num_args() and func_get_args() as parameters in a function call
= 0.6 [2013.03.18] =
* Created a product category page template, supported by a new rendering function, simplifying customization for end users by making the programming interface more familiar to WordPress users experienced with theme and/or plugin customization or development
* Re-created the product page template, using the above-mentioned rendering function in a similar fashion
* Made both new templates easier to translate, using WordPress' internationalization tools, with support included in the rendering function created for them
* Added use of the "Force HTTPS for product and category page URLs" backend-configurable setting
* Fixed some assorted bugs that existed before these new templates and were noticed during this recode, but apparently hadn't surfaced on customer sites
= 0.5.7.6 [2013.02.01] =
* Changed the default of the "Do not verify SSL peer certificate" advanced setting from FALSE to TRUE, in order to accommodate for a lot of users hosting their sites with services that, apparently, don't configure their PHP SSL settings properly, preventing cUrl from being able to verify the peer's certificate against the root certificate authority
= 0.5.7.5 [2013.01.22] =
* Fixed a strange incompatibility with Automattic's Jetpack plugin, which caused the render_product_details.php script not to load
* Fixed the product category page to display the configured currency symbol in its products list, when there is one (it was showing a hard-coded dollar sign)
= 0.5.7.4 [2012.12.17] =
* Fixed syntax error in the CSS selector for "menuItemsGroup" in ostrm_categories_menu.js (this is an error uncovered by WordPress 3.5, which now uses jQuery 1.8, that dropped tolerance for the previous erroneous syntax)
= 0.5.7.3 [2012.10.08] =
* Fixed warning on the orderstorm_ecommerce_the_title filter function, for cases when the filter is applied without sending the required post ID parameter (as specified by WordPress) by some non-compliant plugins
* Fixed the same warning fixed for the [orderstorm_select_product] shortcode function on version 0.5.7.2, for all the other product information rendering shortcodes
= 0.5.7.2 [2012.10.07] =
* Fixed warning on the [orderstorm_select_product] shortcode function, when called internally from any of the other pertinent shortcodes
= 0.5.7.1 [2012.08.14] =
* Fixed error in rendering of Product Category pages, when honoring the "display product/category names in page title" Storefront Setting
= 0.5.7 [2012.08.13] =
* Fixed rendering of Product Category and Product pages to honor the "display product/category names in page title" Storefront Setting
* Added generation of "description" and "keywords" META tags for Product Category and Product pages, including compatibility with Michael Torbert's "All in One SEO Pack" plugin (at version 1.6.14.6, at the moment of this release)
* Added styles to the "ships free" notice on the product details template and modified CSS accordingly
* Fixed generation of Product Category page permalinks for the list of products in the Product Category page, when WordPress permalinks are set to WordPress' default
* Fixed the way CSS stylesheets are enqueued
* Fixed the way shortcode functions are declared
* Fixed JavaScript code repeats
= 0.5.6.4 [2012.07.25] =
* Added compatibility with Michael Torbert's "All in One SEO Pack" plugin (at version 1.6.14.6, at the moment of this release), for generation of canonical URLs for Product Category and Product pages
= 0.5.6.3 [2012.07.25] =
* Fixed critical bug in the HTML <TITLE> tag code from previous versions, causing incompatibility with other plugins, resulting in multiple loads of Product Category or Product page data
= 0.5.6.2 [2012.07.21] =
* Fixed the product details template and its corresponding JavaScript, to display and properly process a "NONE" default option for non-required features of the "Drop-down" type
= 0.5.6.1 [2012.07.20] =
* Fixed critical bug due to the HTML <TITLE> tag change in the previous version, causing the Product page "add to cart" functionality to fail
= 0.5.6 [2012.07.19] =
* Added shortcodes to allow flexible rendering of product information wherever a normal content generation shortcode can be used:
	- [orderstorm_select_product]
	- [orderstorm_product_name]
	- [orderstorm_product_item_number]
	- [orderstorm_product_short_description]
	- [orderstorm_product_long_description]
	- [orderstorm_product_small_image]
	- [orderstorm_product_medium_image]
	- [orderstorm_product_large_image]
	- [orderstorm_product_not_for_sale_or_deleted]
	- [orderstorm_url_for_product_page]
	- [orderstorm_product_retail_price]
	- [orderstorm_product_your_cost]
* Added filter for properly rendering the HTML <TITLE> tag for Product Category and Product pages
* Fixed generation of URLs for Product Category page links to allow replacement of the category slug with the category key (works for both types of product category link generation: SEO-friendly or WordPress' default)
* Fixed generation of URLs for Product page links to allow replacement of the product slug with the product key (works for both types of product link generation: SEO-friendly or WordPress' default)
= 0.5.5.2 [2012.07.17] =
* Fixed generation of URLs for Product and Category page links to honor link-override settings for both types of pages
* Added an [orderstorm_ecommerce_shopping_cart_status] shortcode
* Added the "Is the product name editable in the page title?" option to display this OrderStorm Storefront setting's current value
* Deleted code left over after fixing shortcodes in version 0.5.5
= 0.5.5.1 [2012.07.11] =
* Fixed bug in the Product Details JavaScript, caused by a change in its enqueueing in the previous release
* Fixed bugs related to our money_format replacement function in its parameter-fetching section
* The product name used as the WordPress page title for Product pages will only be rendered as an inline-editable control for the first instance (which SHOULD be the page title), if the corresponding option in the site's OrderStorm.com Storefront settings is checked, which is the default from now on
= 0.5.5 [2012.07.07] =
* Fixed the [orderstorm_ecommerce_display_product_category_page] and [orderstorm_ecommerce_display_product_page] shortcodes, and their related scripts, so they can be effectively used anywhere a normal content generation shortcode would be called from
* Fixed the way Product Category and Product pages are rendered
* Product Category pages now use the category description as the WordPress page title
* Product pages now use the product name as the WordPress page title
* Fixed generation of canonical URLs for Product Category and Product pages
* Fixed rendering of the Product Categories Menu Widget, so it behaves well when no categories have yet been configured for the site
* Fixed a positioning issue affecting the color picker for product options
* Fixed URL generation for Product Category and Product pages to use WordPress' "Site Address (URL)" setting, instead of the "WordPress Address (URL)" setting
* In the plugin's Advanced settings page, added the "Do not verify SSL peer certificate" option (with an appropriately visible warning message), to accommodate for web sites suffering from PHP installs with improper cURL library configuration
* Replaced usage of PHP's money_format function with our custom version, using parameters configurable from the OrderStorm.com Storefront settings page
= 0.5.4.1 [2012.06.11] =
* Added messages to the Main settings page of the plugin's administrative interface, explaining the kind of API key in use and providing the option to set the sample key in case an empty API key has been set by mistake
= 0.5.4 [2012.06.09] =
* Added an API key signup form to the plugin's administrative interface
* Enhanced JavaScript code enqueuing and compatibility
* Fixed a multifaceted bug which affected the features data encoding and decoding for the order products detail form script
* Fixed bug displaying the item number in the products list for a category
* Changed CSS to facilitate style inheritance from the selected theme
* Modified the help text on configuration pages for Product Category and Product pages
* Changed plugin description to a more helpful one
= 0.5.3.3 [2012.05.23] =
* Updated the product details rendering script to honor the "default feature" setting for features of the "Drop-down" type
= 0.5.3.2 [2012.05.07] =
* Updated the product details rendering script to use text parameters from the OrderStorm.com Storefront settings page to display the following field labels:
	- item number label
	- retail price label
	- sell price label
	- extended links label
	- features/options label
	- other options text
	- free shipping text
	- no free shipping text
* Fixed several bugs found in the feature groups verification section of the order products detail form script
* Fixed URL generation for Product Category and Product pages
* Fixed layout for product list items
* Added notices in the plugin configuration pages, letting the user know configuration is to be performed in the backend (OrderStorm.com Storefront settings page)
* Minor code simplifications
= 0.5.3.1 [2012.03.01] =
* Added preliminary support for showing a link to an OrderStorm administration page for editing product info, for users logged in their OrderStorm administration page.
= 0.5.3 [2012.02.29] =
* Fixed display and inline AJAX editing of "Days to ship" information for product pages
* Added trimContent option to jquery.inlineTextArea.js and jquery.inlineTextEdit.js, to enhance editing of applicable product information fields in product pages
= 0.5.2 [2012.02.28] =
* Added support for inline AJAX editing of product information, in each product page, for users logged in their OrderStorm administration page
* Updated htmlentity.js to its latest version from http://phpjs.org
= 0.5.1 [2012.01.24] =
* Added support for PayPal Express Checkout
* Fixed page redirection for invalid Product Page URLs
* Fixed bug for adding products, without product features, to the cart
= 0.5.0.2 [2011.12.29] =
* Added pagination to the list of products in the Product Category page
* Fixed URL rewrites initialization and rules, to accommodate the new pagination for products and fix some bugs
* Fixed search page results to null the excerpt in case the content is empty for a product or category result
* Fixed minor conditional display bugs
= 0.5.0.1 [2011.12.21] =
* Fixed query variable validation for Product Category pages
* Fixed conditional display of category title and information fields in Product Category pages
* Fixed display of shipping information, to obey a previously-overlooked configuration switch
= 0.5 [2011.12.14] =
* Added product and category search capabilities to WordPress search results, if those are enabled in the site's OrderStorm.com Storefront settings page
* Fixed basic support for localization (more work is needed to make all plugin output localizable)
* Fixed loading of scripts and styles, using the proper hooks to make it compatible with WordPress 3.3
* Replaced usage of WordPress' "convertEntities" JavaScript function with another open source alternative (from php.js), since that l10n.js was taken out from WordPress 3.3
* Fixed a problem with the checkout modal window, related to WordPress 3.3, where it showed underneath the navigation menu for the default theme
* Fixed generation of URLs for Product and Category page links
* Removed deprecated code from the Product Categories Menu Widget
* Fixed Product Categories Menu Widget caching
* Replaced usage of WordPress' JSON.php (part Moxiecode's TinyMCE SpellChecker plugin) with our improved version (a ticket - #19440 - and patch had already been submitted to core.trac.wordpress.org), allowing us to discontinue usage of PHP's json_encode
* Added display of settings for inclusion of search results for products and product categories
* Fixed publish page verification
* Fixed session management for WordPress web service callbacks for adding products and submitting product questions
* Fixed creation of default Product Category and Product pages, to prevent comments and pingbacks on those pages
* Fixed a typo in the product details rendering script
= 0.4.9.11 [2011.11.30] =
* Added compatibility with the Thesis WordPress Theme
* Minor bug fix
= 0.4.9.10 [2011.10.29] =
* Added display of settings for generation of XML sitemap entries for Product Category and Product pages
* Fixed a bug for displaying Product Category pages when usage of pretty permalinks is disabled (WordPress default)
= 0.4.9.9 [2011.10.28] =
* Added more flexibility for handling web service timeouts
* Added support for [Arne Brachhold](http://www.arnebrachhold.de/)'s [Google XML Sitemaps](http://wordpress.org/extend/plugins/google-sitemap-generator/) plugin, enabling it to include URLs for Product Category and Product pages in the sitemap it generates
= 0.4.9.8 [2011.10.27] =
* Changed styles for displaying product details
= 0.4.9.7 [2011.10.26] =
* Changed styles for displaying category tiles in a grid
= 0.4.9.6 [2011.10.26] =
* The Product Category page URL can now be used without a category permalink, to display the main categories list
* Minor content changes for plugin configuration pages
= 0.4.9.5 [2011.10.24] =
* Fixed creation of default Product Category and Product pages, to force deletion of pre-existing pages
* Fixed array checking for the product features array submitted by the checkout modal window to the corresponding web services proxy
* Various changes to the default layouts for categories, products list and product details
= 0.4.9.4 [2011.10.24] =
* Fixed a bug introduced in the default pages creation code
= 0.4.9.3 [2011.10.21] =
* Changed product validation message
* Fixed creation of default Product Category and Product pages
= 0.4.9.2 [2011.10.17] =
* Fixed array checking for current re-write rules
= 0.4.9.1 [2011.09.16] =
* Fixed isWellFormedGUID's regular expression, which caused the function to accept digits outside of the hexadecimal range
* Fixed range validation for the row member function in jsonResultSet
* Modified height and width calculation for the checkout modal window to better suit changes in formatting
* Replaced use of DateTime::getTimestamp() with DateTime::format('U') for categories menu caching to fix the PHP 5.2 incompatibility caused by getTimestamp and to avoid a bug it has in 32-bit systems
= 0.4.9 [2011.08.23] =
* Added HTML5 drawings with color option selection to the product details template
* Fixed a minor categories menu caching related to AJAX communications failover
= 0.4.8.2 [2011.08.21] =
* Fixed a bug in Categories Menu caching, which prevented it from deleting a cached menu after it was marked stale
* Fixed the product details page to display the default medium image in case the product doesn't have one of its own
= 0.4.8.1 [2011.08.19] =
* Added color data for product features
* Added data for product HTML5 drawings
= 0.4.8 [2011.08.19] =
* Moved the majority of configuration options from plugin settings to the corresponding OrderStorm.com Storefront Settings page
* Changed the URL-rewrite and query vars generation logic, due to the above mentioned change
* Cleaned up plugin initialization by moving environment options from the global scope to options in the OrderStormECommerceForWordPress class
* The necessary Product Category and Product pages are now created by default at plugin activation, based upon defaults from the site's OrderStorm.com Storefront settings page
* Standardized and centralized generation of URLs for links and images
* Fixed input verification in the constructor of the jsonResultSet class
* Re-designed and implemented more efficient and well-behaved Categories Menu caching
* Miscellaneous bug fixes
= 0.4.7.1 [2011.08.10] =
* Minor changes to default colors
= 0.4.7 [2011.08.09] =
* Initial Release

== Upgrade Notice ==
OrderStorm may send out future updates.